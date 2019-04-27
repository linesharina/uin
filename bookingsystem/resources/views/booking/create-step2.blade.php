@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-2">
            <h2>Bestill rom</h2>
            <h3>Tilgjengelige rom</h3>
            <form action="{{ route('booking.create-step3') }}" method="POST">
                @csrf
                <div class="step-2-sec">
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/enkeltrom.jpg') }}" alt="Illutrasjon av enkeltrom">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" id="single-room" value="single-room">
                            <label for="single-room">Enkeltrom</label>
                        </span>
                        <p>NOK 990,- per natt</p>        
                    </section>
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/dobbeltrom.jpg') }}" alt="Illutrasjon av dobbeltrom">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" value="double-room" id="double-room">
                            <label for="double-room">Dobbeltrom</label>
                        </span>
                        <p>NOK 1290,- per natt</p>

                    </section>
                </div>
                <div class="step-2-sec">
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/suite.jpg') }}" alt="Illutrasjon av suite">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" value="suite" id="suite">
                            <label for="suite">Suite</label>
                        </span>
                        <p>NOK 1990,- per natt</p>
                    </section>
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/bryllupssuite.jpg') }}" alt="Illutrasjon av bryllupssuite">
                        <span class="step-2-sec-inner-check">                            
                            <input type="checkbox" name="room" value="wedding-suite" id="wedding-suite">
                            <label for="wedding-suite">Bryllupssuite</label>
                        </span>
                        <p>NOK 2490,- per natt</p>
                    </section>
                </div>
                <section class="booking-form-btns">
                    <a href="{{ route('booking.create-step1') }}" class="button button-secondary">Tilbake<a/>
                    <button type="submit">Neste</button>
                </section>
            </form>
    </article>
@endsection
