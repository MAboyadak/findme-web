<?php
    foreach($posts as $row => $post)
    {
?>

<div class="row posts">

    <div class="col-sm-9">
        <p> Name : <?php echo $post['fullName']; ?> </p>
        <p> Age :<?php echo $post['age']; ?> </p>
        <p> City : <?php echo $post['city']; ?> </p>
        <div><a href="http://www.findme.com/home/post/<?php echo $post['id']; ?>"> More Details .. </a></div>
    </div>

    <div class="col-sm-3 ">
    <img src="/uploads/<?php echo $post['img1']; ?>" class="img-fluid rounded" alt="">
    </div>

</div>
<hr>

<?php
    }
?>