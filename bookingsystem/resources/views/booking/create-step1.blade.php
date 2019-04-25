@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-1">
            <h2>Når vil du reise?</h2>
            <form action="get">
                <div class="booking-form-sec">
                    <section class="booking-form-sec-inner">
                            <p>Innsjekk</p>
                            <div class="input-wrapper">
                                <input placeholder="Dag" type="number" id="checkin-day" name="when_checkin-day" />
                                <input placeholder="Måned" type="number" id="checkin-month" name="when_checkin-month" />
                                <input value="2019" type="number" id="checkin-year" name="when_checkin-year" max="2019" min="2019"/>
                            </div>
                        </section>
                        <section class="booking-form-sec-inner">
                            <p>Utsjekk</p>
                            <div class="input-wrapper">
                                <input placeholder="Dag" type="number" id="checkout-day" name="when_checkout-day" />
                                <input placeholder="Måned" type="number" id="checkout-month" name="when_checkout-month" />
                                <input value="2019" type="number" id="checkout-year" name="when_checkout-year" max="2019" min="2019"/>
                            </div>
                        </section>
                        <section class="booking-form-sec-inner">
                            <label for="checkout-number">Antall personer</label>
                            <div class="select-checkout-number">
                                <select type="checkout-number" id="checkout-number" name="when_number" />
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
