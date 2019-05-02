@extends('layouts.app')

@section('content')
    <article class="booking-form bookings">
        <h1>Bookinger</h1>
        @foreach ($bookings as $booking)
            <section class="bookings-inner">
                <h2>ID: {{ $booking->id }}</h2>
                <h4>Opplysninger</h4>
                <p>Innsjekk: {{ $booking->check_in->format('Y-m-d') }}</p>
                <p>Utsjekk: {{ $booking->check_out->format('Y-m-d') }}</p>
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
                <div class="bookings-inner-edit">
                    <a class="button" href="{{ route('admin.admin-edit', $booking) }}">Rediger</a>
                    <form method="POST" action="{{ route('admin.admin-delete', $booking) }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="button button-secondary">Slett</button>
                    </form>
                </div>
            </section>
            <hr>
        @endforeach
   </article>
@endsection
