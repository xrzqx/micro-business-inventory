@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade modal-item" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title exampleModalLabel" id="exampleModalLabel">Tambah Penjualan</h5>
            </div>
            <form method="POST" action="{{route('studiopenjualan.store')}}">
                @csrf
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label>Nama Produk</label>
                            <div class="input-group">
                                <select class="js-example-basic-single col-sm-12" name="produk" id="nama-produk">
                                    <option value="" disabled selected hidden>Pilih Produk</option>
                                    @foreach ($produk as $value)
                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('produk')
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
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label>Nama Barang</label>
                            <div class="input-group">
                                <select class="js-example-basic-single col-sm-12" name="namaDynamic[]" id="kategori-produk">
                                    <option value="" disabled selected hidden>Pilih Barang</option>
                                    @foreach ($barang as $value)
                                        <option value="{{ $value->master_item_id }}">{{ $value->barang->item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('namaDynamic[]')
                            <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                                width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                                </path>
                            </svg>
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Batch</label>
                            <div class="input-group">
                                <select class="js-example-basic-single col-sm-12" name="batchDynamic[]" id="batch-produk">
                                    <option value="" disabled selected hidden>Pilih Batch</option>
                                </select>
                            </div>
                            @error('batchDynamic[]')
                            <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                                width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                                </path>
                            </svg>
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control form-control-sm jumlah-produk" 
                            oninput="validateInput(this)" placeholder="Input harus angka" name="jumlahDynamic[]" 
                            id="jumlahInp" data-dynamic-value="0"
                            />
                            @error('jumlahDynamic[]')
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
                    <div id="addMore">

                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <button type="button" class="btn btn-primary btn-more" id="addButton">Add More</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label>Jumlah Produk</label>
                            <input type="text" class="form-control form-control-sm jumlah-produk" 
                            oninput="validateInput(this)" placeholder="Input harus angka" name="jprod" 
                            id="jumlahInp" data-dynamic-value="0"
                            />
                            @error('jprod')
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

                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label>Harga</label>
                            <input type="text" class="form-control form-control-sm harga-produk"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                placeholder="input harus angka" name="harga" />
                            @error('harga')
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
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control form-control-sm tanggal-produk" id="my_date_picker"
                                name="tanggal" />
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
                <li class="sublist-item selected"><a href="{{route('studiopenjualan.index')}}">Penjualan Produk</a></li>
                <li class="sublist-item"><a href="{{route('studiolimbah.index')}}">Limbah Barang</a></li>
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
        <h1>Daftar Penjualan Barang</h1>
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
                    <th>Customer</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
                @foreach ($penjualan as $key => $value)
                <tr>
                    <td>
                        {{ $value->penjualan_produk->nama }}
                    </td>
                    <td>
                        {{ $value->penjualan_produk->produk->nama }}
                    </td>
                    <td>
                        {{ $value->penjualan_produk->jumlah }}
                    </td>
                    <td>
                        {{ $value->penjualan_produk->harga }}
                    </td>
                    <td>
                        {{date('d-m-Y', $value->penjualan_produk->tanggal)}}
                    </td>
                    <td>
                        <form method="post" action="{{ route('studiopenjualan.destroy', $value->penjualan_produk_id) }}"
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
        {{ $penjualan->appends(request()->input())->links() }}
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

<script>
    $(document).ready(function () {
        // Counter to keep track of added elements
        var counter = 1;
        var additionalScripts = [];

        // Event listener for the "Add More" button
        $("#addButton").click(function () {
            var dynamicContent = `
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label>Nama Barang</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="namaDynamic[]" id="kategori-produk-`+counter+`">
                                <option value="" disabled selected hidden>Pilih Barang</option>
                                @foreach ($barang as $value)
                                    <option value="{{ $value->master_item_id }}">{{ $value->barang->item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('namaDynamic[]')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                            width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    `+`
                    <div class="col-sm-4 form-group">
                        <label>Batch</label>
                        <div class="input-group">
                            <select class="js-example-basic-single col-sm-12" name="batchDynamic[]" id="batch-produk-`+counter+`">
                                <option value="" disabled selected hidden>Pilih Batch</option>
                            </select>
                        </div>
                        @error('batchDynamic[]')
                        <svg aria-hidden="true" class="stUf5b LxE1Id" fill="currentColor" focusable="false"
                            width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z">
                            </path>
                        </svg>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    `+`
                    <div class="col-sm-4 form-group">
                        <label>Jumlah</label>
                        <input type="text" class="form-control form-control-sm jumlah-produk" 
                        oninput="validateInput(this)" placeholder="Input harus angka" name="jumlahDynamic[]" 
                        id="jumlahInp-`+counter+`" data-dynamic-value="0"
                        />
                        @error('jumlahDynamic[]')
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
            `;

            // Append the dynamic content to the container
            $("#addMore").append(dynamicContent);

            // Append additional code to the existing script
            var additionalCode = `
            $(document).ready(function () {
                $('.js-example-basic-single').select2();
                $('body').on('shown.bs.modal', '#exampleModalCenter', function () {
                    $(this).find('select').each(function () {
                        var dropdownParent = $(document.body);
                        if ($(this).parents('.modal.in:first').length !== 0) {
                            dropdownParent = $(this).parents('.modal.in:first');
                        }
                        $('#kategori-produk-`+counter+`').select2({
                            dropdownParent: $('#exampleModalCenter')
                        });
                        $('#batch-produk-`+counter+`').select2({
                            dropdownParent: $('#exampleModalCenter')
                        });
                    });
                });
                
                $('#kategori-produk-`+counter+`').on('select2:select', function (e) {
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
                            $('#batch-produk-`+counter+`').empty();
                            $('#batch-produk-`+counter+`').append('<option value="" disabled selected hidden>Pilih Batch</option>');
                            // Populate options based on the AJAX response
                            $.each(response, function (index, value) {
                                $('#batch-produk-`+counter+`').append('<option value="' + value.id + '">' + value
                                    .batch + " | Stock: " + value.sisa +'</option>');
                            });

                            // Trigger Select2 to update the UI
                            $('#batch-produk-`+counter+`').trigger('change');
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                });

                $('#batch-produk-`+counter+`').on('change', function (e) {
                    $('#jumlahInp-`+counter+`').val('');
                    console.log("Change event triggered");
                });

                $('#batch-produk-`+counter+`').on('select2:select', function (e) {
                    var selectedBatchText = e.params.data.text;
                    // Split the string by '|'
                    var parts = selectedBatchText.split('|');

                    // Extract the stock data (assuming it's in the second part after the '|')
                    var stockData = parts[1].trim().split(':')[1].trim();
                    
                    // Access the data attribute using JavaScript
                    document.getElementById('jumlahInp').setAttribute('data-dynamic-value', stockData);
                    console.log(stockData);
                });

            });
            `;
            var newScript = document.createElement("script");
            newScript.textContent = additionalCode;
            document.body.appendChild(newScript);

            // Store the reference to the dynamically added script
            additionalScripts.push(newScript);

            // Increment the counter
            counter++;
        });
        // Event listener for modal close event
        $('#exampleModalCenter').on('hidden.bs.modal', function () {
            // Clear the addMore
            $("#addMore").empty();

            // Remove all dynamically added scripts
            additionalScripts.forEach(function (script) {
            document.body.removeChild(script);
            });

            // Clear the array
            additionalScripts = [];
        });
    });
</script>
@endsection
