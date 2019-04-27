@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-3">
            <h2>Fasiliteter</h2>
            <form action="{{ route('booking.create-step4') }}" method="POST">
                @csrf
                <div class="step-3-sec">
                    <section class="step-3-sec-inner">
                        <h3>Måltider</h3>
                        <p>Alle overnattinger inkluderer frokost i prisen.</p>
                        <div class="step-3-facility">
                            <h4>Lunsj</h4>
                            <div class="step-3-facility-inner">
                                <p>100,- per person</p>
                                <span class="step-3-facility-inner-number">
                                    <label for="facility_lunch">Antall</label>
                                    <input value="{{ old('facility_lunch', session('facility_lunch')) }}" type="number" id="lunch" name="facility_lunch" min="0" max="10" required/>
                                </span>
                            </div>
                        </div>
                        <div class="step-3-facility">
                            <h4>Middag</h4>
                            <div class="step-3-facility-inner">
                                <p>250,- per person</p>
                                <span class="step-3-facility-inner-number">
                                    <label for="facility_dinner">Antall</label>
                                    <input value="{{ old('facility_dinner', session('facility_dinner')) }}" type="number" id="lunch" name="facility_dinner" min="0" max="10" required/>
                                </span>
                            </div>
                            <div class="step-3-facility">
                                <h3>Parkering</h3>
                                <div class="step-3-facility-parking">
                                    <p>Ønsker du å reservere parkering?</p>
                                    <div class="step-3-facility-parking-inner">
                                        <span>
                                            <input type="radio" name="facility_parking" id="parking-yes" value="1" required>
                                            <label for="parking-yes">Ja</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="facility_parking" id="parking-no" value="0" required>
                                            <label for="parking-no">Nei</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <section class="booking-form-btns">
                    <a href="{{ route('booking.create-step2') }}" class="button button-secondary">Tilbake<a/>
                    <button type="submit">Neste</button>
                </section>
            </form>
    </article>
@endsection
