<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Saving - Bank Sampah Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Poppins', sans-serif;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background-color: #b8e6c2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #2e7d32;
            margin: 0 auto;
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2e7d32;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #388e3c;
            font-weight: 500;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 15px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .feature-icon {
            font-size: 28px;
        }

        .btn-green {
            background-color: #43a047;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            width: 100%;
        }

        .btn-green:hover {
            background-color: #388e3c;
        }

        .section-title {
            font-weight: 600;
            color: #2e7d32;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container py-5 text-center">

        <!-- Logo -->
        <div class="logo mb-3">&#9851;</div> 

        <!-- Judul -->
        <h1 class="brand-title">Green Saving</h1>
        <p class="subtitle mb-5">Bank Sampah Digital</p>

        <!-- Headline -->
        <h3 class="fw-bold">Kelola Sampah, Dapatkan Reward</h3>
        <p class="text-muted mb-5">
            Platform Digital untuk mengelola sampah dengan sistem reward yang menguntungkan dan ramah lingkungan
        </p>

        <!-- Fitur -->
        <div class="feature-card">
            <span class="feature-icon">&#128465;</span> 
            <div class="text-start">
                <h5 class="mb-0 text-success fw-semibold">Setor Sampah</h5>
                <small class="text-muted">Mudah dan Praktis</small>
            </div>
        </div>

        <div class="feature-card">
            <span class="feature-icon">&#127873;</span> 
            <div class="text-start">
                <h5 class="mb-0 text-success fw-semibold">Tukar Reward</h5>
                <small class="text-muted">Poin jadi barang</small>
            </div>
        </div>

        <div class="feature-card">
            <span class="feature-icon">&#127793;</span> 
            <div class="text-start">
                <h5 class="mb-0 text-success fw-semibold">Ramah Lingkungan</h5>
                <small class="text-muted">Kurangi emisi CO₂</small>
            </div>
        </div>

        <div class="feature-card">
            <span class="feature-icon">&#128202;</span> 
            <div class="text-start">
                <h5 class="mb-0 text-success fw-semibold">Tracking Lengkap</h5>
                <small class="text-muted">Monitor Progress</small>
            </div>
        </div>

        <!-- Tombol Navigasi -->
        <h5 class="section-title">Jelajahi Platform:</h5>
        <div class="d-grid gap-3 mt-3">
            <a href="/login" class="btn btn-green">Masuk</a>
            <a href="/register" class="btn btn-green">Daftar</a>
        </div>
    </div>
</body>
</html>
