<?php
session_start();
unset($_SESSION['user_id']);
echo "<script>window.location = 'index.php' ;</script>";
?>