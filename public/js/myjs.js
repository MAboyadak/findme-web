var lostForm = document.getElementById("lost-child-form");
var foundForm = document.getElementById("found-child-form");
var foundBtn = document.getElementById("add-found");
var lostBtn = document.getElementById("add-lost");


lostBtn.onclick = function() {toggleLostForm()};

function toggleLostForm() {
    lostForm.classList.toggle("show");
}


foundBtn.onclick = function() {toggleFoundForm()};

function toggleFoundForm() {
    foundForm.classList.toggle("show");
}

// $(document).ready(function(){
//          $("#count").load("./home");

//          setInterval(function(){
//              $("#count").load('./home')
//              }, 10000);
//       });

/* Ajax For Posts */

