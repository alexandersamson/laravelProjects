@if(count($data['casefiles_recent'])> 0)
    <small><table class="table table-sm">
        @foreach($data['casefiles_recent'] as $casefile)
            <tr id="casefiles{{$casefile->id}}">
                <td class="line-clamp">
                    {{$casefile->name}}
                </td>
                <td class="text-right">
                    @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['casefiles_recent'][$casefile->id],'c'=>'blocked','d'=>'blocked'])
            </tr>
        @endforeach
    </table>
    </small>
@endif