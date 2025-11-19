<!-- 
    CONTOH PENGGUNAAN VIEW COMPOSER
    File ini menunjukkan cara menggunakan variabel global yang tersedia
    di semua view Blade setelah implementasi View Composer
-->

<div class="container">
    
    <!-- 1. Tampilkan Nama User -->
    <h1>Selamat datang, {{ $namaUser }}! 👋</h1>
    
    
    <!-- 2. Tampilkan Saldo Poin dengan Format -->
    <div class="balance-card">
        <span>Saldo Poin Anda:</span>
        <strong>{{ number_format($saldoPoin, 0, ',', '.') }}</strong> poin
    </div>
    
    
    <!-- 3. Kondisional Berdasarkan Role -->
    @if($roleUser === 'admin')
        <div class="admin-panel">
            <h2>Panel Admin</h2>
            <p>Anda memiliki akses penuh ke sistem</p>
        </div>
    @elseif($roleUser === 'user')
        <div class="user-panel">
            <h2>Dashboard Warga</h2>
            <p>Tukarkan poin Anda dengan hadiah menarik!</p>
        </div>
    @endif
    
    
    <!-- 4. Tampilkan Email User -->
    <div class="user-info">
        <p>Email: {{ $emailUser }}</p>
    </div>
    
    
    <!-- 5. Akses Object User Lengkap -->
    <div class="profile">
        <p>ID User: {{ $authUser->id }}</p>
        <p>Branch: {{ $authUser->branch->name ?? 'Belum ada cabang' }}</p>
        <p>Member sejak: {{ $authUser->created_at->format('d F Y') }}</p>
    </div>
    
    
    <!-- 6. Badge Saldo Poin -->
    <span class="badge badge-success">
        💰 {{ number_format($saldoPoin, 0, ',', '.') }} poin
    </span>
    
    
    <!-- 7. Progress Bar Poin -->
    @php
        $targetPoin = 5000;
        $progress = min(100, ($saldoPoin / $targetPoin) * 100);
    @endphp
    <div class="progress">
        <div class="progress-bar" style="width: {{ $progress }}%">
            {{ number_format($saldoPoin, 0, ',', '.') }} / {{ number_format($targetPoin, 0, ',', '.') }}
        </div>
    </div>
    
</div>


<!-- 
    VARIABEL YANG TERSEDIA SECARA GLOBAL:
    
    $authUser   → Object user lengkap (User model)
    $saldoPoin  → Integer saldo poin (balance_points)
    $namaUser   → String nama lengkap user
    $emailUser  → String email user
    $roleUser   → String role user ('admin' atau 'user')
    
    TIDAK PERLU LAGI:
    - Passing dari controller dengan compact()
    - Menulis Auth::user() berulang kali
    - Mengecek null di setiap view
-->
