@extends('errors.layout')

@section('message')
    <div class="message-box">
        <pre>Je hebt geen toegang tot deze pagina</pre>
        <div class="countdown">
            <pre>Je wordt over&nbsp;</pre>
            <pre id="timer">5</pre>
            <pre>&nbsp;seconden terug gestuurd naar de home page</pre>
        </div>
    </div>
    <img class="background-container" src="{{ asset('/images/24213_SAVETHEDATE_LETS_CONNECT_01.jpg') }}">
<<<<<<< Jesper

    <script>
        let countdown = 5;  
        const timerElement = document.getElementById('timer');

        const interval = setInterval(() => {
            countdown--;
            timerElement.textContent = countdown;

            if (countdown === 0) {
                clearInterval(interval);

                setTimeout(() => {
                    window.location.href = "{{ url('/dashboard') }}";  
                }, 1000);
            }
        }, 1000);
    </script>

</body>
</html>
=======
@endsection
>>>>>>> responsive-design
