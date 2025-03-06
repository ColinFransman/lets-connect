<div>
   <!-- TODO: Mooi maken deze frontend -->

   <h3> {{$wsm->workshop->name}} {{$wsm->moment->time}} </h3>
    <table>
    @foreach ($wsm->bookings as $booking)
        <tr>
        <td>{{$booking->student->name}}</td>
        <td>{{$booking->student->email}}</td>
        <td>{{$booking->student->phone}}</td>
        </tr>
    @endforeach
</div>
