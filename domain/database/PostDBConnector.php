<?php

class PostDBConnector extends UserDBConnector {

    protected static $pdo;

      public static function posts($user_id) {
        $stmt = self::connect()->prepare("SELECT * from `posts`
        WHERE user_id = :user_id OR user_id IN (SELECT following_id from `follow` WHERE follower_id = :user_id)
        ORDER BY post_on DESC");
        $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      public static function tweetsUser($user_id) {
        $stmt = self::connect()->prepare("SELECT * from `posts`
        WHERE user_id = :user_id
        ORDER BY post_on DESC");
        $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      public static function likedTweets($user_id) {
        $stmt = self::connect()->prepare("SELECT * from `posts`
        WHERE id IN (SELECT post_id from `likes` WHERE user_id = :user_id)
        ORDER BY post_on DESC");
        $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      public static function mediaTweets($user_id) {
        $stmt = self::connect()->prepare("SELECT * from `posts`
        WHERE id IN (SELECT post_id from `tweets` WHERE user_id = :user_id AND img is not null)
        ORDER BY post_on DESC");
        $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
        $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      public static function isTweet($tweet_id){

        $stmt = self::connect()->prepare("SELECT * FROM `tweets` 
        WHERE `post_id` = :tweet_id");
        $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else return false;
    }
    public static function isRetweet($tweet_id){

        $stmt = self::connect()->prepare("SELECT * FROM `retweets` 
        WHERE `post_id` = :tweet_id");
        $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else return false;

    }

        public static function getTimeAgo($timestamp){
            date_default_timezone_set("Africa/Cairo");

            $time_ago        = strtotime($timestamp);
            $current_time = strtotime(date("Y-m-d H:i:s"));
            // $current_time    = time();
            $time_difference = $current_time - $time_ago;
            $seconds         = $time_difference;

            $minutes = round($seconds / 60); // value 60 is seconds
            $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
            $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
            $weeks   = round($seconds / 604800); // 7*24*60*60;
            $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
            $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

            if ($seconds <= 60){

            return "just now";

            } else if ($minutes <= 60){

            if ($minutes == 1){

                return "one minute ago";

            } else {

                return "$minutes minutes ago";

            }

            } else if ($hours <= 24){

            if ($hours == 1){

                return "an hour ago";

            } else {

                return "$hours hrs ago";

            }

            } else if ($days <= 7){

            if ($days == 1){

                return "yesterday";

            } else {

                return "$days days ago";

            }

            } else if ($weeks <= 4.3){

            if ($weeks == 1){

                return "a week ago";

            } else {

                return "$weeks weeks ago";

            }

            } else if ($months <= 12){

            if ($months == 1){

                return "a month ago";

            } else {

                return "$months months ago";

            }

            } else {

            if ($years == 1){

                return "one year ago";

            } else {

                return "$years years ago";

            }
            }
        }

        public static function getTweetLinks($tweet){
            $tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $tweet);
            $tweet = preg_replace("/#([\w]+)/", "<a class='hash-tweet' href='#'>$0</a>", $tweet);
            $tweet = preg_replace("/@([\w]+)/", "<a class='hash-tweet' href='http://localhost/twitter/$1'>$0</a>", $tweet);
            return $tweet;
        }

        public static function countLikes($post_id) {
            $stmt = self::connect()->prepare("SELECT COUNT(post_id) as count FROM `likes`
            WHERE post_id = :post_id");
            $stmt->bindParam(":post_id" , $post_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }
        public static function countTweets($user_id) {
            $stmt = self::connect()->prepare("SELECT COUNT(user_id) as count FROM `posts`
            WHERE user_id = :user_id");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->count;
        }

        public static function countRetweets($tweet_id) {
            $stmt = self::connect()->prepare("SELECT COUNT(*) as count FROM `retweets`
            WHERE (`tweet_id` = :tweet_id or `retweet_id` = :tweet_id)  and retweet_msg is null 
            GROUP BY tweet_id , retweet_id");
            $stmt->bindParam(":tweet_id" , $tweet_id , PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $count = $stmt->fetch(PDO::FETCH_OBJ);
                return $count->count;
            } else return false;

        }

        public static function unLike($user_id, $tweet_id){

            $stmt = self::connect()->prepare("DELETE FROM `likes` 
            WHERE `user_id` = :user_id and `post_id` = :tweet_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;

        }

        public static function userLikeIt( $user_id ,$tweet_id){

            $stmt = self::connect()->prepare("SELECT `post_id` , `user_id` FROM `likes` 
            WHERE `user_id` = :user_id and `post_id` = :tweet_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;

        }
        public static function usersLiked($tweet_id){

            $stmt = self::connect()->prepare("SELECT `post_id` , `user_id` FROM `likes` 
            WHERE  `post_id` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public static function userRetweeetedIt($user_id ,$tweet_id){

            $stmt = self::connect()->prepare("SELECT `id` , `user_id` FROM `posts` JOIN `retweets`
            on id = post_id
            WHERE `user_id` = :user_id and (`tweet_id` = :tweet_id or `retweet_id` = :tweet_id)  and retweet_msg is NULL");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;

        }
        public static function usersRetweeeted($tweet_id){

            $stmt = self::connect()->prepare("SELECT `id` , `user_id` FROM `posts` JOIN `retweets`
            on id = post_id
            WHERE (`tweet_id` = :tweet_id or `retweet_id` = :tweet_id)  and retweet_msg is NULL");
            // $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public static function undoRetweet($user_id , $tweet_id) {

            $stmt = self::connect()->prepare("DELETE FROM `posts` 
            WHERE `user_id` = :user_id and `id` = :tweet_id
            ");
            // and id not in (SELECT post_id from `retweets` WHERE retweet_msg is not null)
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else return false;
        }

        public static function retweetRealId($tweet_id , $user_id) {
            $stmt = self::connect()->prepare("SELECT post_id FROM retweets JOIN posts
            on id = post_id
            WHERE (tweet_id = :tweet_id or  retweet_id = :tweet_id) and `user_id` = :user_id");
            $stmt->bindParam(":tweet_id" , $tweet_id , PDO::PARAM_STR);
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $id = $stmt->fetch(PDO::FETCH_OBJ);
            return $id->post_id;
        }

        public static function getTweet($tweet_id){
            $stmt = self::connect()->prepare("SELECT * FROM `tweets` JOIN `posts` 
            on posts.id = tweets.post_id 
            WHERE `post_id` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        public static function getRetweet($tweet_id){
            $stmt = self::connect()->prepare("SELECT * FROM `retweets` JOIN `posts` 
            on id = post_id 
            WHERE `post_id` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        public static function getData($id) {
            $stmt = self::connect()->prepare("SELECT * from `posts` WHERE `id` = :id");
            $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
            $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
     }
}