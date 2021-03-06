{{--TODO:Basis opzetje, verre van klaar; nog afmaken en uitbouwen--}}
<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
</head>
<body>
<h1>Casefile - {{ $obj->casecode }}</h1>
<div class="">
    <span><b>CC:</b> {{$obj->casecode}}</span><br>
    <span><b>CID:</b> {{$obj->id}}</span><br>
    <span><b>Created at:</b> {{$obj->created_at}} <b>by</b> {{$obj->creator->name}}</span><br>
    <span><b>Last update at:</b> {{$obj->updated_at}} <b>by</b> {{$obj->modifier->name}}</span><br>
    <span><b>PDF generated at:</b> {{date("d-m-Y h:i",time())}} <b>by</b> {{auth()->user()->name}}</span><br>
    <span><b>Case integrity:</b> <small><span style="color:#686868;">sha256:</span>{{$checksumHash}}</small></span><br>
    @if(isset($leader))
        <span><b>Lead investigator:</b> {{$leader->name}} (UID:{{$leader->id}})</span>
    @else
        <span><b>No lead investigator assigned</b></span>
    @endif

</div>
<div>
    <b>Description:</b> {{$obj->description}}
</div>
<hr>
@if($obj->deleted)
    <h5><span class="badge badge-danger">This casefile has been deleted</span></h5>
@endif

<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(240)->generate('http://localhost/casefiles/cc/'.$obj->casecode)) }} ">


</body>

<style>
    <?php include(public_path().'/css/print.css');?>
</style>

</html>