@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-1">
            <h2>Når vil du reise?</h2>
            <form action="{{ route('booking.create-step2') }}" method="POST">
                {{ csrf_field() }}
                <div class="step-1-sec">
                    <section class="step-1-sec-inner">
                            <p>Innsjekk</p>
                            <div class="input-wrapper">
                                <input value="{{ old('when_checkin-day', session('when_checkin-day')) }}" placeholder="Dag" type="number" id="checkin-day" name="when_checkin-day" min="1" max="31" required />
                                <input value="{{ old('when_checkin-month', session('when_checkin-month')) }}"  placeholder="Måned" type="number" id="checkin-month" name="when_checkin-month" min="1" max="12" required />
                                <input value="{{ old('when_checkin-year', session('when_checkin-year', date('Y'))) }}" type="number" id="checkin-year" name="when_checkin-year" min="{{ date('Y') }}" max="{{ date('Y') + 1 }}" required/>
                            </div>
                        </section>
                        <section class="step-1-sec-inner">
                            <p>Utsjekk</p>
                            <div class="input-wrapper">
                                <input value="{{ old('when_checkout-day', session('when_checkout-day')) }}"  placeholder="Dag" type="number" id="checkout-day" name="when_checkout-day" min="1" max="31" required/>
                                <input value="{{ old('when_checkout-month', session('when_checkout-month')) }}" placeholder="Måned" type="number" id="checkout-month" name="when_checkout-month" min="1" max="12" required/>
                                <input value="{{ old('when_checkout-year', session('when_checkout-year', date('Y'))) }}" value="2019" type="number" id="checkout-year" name="when_checkout-year" min="{{ date('Y') }}" max="{{ date('Y') + 1 }}" required/>
                            </div>
                        </section>
                        <section class="step-1-sec-inner">
                            <label for="checkout-number">Antall personer</label>
                            <div class="select-checkout-number">
                                <select type="checkout-number" id="checkout-number" name="when_number" value="{{ old('when_number', session('when_number')) }}"  />
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </section>
                </div>
                <button type="submit">Søk</button>
            </form>
    </article>
@endsection
