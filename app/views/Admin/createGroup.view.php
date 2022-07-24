<!-- right column -->
    <div class="col-9 m-5 scrollit">
        <?php
            if($assurance == 'yes')
            {
                echo "<div class='alert alert-success'>";
                echo "<strong>Success! </strong>" . $newGroup->name . ' Has Created Successfully With ID : ' . $newGroup->id . '</br>' ;
                echo "</div>";
            }
            else if($assurance == 'no')
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong>Error! </strong>" . $newGroup->name . ' Group Is Already Existing' . '</br>' ;
                echo "</div>";
            }
            else if ($assurance == 'empty')
            {
                echo "<div class='alert alert-warning'>";
                echo "<strong>Notice! </strong> Group Name Can't Be Empty" . '</br>' ;
                echo "</div>";
            }
            else{;}
            
        ?>        
            <form action="#" method="post">
                <div class="form-group">
                    <label>Group Name :</label>
                    <input type="text" name="groupname" class="form-control">
                </div> 
                <div class="form-group">
                    <label>Group Descriptionnn :</label>
                    <input type="text" name="groupdata" class="form-control">
                </div> 
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>            
    </div>
 <!-- end right column !-->


</div>
<!-- END ROW !-->