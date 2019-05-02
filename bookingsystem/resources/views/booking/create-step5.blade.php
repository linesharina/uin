@extends('layouts.app')

@section('content')
    <form class="booking-form booking-form-step-5" action="{{ route('booking.create-step6') }}" method="POST">
        @csrf
        <h2>Sammendrag</h2>
        <section class="step-5-sec">
            <h3>Reise</h3>
            <div class="step-5-sec-inner">
                <p>Innsjekk:</p>
                <p>{{ Session::get('when_checkin-day') . "." . Session::get('when_checkin-month') . "." . Session::get('when_checkin-year')}}</p>
            </div>
            <div class="step-5-sec-inner">
                <p>Utsjekk:</p>
                <p>{{ Session::get('when_checkout-day') . "." . Session::get('when_checkout-month') . "." . Session::get('when_checkout-year')}}</p>
            </div>
        </section>
        <h3>Rom</h3>
        @foreach ($rooms as $room)        
            <section class="step-5-sec">
                <div class="step-5-sec-inner">
                    <p>Romtype:</p>
                    <p>{{ __($room['room_type']) }}</p> 
                </div>
                <div class="step-5-sec-inner">
                    <p>Pris rom:</p>
                    <p>{{ $room['room_price'] }},- NOK</p> 
                </div>
                <div class="step-5-sec-inner">
                    <p>Antall netter:</p>
                    <p>{{ $days_count }}</p>
                </div>
            </section>
        @endforeach
        <section class="step-5-sec">
            <h3>Fasiliteter</h3>
            <div>
                <div class="step-5-sec-inner">
                    <p>Lunsj:</p>
                    <p>{{ Session::get('facility_lunch')}}</p>
                </div>
                <div class="step-5-sec-inner">
                    <p>Middag:</p>
                    <p>{{ Session::get('facility_dinner')}}</p>
                </div>
                <div class="step-5-sec-inner">
                    <p>Pris måltider:</p>
                    {{-- <p>{{ Session::get('price_fac')}},- NOK</p> --}}
                    <p>{{ $price_fac }},- NOK</p>
                </div>
            </div>
            <div class="step-5-sec-inner">
                <h4>Parkering:</h4>
                <p>{{ Session::get('facility_parking')}}</p>
            </div>
        </section>
        <section class="step-5-sec">
            <h3>Personopplysninger</h3>
            <div class="step-5-sec-inner">
                <p>Navn:</p>
                @if (Auth::check())
                <p>{{ Auth::user()->firstname . ' ' . Auth::user()->surname }}</p>    
                @else 
                    <p>{{ Session::get('user_firstname') . " " . Session::get('user_surname') }}</p>
                @endif
            </div>
            <div class="step-5-sec-inner">
                <p>E-post: </p>
                @if (Auth::check())
                <p>{{ Auth::user()->email }}</p>    
                @else 
                    <p>{{ Session::get('user_mail')}}</p>
                @endif
            </div>
            <div class="step-5-sec-inner">
                <p>Telefonnummer: </p>
                @if (Auth::check())
                <p>{{ Auth::user()->phone }}</p>    
                @else 
                    <p>{{ Session::get('user_phone')}}</p>
                @endif
                
            </div>
        </section>
        <section class="step-5-sec">
            <h3>Totalpris: {{ $price }},- NOK</h3>
        </section>

        <section class="booking-form-btns">
                <a href="{{ route('booking.create-step4') }}" class="button button-secondary">Tilbake</a>
                <button type="submit">Bekreft booking</button>
        </section>
    </form>
@endsection
