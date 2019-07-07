@if(count($data['licenses_due'])> 0)
    <small><table class="table table-sm">
            <tr class="bg-light" id="licensesTitle">
                <td class="overflow-hidden">
                    Type
                </td>
                <td class="overflow-hidden">
                    Expires in
                </td>
                <td class="text-right">
                    Actions
                </td>
            </tr>
        @foreach($data['licenses_due'] as $license)
            <tr id="licenses{{$license->id}}">
                <td class="overflow-hidden">
                    {{\Illuminate\Support\Str::limit($license->type,27)}}
                </td>
                <td class="overflow-hidden">
                    {{ (new \App\Http\Controllers\Services\Helper)->getDaysLeft($license->valid_to)}}
                </td>
                <td class="text-right">

                    @if(isset($data['cavedBtn']['licenses_due'][$license->id]))
                        @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['licenses_due'][$license->id],'c'=>'blocked','a'=>'blocked','d' =>'blocked'])
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    </small>
@endif