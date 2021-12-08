<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Task List with Ajax</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	
	<div class="container">
		<h1 class="text-primary text-center text-uppercase">Smart Datasoft Task With Ajax</h1>

		<!-- Button trigger modal -->
		<div class="d-flex justify-content-end">
			<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#addUser">
			  Add Task
			</button>
		</div>
		<h2>All Task</h2>
		<div id="recodrs_contant">
			
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="addUser" tabindex="-1" role="dialog" 			aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       <div class="form-group">
		       	<label for="name"> Name:</label>
		       	<input type="text" id="name" name="" class="form-control" required>
		       </div>
		       <div class="form-group">
		       	<label for="description">Description:</label>
		       	<textarea name="" id="desc" cols="2" rows="2" class="form-control" required></textarea>
		       </div>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="addRecord()">Save</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        
		      </div>
		    </div>
		  </div>
		</div>
			<!-- Modal -->
			<div class="modal fade" id="UserUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       <div class="form-group">
		       	<label for="update_name"> Name:</label>
		       	<input type="text" id="update_name" name="" class="form-control" required>
		       </div>
		       <div class="form-group">
		       	<label for="update_desc">Description:</label>
		       	<textarea name="" id="update_desc" cols="2" rows="2" class="form-control" required></textarea>
		       </div>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateuserrecords()">Update</button>
				  <input type="hidden" name="" id="hidden_user_id">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        
		      </div>
		    </div>
		  </div>
		</div>




	</div>





<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	readRecords();
	
});

	
	function readRecords(){
		var readrecord= "readrecord";
		$.ajax({
			url:"ajax.php",
			type:'post',
			data:{readrecord:readrecord},
			success:function(data,status){
				$('#recodrs_contant').html(data);
			}
		});
	}
		function addRecord() {
			var name = $('#name').val();
			var desc = $('#desc').val();

			$.ajax({
				url:"ajax.php",
				type:'post',
				data:{
					name:name,
					desc:desc
				},
				success:function(data,status){
					readRecords();
				}
			});
			inputs.forEach(input=>input.value='');
		}
		// Delete Data
		function DeleteUser(Deleteid){
			var conf=confirm("Are You Sure to delete this?");
			if(conf==true){
				$.ajax({
					url:"ajax.php",
					type:"post",
					data:{Deleteid:Deleteid},
					success:function(data,status){
						readRecords();
					}
				});
			}
		}
		function deleteMulti(){
			var bulkid =[];
			$(':checkbox:checked').each(function(i){
				bulkid[i]=$(this).val();
			});
			if(bulkid.length===0){
				alert("please select row first");
			} else{
				var conf=confirm("Are You Sure to delete this?");
			if(conf==true){
				$.ajax({
					url:"ajax.php",
					type:"post",
					data:{bulkid:bulkid},
					success:function(data,status){
						for(var i=0;i<=bulkid.length;i++){
							$('tr#'+bulkid[i]+'').css('background-color','#red');
							$('tr#'+bulkid[i]+'').fadeOut('slow');
						}
						readRecords();

					}
				});
			}
			}
			
		}
		function GetUserDetails(id){
			$('#hidden_user_id').val(id);
			$.post("ajax.php",
			{id:id},
			function(data,status){
				var user =JSON.parse(data);
				$('#update_name').val(user.name);
				$('#update_desc').val(user.desc);
			});
			$('#UserUpdate').modal("show");
		}
		// update userdetails
		function updateuserrecords(){
			var update_name=$('#update_name').val();
			var update_desc=$('#update_desc').val();

			var hidden_user_id =$('#hidden_user_id').val();
			$.post("ajax.php",{
				hidden_user_id:hidden_user_id,
				update_name:update_name,
				update_desc:update_desc
			},
			function(data,status){
				$('#UserUpdate').modal("hide");
				readRecords();
			});
		}
</script>
	
</body>
</html>