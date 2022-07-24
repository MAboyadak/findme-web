<?php
namespace MVC\Controllers;
use MVC\Models\UsersModel;
session_start();

class IndexController extends AbstractController
{
  public function __construct()
  {
    if( isset($_SESSION['user']) && $_SESSION['user'] == true )
      {
        header("Location:http://www.findme.com/home");
        exit();
      }
      var_dump($_SESSION);
  }
  /////////////////////////////////
  public function defaultAction()
  {   
    $this->_data['_error'] = null;
    $this->_view();
  }
  ////////////////////////////////
  public function loginAction()
  {

    if(isset($_POST['submit']))
    {
      if(!empty($_POST['username']) && !empty($_POST['password']))
      {
        $this->_data['username'] = $_POST['username'];
        $this->_data['password'] = $_POST['password'];

        $user = new UsersModel();
        $userData = $user->getByName($this->_data['username']);

        if($userData)
        {
          if($userData['password'] == $this->_data['password'])
          {
            $_SESSION['user'] = $userData['id'];
            header("Location:http://www.findme.com/home");
            exit();          
          }
          else
          {
              $this->_data['_error'] = "password";
              $this->_controller = "index";
              $this->_action = 'default';
              $this->_view();
          }
        }
        else
        {
          $this->_data['_error'] = "username";
          $this->_controller = "index";
          $this->_action = 'default';
          $this->_view();
        }
      }
      else
      {
        $this->_data['_error'] = "empty_field";
        $this->_controller = "index";
        $this->_action = 'default';
        $this->_view();
      }
    }
    else
    {
      header("Location:http://www.findme.com/index");
    }


  }


}
