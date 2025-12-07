<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lokasi Bank Sampah - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        #map {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-2xl text-gray-800">Green Saving</h1>
                        <p class="text-sm text-green-600">Halo, {{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-8 py-3 rounded-full border-2 border-green-200 shadow-sm">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-2xl"></i>
                            <span class="font-bold text-green-700 text-xl">{{ number_format($saldoPoin ?? 0, 0, ',', '.') }} poin</span>
                        </div>
                    </div>

                    <!-- Cart Button -->
                    <a href="{{ route('cart.index') }}" class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="bi bi-cart3 text-white text-xl"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Profile Button -->
                    <a href="/profil" class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center transition-all hover:scale-105 overflow-hidden shadow-lg">
                        @if(Auth::user()->profile_photo)
                            <img src="/{{ Auth::user()->profile_photo }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-person-fill text-white text-2xl"></i>
                        @endif
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-14 h-14 bg-red-100 hover:bg-red-200 rounded-full flex items-center justify-center transition-all hover:scale-105 shadow-lg">
                            <i class="bi bi-box-arrow-right text-red-600 text-2xl"></i>
                        </button>
                    </form>
                    @else
                    <!-- Guest Actions -->
                    <a href="{{ route('login') }}" class="bg-white border-2 border-green-600 text-green-600 hover:bg-green-50 px-6 py-2 rounded-full font-semibold transition-all">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-semibold transition-all shadow-md">
                        Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-8 gap-3">
                    <a href="/dashboard" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-house-door pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Dashboard</span>
                        <span class="lg:hidden pointer-events-none">Dashb</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-person pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-gift pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Tukar Poin</span>
                        <span class="lg:hidden pointer-events-none">Tukar</span>
                    </a>
                    <a href="/eco-news" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-newspaper pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Eco News</span>
                        <span class="lg:hidden pointer-events-none">Eco</span>
                    </a>
                    <a href="/lokasi" class="bg-green-500 text-white px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center gap-1 lg:gap-2 w-full cursor-default">
                        <i class="bi bi-geo-alt-fill pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Lokasi</span>
                    </a>
                    <a href="/riwayat" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-clock-history pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-bell pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Notifikasi</span>
                        <span class="lg:hidden pointer-events-none">Notif</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Title -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-geo-alt-fill text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Lokasi Bank Sampah</h2>
                        <p class="text-gray-600 mt-1">Temukan cabang Bank Sampah terdekat di sekitar Anda</p>
                    </div>
                </div>
            </div>

            <!-- Branch List -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($branches as $index => $branch)
                <div onclick="showMap({{ $index }})" 
                     class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer hover:scale-[1.02] transform">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-building text-green-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $branch['name'] }}</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-geo-alt text-green-600"></i>
                                    <span>{{ $branch['address'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-telephone text-green-600"></i>
                                    <span>{{ $branch['phone'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-pin-map text-green-600"></i>
                                    <span>{{ $branch['lat'] }}, {{ $branch['lng'] }}</span>
                                </div>
                            </div>
                            <div class="mt-4 text-green-600 text-sm font-semibold flex items-center gap-1">
                                <i class="bi bi-map"></i>
                                <span>Klik untuk lihat peta</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Google Maps Container (Hidden by default) -->
            <div id="mapContainer" class="bg-white rounded-2xl shadow-lg p-6 hidden">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-map text-green-600"></i>
                        <span id="mapTitle">Peta Lokasi</span>
                    </h3>
                    <div class="flex items-center gap-2">
                        <button onclick="findMyLocation()" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Lokasi Saya</span>
                        </button>
                        <button onclick="hideMap()" class="text-gray-500 hover:text-red-600 transition-colors">
                            <i class="bi bi-x-circle text-2xl"></i>
                        </button>
                    </div>
                </div>
                <!-- Distance info -->
                <div id="distanceInfo" class="hidden mb-4 p-3 bg-blue-50 rounded-lg text-sm">
                    <div class="flex items-center gap-2 text-blue-800">
                        <i class="bi bi-info-circle"></i>
                        <span id="distanceText"></span>
                    </div>
                </div>
                <div id="map"></div>
            </div>

        </div>
    </div>

    <!-- Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}" async defer></script>
    
    <script>
        // Branch data from Laravel
        const branches = @json($branches);
        let map = null;
        let markers = [];
        let infoWindow = null;
        let userMarker = null;
        let userLocation = null;
        
        // Calculate distance between two coordinates (Haversine formula)
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // Earth radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                     Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                     Math.sin(dLng/2) * Math.sin(dLng/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            const distance = R * c;
            return distance;
        }
        
        // Find and display user's current location
        function findMyLocation() {
            if (!navigator.geolocation) {
                alert('Browser Anda tidak mendukung Geolocation');
                return;
            }
            
            // Show loading
            const btn = event.target.closest('button');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-arrow-clockwise animate-spin"></i> <span>Mencari...</span>';
            btn.disabled = true;
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    // Remove previous user marker if exists
                    if (userMarker) {
                        userMarker.setMap(null);
                    }
                    
                    // Add blue marker for user location
                    userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'Lokasi Anda',
                        icon: {
                            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#3b82f6">
                                    <circle cx="12" cy="12" r="8" fill="#3b82f6" stroke="white" stroke-width="3"/>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(30, 30)
                        },
                        animation: google.maps.Animation.DROP
                    });
                    
                    // Pan to user location
                    map.panTo(userLocation);
                    map.setZoom(13);
                    
                    // Find nearest branch
                    let nearestBranch = null;
                    let minDistance = Infinity;
                    
                    branches.forEach((branch, index) => {
                        const distance = calculateDistance(
                            userLocation.lat, 
                            userLocation.lng, 
                            branch.lat, 
                            branch.lng
                        );
                        
                        if (distance < minDistance) {
                            minDistance = distance;
                            nearestBranch = { ...branch, index, distance };
                        }
                    });
                    
                    // Show distance info
                    const distanceInfo = document.getElementById('distanceInfo');
                    const distanceText = document.getElementById('distanceText');
                    
                    if (nearestBranch) {
                        distanceText.innerHTML = `
                            <strong>Bank Sampah Terdekat:</strong> ${nearestBranch.name} 
                            (${nearestBranch.distance.toFixed(2)} km dari lokasi Anda)
                        `;
                        distanceInfo.classList.remove('hidden');
                        
                        // Adjust map bounds to show both user and nearest branch
                        const bounds = new google.maps.LatLngBounds();
                        bounds.extend(userLocation);
                        bounds.extend({ lat: nearestBranch.lat, lng: nearestBranch.lng });
                        map.fitBounds(bounds);
                    }
                    
                    // Update all info windows with new direction links
                    markers.forEach((marker, index) => {
                        google.maps.event.clearListeners(marker, 'click');
                        marker.addListener('click', function() {
                            const contentString = createInfoWindowContent(branches[index]);
                            infoWindow.setContent(contentString);
                            infoWindow.open(map, marker);
                        });
                    });
                    
                    // Restore button
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                },
                function(error) {
                    let errorMsg = 'Tidak dapat mengakses lokasi Anda';
                    if (error.code === error.PERMISSION_DENIED) {
                        errorMsg = 'Izin akses lokasi ditolak. Silakan aktifkan di pengaturan browser.';
                    }
                    alert(errorMsg);
                    
                    // Restore button
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        }
        
        // Show map for specific branch
        function showMap(branchIndex) {
            const branch = branches[branchIndex];
            
            // Show map container
            const mapContainer = document.getElementById('mapContainer');
            mapContainer.classList.remove('hidden');
            
            // Update title
            document.getElementById('mapTitle').textContent = `Peta Lokasi - ${branch.name}`;
            
            // Scroll to map
            mapContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Initialize map if not already done
            if (!map) {
                initMap(branchIndex);
            } else {
                // Pan to selected branch and open info window
                map.panTo({ lat: branch.lat, lng: branch.lng });
                map.setZoom(15);
                
                // Open info window for selected marker
                if (infoWindow && markers[branchIndex]) {
                    infoWindow.close();
                    const contentString = createInfoWindowContent(branch);
                    infoWindow.setContent(contentString);
                    infoWindow.open(map, markers[branchIndex]);
                }
            }
        }
        
        // Hide map
        function hideMap() {
            const mapContainer = document.getElementById('mapContainer');
            mapContainer.classList.add('hidden');
            
            // Hide distance info
            document.getElementById('distanceInfo').classList.add('hidden');
        }
        
        // Create info window content
        function createInfoWindowContent(branch) {
            // Build direction URL - use user location as origin if available
            let directionUrl = `https://www.google.com/maps/dir/?api=1&destination=${branch.lat},${branch.lng}`;
            
            if (userLocation) {
                // If user location is available, set it as origin
                directionUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLocation.lat},${userLocation.lng}&destination=${branch.lat},${branch.lng}`;
            }
            
            // Calculate distance if user location available
            let distanceHTML = '';
            if (userLocation) {
                const distance = calculateDistance(userLocation.lat, userLocation.lng, branch.lat, branch.lng);
                distanceHTML = `
                    <div style="margin-bottom: 6px; color: #3b82f6; font-weight: 600;">
                        <i class="bi bi-arrow-left-right"></i> ${distance.toFixed(2)} km dari Anda
                    </div>
                `;
            }
            
            return `
                <div style="font-family: 'Poppins', sans-serif; padding: 10px; max-width: 250px;">
                    <h3 style="font-size: 16px; font-weight: bold; color: #10b981; margin-bottom: 8px;">
                        ${branch.name}
                    </h3>
                    <div style="font-size: 13px; color: #4b5563; line-height: 1.6;">
                        <div style="margin-bottom: 6px;">
                            <i class="bi bi-geo-alt"></i> ${branch.address}
                        </div>
                        <div style="margin-bottom: 6px;">
                            <i class="bi bi-telephone"></i> ${branch.phone}
                        </div>
                        ${distanceHTML}
                        <div style="margin-top: 10px;">
                            <a href="${directionUrl}" 
                               target="_blank"
                               style="display: inline-block; background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;">
                                🗺️ Petunjuk Arah
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Initialize Google Maps
        function initMap(selectedIndex = 0) {
            const selectedBranch = branches[selectedIndex];
            
            // Map options
            const mapOptions = {
                zoom: 15,
                center: { lat: selectedBranch.lat, lng: selectedBranch.lng },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [
                    {
                        "featureType": "poi",
                        "elementType": "labels",
                        "stylers": [{ "visibility": "on" }]
                    }
                ]
            };
            
            // Create map
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            
            // Create info window (shared for all markers)
            infoWindow = new google.maps.InfoWindow();
            
            // Add markers for each branch
            branches.forEach((branch, index) => {
                const marker = new google.maps.Marker({
                    position: { lat: branch.lat, lng: branch.lng },
                    map: map,
                    title: branch.name,
                    animation: google.maps.Animation.DROP,
                    icon: {
                        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#10b981">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        `),
                        scaledSize: new google.maps.Size(40, 40)
                    }
                });
                
                markers.push(marker);
                
                // Add click listener to marker
                marker.addListener('click', function() {
                    const contentString = createInfoWindowContent(branch);
                    infoWindow.setContent(contentString);
                    infoWindow.open(map, marker);
                });
                
                // Open selected marker by default
                if (index === selectedIndex) {
                    const contentString = createInfoWindowContent(branch);
                    infoWindow.setContent(contentString);
                    infoWindow.open(map, marker);
                }
            });
        }
        
        // Fallback if Maps API fails to load
        window.addEventListener('error', function(e) {
            if (e.message.includes('maps')) {
                document.getElementById('map').innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #fee; border-radius: 12px; padding: 20px; text-align: center;">
                        <div>
                            <h3 style="color: #dc2626; font-weight: bold; margin-bottom: 8px;">
                                ⚠️ Google Maps API Error
                            </h3>
                            <p style="color: #7f1d1d; font-size: 14px;">
                                Pastikan GOOGLE_MAPS_API_KEY sudah diset di file .env
                            </p>
                        </div>
                    </div>
                `;
            }
        }, true);
    </script>

</body>
</html>
