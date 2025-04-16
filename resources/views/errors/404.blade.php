@extends('errors.layout')

@section('message')
    <div class="message-box">
        <pre>De pagina is niet gevonden</pre>
        <div class="countdown">
            <pre>Je wordt over&nbsp;</pre>
            <pre id="timer">5</pre>
            <pre>&nbsp;seconden terug gestuurd naar de home page</pre>
        </div>
    </div>
    <img class="background-container" src="{{ asset('/images/24213_SAVETHEDATE_LETS_CONNECT_01.jpg') }}">
@endsection
