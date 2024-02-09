<?php
session_start();
unset($_SESSION['admin_username']);
echo "<script>window.location = 'adminLogin.php' ;</script>";
?>