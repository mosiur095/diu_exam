@extends('master')
@section('content')
<div class="col-md-12">
	<form action="{{url('/image_upload')}}" method="POST" enctype="multipart/form-data">
		<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token();?>">
		<div class="form-group">
			<label for="exampleFormControlFile1">file input</label>
			<input type="file" class="form-control-file" id="image" name="image">
		</div>
		<button type="submit" name="submit" class="btn btn-success">Save</button>
	</form>
</div>
@endsection