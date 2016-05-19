<?php

session_start();
session_destroy();
setcookie(session_name(), false, time() - 3600);
header("Location: index.php");
