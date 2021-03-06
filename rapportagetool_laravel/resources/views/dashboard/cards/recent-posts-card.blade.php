@if(count($data['posts'])> 0)
    <small><table class="table table-sm">
        @foreach($data['posts'] as $post)
            <tr id="posts{{$post->id}}">
                <td class="line-clamp">
                    {{$post->name}}
                </td>
                <td class="text-right">

                    @if(isset($data['cavedBtn']['posts'][$post->id]))
                        @include('includes.caved-buttons', ['cavedBtnArray' => $data['cavedBtn']['posts'][$post->id],'c'=>'blocked', 'p'=>'blocked'])
                    @endif
            </tr>
        @endforeach
    </table>
    </small>
@endif