<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Green Saving</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px 25px;
            max-width: 400px;
            margin: 60px auto;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background-color: #b8e6c2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #2e7d32;
            margin: 0 auto;
        }

        .tab-btn {
            display: flex;
            background-color: #d7f0da;
            border-radius: 30px;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .tab-btn a {
            flex: 1;
            text-decoration: none;
            padding: 8px 0;
            font-weight: 600;
            color: #2e7d32;
            transition: 0.3s;
        }

        .tab-btn a.active {
            background-color: #81c784;
            color: #fff;
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

        small a {
            color: #2e7d32;
            text-decoration: none;
        }

        small a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card text-center">
            <!-- Logo -->
            <div class="logo mb-3">&#9851;</div>

            <!-- Judul -->
            <h2 class="fw-bold text-success mb-0">Green Saving</h2>
            <p class="text-muted" style="margin-top:-5px;">Bank Sampah Digital</p>

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

            <small class="d-block mt-3">
                <a href="#">Butuh Bantuan?</a>
            </small>
        </div>
    </div>
</body>
</html>
