<?php
ob_start();


session_start();
// require 'config.php';
// if (!isset($_COOKIE['token'])) {
// 	header('Location: http://'. $_SERVER['HTTP_HOST']);
// 	exit;
// }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get-like-id</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/bootstrap.css">
    <!-- <link rel="stylesheet" href="styles/style.css"> -->
    <link rel="stylesheet" href="styles/select2.min.css">
    <link rel="stylesheet" href="styles/tcal.css">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modernizr-custom.js"></script>
    <script src="js/tcal.js"></script>
    <script src="js/select2.min.js"></script>

</head>
<body>

<?php
require_once 'inc/header.php';
require 'lib.php';
?>


<div class="container">

    <?php
    switch ($_GET['page']) {
        case 'hide-for-friends':
            require_once 'friends.php';
            break;

        case 'hide-for-activity':
            require_once 'activity.php';
            break;

        default:
            require_once 'likes.php';
            break;
    }

    ?>


    <?php
    // echo "<pre>";
    // print_r(getPhotoId($userId));
    // print_r(allLikeUser($groupNameId,165));
    //  print_r(getdate($dateTimeStamp1));
    // print_r($oResponce->error->error_code);
    // print_r($_SESSION['result_like']);
    // print_r(count(getFriends('416334309')->response));
    // echo "</pre>";
    ?>
</div>
</body>
</html>