<?php
include_once 'php/DBclass.php';
$db = new DB('localhost', 'ozantu5_work', 'xFM{s+1Gb&3O', 'ozantu5_terradoor');


extract($_POST);

if( isset($_POST['action']) && $_POST['action'] == 'delete' && isset($id)) {
	$sql = 'DELETE FROM images WHERE id = "'.$db->secure($id).'"';
	$que = $db->query($sql);
	if( $que) {}
}
elseif( isset($action, $title, $description, $actdate)) {
	$action 	 = trim($action);
	$title 		 = trim($title);
	$description = trim($description);
	$category 	 = trim($category);
	if( !empty($action) && !empty($title) && !empty($description) && !empty($category)) {
		switch ($action) {
			case 'add':
				if( !isset($_FILES['thumbnail'])) 
					continue;
				$thumbnail = $_FILES['thumbnail'];
				$insertarr = array();
				$insertarr['imagename'] = $db->secure($title);
				$insertarr['imagedesc'] = $db->secure($description);
				$insertarr['adddate'] 	= date('Y-m-d H:i:s');
				$insertarr['category']  = $category;
				$insertarr['imageurl']  = '';
				$que = $db->insert('images', $insertarr);
				if( $que) {}
				break;
			
			case 'edit':
				$sql = 'UPDATE images SET title="'.$db->secure($title).'", description="'.$db->secure($description).'", "'.date('Y-m-d H:i:s', strtotime($actdate)).'" WHERE imageid="'.$db->secure($id).'"';
				$que = $db->query($sql);
				if( $que) {}
				break;
		}
	}
}

$sql = 'SELECT category FROM images WHERE 1 GROUP BY category';
$catArr    = $db->query($sql);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Images</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/images.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-transition.js"></script>
	<script type="text/javascript">
		$( function() {
		})
	</script>
</head>
<body>
<?php $tab = 'images'; include_once 'header.php' ?>

	<div id="container">
		<h2 style="text-align:center;">Images</h2><br>
		  <table class="table table-bordered" id="wrapper">
		  	<tr>
		  		<th>Image</th>
		  		<th>Title</th>
		  		<th>Description</th>
		  		<th>Category</th>
		  		<th>Views</th>
		  	</tr>
		  	
		  </table>
		<a id="buttonOpenAdd" href="#addBox" class="btn btn-primary btn-large" style="float:right;" data-toggle="modal">Add an Image</a>
	</div>


	<div class="modal hide fade" id="addBox">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>Add an Image</h3>
	  </div>
	  <div class="modal-body">
	  	<form action="images.php" method="post" id="addForm" enctype="multipart/form-data">
		    <table class="table">
		    	<tr>
		    		<td><span class="input-label">Image:</span></td>
		    		<td><input type="file" id="thumbnail" name="thumbnail"></td>
		    	</tr>
		    	<tr>
		    		<td><span class="input-label">Category:</span></td>
		    		<td><select name="category">
		    			<?php foreach ($catArr as $key => $value) { ?>
		    				<option value="<?php echo $value['category']; ?>"><?php echo $value['category']; ?></option>
		    			<?php } ?>
		    			<option value="new">New...</option>
		    		</select></td>
		    	</tr>
		    	<tr>
		    		<td><span class="input-label">Title:</span></td>
		    		<td><input type="text" id="title" name="title"></td>
		    	</tr>
		    	<tr>
		    		<td><span class="input-label">Description:</span></td>
		    		<td><textarea style="width:350px; height:100px;" id="desc" name="description"></textarea></td>
		    	</tr>
		    </table>
		    <input type="hidden" value="images" name="action">
		    <input type="hidden" value="" name="id">
		</form>
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Close</a>
	    <a id="buttonAddImage" href="#" class="btn btn-primary">Add</a>
	  </div>
	</div>

	<div class="modal hide fade" id="deleteBox">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Are you sure to delete?</h3>
		</div>
		<div class="modal-body">
			<form action="images.php" method="post" id="deleteForm">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a id="buttonDeleteImage" href="#" class="btn btn-danger">Delete</a>
				<input type="hidden" value="dummy" name="title">
				<input type="hidden" value="dummy" name="description">
				<input type="hidden" value="delete" name="action">
				<input type="hidden" value="" name="id">
			</form>
		</div>
	</div>


</body>
</html>