<div style="text-align: center; margin-top: 20px;">
    <!-- TODO: Mooi maken deze frontend -->
 
    <h3> {{$wsm->workshop->name}} {{$wsm->moment->time}} </h3>
 
    <table style="width: 50%; margin-left: auto; margin-right: auto; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #343469; text-align: left;">
                <th style="padding: 4px; border: 1px solid #ddd; width: 25%; color: white;">Naam</th>
                <th style="padding: 4px; border: 1px solid #ddd; width: 25%; color: white;">Email</th>
                <th style="padding: 4px; border: 1px solid #ddd; width: 25%; color: white;">Klass</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wsm->bookings as $booking)
                <tr style="background-color: #fafafa;">
                    <td style="padding: 4px; border: 1px solid #ddd;">{{$booking->student->name}}</td>
                    <td style="padding: 4px; border: 1px solid #ddd;">{{$booking->student->email}}</td>
                    <td style="padding: 4px; border: 1px solid #ddd;">{{$booking->student->class}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
 </div>
 
 