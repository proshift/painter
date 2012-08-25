<?php
include_once 'php/DBclass.php';
$db = new DB('localhost', 'ozantu5_work', 'xFM{s+1Gb&3O', 'ozantu5_terradoor');


extract($_POST);

if( isset($_POST['action']) && $_POST['action'] == 'delete' && isset($id)) {
	$sql = 'UPDATE activities SET status="deleted" WHERE id = "'.$db->secure($id).'"';
	$que = $db->query($sql);
	if( $que) {}
}
elseif( isset($action, $title, $description, $actdate)) {
	$action 	 = trim($action);
	$title 		 = trim($title);
	$description = trim($description);
	$actdate 	 = trim($actdate);
	if( !empty($action) && !empty($title) && !empty($description) && !empty($actdate)) {
		switch ($action) {
			case 'add':
				$sql = 'INSERT INTO activities(title, description, activitydate, adddate, type) VALUES ("'.$db->secure($title).'", "'.$db->secure($description).'", "'.date('Y-m-d H:i:s', strtotime($actdate)).'", "'.date('Y-m-d H:i:s').'", "events")';
				$que = $db->query($sql);
				if( $que) {}
				break;
			
			case 'edit':
				$sql = 'UPDATE activities SET title="'.$db->secure($title).'", description="'.$db->secure($description).'", "'.date('Y-m-d H:i:s', strtotime($actdate)).'" WHERE id="'.$db->secure($id).'"';
				$que = $db->query($sql);
				if( $que) {}
				break;
		}
	}
}

$sql = 'SELECT * FROM activities WHERE status <> "deleted" AND type = "events" ORDER BY ADDDATE DESC LIMIT 20';
$result = $db->query($sql);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Events</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/events.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-transition.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
</head>
<body>
<?php $tab = 'events'; include_once 'header.php' ?>

	<div id="container">
		<h2 style="text-align:center;">Events</h2><br>
		  <table class="table table-bordered" id="wrapper">
		  	<tr>
		  		<th>Title</th>
		  		<th>Description</th>
		  		<th>Event Date</th>
		  		<th>Add Date</th>
		  		<th>Options</th>
		  	</tr>
		  	<?php $count = 0;
		  		foreach( $result as $key => $value) { $count++;?>
			  	<tr>
			  		<td><?php echo $value['title']; ?></td>
			  		<td><?php echo $value['description']; ?></td>
			  		<td style="widht:150px;"><?php echo $value['activitydate']; ?></td>
			  		<td style="width:150px;"><?php echo $value['ADDDATE']; ?></td>
			  		<td style="width:150px;">
			  			<a href="#deleteBox" class="btn btn-danger" data-toggle="modal" onclick="news.openDeleteBox(<?php echo $value['id'].','.$count; ?>)"><span class="icon-trash icon-white"></span> Delete</a>
			  			<a href="#addModal" class="btn btn-primary" data-toggle="modal" onclick="news.openEditModal(<?php echo $value['id'].','.$count; ?>)"><span class="icon-edit icon-white"></span> Edit</a>
			  		</td>
			  	</tr>
		  	<?php } ?>
		  </table>
		<a href="#addModal" class="btn btn-primary btn-large" style="float:right;" data-toggle="modal" onclick="news.openAddModal()">Add an Event</a>
	</div>


	<div class="modal hide fade" id="addModal">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>Add a News</h3>
	  </div>
	  <div class="modal-body">
	  	<form action="events.php" method="post" id="addForm">
		    <table class="table">
		    	<tr>
		    		<td><span class="input-label">Title:</span></td>
		    		<td><input type="text" id="title" name="title"></td>
		    	</tr>
		    	<tr>
		    		<td><span class="input-label">Event Date</span></td>
		    		<td>
		    			<div class="input-append date datepicker" id="datepickerFrom" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
							<input class="span2 date-input" id="date-inputFrom" size="16" type="text" name="actdate" value="Pick a date..." readonly>
							<span class="add-on"><i class="icon-th"></i></span>
						</div>
		    		</td>
		    	<tr>
		    		<td><span class="input-label">Description:</span></td>
		    		<td><textarea style="width:350px; height:100px;" id="desc" name="description"></textarea></td>
		    	</tr>
		    </table>
		    <input type="hidden" value="news" name="action">
		    <input type="hidden" value="" name="id">
		</form>
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Close</a>
	    <a href="#" class="btn btn-primary" onclick="news.addNews()">Add</a>
	  </div>
	</div>

	<div class="modal hide fade" id="deleteBox">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Are you sure to delete?</h3>
		</div>
		<div class="modal-body">
			<form action="events.php" method="post" id="deleteForm">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-danger" onclick="news.deleteNews()">Delete</a>
				<input type="hidden" value="dummy" name="title">
				<input type="hidden" value="dummy" name="description">
				<input type="hidden" value="delete" name="action">
				<input type="hidden" value="" name="id">
			</form>
		</div>
	</div>


</body>
</html>