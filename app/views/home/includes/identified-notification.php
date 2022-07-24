<h4 class="row text-center text-white p-4 mt-5"><span class="col-12">Result of Identifying Action</span></h4>
    <div class="row justify-content-center align-items-center">
    <h2 class="col-sm-12 text-center text-white mt-5">Uploaded Image</h2>
        <div class="col-sm-12 text-center">
    
            <?php                 
                    echo "<img src='/uploads/$uploadedImgName' class='img-fluid rounded' width='200'>";                
            ?>
        </div>
    </div>
    <div class="row bg-white result-sec">
        <h2 class="col-sm-12 text-center">Identified Person</h2>
        <hr>
        <div class="col-sm-9">
            <p> Name : <?php echo $identifiedPerson['fullName']; ?> </p>
            <p> Age :<?php echo $identifiedPerson['age']; ?> </p>
            <p> City : <?php echo $identifiedPerson['city']; ?> </p>
            <p> Area : <?php echo $identifiedPerson['area']; ?> </p>
            <p> Gender : <?php echo $identifiedPerson['gender']; ?> </p>
            <p> Number : <?php echo '010' ?> </p>
            <p> Description :<?php echo $identifiedPerson['personData']; ?> </p>
        </div>

        <div class="col-sm-3 img-col">
            <?php                    
                echo "<img src='/uploads/$identifiedImgName' class='img-fluid rounded'>";
            ?>
        </div>

    </div>