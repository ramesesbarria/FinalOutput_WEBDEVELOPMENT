<?php
include 'domain/init.php';

$user_id = $_SESSION['user_id'];

$user = UserDBConnector::getData($user_id);

if (UserDBConnector::checkLogIn() === false)
    header('location: index.php');


$tweet_id = $_GET['post_id'];
$tweet = PostDBConnector::getData($tweet_id);
$notify_count = UserDBConnector::GetNotificationCount($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status | Twitter</title>
    <base href="<?php echo BASE_URL; ?>">
    <link rel="shortcut icon" type="image/png" href="resources/images/twitter.svg">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/all.min.css">
    <link rel="stylesheet" href="resources/css/home_style.css?v=<?php echo time(); ?>">

</head>
<body>
<script src="resources/js/jquery-3.5.1.min.js"></script>

<div id="mine">

    <div class="wrapper-left">
        <div class="sidebar-left">
            <div class="grid-sidebar" style="margin-top: 12px">
                <div class="icon-sidebar-align">
                    <img src="https://img.freepik.com/free-vector/new-2023-twitter-logo-x-icon-design_1017-45418.jpg?size=338&ext=jpg&ga=GA1.1.44546679.1716854400&semt=ais_user"
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
                        <a href="notification.php" style="margin-top: 4px"><strong>Notification</strong></a>
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
                    <div class="container" style="border-bottom: 1px solid #E9ECEF;">
                        <div class="row">
                            <div class="col-xs-1">
                                <!-- history go to the perv page and specific section user come from -->
                                <a href="javascript: history.go(-1);"> <i style="font-size:20px;"
                                                                          class="fas fa-arrow-left arrow-style"></i>
                                </a>
                            </div>
                            <div class="col-xs-10 mt-1">
                                <p class="tweet-name" style="
                           font-weight:700"> Tweet</p>
                            </div>
                        </div>
                        <div class="part-2">

                        </div>

                    </div>


                </div>
                <!-- <div class="mt-icon-settings">
                  <img src="https://i.ibb.co/W5T9ycN/settings.png" alt="" />
                </div> -->
            </div>

            <div class="box-fixed" id="box-fixed"></div>

            <?php

            $retweet_sign = false;
            $retweet_comment = false;
            $qoq = false;

            if (PostDBConnector::isTweet($tweet->id)) {

                $tweet_user = UserDBConnector::getData($tweet->user_id);
                $tweet_real = PostDBConnector::getTweet($tweet->id);
                $timeAgo = PostDBConnector::getTimeAgo($tweet->post_on);
                $likes_count = PostDBConnector::countLikes($tweet->id);
                $user_like_it = PostDBConnector::userLikeIt($user_id, $tweet->id);
                $retweets_count = PostDBConnector::countRetweets($tweet->id);
                $user_retweeted_it = PostDBConnector::userRetweeetedIt($user_id, $tweet->id);

            } else if (PostDBConnector::isRetweet($tweet->id)) {

                $retweet = PostDBConnector::getRetweet($tweet->id);

                if ($retweet->retweet_msg == null) {

                    if ($retweet->retweet_id == null) {

                        // if retweeted normal tweet
                        $retweeted_tweet = PostDBConnector::getTweet($retweet->tweet_id);
                        $tweet_user = UserDBConnector::getData($retweeted_tweet->user_id);
                        $tweet_real = PostDBConnector::getTweet($retweet->tweet_id);
                        $timeAgo = PostDBConnector::getTimeAgo($tweet_real->post_on);
                        $likes_count = PostDBConnector::countLikes($retweet->tweet_id);
                        $user_like_it = PostDBConnector::userLikeIt($user_id, $retweet->tweet_id);
                        $retweets_count = PostDBConnector::countRetweets($retweet->tweet_id);
                        $user_retweeted_it = PostDBConnector::userRetweeetedIt($user_id, $retweet->tweet_id);
                        $retweeted_user = UserDBConnector::getData($tweet->user_id);
                        $retweet_sign = true;
                    } else {

                        // this condtion if user retweeted qouted tweet or qoute of qoute tweet


                        $retweeted_tweet = PostDBConnector::getRetweet($retweet->retweet_id);

                        if ($retweeted_tweet->tweet_id != null) {
                            // here it's retweeted qouted
                            // if($retweeted_tweet->)
                            $tweet_user = UserDBConnector::getData($retweeted_tweet->user_id);
                            $timeAgo = PostDBConnector::getTimeAgo($retweeted_tweet->post_on);
                            $likes_count = PostDBConnector::countLikes($retweeted_tweet->post_id);
                            $user_like_it = PostDBConnector::userLikeIt($user_id, $retweeted_tweet->post_id);
                            $retweets_count = PostDBConnector::countRetweets($retweeted_tweet->post_id);
                            $user_retweeted_it = PostDBConnector::userRetweeetedIt($user_id, $retweeted_tweet->post_id);


                            $tweet_inner = PostDBConnector::getTweet($retweeted_tweet->tweet_id);
                            $user_inner_tweet = UserDBConnector::getData($tweet_inner->user_id);
                            $timeAgo_inner = PostDBConnector::getTimeAgo($tweet_inner->post_on);
                            $retweeted_user = UserDBConnector::getData($tweet->user_id);
                            $retweet_sign = true;

                            $qoute = $retweeted_tweet->retweet_msg;
                            $retweet_comment = true;
                        } else {
                            // here is retweeted qouted of qouted

                            $retweet_sign = true;
                            $tweet_user = UserDBConnector::getData($retweeted_tweet->user_id);

                            $timeAgo = PostDBConnector::getTimeAgo($retweeted_tweet->post_on);
                            $likes_count = PostDBConnector::countLikes($retweeted_tweet->post_id);
                            $user_like_it = PostDBConnector::userLikeIt($user_id, $retweeted_tweet->post_id);
                            $retweets_count = PostDBConnector::countRetweets($retweeted_tweet->post_id);
                            $user_retweeted_it = PostDBConnector::userRetweeetedIt($user_id, $retweeted_tweet->post_id);

                            $qoq = true; // stand for qoute of qoute
                            $qoute = $retweeted_tweet->retweet_msg;
                            $tweet_inner = PostDBConnector::getRetweet($retweeted_tweet->retweet_id);
                            $user_inner_tweet = UserDBConnector::getData($tweet_inner->user_id);
                            $timeAgo_inner = PostDBConnector::getTimeAgo($tweet_inner->post_on);
                            $inner_qoute = $tweet_inner->retweet_msg;


                            $retweeted_user = UserDBConnector::getData($tweet->user_id);

                        }
                    }

                } else {
                    // qoute tweet condtion
                    if ($retweet->retweet_id == null) {
                        $tweet_user = UserDBConnector::getData($tweet->user_id);
                        $timeAgo = PostDBConnector::getTimeAgo($tweet->post_on);
                        $likes_count = PostDBConnector::countLikes($tweet->id);
                        $user_like_it = PostDBConnector::userLikeIt($user_id, $tweet->id);
                        $retweets_count = PostDBConnector::countRetweets($tweet->id);
                        $user_retweeted_it = PostDBConnector::userRetweeetedIt($user_id, $tweet->id);
                        $qoute = $retweet->retweet_msg;
                        $retweet_comment = true;


                        $tweet_inner = PostDBConnector::getTweet($retweet->tweet_id);
                        $user_inner_tweet = UserDBConnector::getData($tweet_inner->user_id);
                        $timeAgo_inner = PostDBConnector::getTimeAgo($tweet_inner->post_on);
                    } else {

                        // this condtion for qoute of qoute which retweet_id not null and retweet msg not null
                        $tweet_user = UserDBConnector::getData($tweet->user_id);
                        $timeAgo = PostDBConnector::getTimeAgo($tweet->post_on);
                        $likes_count = PostDBConnector::countLikes($tweet->id);
                        $user_like_it = PostDBConnector::userLikeIt($user_id, $tweet->id);
                        $retweets_count = PostDBConnector::countRetweets($tweet->id);
                        $user_retweeted_it = PostDBConnector::userRetweeetedIt($user_id, $tweet->id);
                        $qoute = $retweet->retweet_msg;
                        $qoq = true; // stand for qoute of qoute

                        $tweet_inner = PostDBConnector::getRetweet($retweet->retweet_id);
                        $user_inner_tweet = UserDBConnector::getData($tweet_inner->user_id);
                        $timeAgo_inner = PostDBConnector::getTimeAgo($tweet_inner->post_on);
                        $inner_qoute = $tweet_inner->retweet_msg;
                        if ($inner_qoute == null) {

                            $tweet_innerr = PostDBConnector::getRetweet($tweet_inner->retweet_id);
                            $inner_qoute = $tweet_innerr->retweet_msg;

                            // $inner_qoute = "qork";

                        }

                    }

                }

            }
            $tweet_link = $tweet->id;

            //  show real tweet comments if retweeted tweet 
            if ($retweet_sign)
                $comments = PostDBConnector::comments($retweeted_tweet->id);
            else  $comments = PostDBConnector::comments($tweet_id);


            if ($retweet_sign)
                $comment_count = PostDBConnector::countComments($retweeted_tweet->id);
            else  $comment_count = PostDBConnector::countComments($tweet->id);


            ?>


            <div class="box-tweet feed" style="position: relative;">
                <a href="status/<?php echo $tweet->id; ?>">
                    <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                </a>
                <?php if ($retweet_sign) { ?>
                    <span class="retweed-name"> <i class="fa fa-retweet retweet-name-i" aria-hidden="true"></i>
            <a style="position: relative; z-index:100; color:rgb(102, 117, 130);"
               href="<?php echo $retweeted_user->name; ?> "> <?php if ($retweeted_user->id == $user_id) echo "You";
                else echo $retweeted_user->name; ?> </a>  retweeted</span>
                <?php } ?>
                <div class="grid-tweet">
                    <a style="position: relative; z-index:1000" href="<?php echo $tweet_user->username; ?>">
                        <img
                                src="resources/images/users/<?php echo $tweet_user->img; ?>"
                                alt=""
                                class="img-user-tweet"
                        />
                    </a>

                    <div>
                        <p>
                            <a style="position: relative; z-index:1000; color:black"
                               href="<?php echo $tweet_user->username; ?>">
                                <strong> <?php echo $tweet_user->name ?> </strong>
                            </a>
                            <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                            <span class="username-twitter"><?php echo $timeAgo ?></span>
                        </p>
                        <p>
                            <?php
                            // check if it's qoute or normal tweet
                            if ($retweet_comment || $qoq)
                                echo PostDBConnector::getTweetLinks($qoute);
                            else echo PostDBConnector::getTweetLinks($tweet_real->status); ?>
                        </p>
                        <?php if ($retweet_comment == false && $qoq == false) { ?>
                            <?php if ($tweet_real->img != null) { ?>
                                <p class="mt-post-tweet">
                                    <img
                                            src="resources/images/tweets/<?php echo $tweet_real->img; ?>"
                                            alt=""
                                            class="img-post-tweet"
                                    />
                                </p>
                            <?php }
                        } else { ?>
                            <!-- ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss -->

                            <div class="mt-post-tweet comment-post" style="position: relative;">

                                <a href="status/<?php echo $tweet_inner->id; ?>">
                                    <span class=""
                                          style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 2;"></span>
                                </a>
                                <div class="grid-tweet py-3 ">

                                    <a style="position: relative; z-index:1000"
                                       href="<?php echo $user_inner_tweet->username; ?>">
                                        <img
                                                src="resources/images/users/<?php echo $user_inner_tweet->img; ?>"
                                                alt=""
                                                class="img-user-tweet"
                                        />
                                    </a>

                                    <div>
                                        <p>
                                            <a style="position: relative; z-index:1000; color:black"
                                               href="<?php echo $user_inner_tweet->username; ?>">
                                                <strong> <?php echo $user_inner_tweet->name ?> </strong>
                                            </a>
                                            <span class="username-twitter">@<?php echo $user_inner_tweet->username ?> </span>
                                            <span class="username-twitter"><?php echo $timeAgo_inner ?></span>
                                        </p>
                                        <p>
                                            <?php
                                            if ($qoq)
                                                echo PostDBConnector::getTweetLinks($inner_qoute);
                                            else  echo PostDBConnector::getTweetLinks($tweet_inner->status); ?>
                                        </p>
                                        <?php // don't show img if qoute of qoute
                                        if ($qoq == false) {
                                            if ($tweet_inner->img != null) { ?>
                                                <p class="mt-post-tweet">
                                                    <img
                                                            src="resources/images/tweets/<?php echo $tweet_inner->img; ?>"
                                                            alt=""
                                                            class="img-post-retweet"
                                                    />
                                                </p>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row home-follow pt-3">

                            <?php if ($retweets_count > 0) { ?>
                                <div class="col-md-2 users-count">
                                    <i class="retweets-u"
                                       data-tweet="<?php
                                       if ($retweet_sign)
                                           echo $retweeted_tweet->id;
                                       else  echo $tweet->id; ?>">
                                        <span class="home-follow-count"> <?php echo $retweets_count; ?> </span> Retweets</i>
                                </div>
                            <?php } ?>
                            <?php if ($likes_count > 0) { ?>
                                <div class="col-md-2 users-count">
                                    <i class="likes-u"
                                       data-tweet="<?php
                                       if ($retweet_sign)
                                           echo $retweeted_tweet->id;
                                       else  echo $tweet->id; ?>">
                                        <span class="home-follow-count">  <?php echo $likes_count; ?>  </span> Likes</i>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="grid-reactions">
                            <div class="grid-box-reaction">
                                <div class="hover-reaction hover-reaction-comment comment"
                                     data-user="<?php echo $user_id; ?>"
                                     data-tweet="<?php
                                     if ($retweet_sign)
                                         echo $retweeted_tweet->id;
                                     else  echo $tweet->id; ?>">

                                    <i class="far fa-comment"></i>
                                    <div class="mt-counter likes-count d-inline-block">
                                        <p> <?php if ($comment_count > 0) echo $comment_count; ?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-box-reaction">

                                <div class="hover-reaction hover-reaction-retweet
                    <?= $user_retweeted_it ? 'retweeted' : 'retweet' ?> option"
                                     data-tweet="<?php
                                     // send the tweet you wanna undo retweet to undo function
                                     // if the user retweeted it and it's the real tweet
                                     // to send the id of retweeted tweet
                                     // if($user_retweeted_it && !$retweet_sign)
                                     // echo Tweet::retweetRealId($tweet->id);
                                     // else
                                     echo $tweet->id;
                                     ?>"
                                     data-user="<?php echo $user_id; ?>
                    "
                                     data-retweeted="<?php echo $user_retweeted_it; ?>"
                                     data-sign="<?php echo $retweet_sign; ?>"
                                     data-tmp="<?php echo $retweet_comment; ?>"
                                     data-qoq="<?php echo $qoq; ?>"
                                     data-status="<?php echo true; ?>">
                                    <i class="fas fa-retweet"></i>
                                    <div class="mt-counter likes-count d-inline-block">
                                        <p><?php if ($retweets_count > 0) echo $retweets_count; ?></p>
                                    </div>
                                </div>

                                <div class="options">
                                </div>
                            </div>
                            <div class="grid-box-reaction">
                                <a class="hover-reaction hover-reaction-like
                    <?= $user_like_it ? 'unlike-btn' : 'like-btn' ?> "
                                   data-tweet="<?php
                                   if ($retweet_sign) {
                                       if ($retweet->tweet_id != null) {
                                           echo $retweet->tweet_id;
                                       }
                                       echo $retweet->retweet_id;
                                   } else echo $tweet->id;
                                   //  echo Tweet::likedTweetRealId($tweet->id);

                                   ?>"
                                   data-user="<?php echo $user_id; ?>">
                                    <i class="fa-heart <?= $user_like_it ? 'fas' : 'far mt-icon-reaction' ?>"></i>
                                    <!-- <i class="fas fa-heart liked"></i> -->
                                    <div class="mt-counter likes-count d-inline-block">
                                        <p> <?php if ($likes_count > 0) echo $likes_count; ?> </p>
                                    </div>
                                </a>
                            </div>

                            <div class="grid-box-reaction">
                                <div class="hover-reaction hover-reaction-comment">
                                    <i class="fas fa-ellipsis-h mt-icon-reaction"></i>
                                </div>
                                <div class="mt-counter">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="comments">


                <!-- comments place -->
                <?php foreach ($comments as $comment) {
                    $tweet_user = UserDBConnector::getData($comment->user_id);
                    $timeAgo = PostDBConnector::getTimeAgo($comment->time);
                    $replies = PostDBConnector::replies($comment->id);
                    $reply_count = PostDBConnector::countReplies($comment->id);
                    ?>

                    <div class="box-comment feed py-2">
                        <div class="grid-tweet">
                            <div>
                                <img
                                        src="resources/images/users/<?php echo $tweet_user->img; ?>"
                                        alt=""
                                        class="img-user-tweet"
                                />
                            </div>

                            <div>
                                <p>
                                    <strong> <?php echo $tweet_user->name ?> </strong>
                                    <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                                    <span class="username-twitter"><?php echo $timeAgo ?></span>
                                </p>
                                <p>
                                    <?php
                                    echo PostDBConnector::getTweetLinks($comment->comment); ?>
                                </p>

                                <div class="grid-reactions">
                                    <div class="grid-box-reaction-rep">
                                        <div class="hover-reaction-rep hover-reaction-comment reply"
                                             data-user="<?php echo $user_id; ?>"
                                             data-tweet="<?php
                                             echo $comment->id; ?>">

                                            <i class="far fa-comment"></i>
                                            <div class="mt-counter likes-count d-inline-block">
                                                <p> <?php if ($reply_count > 0) echo $reply_count; ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- replies -->
                    <?php foreach ($replies as $reply) {
                        $tweet_user = UserDBConnector::getData($reply->user_id);
                        $timeAgo = PostDBConnector::getTimeAgo($reply->time);

                        ?>
                        <div class="box-reply feed">
                            <div class="grid-tweet">
                                <div>
                                    <img
                                            src="resources/images/users/<?php echo $tweet_user->img; ?>"
                                            alt=""
                                            class="img-user-tweet"
                                    />
                                </div>
                                <div>
                                    <p>
                                        <strong> <?php echo $tweet_user->name ?> </strong>
                                        <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                                        <span class="username-twitter"><?php echo $timeAgo ?></span>
                                    </p>
                                    <p>
                                        <?php
                                        echo PostDBConnector::getTweetLinks($reply->reply); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="popupTweet">
                </div>
                <div class="popupComment">
                </div>
                <div class="popupUsers">
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
<script type="text/javascript" src="resources/js/hashtag.js"></script>
<script type="text/javascript" src="resources/js/like.js"></script>
<script type="text/javascript" src="resources/js/users.js"></script>
<script type="text/javascript" src="resources/js/comment.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript" src="resources/js/retweet.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript" src="resources/js/follow.js?v=<?php echo time(); ?>"></script>
<script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
<!-- <script src="resources/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="resources/js/jquery-3.5.1.min.js"></script>

<script src="resources/js/popper.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
</body>
</html> 