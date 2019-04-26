<?php
    session_start();
    foreach($_POST as $key => $value) {  
        $_SESSION[$key] = $value;  
    } 
    
    var_dump($_SESSION);
?>
@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-2">
            <h2>Bestill rom</h2>
            <h3>Tilgjengelige rom</h3>
            <form action="/booking-facilities" method="POST">
                @csrf
                <div class="step-2-sec">
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/enkeltrom.jpg') }}" alt="Illutrasjon av enkeltrom">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" value="single-room">
                            <p>Enkeltrom</p>
                        </span>
                        <p>NOK 990,- per natt</p>        
                    </section>
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/dobbeltrom.jpg') }}" alt="Illutrasjon av dobbeltrom">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" value="single-double">
                            <p>Dobbeltrom</p>
                        </span>
                        <p>NOK 1290,- per natt</p>

                    </section>
                </div>
                <div class="step-2-sec">
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/suite.jpg') }}" alt="Illutrasjon av suite">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" value="single-suite">
                            <p>Suite</p>
                        </span>
                        <p>NOK 1990,- per natt</p>
                    </section>
                    <section class="step-2-sec-inner">
                        <img src="{{ asset('images/bryllupssuite.jpg') }}" alt="Illutrasjon av bryllupssuite">
                        <span class="step-2-sec-inner-check">                            
                            <input type="checkbox" name="room" value="single-wedding-suite">
                            <p>Bryllupssuite</p>
                        </span>
                        <p>NOK 2490,- per natt</p>
                    </section>
                </div>
                <section class="booking-form-btns">
                    <a href="#" class="button button-secondary">Tilbake<a/>
                    <button type="submit">Neste</button>
                </section>
            </form>
    </article>
@endsection
