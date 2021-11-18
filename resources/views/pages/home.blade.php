@extends('master')
@section('content')

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Modal Header</h4>
			</div>
			<div class="modal-body">
				<div id="modal_body"></div>
				<div id="quiz_view"></div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Sl</th>
			<th>Title</th>
			<th>version</th>
			<th>Class</th>
			<th>Subject</th>
			<th>Pass Percentage</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sl=1;
		?>
		@foreach($card as $row)
		<tr>
			<td><?php echo $sl;?></td>
			<td>{{$row->title}}</td>
			<td>{{$row->virson}}</td>
			<td>{{$row->class}}</td>
			<td>{{$row->subject}}</td>
			<td>4</td>
			<td onclick="edit_item('{{$row->id}}')"><i class="text-info far fa-edit"></i></td>
			<td onclick="delete_item('{{$row->id}}')"><i class="text-danger fas fa-trash-alt"></i></td>
		</tr>
		<?php echo $sl++;?>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">



	function submit(){
		let id = document.getElementById('id').value;
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
			url: "{{url('/update')}}",
			type: "POST",
			data: {
				id:id,
				version:version,
				classes:classes,
				subject:subject,
				quiz:quiz,
				answer:answer,
				_token:token
			},
			cache: false,
			success: function(dataResult){
				$("#modal_body").html('');
				$("#myModal").modal('hide');
			}
		});
	}





	function edit_item(id){
		$.ajax({
			url: "{{url('/edititem')}}",
			type: "GET",
			data: {
				id:id
			},
			cache: false,
			success: function(dataResult){
				console.log(dataResult);

				$("#modal_body").html(dataResult);
				$("#myModal").modal('show');
			}
		});
	}

	function delete_item(id){
		$.ajax({
			url: "{{url('/delete_item')}}",
			type: "GET",
			data: {
				id:id
			},
			cache: false,
			success: function(dataResult){
				//console.log(dataResult);
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