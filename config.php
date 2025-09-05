<?php
//session başlangıcı
session_start();

// gereksinimleri al

include "includes/db.php";
include "includes/functions.php";

//veritabanı ile bağlantı kuran değişken

$baglanti = baglan();