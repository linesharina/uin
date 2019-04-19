@extends('layouts.app')

@section('content')
    <form action="get">
        <div>
            <label for="firstname">Fornavn*</label>
            <input type="text" id="firstname" name="user_firstname" />
        </div>
        <div>
            <label for="surname">Etternavn*</label>
            <input type="text" id="surname" name="user_surname" />
        </div>
        <div>
            <label for="mail">E-post*</label>
            <input type="email" id="mail" name="user_mail" />
        </div>
        <div>
            <label for="number">Mobil</label>
            <input type="text" id="number" name="user_number" />
        </div>
    </form>
@endsection
