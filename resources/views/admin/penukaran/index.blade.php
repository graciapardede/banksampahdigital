<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Daftar Permintaan Penukaran') }}</h2>
            <p class="text-sm text-gray-500">Menampilkan permintaan penukaran</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                     class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                        <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <h3 class="text-gray-700 font-semibold mb-4">Daftar Permintaan Penukaran</h3>
                    <p class="text-sm text-gray-500 mb-6">Menampilkan permintaan penukaran</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // demo fallback data
                                    $demoRows = [
                                        (object)['user'=>'Sari Simanullang','item'=>'Beras Premium 5kg','points'=>100,'date'=>'20 Jan 2025, 14:30','status'=>'Menunggu','method'=>'Ambil di Cabang (Cabang Sitoluama)'],
                                        (object)['user'=>'Binsar Hutabarat','item'=>'Minyak goreng 2L, gula pasir','points'=>250,'date'=>'19 Jan 2025, 16:45','status'=>'Dikonfirmasi','method'=>'Ambil di Cabang (Cabang Lajubet)'],
                                        (object)['user'=>'Maria Situmorang','item'=>'Kertas','points'=>50,'date'=>'18 Jan 2025, 10:20','status'=>'Menunggu','method'=>'Ambil di Cabang (Cabang Sitoluama)'],
                                        (object)['user'=>'Toba Siahaan','item'=>'Plastik','points'=>80,'date'=>'17 Jan 2025, 13:15','status'=>'Menunggu','method'=>'Ambil di Cabang (Cabang Sitoluama)'],
                                    ];
                                    $rows = isset($requests) && count($requests) ? $requests : $demoRows;
                                    $pendingCount = collect($rows)->filter(fn($r) => strtolower($r->status) === 'menunggu')->count();
                                @endphp

                                @foreach($rows as $r)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $r->user }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $r->item }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">{{ $r->points }} poin</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $r->date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if(strtolower($r->status) === 'menunggu')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">Menunggu</span>
                                            @elseif(strtolower($r->status) === 'dikonfirmasi')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Dikonfirmasi</span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">{{ $r->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $r->method }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                                            <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-200 text-gray-700" title="Lihat">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.7 5.2 1 9c1.7 3.8 5 6 9 6s7.3-2.2 9-6c-1.7-3.8-5-6-9-6zm0 10a4 4 0 110-8 4 4 0 010 8z"/></svg>
                                            </a>
                                            @if(strtolower($r->status) === 'menunggu')
                                                <form action="#" method="POST" class="inline-block" onsubmit="event.preventDefault(); alert('Konfirmasi action (demo)')">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center justify-center h-9 px-3 rounded bg-green-600 text-white text-sm" title="Konfirmasi">Konfirmasi</button>
                                                </form>
                                            @elseif(strtolower($r->status) === 'dikonfirmasi')
                                                <button class="inline-flex items-center justify-center h-9 px-3 rounded bg-blue-600 text-white text-sm">Diserahkan</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pendingCount > 0)
                        <div class="mt-6 p-4 rounded border-l-4 border-yellow-400 bg-yellow-50 text-yellow-800">
                            Ada {{ $pendingCount }} permintaan yang menunggu konfirmasi
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
