<div class="row">
    <div class="col-md-4">
        <div class="theatre">
            <div class="screen-side">
                <div class="screen">Screen</div>

                <h3 class="select-text">Please select a seat</h3>
            </div>
            @php
                $book = \session()->get('seat') ?? [];
            @endphp
            <ol class="cabin">
                <li class="row--1">
                    <ol class="seats" type="A">
                        <li class="seat">
                            <div class="row">
                                @foreach (explode(' ', $trip->types->seat) as $seat)
                                    <div
                                        class="
                                    @if ($trip->types->layout == '1-1') col-6
                                    @elseif ($trip->types->layout == '2-2')
                                    col-3
                                    @elseif ($trip->types->layout == '3-3')
                                    col-2 @endif
                                    p-2">
                                        <input type="checkbox"
                                            @foreach ($order as $orders) @foreach (explode('  ', $orders['seat']) as $tick) 
                                            @if ($tick == $seat) 
                                            @disabled(true) @endif
                                            @endforeach
                                @endforeach
                                onclick="seatFunc({{ $trip->id }}, {{ $trip->price }}, '{{ $seat }}', '{{ $date }}')"
                                id="{{ $seat }}-{{ $trip->id }}"
                                @foreach ($book as $item) @if ($item['id'] == $trip->id) 
                                {{ $item['seat'] == $seat ? 'checked' : '' }} @endif
                                @endforeach
                                />
                                <label for="{{ $seat }}-{{ $trip->id }}">{{ $seat }}</label>
                            </div>
                            @endforeach
        </div>
        </li>
        </ol>
        </li>
        </ol>
    </div>
    <div class="d-flex mt-3">
        <div class="mx-3 text-center">
            <div class="seat__box s"></div>
            <p>Selected </p>
        </div>
        <div class="mx-3 text-center">
            <div class="seat__box a"></div>
            <p>Available</p>
        </div>
        <div class="mx-3 text-center">
            <div class="seat__box b"></div>
            <p>Booked</p>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="row">
        <div class="col-6 border py-2">Seats :</div>
        <div class="col-6 border py-2">
            @php
                $single = 0;
                $prices = 0;
                $seat = \session()->has('seat') ? \session()->get('seat') : [];
                $count = 0;
            @endphp
            @foreach ($seat as $item)
                @if ($item['id'] == $trip->id)
                    {{ $item['seat'] }},
                    @php
                        $single = $item['price'];
                        $prices += $item['price'];
                        $count++;
                    @endphp
                @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-6 border py-2">Seats Fare:</div>
        <div class="col-6 border py-2">
            {{ $single }}&#2547;</div>
    </div>
    <div class="row">
        <div class="col-6 border py-2">Total Fare :</div>
        <div class="col-6 border py-2">
            {{ $prices }}
            &#2547;</div>
    </div>
    <div class="row">
        <div class="col-6 border py-2">VAT/TAX :</div>
        <div class="col-6 border py-2">25&#2547; (per seat)</div>
    </div>
    @php
        $totalVat = $count * 25;
    @endphp
    <div class="row">
        <div class="col-6 border py-2">Total Amount :</div>
        <div class="col-6 border py-2">{{ $prices + $totalVat }}&#2547;</div>
    </div>


    <div class="card card-body mt-3">
        <form action="{{ route('order') }}" method="POST">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <input type="hidden" name="route" value="{{ $trip->routes->name }}">
            <input type="hidden" name="time" value="{{ $trip->schedules->start }}">
            <input type="hidden" name="date" value="{{ date('Y-m-d', strtotime($date)) }}">
            <input type="hidden" name="seat" value="@foreach ($book as $item) {{ $item['seat'] }} @endforeach">
            <input type="hidden" name="price" value="{{ $prices + $totalVat }}">
            <div class="row">
                <div class="col-md-6 position-relative">
                    <div class="mb-3">
                        <label for="" class="form-label">Mobile No
                            :</label>
                        <input type="number" onkeyup="myFunction(event, this)" required name="number"
                            class="form-control">
                        <div id="number_list">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Name :</label>
                        <input type="text" required name="name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Email
                            :</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Gender
                            :</label>
                        <select required name="gender" class="form-control">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Payment
                            Method
                            :</label>
                        <select required name="method" class="form-control">
                            <option value="">Select payment method
                            </option>
                            <option value="bkash">Bkash</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">I
                            agree terms & condition</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="button" onclick="sessionClose()" class="btn btn-danger d-inline-block"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary d-inline-block">PAY</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
