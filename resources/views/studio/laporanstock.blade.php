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
                <li class="sublist-item"><a href="{{route('motorlaporanlabakategori.index')}}">Laporan Laba (Category Wise)</a></li>
                <li class="sublist-item"><a href="{{route('motorlaporanlababulan.index')}}">Laporan Laba (Month Wise)</a></li>
                <!-- Add more sublist items as needed -->
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>SGH Studio</span>
                    <span class="material-symbols-outlined toggle-icon rotate">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist">
                <li class="sublist-item"><a href="{{route('studiocustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('studiokategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('studio.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('studioproduk.index')}}">Daftar Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopembelian.index')}}">Pembelian Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopengeluaran.index')}}">Pengeluaran</a></li>
                <li class="sublist-item"><a href="{{route('studiolimbah.index')}}">Limbah Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiolaporancustomer.index')}}">Laporan Customer</a></li>
                <li class="sublist-item selected"><a href="{{route('studiostock.index')}}">Laporan Stock</a></li>
                <li class="sublist-item"><a href="{{route('studiokeuangan.index')}}">Laporan Keuangan</a></li>
                <li class="sublist-item"><a href="{{route('studiolaporanlabakategori.index')}}">Laporan Laba (Category Wise)</a></li>
                <li class="sublist-item"><a href="{{route('studiolaporanlababulan.index')}}">Laporan Laba (Month Wise)</a></li>
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
        <h1>Laporan Stock</h1>
        <div class="row">
            <div class="col-sm-12">
                <form class="d-flex align-items-center text-center" action="{{ route('studiostock.search') }}" method="GET">
                    <div class="input-group mb-3">
                        <label for="my_date_picker" class="mr-2" style="display:flex; align-items: center; font-size: 1.2rem">Tanggal:</label>
                        <input type="text" class="form-control form-control-sm tanggal-produk" id="my_date_picker" name="tanggal" value="{{ request('date') }}" autocomplete="off"/>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="mb-3">Tanggal : {{ request('tanggal') }}</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Nama Barang</th>
                    <th>Stock Awal</th>
                    <th>Masuk</th>
                    <th>Pemakaian</th>
                    <th>Stock Akhir</th>
                </tr>
                @foreach ($data as $key => $value)
                <tr>
                    <td>
                        {{ $value['nama'] }}
                    </td>
                    <td>
                        {{ $value['stock_akhir'] + $value['pemakaian'] - $value['masuk']}}
                    </td>
                    <td>
                        {{ $value['masuk'] }}
                    </td>
                    <td>
                        {{ $value['pemakaian'] }}
                    </td>
                    <td>
                        {{ $value['stock_akhir'] }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        {{-- {{ $data->appends(request()->input())->links() }} --}}
    </div>
</div>

<script>
    function validateInput(input) {
      // Remove non-numeric characters
      input.value = input.value.replace(/[^0-9]/g, '');
  
      // Remove leading zeros
      input.value = input.value.replace(/^0+/g, '');
  
      // Limit the input to a maximum of stock
      var maxStock = document.getElementById('jumlahInp').getAttribute('data-dynamic-value');
      var numericMaxStock = parseInt(maxStock, 10);
      const numericValue = parseInt(input.value, 10);
      if (!isNaN(numericValue) && numericValue > numericMaxStock) {
        input.value = maxStock;
      }
    }
</script>

<script>
    // Attach an event listener to the select2:select event for "kategori-produk"
    $('#kategori-produk').on('select2:select', function (e) {
        var selectedCategoryId = e.params.data.id;

        // Make an AJAX request to fetch data for "batch-produk" based on the selected category
        $.ajax({
            url: '{{ route('fetch.batch') }}', // Replace with your actual endpoint
            method: 'GET',
            data: {
                masterItemId: selectedCategoryId
            },
            success: function (response) {
                // Clear existing options
                $('#batch-produk').empty();
                $('#batch-produk').append('<option value="" disabled selected hidden>Pilih Batch</option>');
                // Populate options based on the AJAX response
                $.each(response, function (index, value) {
                    $('#batch-produk').append('<option value="' + value.id + '">' + value
                        .batch + " | Stock: " + value.sisa +'</option>');
                });

                // Trigger Select2 to update the UI
                $('#batch-produk').trigger('change');
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    $('#batch-produk').on('change', function (e) {
        $('#jumlahInp').val('');
        console.log("Change event triggered");
    });

    $('#batch-produk').on('select2:select', function (e) {
        var selectedBatchText = e.params.data.text;
        // Split the string by '|'
        var parts = selectedBatchText.split('|');

        // Extract the stock data (assuming it's in the second part after the '|')
        var stockData = parts[1].trim().split(':')[1].trim();
        
        // Access the data attribute using JavaScript
        document.getElementById('jumlahInp').setAttribute('data-dynamic-value', stockData);
        console.log(stockData);
    });

</script>
@endsection
