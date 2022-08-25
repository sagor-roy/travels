@extends('layouts.backend')
<style>
    ul.list {
        position: absolute;
        width: 100%;
        list-style: none;
        margin: 0;
        padding: 0;
        background-color: #eeeeee;
    }

    #number_list {
        position: absolute;
        width: 100%;
        transform: scaleY(0);
        transform-origin: top;
        transition: all ease 0.5s;
        z-index: 99;
    }

    ul.list>li>a {
        color: black;
        border-bottom: 1px solid #c2cbd3;
        display: block;
        padding: 3px 25px;
    }

    .screen-side {
        text-align: center;
        margin-bottom: 35px;
    }

    .screen-side .screen {
        height: 25px;
        margin: 0 20px;
        border-radius: 50%;
        /* box-shadow: 0px -3px 0px 1px #ccc; */
        color: #fff;
    }

    .screen-side .select-text {
        color: #ffffff;
        font-size: 20px;
    }

    .exit {
        position: relative;
        height: 50px;
    }

    .exit:before,
    .exit:after {
        content: "EXIT";
        font-size: 14px;
        line-height: 18px;
        padding: 0px 5px;
        font-family: "Arial Narrow", Arial, sans-serif;
        display: block;
        position: absolute;
        background: #81c784;
        color: white;
        top: 50%;
        transform: translate(0, -50%);
    }

    .exit:before {
        left: 0;
    }

    .exit:after {
        right: 0;
    }

    ol {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .seats {
        /* display: flex; */
        /* flex-direction: row; */
        /* flex-wrap: nowrap; */
    }

    .seat {
        /* display: flex; */
        /* flex: 0 0 14.28571%; */
        padding: 5px;
        position: relative;
    }

    .seat:nth-child(2) {
        /* margin-right: 43.28571%; */
    }

    .seat input[type="checkbox"] {
        position: absolute;
        opacity: 0;
    }

    .seat input[type="checkbox"]:checked+label {
        background: #bada55;
        -webkit-animation-name: rubberBand;
        animation-name: rubberBand;
        animation-duration: 300ms;
        animation-fill-mode: both;
    }

    .seat input[type="checkbox"]:disabled+label {
        background: #9f9595;
        /* text-indent: -9999px; */
        overflow: hidden;
    }

    .seat input[type="checkbox"]:disabled+label:after {
        /* content: "X"; */
        text-indent: 0;
        position: absolute;
        top: 4px;
        left: 50%;
        transform: translate(-50%, 0%);
    }

    .seat input[type="checkbox"]:disabled+label:hover {
        box-shadow: none;
        cursor: not-allowed;
    }

    .seat label {
        display: block;
        position: relative;
        width: 100%;
        text-align: center;
        font-size: 17px;
        font-weight: bold;
        line-height: 2.5rem;
        padding: 4px;
        color: #fff;
        background: #26a69a;
        border-radius: 2px;
        animation-duration: 300ms;
        animation-fill-mode: both;
        transition-duration: 300ms;
    }

    .seat label:hover {
        cursor: pointer;
    }

    @-webkit-keyframes rubberBand {
        0% {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }

        30% {
            -webkit-transform: scale3d(1.25, 0.75, 1);
            transform: scale3d(1.25, 0.75, 1);
        }

        40% {
            -webkit-transform: scale3d(0.75, 1.25, 1);
            transform: scale3d(0.75, 1.25, 1);
        }

        50% {
            -webkit-transform: scale3d(1.15, 0.85, 1);
            transform: scale3d(1.15, 0.85, 1);
        }

        65% {
            -webkit-transform: scale3d(0.95, 1.05, 1);
            transform: scale3d(0.95, 1.05, 1);
        }

        75% {
            -webkit-transform: scale3d(1.05, 0.95, 1);
            transform: scale3d(1.05, 0.95, 1);
        }

        100% {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }
    }

    @keyframes rubberBand {
        0% {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }

        30% {
            -webkit-transform: scale3d(1.25, 0.75, 1);
            transform: scale3d(1.25, 0.75, 1);
        }

        40% {
            -webkit-transform: scale3d(0.75, 1.25, 1);
            transform: scale3d(0.75, 1.25, 1);
        }

        50% {
            -webkit-transform: scale3d(1.15, 0.85, 1);
            transform: scale3d(1.15, 0.85, 1);
        }

        65% {
            -webkit-transform: scale3d(0.95, 1.05, 1);
            transform: scale3d(0.95, 1.05, 1);
        }

        75% {
            -webkit-transform: scale3d(1.05, 0.95, 1);
            transform: scale3d(1.05, 0.95, 1);
        }

        100% {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }
    }

    .rubberBand {
        -webkit-animation-name: rubberBand;
        animation-name: rubberBand;
    }


    .seat__box {
        background-color: #bada55;
        padding: 15px;
        display: inline-block;
    }

    .seat__box.a {
        background-color: #26a69a;
    }

    .seat__box.b {
        background-color: #9f9595 !important;
    }

    ul.list {
        position: absolute;
        width: 100%;
        list-style: none;
        margin: 0;
        padding: 0;
        background-color: #eeeeee;
    }

    #number_list {
        transform: scaleY(0);
        transform-origin: top;
        transition: all ease 0.5s;
    }

    ul.list>li>a {
        color: black;
        border-bottom: 1px solid #c2cbd3;
        display: block;
        padding: 3px 25px;
    }
