

{!! Form::select('case-state', $data['casestatusses']->pluck('name','id')->toArray(), 1, ['class'=>'form-control']) !!}