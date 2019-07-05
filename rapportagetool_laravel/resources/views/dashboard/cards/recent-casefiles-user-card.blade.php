@if(count($data['casefiles_user'])> 0)
    <small><table class="table table-sm">
        @foreach($data['casefiles_user'] as $casefile)
            <tr id="casefiles{{$casefile->id}}">
                <td class="overflow-hidden">
                    {{\Illuminate\Support\Str::limit($casefile->name,27)}}
                </td>
                <td class="text-right">
                    @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['casefiles_user'][$casefile->id],'c'=>'blocked','d'=>'blocked'])
            </tr>
        @endforeach
    </table>
    </small>
@endif