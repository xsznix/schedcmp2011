<!DOCTYPE html>
<html>
	<head>
		<title>Schedule comparisonator</title>
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/login.css">
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/zurb.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script src="http://205.185.117.12/static/addcourses.js"></script><!-- IMPORTANT: temporary local link -->
		<script src="http://205.185.117.12/static/zurb.js"></script>
	</head>
	<body>
		<h2>Enter in your courses below!</h2>
		<p class="note"><b>IMPORTANT: READ BEFORE ENTERING INFORMATION</b></p>
		<p class="note">(tl;dr just read the instructions, lazy)</p>
		<p class="note">For each class, click "Add new course", then:</p>
		<p class="note">Enter the block number in the box labelled "Block number". Ex: 1</p>
		<p class="note">Enter the name of the course <i>exactly as it is written</i> on the schedule. Ex: (TODO: course name)</p>
		<p class="note">Enter the 4 digit ID of the course <i>without the following A or B if there is one</i>. Ex: 4353</p>
		<p class="note">Select the semester(s) that you will be taking the course.</p>
		<p class="note"><b>If you already entered information and want to edit your schedule, you have to enter all of your schedule information again.
		I'm sorry. We had less than two days (48 hours) to do this. We'll fix this later.</b></p>
		<p class="note" id="message" style="color:#F00;"><?php if(isset($message)) { echo $message; } ?></p>
		<form id="courses" action="<?=site_url('admin/addcourses')?>" method="post" onsubmit="return validate();">
			<h2>Courses</h2>
			<span id="courses-wrapper">
			</span>
			<input type="button" value="Add new course" onclick="spawnNewCourseEntry();">
			<input type="submit" value="Submit">
		</form>
	<div id="footer">
		<br />
		<br />
		<br />
		<a href="<?=site_url('admin/logout')?>">Log Out</a> | <a href="<?=site_url('admin/main')?>">Back to Main</a>
	</div>
	</body>
</html>
