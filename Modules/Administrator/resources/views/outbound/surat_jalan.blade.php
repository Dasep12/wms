<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMS | SJ</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <style>
        @page {
            margin: 10px;
        }

        body {
            margin: 0px;
            font-family: "Roboto", sans-serif;
        }

        .header h3 {
            color: #000;
        }

        .grid-container {
            margin: auto;
            display: table;
            width: 100%;
        }

        .table {
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
        }

        .grid-item {
            padding: 10px;
            text-align: center;
            display: table-cell
        }

        .table-1 {
            font-size: 13px !important;
            font-weight: bold;
        }

        .grid-item .headers_table_ttd {
            margin-bottom: 3px;
        }

        .table-list td {
            font-size: 12px !important;
        }

        .table-list th {
            font-size: 13px !important;
        }
    </style>
</head>

<body>
    <div class="header">
        <h3>PT. RAVALIA INTI MANDIRI</h3>
    </div>


    <div class="grid-container">
        <div class="grid-item">
            <table class="table table-1">
                <tbody>
                    <tr>
                        <td colspan="2">SECURITY CUSTOMER</td>
                    </tr>
                    <tr>
                        <td>DATE</td>
                        <td rowspan="4"></td>
                    </tr>
                    <tr>
                        <td><br><br></td>
                    </tr>
                    <tr>
                        <td>TIME</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><br><br></td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </tbody>

            </table>
        </div>
        <div class="grid-item">
            <h2 style="text-decoration: underline;font-weight:bold;margin-bottom:5px;">SURAT JALAN</h2>
            <span>NO: {{ $data[0]->no_surat_jalan }}</span>
        </div>
    </div>


    <div class="grid-container" style="margin-top:-20px">
        <div class="grid-item" style="width: 35% !important;">
            <table class="table-1">
                <tr>
                    <td>SUPPLIER CODE</td>
                    <td>:</td>
                    <td>{{ strtoupper($head->code_customers) }}</td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td>:</td>
                    <td>{{ strtoupper($head->name_customers) }}</td>
                </tr>
            </table>
        </div>
        <div class="grid-item">
            <table class="table-1">
                <tr>
                    <td>DELIVERY TO</td>
                    <td>:</td>
                    <td>{{ strtoupper($head->ship_to) }}</td>
                </tr>
                <tr>
                    <td>DATE</td>
                    <td>:</td>
                    <td>{{ $head->formatted_date_trans }}</td>
                </tr>
            </table>
        </div>
        <div class="grid-item">
            <table class="table-1">
                <tr>
                    <td>NO DN</td>
                    <td>:</td>
                    <td>{{ strtoupper($head->no_reference) }}</td>
                </tr>
            </table>
        </div>
    </div>


    <div class="grid-container" style="border:1px solid#000">
        <div class="grid-item">
            <table class="table table-list" style="width: 100% ;height:50%;position:relative;bottom:0px">
                <thead>
                    <tr align="center">
                        <th>NO</th>
                        <th>PART NAME</th>
                        <th>PART NO</th>
                        <th>QTY</th>
                        <th>SATUAN</th>
                        <th>KET</th>
                    </tr>
                </thead>
                <tbody class="" align="center">
                    <?php $no = 1;
                    foreach ($data as $dt) { ?>
                        <tr>
                            <td class="border: 1px solid black;">{{ $no++ }}</td>
                            <td>{{ $dt->name_material }} ( {{ $dt->qtyPackaging }} {{ $dt->packaging }} {{ $dt->details_unit != null ? ' = ' . $dt->details_unit : ''  }} ) </td>
                            <td>{{ $dt->no_material }}</td>
                            <td>{{ number_format($dt->qtyUnits,0) }}</td>
                            <td>{{ $dt->units }}</td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="grid-container" style="position:absolute;bottom:15%">
        <div class="grid-item">
            <h4 class="headers_table_ttd">CUSTOMER</h4>
            <table class="table-1 table" style="width:100%">
                <tr>
                    <td align="center">RECEIVING</td>
                </tr>
                <tr>
                    <td><br><br><br></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </div>
        <div class="grid-item">
            <h4 class="headers_table_ttd">DELIVERY</h4>
            <table class="table-1 table" style="width:100%">
                <tr>
                    <td align="center">PREPARED</td>
                </tr>
                <tr>
                    <td style="font-size: 11px;">KEND NO. {{ strtoupper($head->no_truck) }}</td>
                </tr>
                <tr>
                    <td><br><br></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </div>
        <div class="grid-item">
            <h4 class="headers_table_ttd">SUPPLIER</h4>
            <table class="table-1 table" style="width:100%">
                <tr>
                    <td align="center">SECURITY</td>
                </tr>
                <tr>
                    <td><br><br><br></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </div>
        <div class="grid-item">
            <h4 class="headers_table_ttd">SUPPLIER</h4>
            <table class="table-1 table" style="width:100%">
                <tr>
                    <td align="center">PREPARED</td>
                </tr>
                <tr>
                    <td><br><br><br></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>