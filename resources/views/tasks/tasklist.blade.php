<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- CSS -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <!-- JS -->
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel='shortcut icon' type='image/x-icon' href='../assets/images/weego1.png' />

    <link href="https://fonts.googleapis.com/css?family=Baloo+Thambi" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet">
	<title>To Do List</title>
</head>
<body>
	<div class="container mt-5 mb-5">
		<div class="col-lg-8 offset-lg-2">
			<h3 class="text-center" style="font-family: 'Shrikhand', cursive;">My To Do List</h3>
			<form action="/newtask" method="POST">

				{{ csrf_field() }}

				<div class="form-group" style="background-color: #7e5dc6; color:white; border-radius: 5%; border: 5px solid #2d1660">
					<label for="newtask" style="width:30%; margin-left: 4%;">New Task:</label>
					<input type="text" name="newtask" id="newtask" class="form-control" style="width:94%; margin-left:3%; margin-bottom: 2%;">
					<button type="submit" class="btn" style="width: 50%; margin-left:25%; margin-bottom:2%; background-color: #41b1fb; border: 3px solid #0e354e; border-radius: 40%;"><i class="fa fa-btn fa-plus"></i>Add Task</button>
				</div>
			</form>
				@if(Session::has("success_message"))
				<div class="alert text-center" style="color:green; width:50%; margin-left:25%; background-color: #77e552; border:3px solid #25660f">
					{{ Session::get("success_message") }}
				</div>
				@endif
			<table class="table table-striped">
				<thead>
					<th>Task</th>
					<th>Created on</th>
					<th>Actions</th>
				</thead>
				<tbody>
					@foreach($tasks as $task)
						<tr style="font-family: 'Baloo Thambi', cursive;">
							<td>{{ $task->name }}</td>	
							<td>{{ $task->created_at->diffForHumans() }} </td>
							<td><button type="button" class= "btn btn-danger" data-toggle="modal" onclick="openDeleteModal({{ $task->id }}, '{{ $task->name }}')">Delete</button>

								<button type="button" class="btn btn-primary" data-toggle="modal" onclick="openEditModal({{ $task->id }}, '{{ $task->name }}')">Edit</button>
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>


	<div id="deleteModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Confirm Delete</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<p id="taskName"></p>
				</div>
				<div class="modal-footer">
					<form id="deleteForm" method="POST">
						{{ csrf_field() }}
						{{ method_field("DELETE") }}

						<button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-trash"></i>Proceed</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</form>
				</div>
			</div>
		</div>
	</div>


	<div id="editModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Item</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<span id="taskToReplace"></span>
				</div>
				<div class="modal-footer">
					<form id="editForm" method="POST">

						{{ csrf_field() }}
						{{ method_field("PATCH") }}

						<input type="text" name="editedTask">
						<button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-edit"></i>Confirm</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		function openEditModal(id,name){
			$("#taskToReplace").html("Do you want to edit task <strong>" + name + "</strong>");
			$("#editForm").attr("action", "/task/"+id);
			$("#editModal").modal("show");
		}

		function openDeleteModal(id,name){
			$("#taskName").html("Are you sure you want to delete " + name + "?");
			$("#deleteForm").attr("action", "/task/"+id);
			$("#deleteModal").modal("show");
		}
	</script>

</body>
</html>