<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

   public function __construct()
   {
      session_start();
      parent::__construct();
   }

	public function index()
   { 
      if ( isset($_SESSION['email']) ) {
         redirect('admin/main');
      }
      $this->load->library('form_validation');
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      if ( $this->form_validation->run() !== false ) {
         // then validation passed. Get from db
         $this->load->model('admin_model');
         $res = $this
                  ->admin_model
                  ->verify_user(
                     $this->input->post('email'), 
                     $this->input->post('password')
                  );
         if ( $res !== false ) {
            $_SESSION['email'] = $this->input->post('email');
            $_SESSION['id'] = $this->admin_model->getIDFromEmail($this->input->post('email'));
            $_SESSION['courses'] = $this->admin_model->getCourses($_SESSION['id']);
            redirect('admin/main');
         }

      }

      $this->load->view('login');
   }
   
   public function register() {
   	if (isset($_SESSION['email']) ) { redirect('admin/main'); }
   	if($this->input->post('password') !== $this->input->post('confirm')) { echo "Passwords didn't match. Hit the back button and try again"; exit; }
   	$this->load->library('form_validation');
   	$this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('confirm', 'Password Confirmation', 'required');
      if ( $this->form_validation->run() !== false ) {
      	$this->load->model('admin_model');
      	$success = $this->admin_model->register_user($this->input->post('name'), $this->input->post('email'), $this->input->post('password'));
      	if($success === false) { echo "Something odd happened. Make sure you're using YOUR email address or that you haven't signed up twice. If this isn't the case, please contact us about this error."; exit;}
      	$this->load->view('login', array("message" => "Registration Successful! Please log in."));
      }
      
      else { $this->load->view('login'); };
   }
   
   public function main() { // need to cal lthis something better
		if (!isset($_SESSION['email']) ) {
		      redirect('admin');
		   }
   	$this->load->model('admin_model');
   	$studentsSharing;
   	for($i = 0; $i < sizeof($_SESSION['courses']); $i++) {
   		$id = $_SESSION['id'];
   		$courseid = $_SESSION['courses'][$i]['courseid'];
   		$block = $_SESSION['courses'][$i]['block'];
   		$semesterStatus = $_SESSION['courses'][$i]['semesterStatus'];
   		$courseName = $this->admin_model->getCourseFromID($courseid);
   		$shared = $this->admin_model->getStudentsTakingCourse($courseid, $id, $semesterStatus, $block);
   		$studentsSharing[] = array("name" => $courseName, "shared" => $shared);
   	}
   	if(!isset($studentsSharing)) { redirect('admin/addcourses'); }
   	$this->load->view('main', array("data" => $studentsSharing));
   }
   
   public function addcourses() {
   	if (!isset($_SESSION['email']) ) { redirect('admin'); }
   	
   	if(isset($_POST['coursename'])) {
			$empty_elements = array_keys($_POST['coursename'],"");
			foreach ($empty_elements as $e) { unset($_POST['coursename'][$e]); unset($_POST['coursenumber'][$e]); unset($_POST['block'][$e]); unset($_POST['semesterStatus'][$e]); }
			$this->load->model('admin_model');
			$this->admin_model->addCoursesToUser($_POST, $_SESSION['id']);
			$_SESSION['courses'] = $this->admin_model->getCourses($_SESSION['id']);
			redirect('admin/main');
   	}
   	else {
   		$this->load->view("addcourses");
   	}
   }

   public function logout()
   {
      session_destroy();
      $this->load->view('login');
   }
}
