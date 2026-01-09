# ----------------------------------------------------
# Stage 1: composer_build (依存関係のインストールとビルド)
# ----------------------------------------------------
FROM php:7.4-cli-alpine AS composer_build

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

# 3. 【修正】Composerの実行に必要なすべてのアプリケーションファイルをコピー
#    -> artisan スクリプトが依存する bootstrap/app.php もこれでコピーされる
COPY . .

# 4. Composerが参照するディレクトリを作成（COPY . . で存在しない場合があるため）
RUN mkdir -p database/seeds \
    && mkdir -p database/factories

# 5. 作業ディレクトリの所有権を www-data に変更
RUN chown -R www-data:www-data /app

# 6. Composerの実行を非rootユーザー www-data に切り替える
USER www-data

# 7. 依存関係のインストールを実行
RUN composer install --ignore-platform-reqs --no-dev --prefer-dist --optimize-autoloader --no-interaction

# 8. デバッグ用：vendor が生成されたか確認 (成功すればファイル情報が表示されます)
RUN ls -l /app/vendor/autoload.php

# ユーザーを root に戻す
USER root

# 残りのコードは変更なし。Stage 2 に進みます。
# ----------------------------------------------------
# Stage 2: Final Image (本番環境での実行用 - PHP-FPM)
# ----------------------------------------------------
FROM php:7.4-fpm-alpine AS final

# 1. パッケージリポジトリを更新
RUN apk update

# 2. ビルド依存パッケージ（-dev）とランタイム依存パッケージをインストール
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
COPY --from=composer_build /app/vendor /var/www/html/vendor

# 9. パーミッション設定
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 10. 実行ユーザーを www-data に切り替える
USER www-data

# 11. コンテナ起動時に php-fpm を実行
CMD ["php-fpm"]
