<?php
// This is for outputting error logs for debugging purposes.
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include 'domain/init.php';

if (isset($_SESSION['user_id'])) {
    header('location: home.php');
}
?>

<html lang="en">

<head>
    <title>Twitter</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
    <link rel="stylesheet" href="resources/css/index_style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
</head>
<body>
<main class="twt-main">
    <section class="twt-login">
        <?php include 'shared/login.php'; ?>
        <div class="slow-login">
            <img class="login-bird" src="https://image.ibb.co/d0hbJ9/twt_icon.png" alt="bird">
            <button class="login-small-display signin-btn pri-btn">Log in</button>
            <span class="front-para">See what’s happening in the world right now</span>
            <span class="join">Join Twitter today.</span>
            <button type="button" id="auto" onclick="" class="signup-btn pri-btn" data-toggle="modal"
                    data-target="#exampleModalCenter">
                Sign Up
            </button>

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 style="font-weight: 700;" class="modal-title" id="exampleModalLongTitle">Sign Up</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <?php include 'shared/signup-form.php' ?>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>
    <section class="twt-features">
        <div class="features-div">
            <img class="twt-icon" src='https://image.ibb.co/bzvrkp/search_icon.png'>
            <p>Follow your interests.</p>
            <img class="twt-icon" src="https://image.ibb.co/mZPTWU/heart_icon.png">
            <p>Hear what people are talking about.</p>
            <img class="twt-icon" src="https://image.ibb.co/kw2Ad9/conv_icon.png">
            <p>Join the conversation.</p>
        </div>
    </section>
</main>

<script src="resources/js/jquery-3.4.1.slim.min.js"></script>
<script src="resources/js/popper.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
<script src="resources/js/mine.js"></script>
</body>
</html>
