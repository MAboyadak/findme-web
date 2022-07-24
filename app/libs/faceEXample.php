<?php
$client = new \Subsan\MicrosoftCognitiveFace\Client('255260c0798248cdba53dd4dc27e6943','westcentralus');

///////////////////Create person group////////////////////

    // create new person group
    $newPersonGroupId = uniqid();
    $client->personGroup($newPersonGroupId)->create(
        new \Subsan\MicrosoftCognitiveFace\Entity\PersonGroup(
            null, 
            'Group Name',
            'Additional info'
        )
    );


///////////////////// get faces from image////////////////////
    // get faces from image
    $url   = 'URL_IMAGE_WITH_FACES';
    $faces = $client->face()->detectFacesFromImg($url);

    $userNumber = 1;
    foreach ($faces as $face) {
        $personFaceRectangle = (new \Subsan\MicrosoftCognitiveFace\Entity\FaceRectangle())->import($face->faceRectangle);

///////////////////// create person /////////////////////
    $person = $client->personGroup($newPersonGroupId)->person()->create(
        new \Subsan\MicrosoftCognitiveFace\Entity\Person(
            null, 
            'User '.$userNumber
        )
    );

//////////////////add image to person////////////////
     $client->personGroup($newPersonGroupId)->person($person->getPersonId())->addFace($url,'test',$personFaceRectangle);

     $userNumber++;
}

///////////////////////Training person group//////////////////////
    // in previous example $newPersonGroupId
    $personGroupId = 'ID_OF_CREATED_PERSON_GROUP';

    // train group
    $client->personGroup()->train($personGroupId);

    // get train status
    var_dump($client->personGroup()->getTrainStatus($personGroupId));



///////////////////////Identity all faces in image//////////////////////
    // in previous example $newPersonGroupId
    $personGroupId = 'ID_OF_CREATED_PERSON_GROUP';

    /////////// get faces from image//////////////
    $url   = 'URL_IMAGE_WITH_FACES';
    $faces = $client->face()->detectFacesFromImg($url);

    /////////////prepare array of faces ids/////////////////
    $faceIds = array();
    foreach ($faces as $face) {
        $faceIds[] = $face->faceId;
    }

    //////////////identify all faces///////////////
    print_r($client->face()->identify($faceIds, $personGroupId));
?>