<div class="row" >
        <div class="col-sm-12 hidden add-child-form" id="lost-child-form">
            <form action="http://www.findme.com/home/addlost" method="post" enctype='multipart/form-data'>  
                <h3 class="bg-secondary">Add Lost Child :</h3>
                <div class="row"> 
                    <div class="col-md-6 col-sm-12 ">               
                        <div class="form-group">
                            <label class="input-label text-white">First Name :</label> <input type="text" name="firstname" class="form-control" > 
                            <label class="input-label text-white">Second Name :</label> <input type="text" name="fathername" class="form-control" > 
                            <label class="input-label text-white">Last Name :</label> <input type="text" name="lastname" class="form-control" > 
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">               
                        <div class="form-group">
                        <label class="input-label text-white">Age :</label> <input type="text" name="age" class="form-control" > 
                        <label class="input-label text-white">City :</label> <input type="text" name="city" class="form-control" > 
                        <label class="input-label text-white">Lost Area :</label> <input type="text" name="area" class="form-control" > 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="input-label text-white">Any Extra Details :</label>
                            <br>
                            <textarea type="text" name="persondata" rows="7" cols="60" maxlength="220" 
                                        placeholder="data about the person or what happened..."></textarea>
                        </div>
                        
                        <div class="form-group"> 
                            <label class="input-label text-white">Gender :</label>
                            <select type="text" name="gender" class="form-control" >
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select> 
                        </div>
                        <div class="form-group">
                            Upload an Img: <input type="file" name="myfile" id="fileToUpload" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>   
            </form>
        </div>
</div>