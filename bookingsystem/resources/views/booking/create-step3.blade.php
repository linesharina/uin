<?php
    session_start();
    foreach($_POST as $key => $value) {  
        $_SESSION[$key] = $value;  
    } 
    
    var_dump($_SESSION);
?>
@extends('layouts.app')

@section('content')
    <article class="booking-form booking-form-step-3">
            <h2>Fasiliteter</h2>
            <form action="/" method="POST">
                @csrf
                <div class="step-2-sec">
                    <section class="step-2-sec-inner">
                        <h3>Måltider</h3>
                        <img src="{{ asset('images/enkeltrom.jpg') }}" alt="Illutrasjon av enkeltrom">
                        <span class="step-2-sec-inner-check">
                            <input type="checkbox" name="room" value="single-room">
                            <p>Enkeltrom</p>
                        </span>
                        <p>NOK 990,- per natt</p>        
                    </section>
                </div>
                <section class="booking-form-btns">
                    <a href="#" class="button button-secondary">Tilbake<a/>
                    <button type="submit">Neste</button>
                </section>
            </form>
    </article>
@endsection
