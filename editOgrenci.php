<?php

include "config.php";

izinliMi();
$musaitSinif = uygunSiniflar($baglanti, TABLE_CLASSES);

$mesaj = "Ogrenci icin degisiklikleri asagida yapiniz.";
$formGoster = false;

if (isset($_GET["id"])) {
   $id = $_GET["id"];
   try {
      $sonuc = birKayitAl($baglanti, $id, TABLE_STUDENTS);
      if ($sonuc) {
         $formGoster = true;
      } else {

         throw new Exception("Öğrenci bulunamadı.");
      }
   } catch (Exception $e) {
      $mesaj = $e->getMessage();
   }
}

if (isset($_POST["submit"])) {
   try {
      $sonuc = ogrenciKayitGuncelle($baglanti, $_POST, TABLE_STUDENTS);
      if ($sonuc) {
         $mesaj = "Değişiklikler kaydedildi!";
         $formGoster = false;
      } else {
         throw new Exception("Bir şeyler ters gitti.");
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
   <title>Öğrenci</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            ogrenciDuzenlemeFormu($sonuc, $musaitSinif) ?>
         </main>
         <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>