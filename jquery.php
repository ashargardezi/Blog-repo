<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        .contaiber {

            justify-content: center;
            align-items: center;
        }

        p {

            position: relative;
            /* display: none; */
            height: 100px;
            width: 100px;
            background-color: green;
            border: 12px solid red;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body class="container">
    <div>


        <h1> for animated</h1>

        <button> click to move right</button>
        <p> anamated right</p>


        <!-- <script>
   $(document).ready(function(){
    $("button").click(function(){
        $("p").animate({ left: "100px" });
    })
   })
</script> -->
        <script>
            $(document).ready(function() {
                $("button").click(function() {
                    $("p").animate({
                        left: "60px",
                        height: "80px",
                        width: "80px",
                        fontSize: "13px"





                    });
                });
            });
        </script>




















        <!-- <h1>For slideshow</h1>
    <p id="para">This will be slideshow</p>
</div>

<script>
    $(document).ready(function(){
        $("h1").click(function(){
            $("#para").slideToggle("slow");
        });
    });
</script> -->



        <!-- <h1> fade in jquery mean</h1>
<button> click to seee the effect of fadetoogle</button>

<div class="new1"> div1</div>
<div class="new2" > div2</div>
<div class="new3"> div3</div>
<div class="new4"> div4</div>

<script>
    $(document).ready(function() {
        $("button").click(function() {
            $(".new1").fadeToggle();
            $(".new2").fadeToggle("slow");
            $(".new3").fadeToggle(2000); // Duration specified in milliseconds
            $(".new4").fadeToggle(700);
        });
    });
</script> -->
        <!-- <h1> fade in jquery mean</h1>
<button> click to seee the effect of fadein</button>

<div class="new1"> div1</div>
<div class="new2" > div2</div>
<div class="new3"> div3</div>
<div class="new4"> div4</div>

<script>
    $(document).ready(function() {
        $("button").click(function() {
            $(".new1").fadeOut();
            $(".new2").fadeOut("slow");
            $(".new3").fadeOut(1000); // Duration specified in milliseconds
            $(".new4").fadeOut(300);
        });
    });
</script> -->
        <!-- <script>
    $(document).ready(function() {
        $("button").click(function() {
            $(".new1").fadeIn();
            $(".new2").fadeIn("slow");
            $(".new3").fadeIn(1000); // Duration specified in milliseconds
            $(".new4").fadeIn(300);
        });
    });
</script> -->


        <!-- <script>
        $(document).ready(function() {
            $("h1").click(function() {
                $("p").hide();
            })
            $("h2").click(function() {
                $("p").show();
            })
        });
    </script> -->
        <!-- <script>
        $(document).ready(function() {
            $("h1").click(function() {
                $(this).hide();
            })
        });
    </script> -->
</body>

</html>