@if(count($posts) > 0)
    <small><table class="table table-sm table-striped">
        <tr>
            <th>
                Title
            </th>
            <th>
                View
            </th>
            <th>
                Edit
            </th>
            <th>
                X
            </th>
        </tr>
        @foreach($posts as $post)
            <tr>
                <th>
                    {{$post->title}}
                </th>
                <th>
                    <a href="/posts/{{$post->id}}" class="btn btn-sm btn-xs btn-success">View</a>
                </th>
                <th>
                    <a href="/posts/{{$post->id}}/edit" class="btn btn-sm btn-xs btn-primary">Edit</a>
                </th>
                <th>
                    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => ''])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('&times;', ['class' => 'btn btn-sm btn-xs btn-danger'])}}
                    {!!Form::close()!!}
                </th>
            </tr>
        @endforeach
    </table>
    </small>
@endif