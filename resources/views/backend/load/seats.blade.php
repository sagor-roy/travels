<div class="row">
    <div class="col-md-2">
        <label>Seat Number<sup class="text-danger">*</sup> :</label>
    </div>
    @php
        $book = \session()->get('seats') ?? [];
    @endphp
    <div class="col-md-5">
        <div class="theatre">
            <ol class="cabin">
                <li class="row--1">
                    <ol class="seats" type="A">
                        <li class="seat">
                            <div class="row">
                                <input type="hidden" name="time" value="{{ $trip->schedules->start }}">
                                @foreach (explode(' ', $trip->types->seat) as $seat)

                                    <div class="col-md-3">
                                        <input
                                            @foreach ($order as $orders) @foreach (explode('  ', $orders['seat']) as $tick) 
                                            @if ($tick == $seat) 
                                            @disabled(true) @endif
                                            @endforeach
                                @endforeach
                                onclick="totalPrice({{ $trip->price+25 }})"
                                value="{{ $seat }}"
                                name="seat[]"
                                type="checkbox" id="{{ $seat }}-{{ $trip->id }}" />
                                <label for="{{ $seat }}-{{ $trip->id }}">{{ $seat }}</label>
                            </div>
                            @endforeach
        </div>
        </li>
        </ol>
        </li>
        </ol>
    </div>
</div>
</div>
