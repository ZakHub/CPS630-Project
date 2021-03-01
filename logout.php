<?php
session_start(); // see session variables
session_destroy(); // delete session variables
header("Location: CPS630ProjectMain.php"); // send back to homepage