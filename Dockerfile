# Dockerfile

# ----------------------------------------------------
# Stage 1: composer_dev_build (開発/テスト用依存関係をインストール)
# ----------------------------------------------------
FROM php:7.4-cli-alpine AS composer_dev_build

# 1. ビルドに必要なパッケージをインストール
RUN apk update && apk add --no-cache \
    curl \
    git \
    make \
    autoconf \
    g++ \
    gcc \
    libc-dev \
    libtool

# 2. Composer をインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# アプリケーションの作業ディレクトリを設定
WORKDIR /app

# 3. アプリケーションファイルをコピー
COPY . .

# 4. Composerが参照するディレクトリを作成
RUN mkdir -p database/seeds \
    && mkdir -p database/factories

# 5. 作業ディレクトリの所有権を www-data に変更
RUN chown -R www-data:www-data /app

# 6. Composerの実行を非rootユーザー www-data に切り替える
USER www-data

# 7. 依存関係のインストールを実行 (PHPUnitなど開発依存関係を含める)
# ★ 修正: --no-dev=false または --dev を使用し、開発パッケージを含める
RUN composer install --prefer-dist --optimize-autoloader --no-interaction

# ユーザーを root に戻す
USER root

# ----------------------------------------------------
# Stage 2: composer_prod_build (本番用依存関係のみを抽出)
# ----------------------------------------------------
# Stage 1の成果物を使用
FROM composer_dev_build AS composer_prod_build

# 【重要】開発依存関係を削除し、本番環境を軽量化
# Stage 1で全てインストールされているため、ここでは何も実行しない

# ----------------------------------------------------
# Stage 3: Final Image (本番環境での実行用 - PHP-FPM)
# ----------------------------------------------------
FROM php:7.4-fpm-alpine AS final

# 1. パッケージリポジトリを更新
RUN apk update

# 2. ビルド依存パッケージとランタイム依存パッケージをインストール
RUN apk add --no-cache \
    libjpeg libpng freetype \
    zlib-dev \
    autoconf g++ gcc libc-dev make libtool libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev \
    mariadb-dev \
    git zip unzip

# 3. PHP拡張機能の設定とインストール (安定版)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql

# 4. opcache の設定ファイルの追加
# ... (opcache 設定は省略なしでそのまま) ...
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.use_cwd=1'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.max-accelerated-files=10000'; \
    echo 'opcache.memory-consumption=128'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# 5. ビルド依存パッケージ（-dev）のみを削除 (最終イメージを軽量化)
RUN apk del autoconf g++ gcc libc-dev make libtool freetype-dev libpng-dev libjpeg-turbo-dev mariadb-dev zlib-dev

# 6. 最終的なアプリケーションの作業ディレクトリを設定
WORKDIR /var/www/html

# 7. アプリケーションコード全体をコピー
COPY . .

# 8. ビルドステージから vendor ディレクトリをコピー
# ★ 修正: prod_build ステージから vendor をコピー
COPY --from=composer_prod_build /app/vendor /var/www/html/vendor

# 9. パーミッション設定
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 10. 実行ユーザーを www-data に切り替える
USER www-data

# 11. コンテナ起動時に php-fpm を実行
CMD ["php-fpm"]


# ----------------------------------------------------
# Stage 4: test_runner (テスト実行専用)
# ----------------------------------------------------
# ★ 新規追加ステージ
FROM php:7.4-cli-alpine AS test_runner

# 1. ビルドに必要なパッケージをインストール（DB接続に必要なもの）
RUN apk update && apk add --no-cache git mariadb-client

# 2. PHP拡張機能の設定とインストール (テストDB接続用)
RUN docker-php-ext-install pdo pdo_mysql

# 最終的なアプリケーションの作業ディレクトリを設定
WORKDIR /app

# アプリケーションコード全体をコピー
COPY . .

# 3. 【重要】開発依存関係 (PHPUnitを含む) をインストールしたステージから vendor をコピー
COPY --from=composer_dev_build /app/vendor /app/vendor

# 4. 実行ユーザーを www-data に切り替える
USER www-data

# (CMD や ENTRYPOINT は docker-compose.yml で上書きされるためここでは定義しない)
