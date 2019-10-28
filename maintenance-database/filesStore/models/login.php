<?php
// Login to database variables
$hn = 'localhost';      // Hostname
$db = 'tenmaint';       // Database name
$un = 'root';           // Username
$pw = 'tenmaint123';    // Password

// Autoloading all necessary classes
spl_autoload_register(function ($className){
    include $className.'.php';
});

session_start();
if(!isset($_SESSION['zalogowany']))
{
    // Set session logged state and clear user data
    $_SESSION['zalogowany'] = false;
    $_SESSION['dane_uzytkownika'] = null;
}
?>