<nav class="row navbar navbar-fixed-top navbar-expand-md navbar-dark flex-column flex-md-row bd-navbar main-nav">
        <ul class="navbar-home">
            <li>
                <a class="navbar-brand mr-0 mr-md-2 text-white font-weight-bold" href="http://www.findme.com/home/">Find Me</a>
            </li>
            <li>
                <a href="http://www.findme.com/home/">Home</a>
            </li>      
            <li>
                <a href="#">Previous Posts</a>
            </li>                                                                   
        </ul>
        <ul class="navbar-search navbar-center">                          
            <li class="search-li">
                <form>
                    <div class="input-group ">                                
                        <input class="form-control search-input" type="text" name="search"><i class=""></i>
                        <button class="btn btn-primary input-group-append"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </li>                    
        </ul>
        <ul class="navbar-right">                                        
            <li class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        if($unreadNotifsNo > 0)
                        {
                            echo"<i class='fa fa-bell notify'>$unreadNotifsNo new messages !</i>";
                        }else{
                            echo"<i class='fa fa-bell'></i>";
                        }
                    ?>                    
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <h5 class="text-center p-1 text-white bg-dark">Notifications</h5>
                    <?php
                        foreach($allNotifs as $row => $col)
                        {                                            
                    ?>
                    <hr>                    
                    <li>
                        <i class="fa fa-user"></i>
                        <a class="dropdown-item" href="http://www.findme.com/home/notifications/<?php echo $col['id']; ?>">
                            <?php                                 
                                if($col['seen'] == false){
                                    echo $col['message'] . "<span class='red'> New!</span>" ;
                                }else{
                                    echo $col['message'];
                                }
                             ?>
                        </a>
                    </li>

                    <?php
                        }
                    ?>                    

                </ul>
            </li>
            <li>
                <a href="#">Settings</a>
            </li>                    
        </ul>
</nav>
