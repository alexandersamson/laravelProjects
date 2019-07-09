@if(count($data['subjects_recent'])> 0)
    <small><table class="table table-sm">
        @foreach($data['subjects_recent'] as $subject)
            <tr id="posts{{$subject->id}}">
                <td class="line-clamp">
                    {{$subject->name}}
                </td>
                <td class="text-right">

                    @if(isset($data['cavedBtn']['subjects_recent'][$subject->id]))
                        @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['subjects_recent'][$subject->id],'c'=>'blocked','p'=>'blocked'])
                    @endif
            </tr>
        @endforeach
    </table>
    </small>
@endif