<?php
namespace MVC\Controllers;

class UserController extends AbstractController
{
    ##########################################################################
    public function defaultAction()
    {   
       $this->_view();
    }
    ##########################################################################
    public function signupAction()
    {
        
    }
    ##########################################################################
    public function signinAction()
    {
        $this->_view();
    }
    ##########################################################################
}

?>