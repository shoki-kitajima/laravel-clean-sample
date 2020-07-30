<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="section pb-0">
                <h1 class="title is-1">Task List</h1>
            </div>
            <div class="section">
                @if ($errors->any())
                    <div class="notification is-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <p class="notification is-danger">
                        {{ session('error') }}
                    </p>
                @endif
                <form class="has-addons" method="POST" action="/register" id="task-form">
                    @csrf
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">TaskName</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input class="input is-fullwidth" name="name" type="text" placeholder="タスク入力">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">DueDate</label>
                        </div>
                        <div class="field-body">
                            <p class="control">
                                <input class="input" name="due_date" type="datetime-local" min="">
                            </p>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label"></label>
                        </div>
                        <div class="field-body">
                            <p class="control">
                                <button class="button is-primary">
                                    登録
                                </button>
                            </p>
                        </div>
                </form>
            </div>
            <div class="pt-6">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th class="has-text-centered">No.</th>
                            <th class="has-text-centered">Name</th>
                            <th class="has-text-centered">DueDate</th>
                            <th class="has-text-centered">IsDone</th>
                            <th class="has-text-centered">Archive</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returns as $task)
                            <tr>
                                <td class="has-text-centered">{{ $task->id()->value() }}</td>
                                <td class="has-text-centered">{{ $task->name()->value() }}</td>
                                <td class="has-text-centered">
                                    <span
                                        @if($task->dueDate()->isExpired())
                                            style="color:red;"
                                        @endif
                                    >
                                        {{ $task->dueDate()->value() }}
                                    </span>
                                </td>
                                <td class="has-text-centered">
                                    <form method="POST" action="/toggleIsDone" id="toggle-form">
                                        @csrf
                                        <input name="is_done" type="checkbox" value="1" onchange="toggleIsDone({{ $task->id()->value() }})"
                                            @if($task->isDone())
                                                checked="checked"
                                            @endif
                                        >
                                    </form>
                                </td>
                                <td class="has-text-centered">
                                    <form method="POST" action="/archive" id="archive-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $task->id()->value() }}">
                                        <button class="button is-danger">Archive</button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        toggleIsDone = (id) => {
            let input = document.createElement("input");
            input.name = "id"
            input.type = "hidden"
            input.value = id
            let form = document.getElementById('toggle-form')
            form.appendChild(input)
            form.submit()
        }
    </script>
</body>
</html>
