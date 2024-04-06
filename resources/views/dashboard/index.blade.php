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
                <span>Beban</span>
                <span class="material-symbols-outlined toggle-icon">
                    chevron_right
                </span>
            </div>
        </li>
        <ul class="sublist hide">
            <li class="sublist-item"><a href="{{ route('bebankategori.index') }}">Daftar Kategori</a></li>
            <li class="sublist-item"><a href="{{ route('beban.index') }}">Daftar Beban</a></li>
            <li class="sublist-item"><a href="{{ route('bebanlaporan.index') }}">Laporan Beban</a></li>
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
            <li class="sublist-item"><a href="{{route('motorlaporanlabakategori.index')}}">Laporan Laba (Category
                    Wise)</a></li>
            <li class="sublist-item"><a href="{{route('motorlaporanlababulan.index')}}">Laporan Laba (Month Wise)</a>
            </li>
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
            <li class="sublist-item"><a href="{{route('studiolaporanlabakategori.index')}}">Laporan Laba (Category
                    Wise)</a></li>
            <li class="sublist-item"><a href="{{route('studiolaporanlababulan.index')}}">Laporan Laba (Month Wise)</a>
            </li>
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
                            <div>Rp. {{ number_format($data_laba_kotor['today'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_laba_kotor['yesterday'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_laba_kotor['last7days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_laba_kotor['last30days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_laba_kotor['last60days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_laba_kotor['last90days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_laba_kotor['alltime'], 0, ',', '.') }}</div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-f">
                <div class="card-title-f">
                    Pinjaman
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
                            <div>Rp. {{ number_format($data_pinjaman['today'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pinjaman['yesterday'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pinjaman['last7days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pinjaman['last30days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pinjaman['last60days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pinjaman['last90days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pinjaman['alltime'], 0, ',', '.') }}</div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-f">
                <div class="card-title-f">
                    Pengeluaran
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
                            <div>Rp. {{ number_format($data_pengeluaran['today'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pengeluaran['yesterday'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pengeluaran['last7days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pengeluaran['last30days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pengeluaran['last60days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pengeluaran['last90days'], 0, ',', '.') }}</div>
                            <div>Rp. {{ number_format($data_pengeluaran['alltime'], 0, ',', '.') }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-container" style="margin-top: 0.5rem">
            <div class="card-f-chart">
                <div class="card-title-f">
                    Laba Kotor
                </div>
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <div class="card-f-chart">
                <div class="card-title-f">
                    Pengeluaran
                </div>
                <canvas id="myChartPengeluaran" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    // Sample data for the pie chart
    var sparepartPercentage = {{round(($laba_kotor_sparepart['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    var studioPercentage = {{round(($laba_kotor_studio['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    var rokokPercentage = {{round(($laba_kotor_rokok['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    var minyakPercentage = {{round(($laba_kotor_minyak['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    var berasPercentage = {{round(($laba_kotor_beras['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    var brilinkPercentage = {{round(($laba_kotor_brilink['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    var pupukPercentage = {{round(($laba_kotor_pupuk['alltime']/$data_laba_kotor['alltime']) * 100, 2)}};
    const data = {
        labels: ['Sparepart ' + sparepartPercentage + '%', 'Studio ' + studioPercentage + '%', 
            'Rokok '+ rokokPercentage + '%', 'Minyak '+ minyakPercentage + '%', 
            'Beras '+ berasPercentage + '%', 'Brilink ' + brilinkPercentage + '%', 'Pupuk '+ pupukPercentage + '%'],
        datasets: [{
            label: 'Jumlah',
            data: [{{$laba_kotor_sparepart['alltime']}}, {{$laba_kotor_studio['alltime']}}, 
                {{$laba_kotor_rokok['alltime']}}, {{$laba_kotor_minyak['alltime']}},{{$laba_kotor_beras['alltime']}},
                {{$laba_kotor_brilink['alltime']}},{{$laba_kotor_pupuk['alltime']}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)', // New color
                'rgba(255, 159, 64, 0.5)', // New color
                'rgba(255, 0, 0, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)', // New color
                'rgba(255, 159, 64, 1)', // New color
                'rgba(255, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Chart configuration
    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                // title: {
                //     display: true,
                //     text: 'Fruit Distribution'
                // }
            }
        }
    };

    // Create the chart
    const myChart = new Chart(document.getElementById('myChart'), config);

</script>
<script>
    var sparepartPengeluaranPercentage = {{round(( ($data_pengeluaran_chart['alltime']['motor']+$data_pengeluaran_chart['alltime']['SGH_Motor']) /$data_pengeluaran['alltime']) * 100, 2)}};
    var studioPengeluaranPercentage = {{round((($data_pengeluaran_chart['alltime']['studio']+$data_pengeluaran_chart['alltime']['SGH_Studio']) /$data_pengeluaran['alltime']) * 100, 2)}};
    var rokokPengeluaranPercentage = {{round(($data_pengeluaran_chart['alltime']['rokok']/$data_pengeluaran['alltime']) * 100, 2)}};
    var minyakPengeluaranPercentage = {{round(($data_pengeluaran_chart['alltime']['minyak']/$data_pengeluaran['alltime']) * 100, 2)}};
    var berasPengeluaranPercentage = {{round(($data_pengeluaran_chart['alltime']['beras']/$data_pengeluaran['alltime']) * 100, 2)}};
    var pupukPengeluaranPercentage = {{round(($data_pengeluaran_chart['alltime']['pupuk']/$data_pengeluaran['alltime']) * 100, 2)}};
    // Sample data for the pie chart
    const dataPengeluaran = {
        labels: ['Sparepart ' + sparepartPengeluaranPercentage + '%', 'Studio ' + studioPengeluaranPercentage + '%', 'Rokok ' + rokokPengeluaranPercentage + '%', 'Minyak ' + minyakPengeluaranPercentage + '%', 'Beras ' + berasPengeluaranPercentage+ '%', 'Pupuk ' + pupukPengeluaranPercentage + '%'],
        datasets: [{
            label: 'Jumlah',
            data: [{{$data_pengeluaran_chart['alltime']['motor'] + $data_pengeluaran_chart['alltime']['SGH_Motor']}}, 
                {{$data_pengeluaran_chart['alltime']['studio'] + $data_pengeluaran_chart['alltime']['SGH_Studio']}}, 
                {{$data_pengeluaran_chart['alltime']['rokok']}}, {{$data_pengeluaran_chart['alltime']['minyak']}},
                {{$data_pengeluaran_chart['alltime']['beras']}}, {{$data_pengeluaran_chart['alltime']['pupuk']}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)', // New color
                'rgba(255, 0, 0, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)', // New color
                'rgba(255, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Chart configuration
    const configPengeluaran = {
        type: 'pie',
        data: dataPengeluaran,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    };

    // Create the chart
    const myChartPengeluaran = new Chart(document.getElementById('myChartPengeluaran'), configPengeluaran);

</script>
@endsection
