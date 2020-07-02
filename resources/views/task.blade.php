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
            <div class="section">
                <h1 class="title is-1">Task List</h1>
            </div>
            <div class="section">
                <form class="field has-addons" method="POST" action="/addTask" id="task-form">
                    <p class="control is-expanded">
                        <input class="input is-fullwidth" type="text" placeholder="タスク入力">
                    </p>
                    <p class="control">
                        <button class="button">
                            登録
                        </button>
                    </p>
                </form>
            </div>
            <div class="section">
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
                                        <input name="is_done" type="checkbox" onchange="toggleIsDone({{ $task->id()->value() }})"
                                            @if($task->isDone())
                                                checked="checked"
                                            @endif
                                        >
                                    </form>
                                </td>
                                <td class="has-text-centered">
                                    <form method="POST" action="/archive" id="archive-form">
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
            input.value = id
            let form = document.getElementById('toggle-form')
            form.appendChild(input)
            form.submit()
        }
    </script>
</body>
</html>
