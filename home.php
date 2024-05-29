<?php
//// This is for outputting error logs for debugging purposes.
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Including the init.php file from the domain  directory. This file contains initialization code for the application,
// such as setting up database connections, loading libraries, or other setup tasks.
include 'domain/init.php';

// Retrieves the user's ID from the session with $user_id = $_SESSION['user_id'];. The user's ID is stored in the
// session after they log in, and it's used to identify the user in subsequent requests.
$user_id = $_SESSION['user_id'];

// This is calling a static method getData on the UserDBConnector class, passing in the
// user's ID. Retrieves the user's data from the database and returns it as an object.
$user = UserDBConnector::getData($user_id);

// Checks if the user is logged in. The checkLogIn method on the UserDBConnector class checks the session cookie to
// see if the user is authenticated. If the user is not logged in, they are redirected to the index.php page.
if (UserDBConnector::checkLogIn() === false)
    header('location: index.php');

// Retrieves some data that will be used on the home.php page. These methods involve database queries that
// use the user's ID to retrieve the relevant data.
// retrieves the user's tweets
$tweets = PostDBConnector::posts($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Twitter</title>

    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/home_style.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<script src="resources/js/jquery-3.5.1.min.js"></script>

<?php if (isset($_SESSION['welcome'])) { ?>
<script>
    $(document).ready(function () {
        // Open modal on page load
        $("#welcome").modal('show');
    });
</script>


<!-- Modal -->
<div class="modal fade" id="welcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="">
                <div class="text-center">
         <span class="modal-title font-weight-bold text-center" id="exampleModalLongTitle">
          <span style="font-size: 20px;">Welcome <span style="color:#207ce5"><?php echo $user->name; ?></span>  </span>  
         </span>
                </div>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="text-center">

                    <h4 style="font-weight: 600; ">You Signup Successfuly!</h4>
                </div>
            </div>
        </div>

        <?php unset($_SESSION['welcome']);
        } ?>

        <!-- End welcome -->

        <div id="mine">

            <div class="wrapper-left">
                <div class="sidebar-left">
                    <div class="grid-sidebar" style="margin-top: 12px">
                        <div class="icon-sidebar-align">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Logo_of_Twitter.svg/512px-Logo_of_Twitter.svg.png"
                                 alt="" height="30px" width="30px"/>
                        </div>
                    </div>

                    <a href="home.php">
                        <div class="grid-sidebar bg-active" style="margin-top: 12px">
                            <div class="icon-sidebar-align">
                                <img src="https://i.ibb.co/6tKFLWG/home.png" alt="" height="26.25px" width="26.25px"/>
                            </div>
                            <div class="wrapper-left-elements">
                                <a class="wrapper-left-active" href="home.php"
                                   style="margin-top: 4px;"><strong>Home</strong></a>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo BASE_URL . $user->username; ?>">
                        <div class="grid-sidebar">
                            <div class="icon-sidebar-align">
                                <img src="https://i.ibb.co/znTXjv6/perfil.png" alt="" height="26.25px" width="26.25px"/>
                            </div>

                            <div class="wrapper-left-elements">
                                <!-- <a href="/twitter/<?php echo $user->username; ?>"  style="margin-top: 4px"><strong>Profile</strong></a> -->
                                <a href="./profile.php" style="margin-top: 4px"><strong>Profile</strong></a>

                            </div>
                        </div>
                    </a>
                    <a href="<?php echo BASE_URL . "settings.php"; ?>">
                        <div class="grid-sidebar ">
                            <div class="icon-sidebar-align">
                                <img src="https://i.ibb.co/znTXjv6/perfil.png" alt="" height="26.25px" width="26.25px"/>
                            </div>

                            <div class="wrapper-left-elements">
                                <a href="settings.php" style="margin-top: 4px"><strong>Settings</strong></a>
                            </div>


                        </div>
                    </a>
                    <a href="shared/logout.php">
                        <div class="grid-sidebar">
                            <div class="icon-sidebar-align">
                                <i style="font-size: 26px; color:red" class="fas fa-sign-out-alt"></i>
                            </div>

                            <div class="wrapper-left-elements">
                                <a style="color:red" href="shared/logout.php"
                                   style="margin-top: 4px"><strong>Logout</strong></a>
                            </div>
                        </div>
                    </a>
                    <button class="button-twittear">
                        <strong>Tweet</strong>
                    </button>

                    <div class="box-user">
                        <div class="grid-user">
                            <div>
                                <img
                                        src="resources/images/users/<?php echo $user->img ?>"
                                        alt="user"
                                        class="img-user"
                                />
                            </div>
                            <div>
                                <p class="name"><strong><?php if ($user->name !== null) {
                                            echo $user->name;
                                        } ?></strong></p>
                                <p class="username">@<?php echo $user->username; ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="grid-posts">
                <div class="border-right">
                    <div class="grid-toolbar-center">
                        <div class="center-input-search">
                            <div class="input-group-login" id="whathappen">
                                <div class="container">
                                    <div class="part-1">
                                        <div class="header">
                                            <div class="home">
                                                <h2>Home</h2>
                                            </div>
                                            <!-- <div class="icon">
                                              <button type="button" name="button">+</button>
                                            </div> -->
                                        </div>

                                        <div class="text">
                                            <form class="" action="form_actions/actionTweet.php" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="inner">

                                                    <img src="resources/images/users/<?php echo $user->img ?>"
                                                         alt="profile photo">

                                                    <label>

                                                        <textarea class="text-whathappen" name="status" rows="8"
                                                                  cols="80" placeholder="What's happening?"></textarea>

                                                    </label>
                                                </div>

                                                <!-- tmp image upload place -->
                                                <div class="position-relative upload-photo">
                                                    <img class="img-upload-tmp"
                                                         src="resources/images/tweets/tweet-60666d6b426a1.jpg" alt="">
                                                    <div class="icon-bg">
                                                        <i id="#upload-delete-tmp"
                                                           class="fas fa-times position-absolute upload-delete"></i>

                                                    </div>
                                                </div>


                                                <div class="bottom">

                                                    <div class="bottom-container">


                                                        <label for="tweet_img" class="ml-3 mb-2 uni">

                                                            <i class="fa fa-image item1-pair"></i>
                                                        </label>
                                                        <input class="tweet_img" id="tweet_img" type="file"
                                                               name="tweet_img">

                                                    </div>
                                                    <div class="hash-box">

                                                        <ul style="margin-bottom: 0;">
                                                        </ul>

                                                    </div>
                                                    <?php if (isset($_SESSION['errors_tweet'])) {

                                                        foreach ($_SESSION['errors_tweet'] as $t) { ?>

                                                            <div class="alert alert-danger">
                                                                <span class="item2-pair"> <?php echo $t; ?> </span>
                                                            </div>

                                                        <?php }
                                                    }
                                                    unset($_SESSION['errors_tweet']); ?>
                                                    <div>

                                                        <span class="bioCount" id="count">140</span>
                                                        <input id="tweet-input" type="submit" name="tweet" value="Tweet"
                                                               class="submit"
                                                        >
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="part-2">

                                    </div>

                                </div>


                            </div>
                        </div>
                        <!-- <div class="mt-icon-settings">
                          <img src="https://i.ibb.co/W5T9ycN/settings.png" alt="" />
                        </div> -->
                    </div>
                    <div class="box-fixed" id="box-fixed"></div>

                    <?php include 'shared/tweets.php'; ?>

                </div>


                <div class="wrapper-right">
                    <div style="width: 90%;" class="container">

                        <div class="input-group py-2 m-auto pr-5 position-relative">

                            <i id="icon-search" class="fas fa-search tryy"></i>
                            <input type="text" class="form-control search-input" placeholder="Search Twitter">
                            <div class="search-result">


                            </div>
                        </div>
                    </div>

                    <div class="trends bg-white p-4 max-w-md mx-auto mt-100 rounded border border-gray-300"> <ul>
                            <li class="nav-list header flex justify-between items-center mb-4">
                                <h2 class="main-text font-bold text-lg" style="color: black;">Trends for you</h2>
                                <i class="fas fa-cog text-gray-500"></i>
                            </li>
                            <li class="nav-list flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="trend-list">
                                    <p class="sub-text text-gray-500 text-sm">Trending in Cebu</p>
                                    <p class="main-text font-bold text-lg" style="color: black;">#BINI</p>                                    <p class="sub-text text-gray-500 text-sm">274K Tweets</p>
                                </div>
                                <div class="trend-icon">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </li>
                            <li class="nav-list flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="trend-list">
                                    <p class="sub-text text-gray-500 text-sm">Trending in Cebu</p>
                                    <p class="main-text font-bold text-lg" style="color: black;">#TaylorSwift</p>
                                    <p class="sub-text text-gray-500 text-sm">154K Tweets</p>
                                </div>
                                <div class="trend-icon">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </li>
                            <li class="nav-list flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="trend-list">
                                    <p class="sub-text text-gray-500 text-sm">Trending in Cebu</p>
                                    <p class="main-text font-bold text-lg" style="color: black;">#Lover</p>
                                    <p class="sub-text text-gray-500 text-sm">135K Tweets</p>
                                </div>
                                <div class="trend-icon">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </li>
                            <li class="nav-list flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="trend-list">
                                    <p class="sub-text text-gray-500 text-sm">Trending in Cebu</p>
                                    <p class="main-text font-bold text-lg" style="color: black;">#CAS2024MANILA</p>
                                    <p class="sub-text text-gray-500 text-sm">124K Tweets</p>
                                </div>
                                <div class="trend-icon">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </li>
                            <li class="nav-list flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="trend-list">
                                    <p class="sub-text text-gray-500 text-sm">Trending in Cebu</p>
                                    <p class="main-text font-bold text-lg" style="color: black;">#TGIF</p>
                                    <p class="sub-text text-gray-500 text-sm">43K Tweets</p>
                                </div>
                                <div class="trend-icon">
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </div>
                            </li>
                            <li class="nav-list py-2 text-blue-500 text-center hover:underline cursor-pointer"><a
                                        href="#">Show more</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <script src="resources/js/search.js"></script>
        <script type="text/javascript" src="resources/js/like.js"></script>
        <script type="text/javascript" src="resources/js/retweet.js?v=<?php echo time(); ?>"></script>
        <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
        <script src="resources/js/jquery-3.5.1.min.js"></script>

        <script src="resources/js/popper.min.js"></script>
        <script src="resources/js/bootstrap.min.js"></script>
</body>
</html> 