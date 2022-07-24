<?php
namespace MVC\Controllers;
// use MVC\Models\LostPersonModel;
// use MVC\Models\LostPersonImagesModel;
// use MVC\Models\FoundPersonModel;
// use MVC\Models\FoundPersonImagesModel;

use MVC\Models\UsersModel;
use MVC\Models\PersonGroupModel;
use MVC\Models\PersonModel;
use MVC\Models\PersonImagesModel;
use MVC\Models\PostsModel;
use MVC\Models\NotificationsModel;
session_start();

class HomeController extends AbstractController
{
    public function __construct()
    {
        if( !isset($_SESSION['user']) || $_SESSION['user'] != true )
        {            
            header("Location:http://www.findme.com/index");
            exit();
        }

        #####################
        $loggedUser = new UsersModel();
        $loggedUser = $loggedUser->getByPK($_SESSION['user']);
        // $user = new UsersModel();
        //     $user = $user->getByPk($_SESSION['user']);
        if($loggedUser == false)
        {
            $this->logoutAction();
        }
        $userNotifs = new NotificationsModel();
        $allNotifs = $userNotifs->getAllByUserId($loggedUser['id']);
        $unreadNotifs = $userNotifs->getUnread($loggedUser['id']);
        
        if(!empty($unreadNotifs))
        {            
            $unreadNotifsNo = sizeof($unreadNotifs);
            $this->_data['unreadNotifsNo'] = $unreadNotifsNo;  
            $this->_data['allNotifs'] = $allNotifs;            
        }else{
            $this->_data['unreadNotifsNo'] = 0;
            $this->_data['allNotifs'] = $allNotifs;  
        }

    }    
    ////////////////////////////////////
    public function logoutAction()
    {
        session_destroy(); //destroy the session
        header("location:http://www.findme.com/index"); //to redirect back to "index.php" after logging out
        exit();
    }
    ///////////////////////////////////
    public function defaultAction()
    {
        $posts = new PostsModel();
        $this->_data['posts'] = $posts->getAll();
        $this->_view();
    }
    ///////////////////////////////////
    public function postAction()
    {
        if( isset($this->_params[0]) && $this->_params[0] != '')
        {
            $post = new PostsModel();
            $this->_data['post'] = $post->getByPk($this->_params[0]);
            $this->_view();
        }else
        {
            $this->_controller = 'home';
            $this->_action = 'default';
            $this->defaultAction();
        }
    }
    ///////////////////////////////////
    public function addLostAction()
    {
        ////////////////////////////////////    
        if(isset($_POST['submit']))
        {    
            
        #### First , check whether the person is identified or not
            //// IMAGE Upload details
            $currentDir = getcwd();
            $uploadDirectory =  DS . "uploads" . DS;
    
            $fileName = $_FILES['myfile']['name'];
            $fileTmpName  = $_FILES['myfile']['tmp_name'];

            $uploadPath = $currentDir . $uploadDirectory . $fileName;
                ### END Img Details

            if(move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadPath))
            {
                $detectResponse = $this->detectImageAction($uploadPath); ### return detection response
                if(!empty($detectResponse))
                {
                    $identifyResponse = $this->identifyImageAction($detectResponse[0]['faceId'],FOUND_PERSONS_GROUP); ### return identification response
                    if(!empty($identifyResponse[0]['candidates'])) #
                    {                               
                        $identifiedPersonApiId = $identifyResponse[0]['candidates'][0]['personId'];
                        $identifiedPerson = new PersonModel(); // to get identifiedPerson by its api id
                        $identifiedPerson = $identifiedPerson->getByApiId($identifiedPersonApiId); 
                        
                        $identifiedPersonId = $identifiedPerson['id'];                                  
                        $this->createLostPersonModel(true,$uploadPath,$identifiedPersonId);
                        // $this->_controller = "home";
                        // $this->_action = 'notifications';
                        // $this->_view();
                        // exit();
                    }
                    else{
                        $this->createLostPersonModel(false,$uploadPath);
                    }

                }
                elseif($detectResponse === FALSE)
                {                   
                        $this->_data['error'] = "Error! ,check connection!";
                        $this->_controller = "home";
                        $this->_action = 'default';
                        $this->defaultAction();
                        exit();   
                }
                else
                {                   
                        $this->_data['error'] = "Error! ,the image you uploaded doesn't contain any faces!";
                        $this->_controller = "home";
                        $this->_action = 'default';
                        $this->defaultAction();
                        exit();   
                }
            
            
            }
            else // occurs when the picture doesn't exist or didn't save on the server
            {                
                $this->_data['error'] = "Sorry! ,Error occured while uploading image , please try again later";
            }  

            ##                        
        }
        $this->_controller = "home";
        $this->_action = 'default';
        $this->defaultAction();
    }

