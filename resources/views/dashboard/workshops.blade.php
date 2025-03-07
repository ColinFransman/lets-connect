<div>
    <!-- TODO: Mooi maken deze frontend -->

    
    @foreach ($workshopmoments as $wm)
        <div>
           {{$wm->workshop->name}}
           {{$wm->moment->time}}
           {{$wm->workshop->capacity}}
           {{$wm->workshop->room_name}}
           aantal boekingen: {{count($wm->bookings)}}
            <?php if ( count($wm->bookings) < $wm->workshop->capacity ) { ?>
                <span>nog plek</span>
            <?php } else { ?>
                  <span>Vol</span>
            <?php } ?>
            <a href="{{ route('workshop-moment.showbookings', ['wsm' => $wm]) }}">
                View Workshop
            </a>
           
        </div>
    @endforeach

</div>
