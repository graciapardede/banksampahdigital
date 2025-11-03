<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Bank Sampah Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-green {
            background-color: #43a047;
            color: white;
            font-weight: 600;
        }
        .btn-green:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="text-center text-success fw-bold mb-3">Daftar Akun Baru</h3>
            <form method="POST" action="/register">
                @csrf

                {{-- show validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control" id="name" placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan kata sandi">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi kata sandi">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telepon (opsional)</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Nomor telepon" value="{{ old('phone') }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat (opsional)</label>
                    <textarea name="address" class="form-control" id="address" placeholder="Alamat">{{ old('address') }}</textarea>
                </div>
                <button type="submit" class="btn btn-green w-100 mt-2">Daftar</button>
            </form>
            <p class="text-center mt-3">Sudah punya akun? <a href="/login" class="text-success">Masuk</a></p>
        </div>
    </div>
</div>
</body>
</html>