##########################################################################

public function addFoundAction()
    {
        ////////////////////////////////////    
        if(isset($_POST['submit']))
        {    
            
        #### First , check whether the person is identified or not
            //// IMAGE Upload details
            $currentDir = getcwd();
            $uploadDirectory =  DS . "uploads" . DS;
    
            $fileName = $_FILES['myfile']['name'];
            $fileTmpName  = $_FILES['myfile']['tmp_name'];

            $uploadPath = $currentDir . $uploadDirectory . $fileName;
                ### END Img Details

            if(move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadPath))
            {
                $detectResponse = $this->detectImageAction($uploadPath); ### return detection response
                if(!empty($detectResponse))
                {
                    $identifyResponse = $this->identifyImageAction($detectResponse[0]['faceId'],LOST_PERSONS_GROUP); ### return identification response
                    if(!empty($identifyResponse[0]['candidates'])) #
                    {                                                      
                        $identifiedPersonApiId = $identifyResponse[0]['candidates'][0]['personId'];

                        // echo'<pre>';var_dump($identifyResponse);echo'</pre>';
                        // echo'</br>';

                        // echo'<pre>';var_dump($identifiedPersonApiId);echo'</pre>';
                        // echo'</br>';

                        $identifiedPerson = new PersonModel(); // to get identifiedPerson by its api id
                        $identifiedPerson = $identifiedPerson->getByApiId($identifiedPersonApiId); 

                        // var_dump($identifiedPerson);
                        $identifiedPersonId = $identifiedPerson['id'];                        
                        // echo'<pre>';var_dump($identifiedPerson);echo'</pre>';
                        // exit;
                        
                        $this->createFoundPersonModel(true,$uploadPath,$identifiedPersonId);                        
                    }
                    else{
                        $this->createFoundPersonModel(false,$uploadPath);
                    }

                }
                elseif($detectResponse === FALSE)
                {                   
                        $this->_data['error'] = "Error! ,check connection!";
                        $this->_controller = "home";
                        $this->_action = 'default';
                        $this->defaultAction();
                        exit();   
                }
                else
                {                   
                        $this->_data['error'] = "Error! ,the image you uploaded doesn't contain any faces!";
                        $this->_controller = "home";
                        $this->_action = 'default';
                        $this->defaultAction();
                        exit();   
                }
            
            
            }
            else // occurs when the picture doesn't exist or didn't save on the server
            {                
                $this->_data['error'] = "Sorry! ,Error occured while uploading image , please try again later";
            }  

            ##                        
        }
        $this->_controller = "home";
        $this->_action = 'default';
        $this->defaultAction();
    }

##########################################################################

    public function trainGroupAction($groupId)
    {
        $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/$groupId/train";

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );                        
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(            
            'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY,
            'Content-Length: '. 0,                                                                          
        ));
        curl_setopt($ch, CURLOPT_ENCODING,  '');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        $response = curl_exec($ch);
        return $response;
        curl_close($ch);
    }

##########################################################################
    public function identifyImageAction($faceId,$groupId)
    {
        $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/identify";
        $data = array(
            "PersonGroupId" => $groupId,
            "faceIds" => array($faceId),
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_json );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(      
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json),
            'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
        ));
        curl_setopt($ch, CURLOPT_ENCODING,  '');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        $response = curl_exec($ch);
        curl_close($ch);
        if($response)
        {
            $decodedResponse = json_decode($response,true);
            return $decodedResponse;
        }else{
            return false;
        }
    }
##########################################################################
    public function detectImageAction($img)
    {
        $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect";
        // img handle for bianary
            $imgHandle = fopen($img,"rb");
            $contents = fread($imgHandle, filesize($img));
            fclose($imgHandle);

            // curl handle for image detection
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );                        
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $contents);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/octet-stream',
                'Content-Length: ' . strlen($contents),
                'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
            ));
            curl_setopt($ch, CURLOPT_ENCODING,  '');
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            $response = curl_exec($ch) ;
            curl_close($ch);
            if($response)
            {
                $decodedResponse = json_decode($response,true);
                return $decodedResponse;
            }else{
                return false;
            }
        }   

