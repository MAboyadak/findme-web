<?php
namespace MVC\Controllers;
use MVC\Models\UsersModel;
use MVC\Models\LostPersonModel;
use MVC\Models\LostPersonImagesModel;
use MVC\Models\FoundPersonModel;
use MVC\Models\FoundPersonImagesModel;
use MVC\Models\PostsModel;

class WebApiController extends AbstractController
{
    public $response = array();
    public $username;
    public $password;    
    public function __construct()
    {       
    }    
##########################################################################
    public function createUserAction()
    {        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']))
            {
                $user = new UsersModel();
                $user->username = $_POST['username'];
                $user->password = $_POST['password'];
                $user->email = $_POST['email'];
                $user->city = $_POST['city'];
                $user->number = $_POST['number'];
                if($user->create())
                {
                    $response['error'] = false;
                    $response['msg'] = 'user registered successfully !';
                    $response['id'] = $user->lastInsertedId(); 
                    $response['username'] = $user->username; 
                    $response['email'] = $user->email;                  
                }
                else
                {
                    $response['error'] = true;
                    $response['msg'] = 'some error occured try again later!';                    
                }
            }
            else
            {
                $response['error'] = true;
                $response['msg'] = 'Required fields missed';   
            }
        }
        else
        {
            $response['error'] = true;
            $response['msg'] = 'Invalid Request';   
        }
        echo json_encode($response);
    }
##########################################################################
public function loginAction()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      if(!empty($_POST['username']) && !empty($_POST['password']))
      {
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];

        $user = new UsersModel();
        $userData = $user->getByName($this->username);

        if($userData)
        {
            if($userData['password'] == $this->password)
            {
                $response['error'] = false;
                $response['msg'] = 'user logged successfully !'; 
                $response['id'] = $userData['id']; 
                $response['username'] = $userData['username']; 
                $response['email'] = $userData['email'];                  
            }
            else
            {
                $response['error'] = true;
                $response['msg'] = 'password invalid try again!';          
            }
        }
        else
        {
            $response['error'] = true;
            $response['msg'] = 'invalid username!';
        }
      }
      else
      {
        $response['error'] = true;
        $response['msg'] = 'empty fileds!';
      }
    }
    else
    {
        $response['error'] = true;
        $response['msg'] = 'wrong request!';
    }
    echo json_encode($response);

}
##########################################################################
public function getPostsAction()
  {
    $result = array();
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {    
        $posts = new PostsModel();
        $posts = $posts->getAll();

        if($posts == false)
        {
            $response['error'] = true;
            $response['msg'] = 'No Connection ##Some error occured try again later!';          
        }
        else
        {          
            $response['error'] = false;

            foreach($posts as $postIndex => $post){
                $post['img1'] = "http://192.168.0.105/uploads/" . $post['img1'];            
                array_push($result,$post);
            }            
            $response['posts'] = $result;
        }
    }
    else
    {
        $response['error'] = true;
        $response['msg'] = 'wrong request!';
    }
    echo json_encode($response);

}
##########################################################################


} //end class
