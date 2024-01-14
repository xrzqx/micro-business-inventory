<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGH</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>    
    <div class="container-f">
        <div class="sidenav">
            <ul class="main-list">
                <li class="nonlist-item">
                    Dashboard
                </li>
                <li onclick="toggleSublist(this)">
                    <div class="flex-row-list">
                        <span>SGH Motor</span>
                        <span class="material-symbols-outlined toggle-icon">
                            chevron_right
                        </span>
                    </div>
                </li>
                <ul class="sublist">
                    {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                    <li class="sublist-item">Daftar Barang</li>
                    <li class="sublist-item">Pembelian</li>
                    <li class="sublist-item">Penjualan</li>
                    <!-- Add more sublist items as needed -->
                </ul>
                <li onclick="toggleSublist(this)">
                    <div class="flex-row-list">
                        <span>SGH Studio</span>
                        <span class="material-symbols-outlined toggle-icon">
                            chevron_right
                        </span>
                    </div>
                </li>
                <ul class="sublist">
                    {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                    <li class="sublist-item">Daftar Barang</li>
                    <li class="sublist-item">Pembelian</li>
                    <li class="sublist-item">Penjualan</li>
                    <li class="sublist-item">Limbah</li>
                    <!-- Add more sublist items as needed -->
                </ul>
                <li onclick="toggleSublist(this)">
                    <div class="flex-row-list">
                        <span>Rokok</span>
                        <span class="material-symbols-outlined toggle-icon">
                            chevron_right
                        </span>
                    </div>
                </li>
                <ul class="sublist">
                    {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                    <li class="sublist-item">Daftar Barang</li>
                    <li class="sublist-item">Pembelian</li>
                    <li class="sublist-item">Penjualan</li>
                    <!-- Add more sublist items as needed -->
                </ul>
                <li onclick="toggleSublist(this)">
                    <div class="flex-row-list">
                        <span>Minyak</span>
                        <span class="material-symbols-outlined toggle-icon">
                            chevron_right
                        </span>
                    </div>
                </li>
                <ul class="sublist">
                    {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                    <li class="sublist-item">Daftar Barang</li>
                    <li class="sublist-item">Pembelian</li>
                    <li class="sublist-item">Penjualan</li>
                    <!-- Add more sublist items as needed -->
                </ul>
                <li onclick="toggleSublist(this)">
                    <div class="flex-row-list">
                        <span>Briling</span>
                        <span class="material-symbols-outlined toggle-icon">
                            chevron_right
                        </span>
                    </div>
                </li>
                <ul class="sublist">
                    {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                    <li class="sublist-item">Daftar Barang</li>
                    <li class="sublist-item">Pembelian</li>
                    <li class="sublist-item">Penjualan</li>
                    <!-- Add more sublist items as needed -->
                </ul>
            </ul>
        </div>
        <button class="toggle-btn-sidenav" onclick="toggleSidenav()">
            <span class="material-symbols-outlined toggle-icon-sidenav">
                chevron_right
            </span>
        </button>
        <div class="content">
            <h1>Dashboard</h1>
            <div class="card-container">
                <div class="card-f">
                    <div class="card-title-f">
                        Sales
                    </div>
                    <div class="card-body-f">
                        <div class="f-row">
                            <div class="f-col">
                                <div>#</div>
                                <div>Today</div>
                                <div>Yesterday</div>
                                <div>Last 7 days</div>
                                <div>Last 30 days</div>
                                <div>Last 60 days</div>
                                <div>Last 90 days</div>
                                <div>All time</div>
                            </div>
                            <div class="f-col">
                                <div>
                                    Total
                                </div>
                                <div>Rp. 500.000</div>
                                <div>Rp. 400.000</div>
                                <div>Rp. 2.300.000</div>
                                <div>Rp. 4.000.000</div>
                                <div>Rp. 8.400.000</div>
                                <div>Rp. 16.700.000</div>
                                <div>Rp. 1.114.700.000</div>
                            </div>
                            <div class="f-col">
                                <div>
                                    Order
                                </div>
                                <div>70</div>
                                <div>100</div>
                                <div>1000</div>
                                <div>10000</div>
                                <div>100000</div>
                                <div>1000000</div>
                                <div>10000000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleSublist(element) {
            var sublist = element.nextElementSibling;

            if (sublist.classList.contains('sublist')) {
                sublist.style.display = (sublist.style.display === 'none' || sublist.style.display === '') ? 'block' :
                    'none';
            }

            // Toggle the rotation class
            var toggleIcon = element.querySelector('.toggle-icon');
            toggleIcon.classList.toggle('rotate', sublist.style.display === 'block');
        }

        function toggleSidenav() {
            var sidenav = document.querySelector('.sidenav');
            sidenav.style.display = (sidenav.style.display === 'none' || sidenav.style.display === '') ? 'block' :
                'none';
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