##########################################################################
    public function createPostAction($newPerson,$imgModel)
    {
        if(isset($_POST['submit']))
        {
            $newPost                = new PostsModel();
            $newPost->fullName      = $newPerson->fullName;
            $newPost->gender        = $newPerson->gender;
            $newPost->age           = $newPerson->age;
            $newPost->city          = $newPerson->city;
            $newPost->area          = $newPerson->area;
            $newPost->personData    = $newPerson->personData;
            $newPost->userId        = $_SESSION['user'];
            $newPost->personId      = $newPerson->id;
            $newPost->img1          = $imgModel->imgName;
            $newPost->create();            
        }
        
    }
##########################################################################
    public function notificationsAction()
    {
        if( isset($this->_params[0]) && $this->_params[0] != '')
        {            
            $notification = new NotificationsModel();
            $notification = $notification->getByPk($this->_params[0]);

            $oldNotification = new NotificationsModel();
            $oldNotification->message       = $notification['message'];
            $oldNotification->time          = $notification['time'];            
            $oldNotification->userId        = $notification['userId'];
            $oldNotification->type          = $notification['type'];
            $oldNotification->personId      = $notification['personId'];
            $oldNotification->seen          = true;
            $oldNotification->update($this->_params[0]);

            $this->_data['notification'] = $notification;
            if($notification['userId'] != $_SESSION['user'])
            {
                header("Location: http://www.findme.com/home");
                exit;
            }

            if($notification['message'] == 'Good News , propably matching!')
            {                
                $detectedPerson = new PersonModel();                
                $detectedPerson = $detectedPerson->getByPersonAndUserId($notification['personId'],$notification['userId']);

                // echo '<pre> Noritificaion ::';
                // var_dump($notification);
                // echo '</pre>';

                // echo '<pre> detected person ::';
                // var_dump($detectedPerson);
                // echo '</pre>';
                
                $uploadedImage = new PersonImagesModel();
                $uploadedImage = $uploadedImage->getByPersonId($detectedPerson['id']);                 
                $this->_data['uploadedImgName'] = $uploadedImage['imgName'];

                // echo '<pre>  uploaded img ::';
                // var_dump($this->_data['uploadedImgName']);
                // echo '</pre>';
                
                $identifiedPerson = new PersonModel();
                $identifiedPerson = $identifiedPerson->getByPK($detectedPerson['identifiedId']);
                $this->_data['identifiedPerson']  = $identifiedPerson;
                
                // echo '<pre>  identified person ::';
                // var_dump($identifiedPerson);
                // var_dump($this->_data['identifiedPerson']);
                // echo '</pre>';

                $identifiedImage = new PersonImagesModel();
                $identifiedImage = $identifiedImage->getByPersonId($detectedPerson['identifiedId']);
                $this->_data['identifiedImgName'] = $identifiedImage['imgName'];

                // echo '<pre>  identified img name ::';
                // var_dump($this->_data['identifiedImgName']);
                // echo '</pre>';
                                              
            }
            else{
                header("Location: http://www.findme.com/home");
                exit;
            }
            
        }
        else
        {
            $this->_controller = 'home';
            $this->_action = 'default';
            $this->defaultAction();
        }
        $this->_view();
    }
