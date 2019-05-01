@extends('layouts.app')

@section('content')
    <article class="booking-form bookings">
        <h1>Rediger booking</h1>
        <form method="POST" action="{{ route('admin.admin-update', $booking) }}">
            @csrf
            @method('patch')

            <h2>ID: {{ $booking->id }}</h2>
            <h4>Opplysninger</h4>
            <div class="bookings-inner-edit">
                <p>Innsjekk:</p>
                <input name="check_in" type="text" value="{{ $booking->check_in->format('Y-m-d') }}" required>
            </div>
            <div class="bookings-inner-edit">
                <p>Utsjekk: </p>
                <input name="check_out" type="text" value="{{ $booking->check_out->format('Y-m-d') }}" required>
            </div>
            <div class="bookings-inner-edit">
                <p>Antall personer:</p>
                <input name="people" type="number" value="{{ $booking->people }}" required>
            </div>
            
            @foreach ($booking->users as $booking_user)
                @foreach ($booking->booking_rooms as $booking_room)
                    <div class="bookings-inner-edit">
                        <p>Rom ID:</p>
                        <p>{{ $booking_room->room->id }} </p>
                    </div>
                    <div class="bookings-inner-edit">
                        <p>Romtype: </p>
                        <p>{{ __($booking_room->room->room_type) }} </p>
                    </div>
                @endforeach
                <h4>Bestillers personinformasjon </h4>
                <div class="bookings-inner-edit">
                    <p>Fornavn: </p>
                    <input name="firstname" type="text" value="{{ $booking_user->user->firstname}}" required>
                </div>
                <div class="bookings-inner-edit">
                    <p>Etternavn: </p>
                    <input name="surname" type="text" value="{{ $booking_user->user->surname}}" required>
                </div>
                <div class="bookings-inner-edit">
                    <p>Telefonnummer: </p>
                    <input name="phone" type="text" value="{{ $booking_user->user->phone }}" required>
                </div>
                <div class="bookings-inner-edit">
                    <p>E-post: </p>
                    <p> {{ $booking_user->user->email }} </p>
                </div>

                <h4>Fasiliteter</h4>
                @foreach ($booking_user->facilities as $facility_name => $facility)
                    <div class="bookings-inner-edit">
                        <p>{{ __(ucfirst($facility_name)) . ': '  }}</p>
                        <input name="{{ $facility_name }}" type="number" value="{{ $facility['count'] }}" required>
                    </div>
                @endforeach
            @endforeach
            <div class="bookings-inner-edit">
                <a class="button button-secondary" href="{{ route('admin.admin-bookings') }}">Til alle reservasjoner</a>
                <button class="button" type="submit">Oppdater</button>
            </div>
        </form>
   </article>
@endsection
