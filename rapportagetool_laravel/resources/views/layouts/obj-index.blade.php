@extends('layouts.app')

@section('content')

    <h3>{{ucfirst($data['category'])}}</h3>
    @include('includes.obj-index-tool-bar',['category' => $data['category']])
    <div class="mt-2">
        <obj-index-nav></obj-index-nav>
        <obj-index></obj-index>
        @if(count($data['objs']) > 0)
            <div class="card small">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <table class="table table-sm mb-0 table-hover">
                            @include('includes.headers.index-obj-table',['category' => $data['category']])
                            @foreach($data['objs'] as $obj)
                                <tr class=" @if($obj->draft == true) text-muted @elseif($obj->deleted == true) text-red-50 @endif ">
                                    @foreach(\App\Http\Controllers\Services\Helper::getObjRowData($data['category'], $obj)[0] as $rowData)
                                        <td class="@if($loop->index > 2)d-none d-lg-table-cell @elseif($loop->index == 2)d-none d-sm-table-cell @endif">
                                            @if($loop->index == 0)
                                                @if($obj->deleted == true)
                                                    <small title="This item has been deleted." class="badge badge-danger font-weight-light">Del.</small>
                                                @endif
                                                @if($obj->approved == false)
                                                    <small title="This item is waiting for approval." class="badge badge-warning font-weight-light">Appr.</small>
                                                @endif
                                                @if($obj->draft == true)
                                                    <small title="This item is still in draft." class="badge badge-primary font-weight-light">Draft</small>
                                                @endif
                                                @if($data['category'] == 'messages')
                                                    @if($obj->pivot->marked_as_read == false)
                                                        <small title="You did not read this yet." class="badge badge-success font-weight-light">New</small>
                                                    @endif
                                                @endif
                                                <a href="{{$data['category']}}/{{$obj->id}}">{!!$rowData!!}</a>
                                            @else
                                                {!!html_entity_decode($rowData)!!}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            {{$data['objs']->links()}}
        @else
            <p>No {{$data['category']}} found</p>
        @endif
    </div>
@endsection