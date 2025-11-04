<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Green Saving</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Poppins', sans-serif;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 400px;
            margin: 60px auto;
        }
        .btn-green {
            background-color: #43a047;
            color: white;
            border-radius: 25px;
            font-weight: 600;
            width: 100%;
        }
        .btn-green:hover {
            background-color: #388e3c;
        }
        input.form-control {
            border-radius: 10px;
            background-color: #f4f4f4;
            border: none;
            padding: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="register-card text-center">
        <img src="{{ asset('images/logo user.png') }}" alt="Logo" width="70" class="mb-3">
        <h2 class="fw-bold text-success mb-0">Green Saving</h2>
        <p class="text-muted">Bank Sampah Digital</p>

        <form>
            <div class="mb-3 text-start">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" placeholder="Masukkan Nama Lengkap">
            </div>
            <div class="mb-3 text-start">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Masukkan Email">
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Masukkan Password">
            </div>
            <div class="mb-3 text-start">
                <label for="confirm" class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm" placeholder="Ulangi Password">
            </div>
            <button type="submit" class="btn btn-green mt-3">Daftar Sekarang</button>
        </form>

        <p class="mt-3 text-muted">Sudah punya akun?
            <a href="/login" class="text-success fw-bold">Masuk</a>
        </p>
    </div>
</div>
</body>
</html>
