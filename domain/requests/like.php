<?php
include '../init.php';

// Checks if the 'like' key in the $_POST array is not empty.
if (!empty($_POST['like'])) {
    // Retrieves the user ID and the tweet ID from the session and POST data, respectively.
    // The $user_id is retrieved from the session data, which means it's the ID of the currently logged-in user.
    // The $tweet_id is retrieved from the POST data, which means it's the ID of the tweet that the
    // user is trying to 'like'.
    $user_id = $_SESSION['user_id'];
    $tweet_id = $_POST['like'];

    // Retrieves the ID of the user who posted the tweet that is being liked and then retrieves
    // user ID from the POST data.
    $for_user = PostDBConnector::getData($tweet_id)->user_id;
    $get_id = $_POST['user_id'];
    date_default_timezone_set("Africa/Cairo");

    // This is executed when a 'like' POST request is received. The $user_id and $tweet_id are extracted from the
    // POST data, and then this line of code is used to create a new record in the 'likes' table,  recording that
    // the user with ID $user_id has liked the tweet with ID $tweet_id.
    UserDBConnector::create('likes', array('user_id' => $user_id, 'post_id' => $tweet_id));

    // Outputs an HTML div element with the class tmp and d-none. This div contains the current count of
    // 'likes' for a specific tweet. The PostDBConnector::countLikes($tweet_id)  interacts with the database to
    // count the number of 'likes' for the tweet with the ID $tweet_id.
    echo `<div class="tmp d-none">` + PostDBConnector::countLikes($tweet_id) + `</div>`;
}

// Checks if the 'unlike' key in the $_POST array is not empty.
if (!empty($_POST['unlike'])) {
    $user_id = $_SESSION['user_id'];
    $tweet_id = $_POST['unlike'];
    $get_id = $_POST['user_id'];
    $for_user = PostDBConnector::getData($tweet_id)->user_id;

    PostDBConnector::unLike($user_id, $tweet_id);

    echo `<div class="tmp d-none">
             ` + PostDBConnector::countLikes($tweet_id) + `
		</div>`;
}

if (isset($_POST['file'])) {
    $getFromT->uploadImage($_POST['files']);
}
?>