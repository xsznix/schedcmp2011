<!DOCTYPE html>
<html>
	<head>
		<title>Schedule comparisonator</title>
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/sc.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/zurb-ie.css">
		<script src="static/zurb-ie.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/zurb.css">
		<script src="http://205.185.117.12/static/zurb.js"></script>
		<!--<![endif]-->
	</head>
	<body>
		<h2>View your classmates!</h2>
		<p class="note">Based on the schedule that you input, here are your
		classmates for next year:</p>
		<?php foreach($data as $course) { ?>
			<h3><?=$course['name']?></h3>
			<p class="note">You have <?=$course['name']?> with:</p>
			<span class="peers">
				<ul>
				<?php if($course['shared'] != false) { ?>
					<?php foreach($course['shared'] as $item) { 
						$message = "";
						if(!$item['courseShared'] == "true") { $message = "(semester " . $item['courseShared'] . " only)"; } 
						?>
						<li><?php echo $item['name'] . " " . $message?></li>
					<?php } ?>
					
				<?php } ?>
				</ul>
			</span><br>
		<?php } ?>
		<div id="footer">
		<hr><a href="addcourses">Edit Schedule</a> | <a href="logout">Log out</a> |
		</div>
	</body>
</html>
