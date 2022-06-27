@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Trip
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">create</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    <a href="{{ route('admin.trip.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list"></i>
                        List</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.trip.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Trip Title<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required readonly name="title" class="form-control"
                                        placeholder="Trip Title">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Fleet Type<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="type" id="" class="form-control">
                                        <option value="">Select fleet type</option>
                                        @foreach ($type as $item)
                                            <option value="{{ $item->id }}" data-name="{{ $item->type }} ({{ $item->total }})-">{{ $item->type }} ({{ $item->total }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Route<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="route" id="" class="form-control">
                                        <option value="">Select route</option>
                                        @foreach ($route as $item)
                                            <option value="{{ $item->id }}" data-name="{{ $item->name }}-">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Schedule<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="schedule" id="" class="form-control">
                                        <option value="">Select route</option>
                                        @foreach ($schedule as $item)
                                            <option value="{{ $item->id }}" data-name="{{ $item->start }}-{{ $item->end }}">{{ $item->start }}-{{ $item->end }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Price<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" required name="price" class="form-control"
                                        placeholder="Price">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Status<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="radio" name="status" value="1" id="active">
                                    <label for="active" style="margin-right: 10px">Active</label>
                                    <input type="radio" name="status" value="0" id="inactive">
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
        </section>
        <!-- /.content -->
    </div>

@section('script')
    <script>
        $(function(){
            "use strict";

            $('select[name="type"]').change(function(event){
                event.preventDefault();
                var val = $(this).children("option:selected").data('name');
                $('input[name="title"]').val(val+" "+ $('input[name="title"]').val());
            })

            $('select[name="route"]').change(function(event){
                event.preventDefault();
                var val = $(this).children("option:selected").data('name');
                $('input[name="title"]').val($('input[name="title"]').val() +" "+ val);
            })

            $('select[name="schedule"]').change(function(event){
                event.preventDefault();
                var val = $(this).children("option:selected").data('name');
                $('input[name="title"]').val($('input[name="title"]').val() +"  "+ val);
            })
        })
    </script>
@endsection
@endsection
