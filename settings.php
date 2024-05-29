<?php

include 'domain/init.php';

$user_id = $_SESSION['user_id'];

$user = UserDBConnector::getData($user_id);

if (UserDBConnector::checkLogIn() === false)
    header('location: index.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Twitter</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <!-- time function to force css file to reload -->

    <link rel="stylesheet" href="resources/css/profile_style.css?v=<?php echo time(); ?>">

</head>
<body>


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
                        <a class="wrapper-left-active" href="<?php echo BASE_URL . "settings.php"; ?>"
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
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a style="color:black !important;" class="nav-link active text-center" id="v-pills-home-tab"
                           data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                           aria-selected="true">Change Email or Username</a>
                        <a style="color:black !important;" class="nav-link text-center" id="v-pills-profile-tab"
                           data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                           aria-selected="false">Change Password</a>

                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <!-- Change EMAIL and USAERNAME Form -->

                            <form method="POST" action="form_actions/actionUserSetting.php" class="py-4">

                                <?php if (isset($_SESSION['errors_account'])) {

                                    ?>

                                    <?php foreach ($_SESSION['errors_account'] as $error) { ?>

                                        <div class="alert alert-danger" role="alert">
                                            <p style="font-size: 15px;" class="text-center"> <?php echo $error; ?> </p>
                                        </div>
                                    <?php } ?>

                                <?php }
                                unset($_SESSION['errors_account']) ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" name="email" value="<?php echo $user->email; ?>"
                                           class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Enter email">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Username</label>
                                    <input type="text" name="username" value="<?php echo $user->username; ?>"
                                           class="form-control" id="exampleInputPassword1" placeholder="Username">
                                </div>

                                <div class="text-center">

                                    <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                                </div>

                            </form>

                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                             aria-labelledby="v-pills-profile-tab">


                            <!-- Change Password Form -->

                            <form method="POST" action="form_actions/actionPasswordChange.php" class="py-4">
                                <script src="resources/js/jquery-3.5.1.min.js"></script>
                                <?php if (isset($_SESSION['errors_password'])) { ?>
                                    <script>
                                        $(document).ready(function () {
                                            // Open modal on page load
                                            $("#v-pills-profile-tab").click();
                                        });
                                    </script>

                                <?php foreach ($_SESSION['errors_password'] as $error) { ?>

                                    <div class="alert alert-danger" role="alert">
                                        <p style="font-size: 15px;" class="text-center"> <?php echo $error; ?> </p>
                                    </div>
                                <?php } ?>

                                <?php }
                                unset($_SESSION['errors_password']) ?>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Old Password</label>
                                    <input type="password" name="old_password" class="form-control"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Old Password">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">New Password</label>
                                    <input type="password" name="new_password" class="form-control"
                                           id="exampleInputPassword1" placeholder="New Password">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Verify Password</label>
                                    <input type="password" name="ver_password" class="form-control"
                                           id="exampleInputPassword1" placeholder="New Password">
                                </div>

                                <div class="text-center">

                                    <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
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
<script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
<!-- <script src="resources/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="resources/js/popper.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
</body>
</html>