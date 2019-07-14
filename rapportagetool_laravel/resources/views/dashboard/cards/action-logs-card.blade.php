@if(count($data['action_logs'])> 0)
    <small><table class="table table-sm">
            <tr class="bg-light" id="licensesTitle">
                <td class="overflow-hidden">
                    User
                </td>
                <td class="overflow-hidden">
                    Action
                </td>
                <td class="text-right">
                    Object
                </td>
            </tr>
        @foreach($data['action_logs'] as $actionLog)
            <tr id="casefiles{{$actionLog->id}}">
                <td class="line-clamp">
                    {{\Illuminate\Support\Str::limit($actionLog->user->name,18)}}
                </td>
                <td class="line-clamp @if($actionLog->action == 'delete' || $actionLog->action == 'erase') text-danger @endif ">
                    {{$actionLog->action}}
                </td>
                <td class="line-clamp text-right">
                    <span @if(!\App\Http\Controllers\Services\Helper::exists($actionLog->object, $actionLog->object_id))class="text-black-50" @endif>
                        @if((\App\Http\Controllers\Services\PermissionsService::canDoWithObj($actionLog->object, $actionLog->object_id, 'd_adv', false, true) || \App\Http\Controllers\Services\PermissionsService::canDoWithObj($actionLog->object, $actionLog->object_id, 'r', true, true)) &&  \App\Http\Controllers\Services\Helper::exists($actionLog->object, $actionLog->object_id))
                            <a href="{{$actionLog->object}}/{{$actionLog->object_id}}">
                                @foreach (\Illuminate\Support\Facades\Config::get('categoriesSingular') as $cat => $category)
                                    @if($actionLog->object == $cat)
                                        {{$category}}
                                        @break
                                    @endif
                                @endforeach
                            </a>
                        @else
                            @foreach (\Illuminate\Support\Facades\Config::get('categoriesSingular') as $cat => $category)
                                @if($actionLog->object == $cat)
                                    {{$category}}
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    </small>
@endif