@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fleet Edit
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    <a href="{{ route('admin.fleet.type.index') }}" class="btn btn-sm btn-primary"><i
                            class="fa fa-list"></i> List</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="row">
                    <div class="col-md-8">
                        <form role="form" action="{{ route('admin.fleet.type.update', $data->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Fleet Type<sup class="text-danger">*</sup> :</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" required name="type" value="{{ $data->type }}"
                                                class="form-control" placeholder="Fleet type">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Layouts<sup class="text-danger">*</sup> :</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="layout" required id="" class="form-control">
                                                <option value="">Select layouts</option>
                                                <option value="1-1" {{ $data->layout == '1-1' ? 'selected' : '' }}>1-1
                                                </option>
                                                <option value="2-2" {{ $data->layout == '2-2' ? 'selected' : '' }}>2-2
                                                </option>
                                                <option value="3-3" {{ $data->layout == '3-3' ? 'selected' : '' }}>3-3
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Seat Number<sup class="text-danger">*</sup> :</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="seat" required placeholder="Example:A1 A2 B1 B2" rows="5" class="form-control">{{ $data->seat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Total Seat<sup class="text-danger">*</sup> :</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" readonly required value="{{ $data->total }}"
                                                name="total" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Status<sup class="text-danger">*</sup> :</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="radio" {{ $data->status == 1 ? 'checked' : '' }} name="status"
                                                value="1" id="active">
                                            <label for="active" style="margin-right: 10px">Active</label>
                                            <input type="radio" {{ $data->status == 0 ? 'checked' : '' }}
                                                name="status" value="0" id="inactive">
                                            <label for="inactive">Inactive</label>
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
                    <div class="col-md-4">
                        <div class="row">
                            @foreach (explode(" ",$data->seat) as $item)
                            @if ($data->layout == '1-1')
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('assets/frontend/seat.png') }}" alt="seat" width="50">
                                <p>{{ $item }}</p>
                            </div>
                            @elseif ($data->layout == '2-2')
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('assets/frontend/seat.png') }}" alt="seat" width="50">
                                <p>{{ $item }}</p>
                            </div>
                            @elseif ($data->layout == '3-3')
                            <div class="col-md-2 text-center">
                                <img src="{{ asset('assets/frontend/seat.png') }}" alt="seat" width="50">
                                <p>{{ $item }}</p>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

@section('script')
    <script>
        $(function() {
            'use strict';

            $('textarea[name="seat"]').on('keyup', function(e) {
                e.preventDefault();
                let data = $(this).val();
                $('input[name="total"]').val(data.split(" ").length);

            })
        })
    </script>
@endsection
@endsection
