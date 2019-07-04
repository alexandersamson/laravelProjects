

{!! Form::select('case-state', $data['casestates']->pluck('name','id')->toArray(), 1, ['class'=>'form-control']) !!}