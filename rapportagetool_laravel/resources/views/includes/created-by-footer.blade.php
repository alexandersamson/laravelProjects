<small>
    @if(isset($data['createdAt']) || isset($data['creator']))
        Created
        @if(isset($data['createdAt']))
            at {{$data['createdAt']->format('d/m/Y H:i')}}
        @endif
        @if(isset($data['creator']))
            <span class="text-nowrap"> by <a href="/users/{{$data['creator']->id}}">{{$data['creator']->name}}</a></span>
        @endif
    @endif
    @if((isset($data['createdAt']) || isset($data['creator'])) && (isset($data['modifiedAt']) || isset($data['modifier'])))
        &nbsp;|&nbsp;
    @endif
    @if(isset($data['modifiedAt']) || isset($data['modifier']))
        Last edit
        @if(isset($data['modifiedAt']))
            at {{$data['modifiedAt']->format('d/m/Y H:i')}}
        @endif
        @if(isset($data['modifier']))
                <span class="text-nowrap"> by <a href="/users/{{$data['modifier']->id}}">{{$data['modifier']->name}}</a></span>
        @endif
    @endif
</small>