@extends('layouts.app')

@section('content')
    <div class="modal fade modal-item" id="kategoriModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="kategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title exampleModalLabel" id="kategoriModalLabel">Tambah Kategori</h5>
                </div>
                <form method="POST" action="{{ route('pupukcustomer.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label>Nama Customer</label>
                                <input type="text" class="form-control form-control-sm nama-produk"
                                    name="namacustomer" />
                                <div class="text-err">
                                    @error('namacustomer')
                                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                                            width="16px" height="16px" viewBox="0 0 24 24"
                                            xmlns="https://www.w3.org/2000/svg">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                                            </path>
                                        </svg>
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control form-control-sm nik-produk"
                                    oninput="validateNumber(this)" placeholder="Input harus angka" name="nik" />
                                <div class="text-err">
                                    @error('nik')
                                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                                            width="16px" height="16px" viewBox="0 0 24 24"
                                            xmlns="https://www.w3.org/2000/svg">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                                            </path>
                                        </svg>
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label>Lokasi</label>
                                <input type="text" class="form-control form-control-sm lokasi-produk" name="lokasi" />
                                <div class="text-err">
                                    @error('lokasi')
                                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                                            width="16px" height="16px" viewBox="0 0 24 24"
                                            xmlns="https://www.w3.org/2000/svg">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-save" value="Save changes">
                    </div>
                </form>

            </div>
        </div>
    </div>

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
                    <li class="sublist-item"><a href="{{ route('pinjaman.index') }}">Daftar Pinjaman</a></li>
                    <li class="sublist-item"><a href="{{ route('pinjamankeuangan.index') }}">Laporan Keuangan</a></li>
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
                    <li class="sublist-item"><a href="{{ route('salespembelian.index') }}">Pembelian</a></li>
                    <li class="sublist-item"><a href="{{ route('salespenjualan.index') }}">Penjualan</a></li>
                    <li class="sublist-item"><a href="{{ route('saleskeuangan.index') }}">Laporan Keuangan</a></li>
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
                    <li class="sublist-item"><a href="{{ route('motorcustomer.index') }}">Daftar Customer</a></li>
                    <li class="sublist-item"><a href="{{ route('motorkategori.index') }}">Daftar Kategori</a></li>
                    <li class="sublist-item"><a href="{{ route('motor.index') }}">Daftar Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('motorpembelian.index') }}">Pembelian</a></li>
                    <li class="sublist-item"><a href="{{ route('motorpenjualan.index') }}">Penjualan</a></li>
                    <li class="sublist-item"><a href="{{ route('motorpengeluaran.index') }}">Pengeluaran</a></li>
                    <li class="sublist-item"><a href="{{ route('motorlaporanmovingstock.index') }}">Laporan Moving
                            Stock</a></li>
                    <li class="sublist-item"><a href="{{ route('motorlaporancustomer.index') }}">Laporan Customer</a>
                    </li>
                    <li class="sublist-item"><a href="{{ route('motorlaporanpenjualan.index') }}">Laporan Penjualan</a>
                    </li>
                    <li class="sublist-item"><a href="{{ route('motorkeuangan.index') }}">Laporan Keuangan</a></li>
                    <li class="sublist-item"><a href="{{ route('motorlaporanlabakategori.index') }}">Laporan Laba
                            (Category Wise)</a></li>
                    <li class="sublist-item"><a href="{{ route('motorlaporanlababulan.index') }}">Laporan Laba (Month
                            Wise)</a></li>
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
                    <li class="sublist-item"><a href="{{ route('studiocustomer.index') }}">Daftar Customer</a></li>
                    <li class="sublist-item"><a href="{{ route('studiokategori.index') }}">Daftar Kategori</a></li>
                    <li class="sublist-item"><a href="{{ route('studio.index') }}">Daftar Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('studioproduk.index') }}">Daftar Produk</a></li>
                    <li class="sublist-item"><a href="{{ route('studiopembelian.index') }}">Pembelian Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('studiopenjualan.index') }}">Penjualan Produk</a></li>
                    <li class="sublist-item"><a href="{{ route('studiopengeluaran.index') }}">Pengeluaran</a></li>
                    <li class="sublist-item"><a href="{{ route('studiolimbah.index') }}">Limbah Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('studiolaporancustomer.index') }}">Laporan Customer</a>
                    </li>
                    <li class="sublist-item"><a href="{{ route('studiostock.index') }}">Laporan Stock</a></li>
                    <li class="sublist-item"><a href="{{ route('studiokeuangan.index') }}">Laporan Keuangan</a></li>
                    <li class="sublist-item"><a href="{{ route('studiolaporanlabakategori.index') }}">Laporan Laba
                            (Category Wise)</a></li>
                    <li class="sublist-item"><a href="{{ route('studiolaporanlababulan.index') }}">Laporan Laba (Month
                            Wise)</a></li>
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
                    <li class="sublist-item"><a href="{{ route('rokokcustomer.index') }}">Daftar Customer</a></li>
                    <li class="sublist-item"><a href="{{ route('rokokkategori.index') }}">Daftar Kategori</a></li>
                    <li class="sublist-item"><a href="{{ route('rokok.index') }}">Daftar Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('rokokpembelian.index') }}">Pembelian</a></li>
                    <li class="sublist-item"><a href="{{ route('rokokpenjualan.index') }}">Penjualan</a></li>
                    <li class="sublist-item"><a href="{{ route('rokokkeuangan.index') }}">Laporan Keuangan</a></li>
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
                    <li class="sublist-item"><a href="{{ route('minyakcustomer.index') }}">Daftar Customer</a></li>
                    <li class="sublist-item"><a href="{{ route('minyakkategori.index') }}">Daftar Kategori</a></li>
                    <li class="sublist-item"><a href="{{ route('minyak.index') }}">Daftar Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('minyakpembelian.index') }}">Pembelian</a></li>
                    <li class="sublist-item"><a href="{{ route('minyakpenjualan.index') }}">Penjualan</a></li>
                    <li class="sublist-item"><a href="{{ route('minyakkeuangan.index') }}">Laporan Keuangan</a></li>
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
                    <li class="sublist-item"><a href="{{ route('berascustomer.index') }}">Daftar Customer</a></li>
                    <li class="sublist-item"><a href="{{ route('beraskategori.index') }}">Daftar Kategori</a></li>
                    <li class="sublist-item"><a href="{{ route('beras.index') }}">Daftar Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('beraspembelian.index') }}">Pembelian</a></li>
                    <li class="sublist-item"><a href="{{ route('beraspenjualan.index') }}">Penjualan</a></li>
                    <li class="sublist-item"><a href="{{ route('beraskeuangan.index') }}">Laporan Keuangan</a></li>
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
                    <li class="sublist-item"><a href="{{ route('brilinkbank.index') }}">Daftar Bank</a></li>
                    <li class="sublist-item"><a href="{{ route('brilink.index') }}">Daftar Transaksi</a></li>
                    <li class="sublist-item"><a href="{{ route('brilinkkeuangan.index') }}">Laporan Keuangan</a></li>
                </ul>
                <li class="toggle-sublist">
                    <div class="flex-row-list">
                        <span>Pupuk</span>
                        <span class="material-symbols-outlined toggle-icon rotate">
                            chevron_right
                        </span>
                    </div>
                </li>
                <ul class="sublist">
                    <li class="sublist-item selected"><a href="{{ route('pupukcustomer.index') }}">Daftar Customer</a>
                    </li>
                    <li class="sublist-item"><a href="{{ route('pupukkategori.index') }}">Daftar Kategori</a></li>
                    <li class="sublist-item"><a href="{{ route('pupuk.index') }}">Daftar Barang</a></li>
                    <li class="sublist-item"><a href="{{ route('pupukpembelian.index') }}">Pembelian</a></li>
                    <li class="sublist-item"><a href="{{ route('pupukpenjualan.index') }}">Penjualan</a></li>
                    <li class="sublist-item"><a href="{{ route('pupuklaporanpenjualan.index') }}">Laporan Penjualan</a>
                    </li>
                    <li class="sublist-item"><a href="{{ route('pupukkeuangan.index') }}">Laporan Keuangan</a></li>
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
            <h1>Daftar Customer</h1>
            <div class="row">
                <div class="col-sm-8">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#kategoriModalCenter">
                        Tambah Kategori
                    </button>
                </div>
                <div class="col-sm-4">
                    <form class="d-flex" action="{{ route('pupukcustomer.search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="namacustomer"
                                value="{{ request('search') }}" placeholder="Cari nama kategori">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
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
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <th>NIK/NPWP</th>
                        <th>Lokasi</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($customer as $key => $item)
                        <tr>
                            <td>
                                {{ $item->nama }}
                            </td>
                            <td>
                                {{ $item->nik }}
                            </td>
                            <td>
                                {{ $item->lokasi }}
                            </td>
                            <td>
                                <button type="button" style="background-color: yellow">
                                    <a href="{{ route('pupukcustomer.edit', $item->id) }}"
                                        style="color: black;text-decoration-line: none">edit</a>
                                </button>
                                <form method="post" action="{{ route('pupukcustomer.destroy', $item->id) }}"
                                    style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" style="background-color: lightcoral"
                                        onclick="return confirm('Are you sure you want to delete this post?')">hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $customer->appends(request()->input())->links() }}
        </div>
    </div>

    <script>
        function validateNumber(input) {
            // Remove non-numeric characters
            input.value = input.value.replace(/[^0-9]/g, '');

            // Remove leading zeros
            input.value = input.value.replace(/^0+/, '');

            // Limit the input to a maximum of 13 digits
            var maxDigits = 20;
            if (input.value.length > maxDigits) {
                input.value = input.value.slice(0, maxDigits);
            }

            // Parse the input value to an integer
            var numericValue = parseInt(input.value, 10);
        }
    </script>
@endsection
