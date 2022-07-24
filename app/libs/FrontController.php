<?php
namespace MVC\Libs;

class FrontController{

    private $_controller = 'index';
    private $_action = 'default';
    private $_params = array();
    private $_template;

    public function __construct(Template $template)
    {
        $this->_template = $template;
        $this->parseUrl();
    }
     
    public function parseUrl()
    {
        $url_path = explode('/',trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),'/'),3);

        if($url_path[0] != ''){
            $this->_controller = $url_path[0];
        }
        if(isset($url_path[1]) && $url_path[1] != ''){
            $this->_action = $url_path[1];
        }
        if(isset($url_path[2]) && $url_path[2] != ''){
            $this->_params = explode('/',$url_path[2]);            
        }        
    }

    public function dispatch()
    {
        $controllerClassName =  '\\MVC\\Controllers\\' . ucfirst($this->_controller) .'Controller';
        $controllerAction = $this->_action . 'Action';

        if(!class_exists($controllerClassName)) {
            $controllerClassName = '\\MVC\\Controllers\\NotFoundController'; // Controller 'NotFoundController'
        }
        // echo $controllerClassName . $controllerAction .$this->_action;
        $obj = new $controllerClassName(); // object from the !!! Controller !!! class
        
        if(!method_exists($obj , $controllerAction)) {
            $this->_action = $controllerAction = 'notFoundAction'; // Action 'notFound'
        }
        $obj->setController($this->_controller);     // inherited method 
        $obj->setAction($this->_action);            // from abstract class (the parent)
        $obj->setParams($this->_params);           //in the control class (child)
        $obj->setTemplate($this->_template);
        $obj->$controllerAction();  // Controller Method (VIEW)
        

        // $obj->$controllerAction($this->_controller,$this->_action,$this->_params);
    }
}