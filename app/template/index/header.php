<div class="row header align-items-center">
    <div class="col-md-6 col-xs-12 text-white text-center">
        <h1 class="h1-responsive font-weight-bold wow fadeInLeft">Find Me </h1>
        <hr class="">
        <h6 class="mb-3 wow fadeInLeft">
            Based on Our new Face Recognition Technology , now you can find or report a lost child(or any person) by his picture</h6>
                    <a class="btn btn-outline-white wow fadeInLeft" data-wow-delay="0.3s">Learn more</a>
    </div>
    <div class="col-md-3 col-xs-12 offset-2 card text-center">
        <form action="http://www.findme.com/index/login" method="post">

                <div class="text-center formpanel1">
                    <h3 class="text-white">
                        <i class="fa fa-user text-white"></i> Sign In:
                    </h3>
                    <hr class="hr-light">
                </div>
                <!-- username input -->
                <?php 
                    switch ($_error)
                    {
                        case "username" : echo'<h5 class="text-danger bg-white mb-4">Error! This username is not exist</h5>';;
                        break;
                        case "password" : echo'<h5 class="text-danger bg-white mb-4">Error! The password is not vaild</h5>' ;;
                        break;
                        case "empty_field" : echo'<h5 class="text-danger bg-white mb-4">Error! You must fill all fields!</h5>' ;;
                        break;
                        default : "";
                        break;
                    }
                ?>
                <div class="input-group row mb-3 formpanel2">
                    <div class="col-md-2 text-white icon-form">
                        <i class="fa fa-user font-weight-bold"></i>                    
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Username / Email">
                </div>
                <!-- password input -->
                <div class="input-group row mb-3 formpanel3">
                    <div class="col-md-2 text-white icon-form">
                        <i class="fa fa-lock font-weight-bold"></i>                    
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <div class="row m-2">
                    <div class="col-md-12">
                        <button class="btn btn-primary" name="submit" type="submit">Sign In</button>
                    </div>
                </div>

                <div class="row m-2">
                    <div class="col-md-12">
                        <a href="http://www.findme.com/users/signup" class="text-white">Not a user? Sign Up</a>
                    </div>
                </div>
        </form>
    </div>
</div>