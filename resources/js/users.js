$(function () {


    $(document).on('click', '.retweets-u', function () {
        var tweet_id = $(this).data('tweet');


        //    console.log(tweet_id);

        $.post('domain/requests/users.php', {retweetby: tweet_id}, function (data) {
            $('.popupUsers').html(data);

            $('.close-retweet-popup').click(function () {
                $('.retweet-popup').hide();
            })
            $(document).click(function (e) {
                if ($(e.target).closest('.retweet-popup-body-wrap').length > 0) {
                    return false;
                }

                $('.retweet-popup').hide();
            })
        });
    });

    $(document).on('click', '.likes-u', function () {
        var tweet_id = $(this).data('tweet');


        //    console.log(tweet_id);

        $.post('domain/requests/users.php', {likeby: tweet_id}, function (data) {
            $('.popupUsers').html(data);

            $('.close-retweet-popup').click(function () {
                $('.retweet-popup').hide();
            })
            $(document).click(function (e) {
                if ($(e.target).closest('.retweet-popup-body-wrap').length > 0) {
                    return false;
                }

                $('.retweet-popup').hide();
            })
        });
    });

    $(document).on('click', '.count-following-i', function () {
        var user_id = $(this).data('follow');


        $.post('domain/requests/users.php', {following: user_id}, function (data) {
            $('.popupUsers').html(data);

            $('.close-retweet-popup').click(function () {
                $('.retweet-popup').hide();
            })
            $(document).click(function (e) {
                if ($(e.target).closest('.retweet-popup-body-wrap').length > 0) {
                    return false;
                }

                $('.retweet-popup').hide();
            })
        });
    });

    $(document).on('click', '.count-followers-i', function () {
        var user_id = $(this).data('follow');


        $.post('domain/requests/users.php', {follower: user_id}, function (data) {
            $('.popupUsers').html(data);

            $('.close-retweet-popup').click(function () {
                $('.retweet-popup').hide();
            })
            $(document).click(function (e) {
                if ($(e.target).closest('.retweet-popup-body-wrap').length > 0) {
                    return false;
                }

                $('.retweet-popup').hide();
            })
        });
    });


    $(document).on('click', '.reply', function () {
        var tweet_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        $counter = $(this).find(".likes-count");
        $count = $counter.text();
        $button = $(this);

        console.log(tweet_id);
        console.log(user_id);
    });
});