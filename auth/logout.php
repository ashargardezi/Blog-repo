<?php 
 require('../common/config.php');

 unset($_SESSION['user_id']);
 unset($_SESSION['first_name']);
 session_destroy();

 header("Location: ".BASE_URL."/auth/login.php");