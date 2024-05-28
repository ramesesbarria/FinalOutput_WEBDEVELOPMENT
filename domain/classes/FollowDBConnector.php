<?php 

class FollowDBConnector extends UserDBConnector {
    
    protected static $pdo;

    public static function countFollowers($user_id) {
        $stmt = self::connect()->prepare("SELECT COUNT(following_id) as count FROM `follow`
        WHERE following_id = :user_id");
        $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        return $count->count;
    }
    public static function countFollowing($user_id) {
        $stmt = self::connect()->prepare("SELECT COUNT(follower_id) as count FROM `follow`
        WHERE follower_id = :user_id");
        $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        return $count->count;
    }
    public static function isUserFollow($user_id ,$profile_id){
            
        $stmt = self::connect()->prepare("SELECT `follower_id` , `following_id` FROM `follow` 
        WHERE `follower_id` = :user_id and `following_id` = :profile_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":profile_id", $profile_id, PDO::PARAM_INT);
        $stmt->execute(); 

        if ($stmt->rowCount() > 0) {
            return true;
        } else return false;

    }
    public static function usersFollowing($user_id){
            
        $stmt = self::connect()->prepare("SELECT `following_id` as user_id FROM `follow`
        WHERE follower_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute(); 

        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
    public static function usersFollowers($user_id){
            
        $stmt = self::connect()->prepare("SELECT `follower_id` as user_id FROM `follow`
        WHERE following_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute(); 

        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
    public static function FollowsYou($profile_id , $user_id){
		$stmt = self::connect()->prepare("SELECT * FROM `follow`
         WHERE `follower_id` = :profile_id AND `following_id` = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":profile_id", $profile_id, PDO::PARAM_INT);
        $stmt->execute(); 
        if ($stmt->rowCount() > 0) {
            return true;
        } else return false;
	}



     

}