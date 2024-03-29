@extends('layouts.app')

@section('content')
<div class="container-f">
    <div class="sidenav">
        <ul class="main-list">
            {{-- <div class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Store</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </div>
            <li class="toggle-sublist test hide">
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
            </ul> --}}

            <li class="nonlist-item selected">
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
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
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
                <li class="sublist-item"><a href="{{route('motorlaporanlababulan.index')}}">Laporan Laba (Month Wise)</a></li>
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
                <li class="sublist-item"><a href="{{route('studiolaporanlababulan.index')}}">Laporan Laba (Month Wise)</a></li>
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
                    Laba Kotor
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
                            <div>Rp. {{ number_format($labakotor_today, 0, ',', '.') }}</div>
                            <div>Rp. xxx.000</div>
                            <div>Rp. x.xxx.000</div>
                            <div>Rp. x.xxx.000</div>
                            <div>Rp. x.xxx.000</div>
                            <div>Rp. xx.xxx.000</div>
                            <div>Rp. x.xxx.xxx.000</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card-container">
            <div class="card-f">
                <div class="card-title-f">
                    Laba Kotor
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
                                Sparepart
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
                                Studio
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
                                Rokok
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
                                Minyak
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
                                Beras
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
                                Brilink
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
                                Pupuk
                            </div>
                            <div>Rp. 500.000</div>
                            <div>Rp. 400.000</div>
                            <div>Rp. 2.300.000</div>
                            <div>Rp. 4.000.000</div>
                            <div>Rp. 8.400.000</div>
                            <div>Rp. 16.700.000</div>
                            <div>Rp. 1.114.700.000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        
    </div>
</div>
@endsection
