<div class="container page-container">
    <!-- buttons to show the form -->
    <div class="row">
        <h4 class=" col-sm-12 text-center text-white p-4">Post A Report :</h4>
        <div class="col-sm-12 btn-group" role="group" aria-label="First group">
            <button type="button" class="btn btn-primary" id="add-lost"> Add Lost Person</button>
            <button type="button" class="btn btn-danger"  id="add-found"> Add Found Person</button>            
        </div>
    </div>
    <!-- end buttons -->

    <!-- #add-lost form -->
    <?php include'includes/lost-child-form.php'; ?>   
    <!-- #END add-lost form -->

    <!-- #add-found form -->
    <?php include'includes/found-child-form.php'; ?>
    <!-- #END add-Found form -->
    <?php
        if(isset($success))
        {
            if($success)
            {
                echo "<div class='alert alert-success'>";
                echo "<strong>Success! </strong>" . $newPerson->fullName . ' Has Created Successfully </br>' ;
                echo "</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong>OOPS!</strong> Error Occured , The Person Has Not Created Successfully Please Try Again Later </br>" ;
                echo "</div>";
            }
                
        }
        else if( isset($error) )
        {
                echo "<div class='alert alert-danger'>";
                echo $error;
                echo "</div>";
        }
            ?>

    <div class="row bg-white posts-sec">
        <h2 class="col-sm-12 text-center">Public Posts</h2>
        <hr>
        <?php            
            include'includes/posts.php';
        ?>
        
    </div>

</div>