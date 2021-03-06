@if(count($data['clients_recent'])> 0)
    <small><table class="table table-sm">
        @foreach($data['clients_recent'] as $client)
            <tr id="posts{{$client->id}}">
                <td class="line-clamp">
                    {{$client->name}}
                </td>
                <td class="text-right">

                    @if(isset($data['cavedBtn']['clients_recent'][$client->id]))
                        @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['clients_recent'][$client->id],'c'=>'blocked','p'=>'blocked'])
                    @endif
            </tr>
        @endforeach
    </table>
    </small>
@endif