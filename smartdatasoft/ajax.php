<?php

$conn = mysqli_connect('localhost','root',"",'smartdatasoft');

extract($_POST);

if(isset($_POST['readrecord'])){
	$data ='<table class="table">
	<thead class="thead-dark">
	  <tr>
	  	<th scope="col"><button onclick="deleteMulti()" id="btn_delete" name=""btn_delete" class="btn btn-danger">Delete</button></th>
		<th scope="col">#Id</th>
		<th scope="col">Name</th>
		<th scope="col">Description</th>
		<th scope="col">Edit</th>
		<th scope="col">Delete</th>
	  </tr>
	</thead><tbody>';
	$displayquery = " SELECT * FROM `task`";
	$result = mysqli_query($conn,$displayquery);
	if(mysqli_num_rows($result)>0){
		$number =1;
		while ($row =mysqli_fetch_array($result)) {
			$data .='
				  <tr>
				  <td style="width:10px;text-align:center"><input type="checkbox" name="task_id[]" value="'.$row['id'].'" class="delete_task	"></td>
					<th scope="row">'.$number.'</th>
					<td>'.$row['name'].'</td>
					<td>'.$row['desc'].'</td>
					<td><button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning">Edit</button></td>
					<td><button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button></td>
				  </tr>
				';
			  $number++;
			  }
	}
	$data .='</tbody>
			  </table>';
			  echo $data;

}

if(isset($_POST['name']) && isset($_POST['desc']))
{
	$query =" INSERT INTO `task`(`name`, `desc`) VALUES ('$name','$desc')";
	mysqli_query($conn,$query);
}

if(isset($_POST['Deleteid'])){
	$userid= $_POST['Deleteid'];
	$deletequery= "DELETE FROM `task` WHERE id='$userid'";
	mysqli_query($conn,$deletequery);
}
if(isset($_POST['id']) && isset($_POST['id']) !=""){
	$user_id = $_POST['id'];
	$query = "SELECT * FROM `task` WHERE id='$user_id'";
	if(!$result = mysqli_query($conn,$query)){
		exit(mysqli_error());
	}
	$response=array();
	if(mysqli_num_rows($result)>0){
		while($row =mysqli_fetch_assoc($result)){
			$response =$row;
		}
	}else{
		$response['status']=200;
		$response['message']="Data Not Found";
	}
	echo json_encode($response);
}else{
	$response['status']=200;
	$response['message']="Invalid Request";
}

// update task
if(isset($_POST['hidden_user_id'])){
	$updateid = $_POST['hidden_user_id'];
	$update_name =$_POST['update_name'];
	$update_desc=$_POST['update_desc'];
	$query ="UPDATE `task` SET `name`='$update_name',`desc`='$update_desc' WHERE `id`='$updateid'";
	if(!$result = mysqli_query($conn,$query)){
		exit(mysqli_error());
	}
}
// multiple delete
if(isset($_POST["bulkid"])){
	foreach($_POST["bulkid"] as $id){
		$query ="DELETE FROM `task` WHERE id='$id'";
		mysqli_query($conn,$query);
	}
}
?>