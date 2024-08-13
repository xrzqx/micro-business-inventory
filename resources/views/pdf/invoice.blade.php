<!-- resources/views/pdf/invoice.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        .small-image {
            width: 1.67cm;  /* Width of the image in centimeters */
            height: 1.94cm; /* Height of the image in centimeters */
        }
        .thin-line {
            border-top: 0.05cm solid black; /* Horizontal line with 0.05cm thickness */
            margin-top: 10px; /* Optional spacing */
            margin-bottom: 10px; /* Optional spacing */
        }
        header{
            /* background-color: aqua; */
            width: 100%;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: url('{{ asset("images/logo2.jpeg") }}'); /* Path to background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center; /* Adjust as needed */
            opacity: 0.7; /* Adjust transparency */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .font-12{
            font-size: 12px;
        }
        .font-11{
            font-size: 11px;
        }
        .font-underline{
            text-decoration: underline;
        }
        .font-bold{
            font-weight: bold;
        }
        .header-text{
            display: flex;
        }
        .header-text-col{
            display: flex;
            flex-direction: column;
        }
        .mb-14{
            margin-bottom: 14px;
        }
        .mb-90{
            margin-bottom: 90px;
        }
        .row-reverse{
            flex-direction: row-reverse;
        }
        .end-of-row {
            justify-content: space-between;
        }
        .mb-05em{
            margin-bottom: 0.3em;
        }
        .mt-1em{
            margin-top: 1em;
        }
        .ml-1em{
            margin-left: 1em;
        }
        .space {
            /* Adjust the width or margin to create space */
            width: 100%; /* Adjust this value based on your layout */
        }

        .container {
            /* Set table layout to ensure consistent rendering */
            width: 100%; /* Adjust width as needed */
        }

        .container td {
            margin: 0;
            padding: 0;
            /* Distribute space evenly between table cells */
            width: 50%; /* Each cell takes 50% of the table width */
            /* text-align: left; */
            border: none;
        }

        .align-right{
            text-align: right;
        }

        .align-center{
            text-align: center;
        }

        table.font-11 th, table.font-11 td {
            padding: 3px; /* Adjust this value to your desired padding */
        }

    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset("images/logo-small.png") }}" alt="" class="small-image">
        <hr class="thin-line">
    </div>
    <div class="font-12">
        <div class="header-text-col font-underline font-bold mb-05em">
            <span>INVOICE</span>
        </div>
        <div class="header-text-col mb-14 font-underline font-bold">
            {{-- <span>No : 015/SGH/V/2024</span> --}}
            <span>{{'No : ' . $invoice->no_invoice}}</span>
        </div>

        <table class="container mb-05em">
            <tr>
                <td class="element1">Kepada Yth,</td>
                {{-- <td class="font-bold align-right">Tanggal: xx-xx-xxxx</td> --}}
                <td class="font-bold align-right">{{'Tanggal: ' . date('d-m-Y', $invoice->tanggal)}}</td>
            </tr>
        </table>
        
        <div class="header-text-col font-bold mb-05em">
            {{-- <span>PT Graha  Jaya Sentosa</span> --}}
            <span>{{$customer->nama}}</span>
        </div>
        
        <div class="header-text-col font-bold mb-05em">
            {{-- <span>Surabaya</span> --}}
            <span>{{$customer->lokasi}}</span>
        </div>

        <div class="header-text mb-05em">
            <span>Di Tempat, </span>
        </div>
    </div>
    {{-- <br> --}}
    <table class="font-11 mt-1em" style="width: 60%; padding: 3px;">
        <tr>
            <th class="align-center">No</th>
            <th class="align-center">Jenis Pupuk</th>
            <th class="align-center">Jumlah</th>
            <th class="align-center">Harga</th>
        </tr>
        @foreach ($invoiceItem as $index => $item)
        <tr>
            <td class="align-center">{{ $index + 1 }}</td>
            <td>{{ $item->pembelian->barang->item->nama }}</td>
            <td>{{ $item->jumlah . ' Kg'}}</td>
            <td>{{ 'Rp. ' . number_format($item->harga, 2, ',', '.') }}</td>
        </tr>
        @endforeach
        {{-- <tr>Total : </tr> --}}
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td>{{'Rp. ' . number_format($invoice->harga, 2, ',', '.')}}</td>
        </tr>
    </table>
    
    <div class="header-text-col mt-1em font-12 mb-05em">
        <span class="">Keterangan :</span>
    </div>
    <div class="header-text-col font-12 mb-05em">
        <span class="">1.	Harga produk tersebut termasuk inc.ppn 11%</span>
    </div>
    <div class="header-text-col font-12 mb-05em">
        <span class="">No. Rekening :</span>
    </div>
    <div class="header-text-col font-12 mb-05em">
        <span class="">1.	CV Star Good Hero Bank BRI No Rekening 002601003360308</span>
    </div>
    <div class="header-text-col font-12 mb-05em">
        <span class="">2.	Bintang Bagus Satrio Bank BRI No Rekening 320501033748531</span>
    </div>
    <div class="header-text-col font-12 mb-05em">
        <span class="">3.	Bintang Bagus Satrio Bank BCA No Rekening 0331584834</span>
    </div>
    <div class="header-text-col font-12">
        <span class="mb-05em">4.	Bintang Bagus Satrio Bank BNI No Rekening 0620947332   </span>
    </div>

    <div class="align-right">
        <div class="header-text-col mt-1em font-12 mb-05em">
            <span class="">Gresik, {{$formattedDate}}</span>
        </div>
        <div class="header-text-col font-12 mb-90">
            <span class="">CV. Star Good Hero</span>
        </div>
        <div class="header-text-col font-underline font-bold font-12 mb-05em">
            <span class="">BINTANG BAGUS SATRIO</span>
        </div>
        <div class="header-text-col font-bold font-12 mb-05em">
            <span class="">DIREKTUR</span>
        </div>
    </div>

    
</body>
</html>
