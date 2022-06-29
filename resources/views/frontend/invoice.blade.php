<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>A simple, clean, and responsive HTML invoice template</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        .print,
        .download {
            text-decoration: none;
            color: white;
            background-color: #06f;
            padding: 5px 10px;
            margin: 0px 5px;
            border-radius: 5px;
        }
        .download {
            background-color: rgb(233, 40, 40) !important;
        }
    </style>
</head>

<body>
    <h1>Online Bus Ticket System</h1>
    Find the code on <a href="https://github.com/sagor-roy">GitHub</a>. Licensed under the
    <a href="" target="_blank">MIT license</a>.<br /><br /><br />
    <a href="{{ route('home') }}" class="print">Home</a>
    <a href="{{ route('download',$data->id) }}" class="download">Download</a>
    <br> <br>

    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('assets/frontend/img/logo.png') }}" alt="Company logo" style="width: 100%; max-width: 150px" />
                            </td>

                            {{-- <td>
                                Invoice #: 123<br />
                                Created: January 1, 2015<br />
                                Due: February 1, 2015
                            </td> --}}
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Ticked No #: {{ $data->ticked_no }}<br />
                                Created: {{ date('M m, Y', strtotime($data->created_at)) }}<br />
                                Transaction ID: {{ $data->transaction }}
                            </td>

                            <td>
                                {{ $data->name }}<br />
                                {{ $data->number }}<br />
                                {{ $data->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>

                <td>Status</td>
            </tr>

            <tr class="details">
                <td>{{ $data->method }}</td>

                <td>{{ $data->status }}</td>
            </tr>

            <tr class="heading">
                <td>Seat</td>

                <td>Price</td>
            </tr>

            <tr class="item">
                <td>{{ $data->seat }}</td>

                <td>{{ $data->price }}৳</td>
            </tr>

            <tr class="total">
                <td></td>

                <td>Total: {{ $data->price }}৳</td>
            </tr>
        </table>
        <p><b>N:B-</b>The Browser Don't reload before PDF download</p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>

</html>
