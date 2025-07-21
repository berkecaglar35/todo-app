<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Görev Listesi</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f2f2f2; }
        .done { text-decoration: line-through; color: gray; }
    </style>
</head>
<body>
    <h2>Görev Listesi ({{ auth()->user()->name }})</h2>

    <table>
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Teslim Tarihi</th>
                <th>Öncelik</th>
                <th>Durum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="{{ $task->completed ? 'done' : '' }}">
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d.m.Y') : '-' }}</td>
                    <td>{{ ucfirst($task->priority) }}</td>
                    <td>{{ $task->completed ? 'Tamamlandı' : 'Yapılacak' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

