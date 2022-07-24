<?php

namespace MVC\Controllers;
ob_start();

class AbstractController
{
    protected $_controller;
    protected $_action;
    protected $_params;
    protected $_data = [];
    protected $_template;
    

    public function notFoundAction(){
        $this->_view();
    }
    public function setController($controller){
        $this->_controller = $controller;
    }
    public function setAction($action){
        $this->_action = $action;
    }
    public function setParams($params){
        $this->_params = $params;
    }
    public function setTemplate($template){
        $this->_template = $template;
    }
    public function _view()
    {
        if ($this->_action == 'notFoundAction')
        {
            require_once VIEWS_PATH . DS . 'notfound' . DS . 'NotFound.view.php';
        }else{
            $view_file = VIEWS_PATH . DS . $this->_controller . DS . $this->_action . '.view.php';
            if(file_exists($view_file)){
                $this->_template->setActionView($view_file);
                $this->_template->setAppData($this->_data);
                $this->_template->setController($this->_controller);
                $this->_template->renderApp();
            }else{
                require_once VIEWS_PATH . DS . 'notfound' . DS . 'error.view.php';
            }
        }
    }

    
}