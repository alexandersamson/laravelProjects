@if(count($data['subjects_recent'])> 0)
    <small><table class="table table-sm">
        @foreach($data['subjects_recent'] as $subject)
            <tr id="posts{{$subject->id}}">
                <td class="overflow-hidden">
                    {{\Illuminate\Support\Str::limit($subject->name,27)}}
                </td>
                <td class="text-right">

                    @if(isset($data['cavedBtn']['subjects_recent'][$subject->id]))
                        @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['subjects_recent'][$subject->id],'c'=>'blocked'])
                    @endif
            </tr>
        @endforeach
    </table>
    </small>
@endif