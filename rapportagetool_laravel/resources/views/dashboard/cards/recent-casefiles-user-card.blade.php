@if(count($data['casefiles_user'])> 0)
    <small><table class="table table-sm">
        @foreach($data['casefiles_user'] as $casefile)
            <tr id="casefiles{{$casefile->id}}">
                <td class="line-clamp">
                    {{$casefile->name}}
                </td>
                <td class="text-right">
                    @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['casefiles_user'][$casefile->id],'c'=>'blocked','d'=>'blocked'])
            </tr>
        @endforeach
    </table>
    </small>
@endif