@if(count($data['casefiles_updated'])> 0)
    <small><table class="table table-sm">
        @foreach($data['casefiles_updated'] as $casefile)
            <tr id="casefiles{{$casefile->id}}">
                <td class="line-clamp">
                    {{$casefile->name}}
                </td>
                <td class="text-right">
                    @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['casefiles_updated'][$casefile->id],'c'=>'blocked','d'=>'blocked'])
            </tr>
        @endforeach
    </table>
    </small>
@endif