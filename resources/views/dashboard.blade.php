<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, Admin!</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Event</h5>
                    <p class="card-text">Kelola semua event</p>
                    <a href="{{ route('admin.events') }}" class="btn btn-primary">Lihat Event</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Peserta</h5>
                    <p class="card-text">Lihat semua peserta</p>
                    <a href="{{ route('admin.participants') }}" class="btn btn-primary">Lihat Peserta</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>