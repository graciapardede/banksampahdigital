<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Green Saving</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
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
    <div class="login-card text-center">
        <img src="{{ asset('images/logo user.png') }}" alt="Logo" width="70" class="mb-3">
        <h2 class="fw-bold text-success mb-0">Green Saving</h2>
        <p class="text-muted">Bank Sampah Digital</p>

            <p class="text-success fw-semibold mt-3 mb-4">
                Daftar dan Masuk untuk memulai petualangan<br>ramah lingkungan Anda!
            </p>

            <!-- Tabs -->
            <div class="tab-btn">
                <a href="/login" class="active">Masuk</a>
                <a href="/register">Daftar</a>
            </div>

            <!-- Form -->
            <form>
                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan Email">
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan Password">
                </div>

                <button type="submit" class="btn btn-green mt-3">Masuk Sekarang</button>
            </form>

        <p class="mt-3 text-muted">Belum punya akun?
            <a href="/register" class="text-success fw-bold">Daftar</a>
        </p>
    </div>
</div>
</body>
</html>
