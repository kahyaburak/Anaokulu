<?php
session_start();
session_unset();
session_destroy();

//kullanıcıyı ana menüye yönlendir
header("Location: index.php");