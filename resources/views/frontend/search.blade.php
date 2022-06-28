@extends('layouts.frontend')

@section('content')
    <section class="bg-primary py-5">
        <div class="container">
            <form action="{{ route('search') }}" method="GET">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="input-group">
                            <select name="from" required class="form-control">
                                <option value="">From</option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $from ? 'selected' : '' }}>
                                        {{ $item->destination }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <select name="to" required class="form-control">
                                <option value="">To</option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $to ? 'selected' : '' }}>
                                        {{ $item->destination }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" required name="date" value="{{ $date }}" class="form-control"
                                id="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="custom_btn bg-warning rounded-1">Find Now</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="py-5">
        <div class="container table-responsive">
            <table class="table table-bordered text-center">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Coach</th>
                        <th>
                            {{ date('d-M-Y', strtotime($date)) }}
                        </th>
                        <th>Approximately Time</th>
                        <th>Seats</th>
                        <th>Available</th>
                        <th>Route Name</th>
                        <th>Fare</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trip as $item)
                        <tr>
                            <td>{{ $item->vehicles->model_no }}</td>
                            <td>
                                <h6>{{ date('d-M-Y', strtotime($date)) }}</h6>
                                {{ date('h:m a', strtotime($item->schedules->start)) }}
                            </td>
                            @php
                                $order =
                                    \App\Models\Order::where('trip_id', $item->id)
                                        ->where('date', $date)
                                        ->select('seat')
                                        ->get() ?? [];
                                $count = 0;
                                foreach ($order as $value) {
                                    foreach (explode('  ', $value['seat']) as $items) {
                                        $count++;
                                    }
                                }
                            @endphp
                            <td>{{ $item->routes->duration }}</td>
                            <td>{{ $item->types->total }}</td>
                            <td>{{ $item->types->total - $count }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->price }}&#2547;</td>
                            <td>
                                <a href="#book" onclick="tripId({{ $item->id }}, '{{ $date }}')"
                                    data-bs-toggle="modal" class="btn btn-sm btn-primary">Book</a>
                                <a title="Google Map" href="#map-{{ $item->id }}" data-bs-toggle="modal"
                                    class="btn btn-sm btn-danger"><i class="fa-solid fa-location-dot"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="map-{{ $item->id }}" tabindex="-1" data-bs-keyboard="false"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $item->routes->name }}</h5>
                                        <button type="button" onclick="sessionClose()" class="btn-close"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {!! $item->routes->map !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="modal fade" id="book" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="sessionClose()" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


@section('script')
    <script>
        function sessionClose() {
            $('#loader').removeClass('d-none');
            $.ajax({
                url: "{{ route('session.destroy') }}",
                type: 'get',
                success: (result) => {
                    $('#loader').addClass('d-none');
                }
            })
        }

        function seatFunc(id, price, seat, date) {
            $('#loader').removeClass('d-none');
            $.ajax({
                url: "{{ route('seat.count') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    seat: seat,
                    price: price,
                    id: id,
                },
                success: (result) => {
                    $('#loader').addClass('d-none');
                    tripId(id, date)
                }
            })
        }

        function tripId(id, date) {
            $('#loader').removeClass('d-none');
            $.ajax({
                url: "{{ url('trip/data') }}/" + id,
                type: 'get',
                data: {
                    date: date
                },
                success: (result) => {
                    $('#loader').addClass('d-none');
                    $('.modal-body').html(result)
                    // console.log(result);
                }
            })
        }
    </script>
@endsection
@endsection
