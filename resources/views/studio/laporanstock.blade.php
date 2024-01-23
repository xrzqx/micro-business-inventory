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
            <ul class="sublist hide">
                <li class="sublist-item"><a href="{{route('motorkategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('motor.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('motorpembelian.index')}}">Pembelian</a></li>
                <li class="sublist-item"><a href="{{route('motorpenjualan.index')}}">Penjualan</a></li>
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
            <ul class="sublist">
                <li class="sublist-item"><a href="{{route('studiokategori.index')}}">Daftar Kategori</a></li>
                <li class="sublist-item"><a href="{{route('studio.index')}}">Daftar Barang</a></li>
                <li class="sublist-item"><a href="{{route('studioproduk.index')}}">Daftar Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiopembelian.index')}}">Pembelian Barang</a></li>
                <li class="sublist-item"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiolimbah.index')}}">Limbah Barang</a></li>
                <li class="sublist-item selected"><a href="{{route('studiostock.index')}}">Laporan Stock</a></li>
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
        <h1>Laporan Stock</h1>
        
        <div class="row">
            <div class="col-sm-8">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Tambah Penjualan
                </button>
            </div>
            <div class="col-sm-4">
                <form class="d-flex" action="{{route('motorpenjualan.search')}}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="namabarang" value="{{ request('search') }}"
                            placeholder="Cari Barang">
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
                    <th>Nama Barang</th>
                    <th>Stock</th>
                    <th>Masuk</th>
                    <th>Pemakaian</th>
                    <th>Stock Akhir</th>
                </tr>

            </table>
        </div>
        {{-- {{ $limbah->appends(request()->input())->links() }} --}}
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