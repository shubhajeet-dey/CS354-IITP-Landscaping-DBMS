<?php 
session_start();
unset($_SESSION['attend']);
unset($_SESSION['roster']);
unset($_SESSION['area_code_roster']);
unset($_SESSION['id_roster']);
unset($_SESSION['date_roster']);
unset($_SESSION['equip']);
unset($_SESSION['request_']);
unset($_SESSION['login']);
unset($_SESSION['ID']);
unset($_SESSION['change']);
session_destroy();
header("Location: login.php");
?>