<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Boeking</title>
    <link rel="stylesheet" href="{{ asset('/css/bookings.css') }}">
</head>
<body>

<div class="workshop-container">
    <h3> {{$wsm->workshop->name}} {{$wsm->moment->time}} </h3>

    <div class="table-responsive">
        <table class="workshop-table">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Klas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wsm->bookings as $booking)
                <tr>
                    <td>{{$booking->student->name}}</td>
                    <td>{{$booking->student->email}}</td>
                    <td>{{$booking->student->class}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
