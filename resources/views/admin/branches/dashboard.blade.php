<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    {{-- Jenis Sampah (yang sudah ada) --}}
    <a href="{{ route('admin.waste-types.index') }}" 
       class="block p-6 bg-blue-100 border border-blue-200 rounded-lg hover:bg-blue-200">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-blue-900">Jenis Sampah</h5>
        <p class="font-normal text-blue-700">Kelola jenis sampah dan poin</p>
    </a>

    {{-- Cabang (TAMBAHKAN INI) 👇 --}}
    <a href="{{ route('admin.branches.index') }}" 
       class="block p-6 bg-green-100 border border-green-200 rounded-lg hover:bg-green-200">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-900">Cabang</h5>
        <p class="font-normal text-green-700">Kelola cabang bank sampah</p>
    </a>

    {{-- Placeholder lainnya... --}}
</div>