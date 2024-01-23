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
                    <span>SGH Motor</span>
                    <span class="material-symbols-outlined toggle-icon rotate">
                        chevron_right
                    </span>
                </div>
            </li>
            <ul class="sublist">
                <li class="sublist-item"><a href="{{ route('motorkategori.index') }}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('motor.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{ route('motorpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item selected"><a href="{{ route('motorpenjualan.index')}}">Penjualan</a></li>
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
                {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                <li class="sublist-item"><a href="{{route('studiokategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('studio.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('studioproduk.index')}}">Daftar Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopembelian.index')}}">Pembelian Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiolimbah.index')}}">Limbah Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiostock.index')}}">Laporan Stock</a></li>
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
                {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                <li class="sublist-item">Daftar Barang</li>
                <li class="sublist-item">Pembelian</li>
                <li class="sublist-item">Penjualan</li>
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
                {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                <li class="sublist-item">Daftar Barang</li>
                <li class="sublist-item">Pembelian</li>
                <li class="sublist-item">Penjualan</li>
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
                {{-- <li class="sublist-item" onclick="toggleSublistItem(this)">Master Item</li> --}}
                <li class="sublist-item">Daftar Paket</li>
                <li class="sublist-item">Transaksi</li>
                <!-- Add more sublist items as needed -->
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
        {{-- <form method="POST" action="{{route('motorpenjualan.update', $penjualan[0]->id)}}"> --}}
        <form method="POST" action="">
            @csrf
            @method('POST')
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label>Nama Customer</label>
                        <input type="text" class="form-control form-control-sm supplier-produk" name="customer" />
                        <div class="text-err">
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
                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Nama Barang</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="nama" id="kategori-produk">
                                <option value="#" disabled selected hidden>Pilih Barang</option>
                                {{-- @foreach ($barang as $value)
                                    @if ($value->id == $pembelian[0]->master_item_id)
                                        <option selected value="{{ $value->id }}">{{ $value->item->nama }}</option>
                                @else
                                <option value="{{ $value->id }}">{{ $value->item->nama }}</option>
                                @endif
                                @endforeach --}}
                            </select>
                        </div>
                        @error('nama')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false" width="16px"
                            height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- {{$pembelianSelect}} --}}
                    <div class="col-sm-12 form-group">
                        <label>Batch</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="batch" id="batch-produk">
                                <option value="" disabled hidden>Pilih Batch</option>
                                <option value="" selected>{{$pembelian->batch}}</option>
                                <option value="1" selected>test 1</option>
                                <option value="2" selected>test 2</option>
                            </select>
                        </div>
                        @error('batch')
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
                        <label>Jumlah</label>
                        {{-- <input type="text" class="form-control form-control-sm jumlah-produk"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                            placeholder="input harus angka" name="jumlah" /> --}}
                        <input type="text" class="form-control form-control-sm jumlah-produk"
                            oninput="validateInput(this)" placeholder="Input harus angka" name="jumlah" id="jumlahInp"
                            data-dynamic-value="0" value="{{$penjualan->jumlah}}" />
                        @error('jumlah')
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
                        <label>Harga</label>
                        <input type="text" class="form-control form-control-sm harga-produk"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                            placeholder="input harus angka" name="harga" value="{{$pembelian->harga}}" />
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
                            name="tanggal" value="{{date('m/d/Y', $penjualan->tanggal)}}" />
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
                        <a href="{{route('motorpembelian.index')}}"
                            style="color: white; text-decoration-line: none">back</a>
                    </button>
                    <input type="submit" class="btn btn-primary btn-save" value="Save changes">
                </div>
            </div>
        </form>
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

@endsection
