@if(count($data['messages_recent'])> 0)
    <small><table class="table table-sm">
            <tr class="bg-light" id="licensesTitle">
                <td class="overflow-hidden">
                    Status
                </td>
                <td class="overflow-hidden">
                    From
                </td>
                <td class="overflow-hidden text-right">
                    Date
                </td>
            </tr>
        @foreach($data['messages_recent'] as $message)
            <tr id="licenses{{$message->id}}">
                <td class="line-clamp">
                    <a href="/messages/{{$message->id}}">@if($message->deleted ==  true) deleted @elseif($message->pivot->marked_as_read ==  true) read @else <b>New</b> @endif </a>
                </td>
                <td class="line-clamp">
                    <a href="/users/{{$message->creator->id}}">{{$message->creator->name}}</a>
                </td>
                <td class="text-right">
                    {{\Carbon\Carbon::parse($message->created_at)->format('d/m/Y')}}
                </td>
            </tr>
        @endforeach
    </table>
    </small>
@endif