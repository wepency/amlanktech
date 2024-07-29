<ul class="list-group fa-padding">
    @foreach($tickets as $ticket)
        <li class="list-group-item">
            <a href="{{url('tickets/'.$ticket->id)}}" class="media">
                <i class="fa fa-cog pull-left"></i>

                <div class="media-body">
                    <strong>{{$ticket->title}}</strong> <span
                        class="badge badge-danger">IMPORTANT</span><span
                        class="number pull-right">#{{$ticket->code}}</span>

{{--                    <p class="info">أخر رد من خلال <a href="#"> {{$ticket?->lastMessage?->sender->name}} </a>  <i class="fa fa-comments"></i> <a href="#">{{$ticket->ticket_messages_count}} comments</a></p>--}}
                </div>
            </a>
        </li>
    @endforeach
</ul>
