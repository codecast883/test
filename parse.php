<?php
ob_start();
session_start();


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
 
    ?>
</div>
</body>
</html>
