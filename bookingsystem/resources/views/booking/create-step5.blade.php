@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-5">
        <h2>Sammendrag</h2>
        <section class="booking-form-btns">
                <a href="{{ route('booking.create-step3') }}" class="button button-secondary">Tilbake<a/>
                <button type="submit">Bekreft booking</button>
        </section>
    </article>
@endsection
