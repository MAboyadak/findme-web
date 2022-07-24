<?php
// define( 'API_BASE_URL',     "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect");
// define( 'API_BASE_URL', "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/identify");


$img = 'C:\Users\pc\Desktop\28276266_598059177200248_1637610756409886415_n.jpg';
$handle = fopen($img,"rb");
$contents = fread($handle, filesize($img));
fclose($handle);
####################################################
// d1fd719e-7398-40bb-ac56-84a7be958993  3e06deb9-4f36-4ec0-bfa3-d09b93115b15  95272c2a-7625-48d5-9551-4a86b26b9821  (my face detect result);
// dd294762-daad-43ae-9b71-96501e912058  0309faab-aaf6-4b27-abca-6744b0de6ba4  5e7d0956-fb1d-48d8-bab6-4d4858079c7c  7c251e5c-1319-4a61-924d-1ce817936143  (moaaz)
// 3179a50f-3f8b-4682-b112-065c34fd6594  90f849c8-815f-47d7-b80e-4e997e8c9a6a  dae0eb0a-b40b-4040-b13b-e4034f7c504c (amin)
//
//
##################################################      
// $data = array(
//     "personGroupId" => "$groupid",
//     "faceIds" => [
//     "dd294762-daad-43ae-9b71-96501e912058",
//     "0309faab-aaf6-4b27-abca-6744b0de6ba4",
//     "90f849c8-815f-47d7-b80e-4e997e8c9a6a",
//     "dae0eb0a-b40b-4040-b13b-e4034f7c504c"
//     ],
//     "confidenceThreshold" => 0.5
// );
// $data_json = json_encode($data);
##################################################
// $params = '';
// foreach( $query_params as $key => $value ) {
//     $params .= $key . '=' . $value . '&';
// }
// $params = 'subscription-key=' . API_PRIMARY_KEY;
// $post_url = API_BASE_URL . $params;

    // $url = "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/{$groupId}");
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

    curl_close($ch);
    echo'<pre>';
    var_dump($response);


?>