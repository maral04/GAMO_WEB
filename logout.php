<?php
/**
 * Created by PhpStorm.
 * User: Arnau
 * Date: 05/05/2016
 * Time: 21:24
 */

session_start();
session_destroy();
setcookie(session_name(), false, time() - 3600);

