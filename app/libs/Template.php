<?php
namespace MVC\Libs;

class Template
{
    private $_pageParts;
    private $_adminParts;
    private $_indexParts;
    private $_actionView;
    private $_data;
    private $_controller;

    public function __construct(array $pageParts, array $adminParts, array $indexParts)
    {
        $this->_pageParts = $pageParts; 
        $this->_adminParts = $adminParts;
        $this->_indexParts = $indexParts;
    }
    public function setActionView($actionViewPath)
    {
        $this->_actionView = $actionViewPath;
    }
    public function setController($controller)
    {
        $this->_controller = $controller;
    }
    public function setAppData($data)
    {
        $this->_data = $data;
    }
    ############ STATIC FILES #############

    private function renderTempHeaderStart()
    {
        require_once TMP_PATH . DS . 'page' . DS . 'TmpHeadStart' . '.php';
    }
    private function renderTempHeaderEnd()
    {
        require_once TMP_PATH . DS . 'page' . DS . 'TmpHeadEnd' . '.php';
    }
    private function renderTempFooter()
    {
        require_once TMP_PATH . DS . 'page' . DS . 'TmpFooter' . '.php';
    }
    ############ END STATIC FILES #############

            /**** {ADMIN} *****/
    private function renderAdminHeaderCssJs()
    {
        if (!array_key_exists('header_resources',$this->_adminParts)){
            trigger_error('Sorry you have to define temp header resources' , E_USER_WARNING);
        }else{
            $css = $this->_adminParts['header_resources']['css'];
            $js = $this->_adminParts['header_resources']['js'];
            if(!empty($css)){
                foreach($css as $cssKey => $path){
                    echo '<link rel="stylesheet" href="' . $path . '"/>';
                }
            }
            if(!empty($js)){
                foreach($js as $jsKey => $path){
                    echo '<script src="' . $path . '"></script>';
                }
            }
        }
    }
    ################
    private function renderAdminBlocks()
    {
        if (!array_key_exists('pageBlocks',$this->_adminParts)){
            trigger_error('Sorry you have to define temp page blocks' , E_USER_WARNING);
        }else{
            $parts = $this->_adminParts['pageBlocks'];
            extract($this->_data);
            foreach($parts as $block => $file){
                if($block == ':view'){
                    require_once($this->_actionView);
                }else{
                    require_once($file);
                }
            }
        }
    }
    #################
    private function renderAdminFooterResources()
    {
        if (!array_key_exists('footer_resources',$this->_adminParts)){
            trigger_error('Sorry you have to define temp footer resource' , E_USER_WARNING);
        }else{
            $footerResources = $this->_adminParts['footer_resources'];
            if(!empty($footerResources)){
                foreach($footerResources as $key => $path){
                    echo '<script src="' . $path . '"></script>';
                }
            }
        }
    }
    ####  // {END ADMIN} \\  ####
###########################################

            /**** {PAGE} *****/  
    private function renderPageHeaderCssJs()
    {
        if (!array_key_exists('header_resources',$this->_pageParts)){
            trigger_error('Sorry you have to define temp header resources' , E_USER_WARNING);
        }else{
            $css = $this->_pageParts['header_resources']['css'];
            $js = $this->_pageParts['header_resources']['js'];
            if(!empty($css)){
                foreach($css as $cssKey => $path){
                    echo '<link rel="stylesheet" href="' . $path . '"/>';
                }
            }
            if(!empty($js)){
                foreach($js as $jsKey => $path){
                    echo '<script src="' . $path . '"></script>';
                }
            }
        }
    }
##################
    private function renderPageBlocks()
    {
        if (!array_key_exists('pageBlocks',$this->_pageParts)){
            trigger_error('Sorry you have to define temp page blocks' , E_USER_WARNING);
        }else{
            $parts = $this->_pageParts['pageBlocks'];
            extract($this->_data);
            foreach($parts as $block => $file){
                if($block == ':view'){
                    require_once($this->_actionView);
                }else{
                    require_once($file);
                }
            }
        }
    }
####################
    private function renderPageFooterResources()
    {
        if (!array_key_exists('footer_resources',$this->_pageParts)){
            trigger_error('Sorry you have to define temp footer resource' , E_USER_WARNING);
        }else{
            $footerResources = $this->_pageParts['footer_resources'];
            if(!empty($footerResources)){
                foreach($footerResources as $key => $path){
                    echo '<script src="' . $path . '"></script>';
                }
            }
        }
    }
    ####  // {END PAGE} \\  ####
###########################################
            /**** {INDEX} *****/  
    private function renderIndexHeaderCssJs()
    {
        if (!array_key_exists('header_resources',$this->_indexParts)){
            trigger_error('Sorry you have to define temp header resources' , E_USER_WARNING);
        }else{
            $css = $this->_indexParts['header_resources']['css'];
            $js = $this->_indexParts['header_resources']['js'];
            if(!empty($css)){
                foreach($css as $cssKey => $path){
                    echo '<link rel="stylesheet" href="' . $path . '"/>';
                }
            }
            if(!empty($js)){
                foreach($js as $jsKey => $path){
                    echo '<script src="' . $path . '"></script>';
                }
            }
        }
    }
##################
    private function renderIndexBlocks()
    {
        if (!array_key_exists('pageBlocks',$this->_indexParts)){
            trigger_error('Sorry you have to define temp page blocks' , E_USER_WARNING);
        }else{
            $parts = $this->_indexParts['pageBlocks'];
            extract($this->_data);
            foreach($parts as $block => $file){
                if($block == ':view'){
                    require_once($this->_actionView);
                }else{
                    require_once($file);
                }
            }
        }
    }
####################
    private function renderIndexFooterResources()
    {
        if (!array_key_exists('footer_resources',$this->_indexParts)){
            trigger_error('Sorry you have to define temp footer resource' , E_USER_WARNING);
        }else{
            $footerResources = $this->_indexParts['footer_resources'];
            if(!empty($footerResources)){
                foreach($footerResources as $key => $path){
                    echo '<script src="' . $path . '"></script>';
                }
            }
        }
    }
    ####  // {END INDEX} \\  ####

##########################{{<< RENDERIG APP >>}}#############################
    public function renderApp()
    {
        if($this->_controller == 'admin')
        {
            $this->renderTempHeaderStart();   //    * STATIC *
            $this->renderAdminHeaderCssJs();
            $this->renderTempHeaderEnd();        //  * STATIC *
            $this->renderAdminBlocks();         // WrapperStart,pageContent(view),WrapperEnd
            $this->renderAdminFooterResources();     // js files before end page
            $this->renderTempFooter();          //   * STATIC *   
        }
        else if($this->_controller == 'index')
        {
            $this->renderTempHeaderStart(); //  * STATIC *            
            $this->renderIndexHeaderCssJs();
            $this->renderTempHeaderEnd(); //    * STATIC *
            $this->renderIndexBlocks();
            $this->renderIndexFooterResources();
            $this->renderTempFooter(); //       * STATIC *    
        }else{
            $this->renderTempHeaderStart();
            $this->renderPageHeaderCssJs();
            $this->renderTempHeaderEnd();
            $this->renderPageBlocks();
            $this->renderPageFooterResources();
            $this->renderTempFooter();
        }
        
    }
}