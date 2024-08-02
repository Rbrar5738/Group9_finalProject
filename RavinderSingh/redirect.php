<?php
class Redirect
{
    public function __construct()
    {
        // Ensure the session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function redirectIfLoggedIn()
    {
        if (!empty($_SESSION["UserId"])) {
            header("Location: ../RavinderSingh/home.php");
            exit();
        }
    }

    public function redirectIfNotLoggedIn()
    {
        if (empty($_SESSION["UserId"])) {
            header("Location: ../MonikaPatel/login.php");
            exit();
        }
    }

    public function logout()
    {
        if (!empty($_SESSION["UserId"])) {
            $_SESSION = [];
            session_destroy();
            setcookie("PHPSESSID", "", time() - 3600, "/", "", false, true);
            // Redirect to login page or home page after logout
            header("Location: ../MonikaPatel/login.php");
            exit();
        }
    }
}
?>
