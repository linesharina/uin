@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-2">
            <h2>Bestill rom</h2>
            <h3>Tilgjengelige rom</h3>
            <form action="{{ route('booking.create-step3') }}" method="POST">
                @csrf

                <div class="step-2-sec">
                    @foreach ($room_types as $room_type)
                        <section class="step-2-sec-inner">
                            <img src="{{ asset('images/' . __($room_type->name) . '.jpg') }}" alt="Illutrasjon av {{ __($room_type->name) }}">
                            <span class="step-2-sec-inner-check">
                                {{-- <input type="checkbox" name="rooms[]" id="form-room-{{ $room_type->name }}" value="{{ $room_type->name }}" {{ session('rooms') === $room_type->name ? 'checked' : null }}> --}}
                                <input type="checkbox" name="rooms[]" id="form-room-{{ $room_type->name }}" value="{{ $room_type->name }}" @foreach(session('rooms') as $room) @if($room === $room_type->name) {{'checked'}} @endif @endforeach >
                                <label for="form-room-{{ $room_type->name }}">{{ __(ucfirst($room_type->name)) }}</label>
                            </span>
                            <p>NOK {{ $room_type->price }},- per natt</p>        
                        </section>
                    @endforeach
                </div>
                <section class="booking-form-btns">
                    <a href="{{ route('booking.create-step1') }}" class="button button-secondary">Tilbake<a/>
                    <button type="submit">Neste</button>
                </section>
            </form>
    </article>
@endsection
