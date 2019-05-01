@extends('layouts.app')

@section('content')
    <article class="booking-form bookings">
        <h1>Bookinger</h1>
        <section class="bookings-inner">
            @foreach ($bookings as $booking)
            <h2>ID: {{ $booking->id }}</h2>
                <h4>Opplysninger</h4>
                <p>Innsjekk: {{ $booking->check_in->format('d.m.Y') }}</p>
                <p>Utsjekk: {{ $booking->check_out->format('d.m.Y') }}</p>
                <p>Antall personer: {{ $booking->people }}</p>
                @foreach ($booking->users as $booking_user)
                    @foreach ($booking->booking_rooms as $booking_room)
                        <p>Rom ID: {{ $booking_room->room->id }}</p>
                        <p>Romtype: {{ __($booking_room->room->room_type) }}</p>
                    @endforeach
                    <p>Bestillers navn: {{ $booking_user->user->firstname . ' ' . $booking_user->user->surname}}</p>
                    <p>Telefonnummer: {{ $booking_user->user->phone }}</p>
                    <p>E-post: {{ $booking_user->user->email }}</p>

                    <h4>Fasiliteter</h4>
                    @foreach ($booking_user->facilities as $facility_name => $facility)
                        <p>{{ __(ucfirst($facility_name)) . ': ' . $facility['count']  }}</p>
                    @endforeach
                @endforeach
            @endforeach
        </section>
   </article>
@endsection