##########################################################################
    public function createLostPersonModel($i_result,$img,$identifiedPersonId=null)
    {
        $this->_data['identification'] = $i_result;
        ////// person data
        $newPerson                  = new PersonModel();
        $newPerson->groupId         = LOST_PERSONS_GROUP;
        $newPerson->firstName       = $_POST['firstname'];
        $newPerson->fatherName      = $_POST['fathername'];
        $newPerson->lastName        = $_POST['lastname'];
        $newPerson->city            = $_POST['city'];
        $newPerson->age             = $_POST['age'];
        $newPerson->gender          = $_POST['gender'];
        $newPerson->area            = $_POST['area'];
        $newPerson->fullName        = $_POST['firstname'] . ' ' . $_POST['fathername'] . ' ' . $_POST['lastname'];
        $newPerson->personData      = "new lost person";
        $newPerson->userId          = $_SESSION['user'];

        ///// Post PersonGroup.Person to THE API
        if($i_result == false)
        {
            $newPerson->identified      = false;
            $newPerson->identifiedId    = null;
            define( 'API_BASE_URL',     'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/'.LOST_PERSONS_GROUP.'/persons');
            $data = array(
            "name"      => "$newPerson->fullName",
            "userData"  => "$newPerson->personData"
            );
            $json_data = json_encode($data);

            // curl handle for post person request
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, API_BASE_URL );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data),
            'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
            ));
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_ENCODING,  '' );
            curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            $response = curl_exec($ch);
            curl_close($ch);
            ##### END POSTING PERSON
            if($response) // check post person request has sent and we got the response successfully
            {
                $decodedResponse = json_decode($response,true);
                $newPerson->apiId = $decodedResponse['personId']; //set apiId column to the id returned from the response                            

                $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/".LOST_PERSONS_GROUP."/persons/$newPerson->apiId/persistedFaces";
                // $img = $uploadPath;
                $imgHandle = fopen($img,"rb");
                $contents = fread($imgHandle, filesize($img));
                fclose($imgHandle);

                // curl handle for image request
                $ch2 = curl_init();
                curl_setopt( $ch2, CURLOPT_URL, $url );
                curl_setopt( $ch2, CURLOPT_CUSTOMREQUEST, "POST" );                        
                curl_setopt( $ch2, CURLOPT_POSTFIELDS, $contents);
                curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt( $ch2, CURLOPT_HTTPHEADER, array(                                                                          
                    'Content-Type: application/octet-stream',
                    'Content-Length: ' . strlen($contents),
                    'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
                ));
                curl_setopt($ch2, CURLOPT_ENCODING,  '');
                curl_setopt($ch2, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
                $imgResponse = curl_exec($ch2) ;
                curl_close($ch2);
                ### END adding face to the person in api

                if($imgResponse) // Check The response of Add Img to person request
                {
                    $decodedImgResponse = json_decode($imgResponse,true);

                    if ( isset($newPerson->apiId) && !empty($newPerson->apiId) && isset($decodedImgResponse['persistedFaceId']) )
                    {
                        /// person details(cols);                        
                        $newPersonId = $newPerson->create(); // create lost person in its group                        
                        $imgModel = new PersonImagesModel();
                        $imgModel->imgName = $_FILES['myfile']['name'];
                        $imgModel->imgFaceId = $decodedImgResponse['persistedFaceId'];
                        $imgModel->update($newPersonId); // update image table
                        
                        // echo'<pre> new person ::';
                        // var_dump($newPerson);
                        // echo'</pre>';
                        // echo'<pre> new person ::';
                        // var_dump($newPersonId);
                        // echo'</pre>';
                        
                        // echo'<pre> img model ::';
                        // var_dump($imgModel);
                        // echo'</pre>';
                        
                        $this->createPostAction($newPerson,$imgModel);

                        $notify = new NotificationsModel();
                        $notify->message = "Report has been submittied successfully";
                        $notify->time = date("M,d,Y h:i:s A");
                        $notify->seen  = false;
                        $notify->type  = 'reporting';
                        $notify->userId  = $_SESSION['user'];
                        $notify->personId  = $newPersonId;
                        $notify->create();

                        // echo'<pre> notiftication ::';                        
                        // var_dump($notify);
                        // echo'</pre>';



                        // verification message
                        $this->_data['success'] = true;
                        $this->_data['newPerson'] = $newPerson;
                        $trainStatus = $this->trainGroupAction(LOST_PERSONS_GROUP);  
                        
                        // echo'<pre> training ::';                        
                        // var_dump($trainStatus);
                        // echo'</pre>';

                        // exit;
                    }    
                    ## no else                                
                }
                else // if no img response
                {
                    $this->_data['error'] = 'error occured while sending the image response back';
                }
            }                              
            else // if the person hasn't been created successfully
            {                    
            $this->_data['error'] = "Sorry! ,Error occured while saving a person details , please try again later ";
            }
        }
        else
        {
            $newPerson->identified      = true;
            $newPerson->identifiedId    = $identifiedPersonId;
            $newPerson->apiId           = null;
            $newPersonId = $newPerson->create();
            

            $imgModel = new PersonImagesModel();
            $imgModel->imgName = $_FILES['myfile']['name'];
            $imgModel->imgFaceId = null;
            $imgModel->update($newPersonId); // update image table            
            $this->_data['success'] = true;
            $this->_data['newPerson'] = $newPerson;                        
            
            $notify = new NotificationsModel();
            $notify->message = "Good News , propably matching!";
            $notify->time = date("M,d,Y h:i:s A");                   
            $notify->seen  = false;
            $notify->type  = 'matching';
            $notify->userId  = $_SESSION['user'];
            $notify->personId  = $newPersonId;
            $notify->create();              
        }
    }
        
