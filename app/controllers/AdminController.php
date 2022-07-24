<?php
namespace MVC\Controllers;
use MVC\Models\PersonGroupModel;
use MVC\Models\FoundPersonModel;
use MVC\Models\FoundPersonImagesModel;


class AdminController extends AbstractController
{
    public function defaultAction()
    {
        if(isset($_POST['submit']))
        {
            $groupId = $_POST['groupId'];
            $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{$groupId}";
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
                // 'Content-Type: application/json',
                // 'Content-Length: ' . strlen($data_json),
                'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
            ));
            // curl_setopt($ch,CURLOPT_POSTFIELDS, $data_json);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_ENCODING,  '' );
            curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            $response = curl_exec($ch);
            var_dump($response);
        }

        $this->_view();
    }

    ##################################################################################

    public function createGroupAction()
    {     

        $this->_data['assurance'] = 'equal';

        if(isset($_POST['submit']))
        {            
            $newGroup = new PersonGroupModel();

            if( !empty($_POST['groupname']) ) 
            {
                $newGroup->name = $_POST['groupname'];
                $newGroup->groupData = $_POST['groupdata'];
                if(empty($newGroup->groupData)){
                    $newGroup->groupData = 'new group!';
                }
                $this->_data['newGroup'] = $newGroup; // for sending a success msg to a view
                
                if ( $newGroup->create() )
                {
                    define( 'API_BASE_URL',     'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/' . $newGroup->id);
                    $this->_data['assurance'] = 'yes';
                    $data = array(
                        "name" => "$newGroup->name",
                        "userData"=> "$newGroup->groupData"

                    );
                    $json_data = json_encode($data);
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_URL, API_BASE_URL );
                    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
                    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($json_data),
                        'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY                                                                               
                    ));
                    curl_setopt( $ch,  CURLOPT_POSTFIELDS, $json_data);
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch, CURLOPT_ENCODING,  ''); // make the execution faster a little bit
                    curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); // make the execution more faster
                    $this->_data['response'] = curl_exec($ch);
                    curl_close($ch);
                }            
                else
                {
                    $this->_data['assurance'] = 'no';
                }    
            }
            else
            {
                $this->_data['assurance'] = 'empty';
            }
        }
        $this->_view();

    }
    ##########################################################################
    public function deleteGroupAction()
    {
        $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{$this->_params[0]}";

            // curl handle for image detection
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );        
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                'Ocp-Apim-Subscription-Key: ' . API_PRIMARY_KEY
            ));
            curl_setopt($ch, CURLOPT_ENCODING,  '');
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            $response = curl_exec($ch) ;
            curl_close($ch);
            if (empty($response))
            {            
                $personGroup = new PersonGroupModel;
                $personGroup->delete($this->_params[0]);                
            }else{
                echo 'error occured!';
            }
            $this->_controller = 'admin';
            $this->_action = 'default';
            $this->defaultAction();
    }
    ##############################################################################
    
}