
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a>
				<a class="brand" href="#">Gunay Shemsi</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li id="imagesTab"><a href="images.php">Images</a></li>
						<li id="eventsTab"><a href="events.php">Categories</a></li>
						<li id="productsTab"><a href="#">Products</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$( function() {
			$("#<?php echo $tab; ?>Tab").addClass("active")
		})
	</script>