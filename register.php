<?php

include "config.php";

$mesaj = "Yeni hesap kaydet!";
$formGoster = true;
$hatalar = [];
if (isset($_POST["submit"])) {
   try {
      unset($_POST["submit"]);

      foreach ($_POST as $key => $value) {
         $item = trim($value);
         if (strlen($item) == 0) {
            $hatalar[] = $key . " hatalı";
         } else {
            $_POST[$key] = $item;
         }
      }

      if (kullaniciMevcut($baglanti, $_POST['username'], TABLE_USERS)) {
         $hatalar[] = "Kullanıcı ismi mevcut";
      }

      if (!$hatalar) {
         $password = $_POST['password'];
         $confirm_password = $_POST['confirm_password'];

         if ($confirm_password == $password) {
            unset($_POST['confirm_password']);
            $_POST['password'] = password_hash($password, PASSWORD_DEFAULT);
            if (birKayitEkle($baglanti, TABLE_USERS, $_POST)) {
               $mesaj = "Hesap oluşturduğunuz icin teşekkürler! <a href='login.php'>Giriş yapın  !</a>";
               $formGoster = false;
            } else {
               throw new Exception("Bir şeyler ters gitti. Admin oluşturulamadı.");
            }
         } else {
            $hatalar[] = "Şifreler uyuşmuyor";
         }
      }
   } catch (Exception $e) {
      $mesaj = $e->getMessage();
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin kaydı</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <div class="hata_mesaj">
            <?php
            foreach ($hatalar as $hata) {
               echo "<span>$hata</span></br>";
            } ?>
         </div>
         <?php
         if ($formGoster)
            kayitOlmaFormu() ?>
         </main>
         <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>