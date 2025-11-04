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
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9fdf9;
            overflow-x: hidden;
        }

        .hero-section {
            position: relative;
            background: linear-gradient(rgba(0, 100, 0, 0.55), rgba(0, 100, 0, 0.55)),
                        url('{{ asset('images/background.png') }}') center/cover no-repeat;
            height: 55vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            margin-bottom: 0;
            border-bottom: none;
        }

        .hero-section img {
            width: 90px;
            margin-bottom: 15px;
        }

        .hero-section h2 {
            font-weight: 700;
            font-size: 2rem;
        }

        .hero-section p {
            font-weight: 500;
            color: #d8ffd8;
        }

        /* ===== Main White Container ===== */
        .main-content {
            position: relative;
            z-index: 2;
            background: #fff;
            width: 100%;
            border-radius: 0;
            box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
            padding: 80px 120px;
            margin-top: 0;
        }

        .feature-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            height: 90px;
        }

        .feature-card img {
            width: 35px;
        }

        .feature-card h5 {
            color: #2e7d32;
            font-weight: 600;
        }

        .feature-card small {
            font-size: 0.9rem;
        }

        /* ===== Buttons ===== */
        .btn-green {
            background-color: #43a047;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 0;
            width: 130px;
            transition: 0.3s;
        }

        .btn-outline-green {
            border: 2px solid #43a047;
            color: #43a047;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 0;
            width: 130px;
            transition: 0.3s;
        }

        .btn-green:hover {
            background-color: #388e3c;
        }

        .btn-outline-green:hover {
            background-color: #43a047;
            color: white;
        }

        /* ===== Footer Note ===== */
        .footer-note {
            background-color: #e8f5e9;
            color: #2e7d32;
            font-weight: 500;
            border-radius: 10px;
            margin-top: 40px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer-note img {
            width: 18px;
        }

        /* ===== Responsiveness ===== */
        @media (max-width: 992px) {
            .main-content {
                padding: 50px 30px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 30px 20px;
            }
            .feature-card {
                flex-direction: row;
                height: auto;
            }
            .feature-card img {
                width: 28px;
            }
        }
    </style>
</head>
<body>

    
    <section class="hero-section">
        <img src="{{ asset('images/logo user.png') }}" alt="Logo Green Saving">
        <h2>Welcome to <span class="text-light">Green Saving</span></h2>
        <p>Bank Sampah Digital</p>
    </section>

   
    <div class="main-content text-center">
        <h3 class="fw-bold mb-3 text-dark">Kelola Sampah, Dapatkan Reward</h3>
        <p class="text-muted mb-5">
            Platform Digital untuk mengelola sampah dengan sistem reward yang menguntungkan dan ramah lingkungan
        </p>

        
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="feature-card">
                    <img src="{{ asset('images/setor sampah.png') }}" alt="Setor Sampah">
                    <div class="text-start">
                        <h5 class="mb-0">Setor Sampah</h5>
                        <small class="text-muted">Mudah dan Praktis</small>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="feature-card">
                    <img src="{{ asset('images/tukar reward.png') }}" alt="Tukar Reward">
                    <div class="text-start">
                        <h5 class="mb-0">Tukar Reward</h5>
                        <small class="text-muted">Poin jadi barang</small>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="feature-card">
                    <img src="{{ asset('images/ramah lingkungan.png') }}" alt="Ramah Lingkungan">
                    <div class="text-start">
                        <h5 class="mb-0">Ramah Lingkungan</h5>
                        <small class="text-muted">Kurangi emisi CO₂</small>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="feature-card">
                    <img src="{{ asset('images/tracking lengkap.png') }}" alt="Tracking Lengkap">
                    <div class="text-start">
                        <h5 class="mb-0">Tracking Lengkap</h5>
                        <small class="text-muted">Monitor Progress</small>
                    </div>
                </div>
            </div>
        </div>

        
        <h5 class="fw-semibold mt-5 mb-3 text-dark">Jelajahi Platform:</h5>
        <div class="d-flex justify-content-center gap-3">
            <a href="/login" class="btn btn-green">Masuk</a>
            <a href="/register" class="btn btn-outline-green">Daftar</a>
        </div>

        <p class="footer-note mt-5">
            <img src="{{ asset('images/daun.png') }}" alt="Daun">
            Bersama menjaga lingkungan untuk masa depan lebih baik
        </p>
    </div>

</body>
</html>