##########################################################################
public function createFoundPersonModel($i_result,$img,$identifiedPersonId=null)
    {
        ////// person data
        $newPerson                  = new PersonModel();
        $newPerson->groupId         = FOUND_PERSONS_GROUP;
        $newPerson->firstName       = $_POST['firstname'];
        $newPerson->fatherName      = $_POST['fathername'];
        $newPerson->lastName        = $_POST['lastname'];
        $newPerson->city            = $_POST['city'];
        $newPerson->age             = $_POST['age'];
        $newPerson->gender          = $_POST['gender'];
        $newPerson->area            = $_POST['area'];
        $newPerson->fullName        = $_POST['firstname'] . ' ' . $_POST['fathername'] . ' ' . $_POST['lastname'];
        $newPerson->personData      = "new lost person";
        $newPerson->userId          = $_SESSION['user'];

        ///// Post PersonGroup.Person to THE API
        if($i_result == false)
        {
            $newPerson->identified      = false;
            $newPerson->identifiedId    = null;
            define( 'API_BASE_URL',     'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/'.FOUND_PERSONS_GROUP.'/persons');
            $data = array(
            "name"      => "$newPerson->fullName",
            "userData"  => "$newPerson->personData"
            );
            $json_data = json_encode($data);

            // curl handle for post person request
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, API_BASE_URL );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data),
            'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
            ));
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_ENCODING,  '' );
            curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            $response = curl_exec($ch);
            curl_close($ch);
            ##### END POSTING PERSON
            if($response) // check post person request has sent and we got the response successfully
            {
                $decodedResponse = json_decode($response,true);
                $newPerson->apiId = $decodedResponse['personId']; //set apiId column to the id returned from the response
                
                $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/".FOUND_PERSONS_GROUP."/persons/$newPerson->apiId/persistedFaces";
                // $img = $uploadPath;
                $imgHandle = fopen($img,"rb");
                $contents = fread($imgHandle, filesize($img));
                fclose($imgHandle);

                // curl handle for image request
                $ch2 = curl_init();
                curl_setopt( $ch2, CURLOPT_URL, $url );
                curl_setopt( $ch2, CURLOPT_CUSTOMREQUEST, "POST" );                        
                curl_setopt( $ch2, CURLOPT_POSTFIELDS, $contents);
                curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt( $ch2, CURLOPT_HTTPHEADER, array(                                                                          
                    'Content-Type: application/octet-stream',
                    'Content-Length: ' . strlen($contents),
                    'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
                ));
                curl_setopt($ch2, CURLOPT_ENCODING,  '');
                curl_setopt($ch2, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
                $imgResponse = curl_exec($ch2) ;
                curl_close($ch2);
                ### END adding face to the person in api

                if($imgResponse) // Check The response of Add Img to person request
                {
                    $decodedImgResponse = json_decode($imgResponse,true);

                    if ( isset($newPerson->apiId) && !empty($newPerson->apiId) && isset($decodedImgResponse['persistedFaceId']) )
                    {
                        /// person details(cols);                        
                        $newPersonId = $newPerson->create(); // create found person in its group
                        $imgModel = new PersonImagesModel();
                        $imgModel->imgName = $_FILES['myfile']['name'];
                        $imgModel->imgFaceId = $decodedImgResponse['persistedFaceId'];
                        $imgModel->update($newPersonId); // update image table
                       

                        $notify = new NotificationsModel();
                        $notify->message = "We have received your report successfully";
                        $notify->time = date("M,d,Y h:i:s A");
                        $notify->userId  = $_SESSION['user'];
                        $notify->personId  = $newPersonId;
                        $notify->seen  = false;
                        $notify->type  = 'reporting';
                        $notify->create();

                        // verification message
                        $this->_data['success'] = true;
                        $this->_data['newPerson'] = $newPerson;
                        
                        $this->trainGroupAction(FOUND_PERSONS_GROUP);
                    }    
                    ## no else                                
                }
                else // if no img response
                {
                    $this->_data['error'] = 'error occured while sending the image response back';
                }
            }                              
            else // if the person hasn't been created successfully
            {                    
            $this->_data['error'] = "Sorry! ,Error occured while saving a person details , please try again later ";
            }
        }
        else
        {                     
            $newPerson->identified      = true;
            $newPerson->identifiedId    = $identifiedPersonId;
            $newPerson->apiId           = null;
            $newPersonId = $newPerson->create();
            
            $imgModel = new PersonImagesModel();
            $imgModel->imgName = $_FILES['myfile']['name'];
            $imgModel->imgFaceId = null;
            $imgModel->update($newPersonId); // update image table            
            $this->_data['success'] = true;
            $this->_data['newPerson'] = $newPerson;

            $notify = new NotificationsModel();
            $notify->message = "Good News , propably matching!";
            $notify->time = date("M,d,Y h:i:s A");            
            $notify->seen  = false;
            $notify->type  = 'matching';
            $notify->userId  = $_SESSION['user'];
            $notify->personId  = $newPersonId;
            $notify->create();            
        }
    }
        
##########################################################################
} //end class
