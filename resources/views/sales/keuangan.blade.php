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
            </ul>
            <li class="toggle-sublist">
                <div class="flex-row-list">
                    <span>Salesperson</span>
                    <span class="material-symbols-outlined toggle-icon rotate">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist">
                <li class="sublist-item"><a href="{{ route('sales.index') }}">Daftar Sales</a></li>
                <li class="sublist-item"><a href="{{route('salespembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('salespenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item selected"><a href="{{route('saleskeuangan.index')}}">Laporan Keuangan</a></li>
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
                <li class="sublist-item"><a href="{{route('motorkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('motor.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('motorpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('motorpenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('motorkeuangan.index')}}">Laporan Keuangan</a></li>
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
                <li class="sublist-item"><a href="{{route('studiokategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('studio.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('studioproduk.index')}}">Daftar Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopembelian.index')}}">Pembelian Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiolimbah.index')}}">Limbah Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiostock.index')}}">Laporan Stock</a></li>
                <li class="sublist-item"><a href="{{route('studiokeuangan.index')}}">Laporan Keuangan</a></li>
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
                    <span>Kafe</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                <li class="sublist-item">Daftar Barang</li>
                <li class="sublist-item">Pembelian</li>
                <li class="sublist-item">Penjualan</li>
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
        <h1>Laporan Keuangan</h1>
        <div class="row">
            <div class="col-sm-8 mb-3">
                <form class="d-flex" action="{{route('saleskeuangan.search')}}" method="GET">
                    <div class="col-sm-4 p-0">
                        <div class="input-group">
                            <select class="js-example-basic-multiple col-sm-12" name="sales[]" multiple="multiple">
                                <option value="" disabled hidden>Pilih Sales</option>
                                @foreach ($sales as $value)
                                    @if ($sales_selected)
                                        @foreach ($sales_selected as $select)
                                            @if ($value->id == $select)
                                                <option value="{{ $value->id }}" selected>{{ $value->nama }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="text" class="form-control form-control-sm" id="my_date_picker"
                                name="start" autocomplete="off" value="{{ request('search') }}" 
                                placeholder="Cari Tanggal Mulai"/>
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="input-group">
                            <select class="js-example-basic-multiple col-sm-12" name="kategori[]" multiple="multiple">
                                <option value="" disabled hidden>Pilih Kategori</option>
                                @foreach ($kategori as $value)
                                    @if ($kategori_selected)
                                        @foreach ($kategori_selected as $select)
                                            @if ($value->toko == $select)
                                                <option value="{{ $value->toko }}" selected>{{ $value->toko }}</option>
                                            @else
                                                <option value="{{ $value->toko }}">{{ $value->toko }}</option>
                                            @endif
                                        @endforeach                                        
                                    @else
                                        <option value="{{ $value->toko }}">{{ $value->toko }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="text" class="form-control form-control-sm" id="my_date_picker2"
                                name="end" autocomplete="off" value="{{ request('search') }}" 
                                placeholder="Cari Tanggal Akhir"/>
                        </div>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

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
        <span>Tanggal : {{$tanggalStart}} </span>
        <span style="margin-left:1rem">Sampai Tanggal: {{$tanggalEnd}}</span>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sales</th>
                        <th>Uraian</th>
                        <th>Qty.</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                        $totalDebit = 0;
                        $totalKredit = 0;
                    @endphp
                    @foreach ($data as $value)
                        <tr>
                            <td>{{ ++$no }}</td>
                            @if (isset($value['pembelian']))
                                <td>{{$value['sales']['nama']}}</td>
                                <td>Pembelian {{ $value['pembelian']['barang']['item']['nama']}} BATCH {{ $value['pembelian']['batch'] }}</td>
                                <td>{{ $value['total_barang']}}</td>
                                <td>0</td>
                                <td>{{ number_format($value['total_harga'], 0, ',', '.') }}</td>
                                @php
                                    $totalKredit += $value['total_harga'];
                                @endphp
                            @else
                                <td>{{$value['sales_pembelian']['sales']['nama']}}</td>
                                <td>Penjualan {{ $value['sales_pembelian']['pembelian']['barang']['item']['nama'] }} BATCH {{ $value['sales_pembelian']['pembelian']['batch'] }}</td>
                                <td>{{ $value['total_barang']}}</td>
                                <td>{{ number_format($value['total_harga'], 0, ',', '.') }}</td>
                                <td>0</td>
                                @php
                                    $totalDebit += $value['total_harga'];
                                @endphp
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>{{ number_format($totalDebit, 0, ',', '.') }}</strong></td>
                        <td><strong>{{ number_format($totalKredit, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- {{ $data->appends(request()->input())->links() }} --}}
    </div>
</div>
<script>
    var salesdata;
    // Attach an event listener to the select2:select event for "sales-produk"
    $('#sales-produk').on('select2:select', function (e) {
        var selectedCategoryId = e.params.data.id;
        salesdata = selectedCategoryId;

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
