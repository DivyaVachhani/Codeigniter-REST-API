<?php

require APPPATH.'libraries/REST_Controller.php';

class Student extends REST_Controller{

  public function __construct(){

    parent::__construct();
    //load database
    $this->load->database();
    $this->load->model(array("api/student_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  /*
    INSERT: POST REQUEST TYPE
    UPDATE: PUT REQUEST TYPE
    DELETE: DELETE REQUEST TYPE
    LIST: Get REQUEST TYPE
  */
  


  // POST: <project_url>/index.php/student
  public function addStudent(){
    // insert data method

    
    // collecting form data inputs
    $name = $this->security->xss_clean($this->input->post("name"));
    $email = $this->security->xss_clean($this->input->post("email"));
    $mobile = $this->security->xss_clean($this->input->post("mobile"));
    $course = $this->security->xss_clean($this->input->post("course"));

    // form validation for inputs
    $this->form_validation->set_rules("name", "Name", "required");
    $this->form_validation->set_rules("email", "Email", "required|valid_email");
    $this->form_validation->set_rules("mobile", "Mobile", "required");
    $this->form_validation->set_rules("course", "Course", "required");

    // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){

      // we have some errors
      $this->response(array(
        "status" => 0,
        "message" => "All fields are needed"
      ) , REST_Controller::HTTP_NOT_FOUND);
    }else{

      if(!empty($name) && !empty($email) && !empty($mobile) && !empty($course)){
        // all values are available
        $student = array(
          "name" => $name,
          "email" => $email,
          "mobile" => $mobile,
          "course" => $course
        );

        if($this->student_model->insert_student($student)){

          $this->response(array(
            "status" => 1,
            "message" => "Student has been created"
          ), REST_Controller::HTTP_OK);
        }else{

          $this->response(array(
            "status" => 0,
            "message" => "Failed to create student"
          ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
      }else{
        // we have some empty field
        $this->response(array(
          "status" => 0,
          "message" => "All fields are needed"
        ), REST_Controller::HTTP_NOT_FOUND);
      }
    }

    
  }

  // PUT: <project_url>/index.php/student
  public function updateStudent(){
    // updating data method
    //echo "This is PUT Method";
    // collecting form data inputs
    $id = $this->security->xss_clean($this->input->post("id"));
    $name = $this->security->xss_clean($this->input->post("name"));
    $email = $this->security->xss_clean($this->input->post("email"));
    $mobile = $this->security->xss_clean($this->input->post("mobile"));
    $course = $this->security->xss_clean($this->input->post("course"));

    // form validation for inputs
    $this->form_validation->set_rules("name", "Name", "required");
    $this->form_validation->set_rules("email", "Email", "required|valid_email");
    $this->form_validation->set_rules("mobile", "Mobile", "required");
    $this->form_validation->set_rules("course", "Course", "required");

    // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){

      // we have some errors
      $this->response(array(
        "status" => 0,
        "message" => "All fields are needed"
      ) , REST_Controller::HTTP_NOT_FOUND);
    }else{

      if(!empty($name) && !empty($email) && !empty($mobile) && !empty($course)){
        // all values are available
        $student = array(
          "name" => $name,
          "email" => $email,
          "mobile" => $mobile,
          "course" => $course
        );

        if($this->student_model->update_student_information($id,$student)){

          $this->response(array(
            "status" => 1,
            "message" => "Student has been updated"
          ), REST_Controller::HTTP_OK);
        }else{

          $this->response(array(
            "status" => 0,
            "message" => "Failed to update student"
          ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
      }else{
        // we have some empty field
        $this->response(array(
          "status" => 0,
          "message" => "All fields are needed"
        ), REST_Controller::HTTP_NOT_FOUND);
      }
    }

  }

  // DELETE: <project_url>/index.php/student
  public function deleteStudent(){
    // delete data method
    $student_id = $this->security->xss_clean($this->input->post('id'));

    if($this->student_model->delete_student($student_id)){
      // retruns true
      $this->response(array(
        "status" => 1,
        "message" => "Student has been deleted"
      ), REST_Controller::HTTP_OK);
    }else{
      // return false
      $this->response(array(
        "status" => 0,
        "message" => "Failed to delete student"
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }

  // GET: <project_url>/index.php/student
  public function getStudent(){
    // list data method
    //echo "This is GET Method";
    // SELECT * from tbl_students;
    
    $students = $this->student_model->get_students();

    //print_r($query->result());

    if(count($students) > 0){

      $this->response(array(
        "status" => 1,
        "message" => "Students found",
        "data" => $students
      ), REST_Controller::HTTP_OK);
    }else{

      $this->response(array(
        "status" => 0,
        "message" => "No Students found",
        "data" => $students
      ), REST_Controller::HTTP_NOT_FOUND);
    }

  }

  // GET: <project_url>/index.php/student
  public function getStudentByID(){
    // list data method
    //echo "This is GET Method";
    // SELECT * from tbl_students;
    $student_id = $this->security->xss_clean($this->input->post('id'));

    $students = $this->student_model->get_studentByID($student_id);

    //print_r($students);

    if(count($students) > 0){

      $this->response(array(
        "status" => 1,
        "message" => "Students found",
        "data" => $students
      ), REST_Controller::HTTP_OK);
    }else{

      $this->response(array(
        "status" => 0,
        "message" => "No Students found",
        "data" => $students
      ), REST_Controller::HTTP_NOT_FOUND);
    }



  }
}

 ?>
