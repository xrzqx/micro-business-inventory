@extends('layouts.app')

@section('content')
<div class="container-f">
    <div class="sidenav">
        <ul class="main-list">
            <li class="nonlist-item">
                <a href="/">Dashboard</a>
            </li>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Pinjaman</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{ route('customer.index') }}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('pinjaman.index')}}">Daftar Pinjaman</a></li>
                <li class="sublist-item"><a href="{{route('pinjamankeuangan.index')}}">Laporan Keuangan</a></li>
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Salesperson</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{ route('sales.index') }}">Daftar Sales</a></li>
                <li class="sublist-item"><a href="{{route('salespembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('salespenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('saleskeuangan.index')}}">Laporan Keuangan</a></li>
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>SGH Motor</span>
                    <span class="material-symbols-outlined toggle-icon rotate">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist">
                <li class="sublist-item"><a href="{{route('motorcustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('motorkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('motor.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('motorpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('motorpenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('motorpengeluaran.index')}}">Pengeluaran</a></li>
                <li class="sublist-item"><a href="{{route('motorlaporanmovingstock.index')}}">Laporan Moving Stock</a></li>
                <li class="sublist-item"><a href="{{route('motorlaporancustomer.index')}}">Laporan Customer</a></li>
                <li class="sublist-item"><a href="{{route('motorlaporanpenjualan.index')}}">Laporan Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('motorkeuangan.index')}}">Laporan Keuangan</a></li>
                <li class="sublist-item"><a href="{{route('motorlaporanlabakategori.index')}}">Laporan Laba (Category Wise)</a></li>
                <li class="sublist-item selected"><a href="{{route('motorlaporanlababulan.index')}}">Laporan Laba (Month Wise)</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>SGH Studio</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('studiocustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('studiokategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('studio.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('studioproduk.index')}}">Daftar Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopembelian.index')}}">Pembelian Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopengeluaran.index')}}">Pengeluaran</a></li>
                <li class="sublist-item"><a href="{{route('studiolimbah.index')}}">Limbah Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiolaporancustomer.index')}}">Laporan Customer</a></li>
                <li class="sublist-item"><a href="{{route('studiostock.index')}}">Laporan Stock</a></li>
                <li class="sublist-item"><a href="{{route('studiokeuangan.index')}}">Laporan Keuangan</a></li>
                <li class="sublist-item"><a href="{{route('studiolaporanlabakategori.index')}}">Laporan Laba (Category Wise)</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Rokok</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('rokokcustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('rokokkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('rokok.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('rokokpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('rokokpenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('rokokkeuangan.index')}}">Laporan Keuangan</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Minyak</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('minyakcustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('minyakkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('minyak.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('minyakpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('minyakpenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('minyakkeuangan.index')}}">Laporan Keuangan</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Beras</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('berascustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('beraskategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('beras.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('beraspembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('beraspenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('beraskeuangan.index')}}">Laporan Keuangan</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Brilink</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('brilinkbank.index')}}">Daftar Bank</a></li>
                <li class="sublist-item"><a href="{{route('brilink.index')}}">Daftar Transaksi</a></li>
                <li class="sublist-item"><a href="{{route('brilinkkeuangan.index')}}">Laporan Keuangan</a></li>
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Pupuk</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('pupukcustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('pupukkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('pupuk.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('pupukpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('pupukpenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('pupuklaporanpenjualan.index')}}">Laporan Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('pupukkeuangan.index')}}">Laporan Keuangan</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
        </ul>
    </div>
    <button class="toggle-btn-sidenav">
        <span class="material-symbols-outlined toggle-icon-sidenav">
            chevron_right
        </span>
    </button>
    <div class="content">
        <h1>Laporan Laba (Month Wise)</h1>
        <form class="d-flex" action="{{route('motorlaporanlababulan.search')}}" method="GET">
            <div class="col-sm-6 p-0">
                <div class="row">
                    <div class="col-sm-12 form-group mb-0">
                        <div class="input-group">
                            <select class="form-control form-control-sm" id="test" style="height: 100%; min-height: 38px;" name="year">
                                <?php
                                    $currentYear = date('Y');
                                    $startYear = 2020; // Change as needed
                                    for ($year = $currentYear; $year >= $startYear; $year--) {
                                        if ($tahunStart == $year) {
                                            echo "<option value=\"$year\" selected>$year</option>";
                                        }
                                        else{
                                            echo "<option value=\"$year\">$year</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        @if (Session::has('success'))
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Berhasil </strong> {{ Session::get('success') }}
        </div>
        <script>
            $("#success-alert").fadeTo(5000, 500).slideUp(500);

        </script>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger" id="failed-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Tidak berhasil </strong> menambahkan/mengubah data
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <script>
            $("#failed-alert").fadeTo(5000, 500).slideUp(500);

        </script>
        @endif
        {{-- <span>Tahun : {{$tahunStart}} </span> --}}
        <div style="width: 100%; margin: auto;">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>
<script>
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($data['labels']),
            datasets: [{
                label: 'Jumlah',
                data: @json($data['data']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
