<!DOCTYPE html>
<html>
<head>
    <title>Görev Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
        color: #212529;
        transition: all 0.3s;
    }

    .dark-mode {
        background-color: #121212 !important;
        color: #ffffff !important;
    }

    .dark-mode .card,
    .dark-mode .list-group-item,
    .dark-mode .alert {
        background-color: #1f1f1f !important;
        color: #ffffff !important;
        border-color: #333;
    }

    .theme-toggle {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 9999;
    }
</style>

</head><script>
    function toggleTheme() {
        const body = document.body;
        body.classList.toggle('dark-mode');
        localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark' : 'light');
    }

    // Sayfa yüklenince tema ayarını geri getir
    window.onload = function () {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    }
</script>

<body class="bg-light py-5">
    <div class="d-flex justify-content-end gap-2 p-3 bg-light border-bottom">
    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-danger">Çıkış Yap</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Giriş Yap</a>
        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-success">Kayıt Ol</a>
    @endauth
</div>
<button class="btn btn-sm btn-outline-light bg-dark theme-toggle" onclick="toggleTheme()">🌗 Tema</button>

<div class="container">
    <a href="{{ route('tasks.export.pdf') }}" class="btn btn-outline-secondary mb-3">
    📄 PDF olarak indir
    </a>

    <h1 class="mb-4 text-center">📋 Görev Listesi</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="/tasks" class="d-flex gap-2">
                @csrf
                  <div class="col-md-4">
        <input type="text" name="title" class="form-control" placeholder="Görev başlığı" required>
    </div>

    <div class="col-md-3">
        <input type="date" name="due_date" class="form-control">
    </div>

    <div class="col-md-3">
        <select name="priority" class="form-select">
            <option value="düşük">Düşük</option>
            <option value="orta" selected>Orta</option>
            <option value="yüksek">Yüksek</option>
        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Ekle</button>
            </form>
        </div>
    </div>

    @if ($tasks->count())
        <ul class="list-group">
@foreach ($tasks as $task)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <form action="/tasks/{{ $task->id }}/toggle" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm {{ $task->completed ? 'btn-success' : 'btn-outline-secondary' }}">
                    {{ $task->completed ? '✔' : '❏' }}
                </button>
            </form>

            <span class="ms-2 {{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->title }}

                {{-- Tarih ve öncelik --}}
                <small class="text-secondary ms-2">
                    @if ($task->due_date)
                        📅 {{ \Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}
                    @endif

                    | 🎯 
                    <span class="fw-bold 
                        {{ $task->priority === 'yüksek' ? 'text-danger' : 
                           ($task->priority === 'düşük' ? 'text-success' : 'text-warning') }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </small>
            </span>
        </div>

        <form method="POST" action="/tasks/{{ $task->id }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">🗑</button>
        </form>
    </li>
@endforeach
</ul>

    @else
        <div class="alert alert-info text-center mt-4">
            Henüz hiç görev eklenmemiş.
        </div>
    @endif
</div>

</body>
</html>
