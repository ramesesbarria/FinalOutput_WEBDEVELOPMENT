<?php
include 'domain/init.php';

$user_id = $_SESSION['user_id'];
$user = UserDBConnector::getData($user_id);

// update notification count
UserDBConnector::updateNotifications($user_id);

$notify_count = UserDBConnector::GetNotificationCount($user_id);
$notofication = UserDBConnector::notification($user_id);
// var_dump($notofication);
// die();
if (UserDBConnector::checkLogIn() === false)
    header('location: index.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications | Twitter</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/all.min.css">
    <link rel="stylesheet" href="resources/css/profile_style.css?v=<?php echo time(); ?>">

    <link rel="shortcut icon" type="image/png" href="resources/images/twitter.svg">

</head>
<body>

<script src="resources/js/jquery-3.5.1.min.js"></script>


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
                        <a href="home.php" style="margin-top: 4px;"><strong>Home</strong></a>
                    </div>
                </div>
            </a>

            <a href="notification.php">
                <div class="grid-sidebar">
                    <div class="icon-sidebar-align position-relative">
                        <?php if ($notify_count > 0) { ?>
                            <i class="notify-count"><?php echo $notify_count; ?></i>
                        <?php } ?>
                        <img
                                src="https://i.ibb.co/Gsr7qyX/notification.png"
                                alt=""
                                height="26.25px"
                                width="26.25px"
                        />
                    </div>

                    <div class="wrapper-left-elements">
                        <a class="wrapper-left-active" href="notification.php" style="margin-top: 4px"><strong>Notification</strong></a>
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
                        <a href="<?php echo BASE_URL . $user->username; ?>"
                           style="margin-top: 4px"><strong>Profile</strong></a>

                    </div>
                </div>
            </a>
            <a href="<?php echo BASE_URL . "settings.php"; ?>">
                <div class="grid-sidebar ">
                    <div class="icon-sidebar-align">
                        <img src="https://i.ibb.co/znTXjv6/perfil.png" alt="" height="26.25px" width="26.25px"/>
                    </div>

                    <div class="wrapper-left-elements">
                        <a href="<?php echo BASE_URL . "settings.php"; ?>"
                           style="margin-top: 4px"><strong>Settings</strong></a>
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
                    <div class="mt-arrow">
                        <img
                                src="https://i.ibb.co/mRLLwdW/arrow-down.png"
                                alt=""
                                height="18.75px"
                                width="18.75px"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="grid-posts">
        <div class="border-right">
            <div class="grid-toolbar-center">
                <div class="center-input-search">
                </div>
            </div>

            <div class="box-fixed" id="box-fixed"></div>

            <div class="box-home feed">
                <div class="container">
                    <div style="border-bottom: 1px solid #F5F8FA;" class="row position-fixed box-name">
                        <div class="col-xs-2">
                            <a href="javascript: history.go(-1);"> <i style="font-size:20px;"
                                                                      class="fas fa-arrow-left arrow-style"></i> </a>
                        </div>
                        <div class="col-xs-10">
                            <p style="margin-top: 12px;" class="home-name"> Notifications</p>
                        </div>
                    </div>

                </div>
                <div class="container mt-5">
                    <?php foreach ($notofication as $notify) {
                        $user = UserDBConnector::getData($notify->notify_from);
                        $timeAgo = PostDBConnector::getTimeAgo($notify->time);
                        ?>
                        <?php if ($notify->type == 'like') {
                            $icon = "<i style='color: red;font-size:30px;' class='fa-heart  fas ml-2'></i>";
                            $msg = "Liked Your Tweet";
                        } else if ($notify->type == 'retweet') {
                            $icon = "<i style='font-size:30px;color: rgb(22, 207, 22);'  class='fas fa-retweet ml-2'></i>";
                            $msg = "Retweeted Your Tweet";
                        } else if ($notify->type == 'qoute') {
                            $icon = "<i style='font-size:30px;color: rgb(22, 207, 22);'  class='fas fa-retweet ml-2'></i>";
                            $msg = "Qouted Your Tweet";
                        } else if ($notify->type == 'comment') {
                            $icon = "<i style='font-size:30px;' class='far fa-comment ml-2'></i>";
                            $msg = "Comment to your Tweet";
                        } else if ($notify->type == 'reply') {
                            $icon = "<i style='font-size:30px;' class='far fa-comment ml-2'></i>";
                            $msg = "Reply to your Comment";
                        } else if ($notify->type == 'follow') {
                            $icon = "<i style='font-size:30px;' class='fas fa-user ml-2'></i>";
                            $msg = "Followed You";
                        } else if ($notify->type == 'mention') {
                            $icon = "<i style='font-size:30px;' class='fas fa-user ml-2'></i>";
                            $msg = "Mention you in Tweet";
                        } ?>

                        <div style="position: relative; border-bottom:4px solid #F5F8FA;" class="box-tweet py-3 ">
                            <a href="
                        <?php if ($notify->type == 'follow') {
                                echo $user->username;
                            } else { ?>
                            status/<?php echo $notify->target; ?>
                        <?php } ?>  ">
                                <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                            </a>
                            <div class="grid-tweet">
                                <div class="icon mt-2">
                                    <?php echo $icon; ?>
                                </div>
                                <div class="notify-user">
                                    <p>
                                        <a style="position: relative; z-index:1000;"
                                           href="<?php echo $user->username; ?>">
                                            <img class="img-user" src="resources/images/users/<?php echo $user->img ?>"
                                                 alt="">
                                        </a>
                                    </p>
                                    <p><a style="font-weight: 700;
                                    font-size:18px;
                                    position: relative; z-index:1000;" href="<?php echo $user->username; ?>">
                                            <?php echo $user->name; ?> </a> <?php echo $msg; ?>
                                        <span style="font-weight: 500;" class="ml-3">
                                      <?php echo $timeAgo; ?>
                                    </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
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
        </div>
    </div>
</div>

<script src="resources/js/search.js"></script>
<script src="resources/js/photo.js"></script>
<script src="resources/js/follow.js?v=<?php echo time(); ?>"></script>
<script src="resources/js/users.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript" src="resources/js/hashtag.js"></script>
<script type="text/javascript" src="resources/js/like.js"></script>
<script type="text/javascript" src="resources/js/comment.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript" src="resources/js/retweet.js?v=<?php echo time(); ?>"></script>
<script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
<!-- <script src="resources/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="resources/js/jquery-3.5.1.min.js"></script>
<script src="resources/js/popper.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
</body>
</html>