</style>
@php
$user = Auth::user();
@endphp
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Booking
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Booking</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    @if ($user->can('booking.view'))
                        <a href="{{ route('admin.ticket.booking.index') }}" class="btn btn-sm btn-primary"><i
                                class="fa fa-list"></i> List</a>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.ticket.booking.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Booking Date<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="date" required value="{{ date('Y-m-d') }}" name="date"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Trip ID<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <select required name="trip_id" class="form-control">
                                        <option value="">Select route</option>
                                        @foreach ($trip as $item)
                                            <option value="{{ $item->id }}">{{ $item->routes->name }}-(
                                                {{ $item->types->type }}----{{ date('h:i a', strtotime($item->schedules->start)) }}
                                                )</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="seats" class="form-group">

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Price<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required placeholder="0" name="price" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div style="position: relative" class="row">
                                <div class="col-md-2">
                                    <label>Phone<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required placeholder="+880" name="number" class="form-control">
                                    <div id="number_list">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Name<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required placeholder="Name" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Email :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" placeholder="( optional )" name="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Gender</label>
                                </div>
                                <div class="col-md-10">
                                    <select required name="gender" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Payment</label>
                                </div>
                                <div class="col-md-10">
                                    <select required name="method" class="form-control">
                                        <option value="bkash">Bkash</option>
                                        <option value="hc">Hand Cash</option>
                                        <option value="ssl">SSL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="reset" class="btn btn-sm btn-primary">Reset</button>
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>

@section('script')
    <script>
        $(function() {
            $('select[name="trip_id"]').change(function(event) {
                event.preventDefault();
                var trip_id = $(this).children("option:selected").val();
                var date = $('input[name="date"]').val();
                if (trip_id !== "") {
                    $.ajax({
                        url: "{{ url('admin/ticket/booking/trip') }}/" + trip_id,
                        type: "get",
                        data: {
                            date: date
                        },
                        success: (result) => {
                            $('#seats').html(result)
                        }
                    })
                } else {
                    $('#seats').html("");
                }
            })

            $('input[name="number"]').on('keyup', function(e) {
                e.preventDefault();
                let query = $(this).val();
                if (query != '') {
                    var _token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ route('admin.ticket.booking.search') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: (data) => {
                            $('#number_list').css('transform', 'scale(1)');
                            $('#number_list').html(data)
                        }
                    });
                }
            })

            $(document).on('click', 'body', function() {
                $('#number_list').css('transform', 'scaleY(0)');
            });
        })

        function selectAdds(number, name, email, gender) {
            $('input[name="number"]').val('0' + number);
            $('input[name="name"]').val(name);
            $('input[name="email"]').val(email);
        }

        function totalPrice(price) {
            let total = $('input[name="price"]').val();
            $('input[name="price"]').val(+price + +total);
        }
    </script>
@endsection
@endsection
