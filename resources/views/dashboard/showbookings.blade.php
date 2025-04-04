
<style>
    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
        font-family: sans-serif;
    }

    .section {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        background-color: #fff;
    }

    .section h2 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: #f0f0f0;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
        font-size: 14px;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    .no-bookings {
        font-style: italic;
        color: #888;
    }
</style>

<div class="container">
    <h1 style="text-align: center; font-size: 28px; margin-bottom: 40px;">Workshop Boekingen</h1>

    @foreach($workshopmoments as $wsm)
        <div class="section">
            <h2>{{ $wsm->workshop->name }} — {{ $wsm->moment->time }}</h2>

            @if($wsm->bookings->isEmpty())
                <p class="no-bookings">Nog geen boekingen.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Student Naam</th>
                            <th>Email</th>
                            <th>Aanwezig</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wsm->bookings as $booking)
                            <tr>
                                <td>{{ $booking->student->name }}</td>
                                <td>{{ $booking->student->email }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @pageBreak
    @endforeach
</div>

