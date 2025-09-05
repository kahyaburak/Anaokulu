<?php

include "config.php";

$mesajlar = [];

if (isset($_POST["submit"])) {
   $username = trim($_POST["username"]);
   $password = trim($_POST["password"]);

   try {
      if (strlen($username) > 0 && strlen($password) > 0) {

         $sifreDogrulugu = sifreDogrula($baglanti, $username, $password, TABLE_USERS);
         if ($sifreDogrulugu) {
            //giriş yapma başarılı 

            $_SESSION['user'] = ucfirst($username);

            $adminMi = adminMi($baglanti, $username, TABLE_USERS);
            if ($adminMi) {
               $_SESSION['admin'] = 'Admin';
               header("Location:yoneticiPaneli.php");
               exit();
            }


            header("Location:index.php");
         } else {
            throw new Exception("Bir şeyler ters gitti lütfen tekrar deneyin.");
         }
      } else {
         throw new Exception("Bir şeyler ters gitti lütfen tekrar deneyin.");
      }
   } catch (Exception $e) {
      $mesajlar[] = $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giriş yap</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1>Giriş</h1>
         <div class="hata_mesaj">
            <?php
            foreach ($mesajlar as $msg) {
               echo "<p>* $msg</p>";
            }
            ?>
         </div>
         <?= girisFormu(); ?>
      </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>