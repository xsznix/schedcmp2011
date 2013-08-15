<?php

class Admin_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
   }

   public function verify_user($email, $password)
   {
   	$salt = "[REDACTED]";
      $q = $this
            ->db
            ->where('email', $email)
            ->where('password', sha1($salt . $password))
            ->limit(1)
            ->get('users');
      if ( $q->num_rows > 0 ) {
         // person has account with us
         return $q->row();
      }
     return false;
   }
   
   public function register_user($name, $email, $password) {
   	// check if email is in db already
   	$emailCheck = "SELECT `email` FROM users WHERE email='" . $email ."'";
   	$emailResult = $this->db->query($emailCheck)->result();
   	if(sizeof($emailResult) != 0) { return false; }
   	$salt = "[REDACTED]";
   	$hashedPassword = sha1($salt . $password);
   	$sql = "INSERT INTO `users` (`name`, `email`, `password`, `id`) VALUES ('$name', '$email', '$hashedPassword', NULL)";
   	$result = $this->db->query($sql);
   	return $result;
   }
   
   public function getIDFromEmail($email) {
   	$sql = "SELECT id FROM `users` WHERE email='" . $email ."'";
   	$result = $this->db->query($sql)->result();
   	return $result[0]->id;
   }
   
   public function getCourses($id) {
   	$sql = "SELECT courseid, block, semesterStatus FROM `users_courses` WHERE userid=" . $id;
   	$result = $this->db->query($sql)->result();
   	$prettyResult;
   	foreach($result as $course) {
   		$prettyResult[] = array("courseid" => $course->courseid, "block" => $course->block, "semesterStatus" => $course->semesterStatus);
   	}
   	return $prettyResult;
   }
   
   public function getStudentsTakingCourse($courseID, $currentUserID, $currentUserSemesterStatus, $currentUserBlock) {
   	$sql = "SELECT userid, semesterStatus FROM `users_courses` WHERE block=$currentUserBlock AND courseid=" . $courseID . " AND userid<>" . $currentUserID;
   	$rawresult = $this->db->query($sql)->result();
   	if(sizeof($rawresult) == 0) { return false; }
   	$getNameFromIDSql = "SELECT name FROM `users` WHERE id=" . $rawresult[0]->userid;
   	//generate the id=2 or id=3 or id=4 etc. etc. etc.
   	for($i = 1; $i < sizeof($rawresult); $i++) { // -1 because we already did the first, and $i =1 because we want second element first
   		$getNameFromIDSql .= " OR id=" . $rawresult[$i]->userid;
   	}
   	$result = $this->db->query($getNameFromIDSql)->result(); // we execute
   	$finalArray;
   	for($i = 0; $i < sizeof($rawresult); $i++) { // combine the semesterstatus from raw and the names from the result
   		$courseShared; // do these two people overlap semesters?
   		if($rawresult[$i]->semesterStatus != $currentUserSemesterStatus) {
   			if($rawresult[$i]->semesterStatus == 0 || $currentUserSemesterStatus == 0) { // if one is taking for a whole semester, and one is taking for partial, they will overlap one semester
   				$courseShared = max($rawresult[$i]->semesterStatus, $currentUserSemesterStatus); //example, zero and one. You want to take the larger number.
   			}
   			else { continue; }  // if it's like, 1 and 2, these two people don't even share the course, even though they share the block! how sad :(
   		}
   		else { $courseShared = "true"; } // yay, they share the entire year together :D. why a string? otherwise it outputs "1" to the array. lolz
   		@$finalArray[] = array("courseShared" => $courseShared, "name" => $result[$i]->name);
   	}
   	return $finalArray;
   }
   
   public function addCourse($courseName, $courseID) {
   	$courseName = mysql_real_escape_string($courseName);
   	$courseID = mysql_real_escape_string($courseID);
   	$sql = "INSERT INTO `courses` (`courseName`, `courseID`) VALUES ('$courseName', '$courseID')";
   	return $this->db->query($sql);
   }
   
   public function getCourseFromID($id) {
   	$sql = "SELECT courseName from `courses` WHERE courseID=" . $id;
   	$result = $this->db->query($sql)->result();
   	if(sizeof($result) == 0) { return false; }
   	return $result[0]->courseName;
   }
   
   public function addCoursesToUser($courses, $userID) {
   	for($i = 0; $i < sizeof($courses['coursenumber']); $i++) {
   		$coursenumber = $courses['coursenumber'][$i];
   		$sql = "SELECT courseName from `courses` WHERE courseid=" . $coursenumber;
   		$result = $this->db->query($sql)->result();
   		echo sizeof($result);
   		if(sizeof($result) == 0) { $this->addCourse($courses['coursename'][$i], $coursenumber); }
   	}
   	
   	for($i = 0; $i < sizeof($courses['coursenumber']); $i++) {
   		$coursenumber = mysql_real_escape_string($courses['coursenumber'][$i]);
   		$coursename = mysql_real_escape_string($courses['coursename'][$i]);
   		$block = mysql_real_escape_string($courses['block'][$i]);
   		$semesterStatus = mysql_real_escape_string($courses['semesterstatus'][$i]);
   		$sql = "INSERT INTO `users_courses` (`userid`, `courseid`, `semesterstatus`, `block`) VALUES ('$userID', '$coursenumber', '$semesterStatus', '$block')";
   		$result = $this->db->query($sql);
   	}
   }

}

