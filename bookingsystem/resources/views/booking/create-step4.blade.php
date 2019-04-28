@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-4">
        <h2>Personopplysninger</h2>

        <form action="{{ route('booking.login') }}" method="POST">
            @csrf
            <section class="step-4-sec">
                <div class="step-4-sec-inner">
                    <label for="form-booking-login-email">E-post</label>
                    <input value="{{ old('user_email', session('user_email')) }}" type="email" id="form-booking-login-email" name="user_email" />
                </div>
                <div class="step-4-sec-inner">
                    <label for="form-booking-login-password">Passord</label>
                    <input type="password" id="form-booking-login-password" name="password" />
                </div>
            </section>
            <button type="submit">Logg inn</button>
        </form>
        
        <h3>Eller fortsett som gjest</h3>
    <form action="{{ route('booking.create-step5') }}" method="POST">
            @csrf
            <section class="step-4-sec">
                <div class="step-4-sec-inner">
                    <label for="firstname">Fornavn*</label>
                    <input value="{{ old('user_firstname', session('user_firstname')) }}" type="text" id="firstname" name="user_firstname" required/>
                </div>
                <div class="step-4-sec-inner">
                    <label for="surname">Etternavn*</label>
                    <input value="{{ old('user_surname', session('user_surname')) }}" type="text" id="surname" name="user_surname" />
                </div>
            </section>
            <section class="step-4-sec">
                <div class="step-4-sec-inner">
                    <label for="mail">E-post*</label>
                    <input value="{{ old('user_mail', session('user_mail')) }}" type="email" id="mail" name="user_mail" />
                </div>
                <div class="step-4-sec-inner">
                    <label for="phone_number">Mobil*</label>
                    <input value="{{ old('user_phone', session('user_phone')) }}" type="text" id="phone_number" name="user_phone" />
                </div>
            </section>
            <section class="booking-form-btns">
                    <a href="{{ route('booking.create-step3') }}" class="button button-secondary">Tilbake<a/>
                    <a href="#" class="button button-secondary">Registrer bruker<a/>
                    <button type="submit">Fortsett som gjest</button>
            </section>
        </form>
    </article>
@endsection
