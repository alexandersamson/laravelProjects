<small>
    @if(isset($data['createdAt']) || isset($data['creator']))
        Created
        @if(isset($data['createdAt']))
            at {{$data['createdAt']->format('d/m/Y h:i')}}
        @endif
        @if(isset($data['creator']))
            by <a href="/users/{{$data['creator']->id}}">{{$data['creator']->name}}</a>
        @endif
    @endif
    @if((isset($data['createdAt']) || isset($data['creator'])) && (isset($data['modifiedAt']) || isset($data['modifier'])))
        &nbsp;|&nbsp;
    @endif
    @if(isset($data['modifiedAt']) || isset($data['modifier']))
        Last edited
        @if(isset($data['modifiedAt']))
            at {{$data['modifiedAt']->format('d/m/Y h:i')}}
        @endif
        @if(isset($data['modifier']))
            by <a href="/users/{{$data['modifier']->id}}">{{$data['modifier']->name}}</a>
        @endif
    @endif

</small>