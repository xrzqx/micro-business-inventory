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
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('motorcustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{ route('motorkategori.index') }}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('motor.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{ route('motorpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{ route('motorpenjualan.index')}}">Penjualan</a></li>
                <li class="sublist-item"><a href="{{route('motorpengeluaran.index')}}">Pengeluaran</a></li>
                <li class="sublist-item"><a href="{{route('motorlaporanpenjualan.index')}}">Laporan Penjualan</a></li>
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
                <li class="sublist-item"><a href="{{route('studiocustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('studiokategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('studio.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('studioproduk.index')}}">Daftar Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopembelian.index')}}">Pembelian Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopengeluaran.index')}}">Pengeluaran</a></li>
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
                    <span class="material-symbols-outlined toggle-icon rotate">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist">
                <li class="sublist-item"><a href="{{route('minyakcustomer.index')}}">Daftar Customer</a></li>
                <li class="sublist-item"><a href="{{route('minyakkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('minyak.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('minyakpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item selected"><a href="{{route('minyakpenjualan.index')}}">Penjualan</a></li>
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
                    <span>Pupuk</span>
                    <span class="material-symbols-outlined toggle-icon">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist hide">
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
        <h1>Edit Penjualan</h1>
        @if ($errors->any())
        <div class="alert alert-danger" id="failed-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Tidak berhasil </strong> menambahkan/mengubah barang
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <script>
            $("#failed-alert").fadeTo(2000, 500).slideUp(500, function () {
                $("#failed-alert").slideUp(500);
            });

        </script>
        @endif
        <form method="POST" action="{{route('minyakpenjualan.update', $penjualan->id)}}">
            @csrf
            @method('POST')
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label>Nama Customer</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="customer" id="nama-customer">
                                <option value="" disabled selected hidden>Pilih Customer</option>
                                @foreach ($customer as $value)
                                    @if (isset($penjualan->customer) && $penjualan->customer->id == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->nama }}</option>
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @error('customer')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                            width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Nama Barang</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="nama" id="kategori-produk">
                                <option value="" disabled selected hidden>Pilih Barang</option>
                                @foreach ($barang as $value)
                                    @if ($pembelian->master_item_id == $value->master_item_id)
                                        <option value="{{ $value->master_item_id }}" selected>{{ $value->barang->item->kode }} | {{ $value->barang->item->nama }}</option>
                                    @else
                                        <option value="{{ $value->master_item_id }}">{{ $value->barang->item->kode }} | {{ $value->barang->item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @error('nama')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                            width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Batch</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="batch" id="batch-produk">
                                <option value="" disabled selected hidden>Pilih Batch</option>
                            </select>
                        </div>
                        @error('batch')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                            width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Jumlah</label>
                        <input type="text" class="form-control form-control-sm jumlah-produk" 
                        oninput="validateInput(this,{{$pembelian->sisa + $penjualan->jumlah}})" placeholder="Input harus angka" name="jumlah" 
                        id="jumlahInp" value="{{$penjualan->jumlah}}"
                        />
                        @error('jumlah')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                            width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control form-control-sm harga-produk"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                            placeholder="input harus angka" name="harga" value="{{$penjualan->harga}}" />
                        @error('harga')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false" width="16px"
                            height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control form-control-sm tanggal-produk" id="my_date_picker"
                            name="tanggal" value="{{date('d-m-Y', $penjualan->tanggal)}}" />
                        <div class="text-err">
                            @error('tanggal')
                            <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                                width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                                </path>
                            </svg>
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-12">
                <div class="col-12">
                    <button type="button" class="btn btn-secondary">
                        <a href="{{route('minyakpenjualan.index')}}"
                            style="color: white; text-decoration-line: none">back</a>
                    </button>
                    <input type="submit" class="btn btn-primary btn-save" value="Save changes">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function validateInput(input,x) {
        // Remove non-numeric characters
        input.value = input.value.replace(/[^0-9]/g, '');

        // Remove leading zeros
        input.value = input.value.replace(/^0+/g, '');

        // Limit the input to a maximum of stock
        var maxStock = x;
        var numericMaxStock = parseInt(maxStock, 10);
        const numericValue = parseInt(input.value, 10);
        if (!isNaN(numericValue) && numericValue > numericMaxStock) {
            input.value = maxStock;
        }
    }

</script>
<script>
    // Wait for the document to be ready
    $(document).ready(function () {
        // Perform AJAX request
        $.ajax({
            url: '{{ route('fetch.batch') }}', // Replace with your actual endpoint
            method: 'GET',
            data: {
                masterItemId: {{$pembelian->master_item_id}}
            },
            success: function (response) {
                // Clear existing options
                $('#batch-produk').empty();
                $('#batch-produk').append('<option value="" disabled selected hidden>Pilih Batch</option>');
                // Populate options based on the AJAX response
                $.each(response, function (index, value) {
                    if (value.het != null) {
                        $('#batch-produk').append('<option value="' + value.id + '"selected>' + value
                        .batch + " | Stock: " + value.sisa + ' | HB: ' + value.harga/value.jumlah + ' | HET: ' + value.het +'</option>');
                    }
                    else{
                        if ({{$pembelian->id}} == value.id) {
                            $('#batch-produk').append('<option value="' + value.id + '" selected>' + value
                            .batch + " | Stock: " + value.sisa + ' | HB: ' + value.harga/value.jumlah +'</option>');
                        }
                        else{
                            $('#batch-produk').append('<option value="' + value.id + '">' + value
                            .batch + " | Stock: " + value.sisa + ' | HB: ' + value.harga/value.jumlah +'</option>');
                        }
                    }
                });

                // Trigger Select2 to update the UI
                // $('#batch-produk').trigger('change');
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });
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
                    if (value.het != null) {
                        $('#batch-produk').append('<option value="' + value.id + '">' + value
                        .batch + " | Stock: " + value.sisa + ' | HB: ' + value.harga/value.jumlah + ' | HET: ' + value.het +'</option>');
                    }
                    else{
                        $('#batch-produk').append('<option value="' + value.id + '">' + value
                        .batch + " | Stock: " + value.sisa + ' | HB: ' + value.harga/value.jumlah +'</option>');
                    }
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
