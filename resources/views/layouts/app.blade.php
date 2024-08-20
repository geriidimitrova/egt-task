<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EGT') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand">EGT Digital</a>
            @guest
            @else
                <form class="d-flex" id="logout-form" action="{{ route('logout') }}" method="POST">
                    <div class="form-control me-2">{{ Auth::user()->email }}</div>
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            @endguest
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<script>
    document.getElementById('commentForm').addEventListener('submit', function (event) {
        event.preventDefault();

        fetch('{{ route("comments.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                content: document.getElementById('content').value,
            })
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw response;
            }
        })
        .then(data => {
            document.getElementById('message').innerHTML = '<p>' + data.message + '</p>';
            document.getElementById('content').value = '';
        })
        .catch(error => {
            error.json().then(err => {
                document.getElementById('message').innerHTML = '<p>' + err.message + '</p>';
            });
        });
    });

    function approveComment(commentId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/comments/${commentId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Display message on success
            location.reload(); // Reload page to refresh the comments list
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function rejectComment(commentId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Display message on success
            location.reload(); // Reload page to refresh the comments list
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

</body>
</html>
