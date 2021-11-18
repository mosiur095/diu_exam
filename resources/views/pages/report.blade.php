@extends('master')
@section('content')
<div class="col-md-12">
	<form action="#">
		<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Version:</label>
				<select class="form-control" id="version" onchange="select_class()">
					<option selected="true" disabled>Select one</option>
					@foreach($verson as $row)
					<option value="{{$row->id}}">{{$row->virson}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Class:</label>
				<select class="form-control" id="class" onchange="select_subject()">
					<option selected="true" disabled>Select one</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Subject:</label>
				<select class="form-control" id="subject">
					<option selected="true" disabled>Select one</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="email">Common Quize:</label>
				<select class="form-control" id="quiz" onchange="fetch_quiz()">
					<option selected="true" disabled>common quiz</option>
					@foreach($quiz as $value)
					<option value="{{$value->id}}">{{$value->title}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</form>
</div>
<div class="col-md-12" id="quiz_view"></div>
<script type="text/javascript">

	function submit(){
		let version = document.getElementById('version').value;
		let classes = document.getElementById('class').value;
		let subject = document.getElementById('subject').value;
		let quiz    = document.getElementById('quiz').value;
		let question_id = document.getElementById('questionid').value;
		let token = document.getElementById('_token').value;
		var qusetions = question_id.split(",");
		var answer = [];
		for (var i = qusetions.length - 1; i >= 0; i--) {
			var question = qusetions[i];
			var selcted_answer = document.querySelector('input[name="'+question+'"]:checked').value;
			answer.push({'question':question,'answer':selcted_answer});
		}

		$.ajax({
			url: "{{url('/store')}}",
			type: "POST",
			data: {
				version:version,
				classes:classes,
				subject:subject,
				quiz:quiz,
				answer:answer,
				_token:token
			},
			cache: false,
			success: function(dataResult){
			}
		});
	}

	function select_class(){
		let version = document.getElementById('version').value;
		$.ajax({
			url: "{{url('/fetch_class')}}",
			type: "GET",
			data: {
				version:version
			},
			cache: false,
			success: function(dataResult){
				document.getElementById('class').innerHTML = dataResult;
			}
		});
	}

	function select_subject(){
		let classes = document.getElementById('class').value;
		$.ajax({
			url: "{{url('/fetch_subject')}}",
			type: "GET",
			data: {
				classes:classes
			},
			cache: false,
			success: function(dataResult){
				document.getElementById('subject').innerHTML = dataResult;
			}
		});
	}

	function fetch_quiz(){
		let id = document.getElementById('quiz').value;
		$.ajax({
			url: "{{url('/fetch_quiz')}}",
			type: "GET",
			data: {
				quiz_id:id
			},
			cache: false,
			success: function(dataResult){
				document.getElementById('quiz_view').innerHTML = dataResult;
			}
		});
	}
</script>
@endsection