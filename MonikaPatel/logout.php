<?php
require_once("../RavinderSingh/redirect.php");
$redirect=new redirect();
$redirect->redirectIfNotLoggedIn();
session_start();
session_unset();
session_destroy();
header("Location: ../RavinderSingh/home.php");
exit();
?>
