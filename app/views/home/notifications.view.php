
<div class="container notifications-container">
        <?php
        switch($notification['message'])
        {
            // 
            case 'We have received your report , we will notify you if any matching has occured ':
            ;
            break;

            // 
            case 'Good News , propably matching!':
                require_once('includes/identified-notification.php');
            ;break;

            // 
            default:  ;
            break;


        }        
            
        ?>
</div>