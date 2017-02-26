@extends('base')

@section('content')

<form action="http://localhost:8888/sancoTM/public/fileupload" method="post"
enctype="multipart/form-data">
	<input type="file" name="file"></input>
	<input type="submit">
</form>
@stop