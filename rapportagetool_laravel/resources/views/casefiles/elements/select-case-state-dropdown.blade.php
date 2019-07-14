

{!! Form::select('case-state', $data['casestatus']->pluck('name','id')->toArray(), 1, ['class'=>'form-control']) !!}