<?php

include "config.php";

izinliMi();

$mesaj = "Sınıf için değişiklikleri aşağıda yapınız..";
$formGoster = false;

if (isset($_GET["id"])) {
   $id = $_GET["id"];
   try {
      $sonuc = birKayitAl($baglanti, $id, TABLE_CLASSES);
      if ($sonuc) {
         $formGoster = true;
      } else {

         throw new Exception("Sınıf bulunamadı.");
      }
   } catch (Exception $e) {
      $mesaj = $e->getMessage();
   }
}

if (isset($_POST["submit"])) {
   try {
      $sonuc = SinifKayitGuncelle($baglanti, $_POST, TABLE_CLASSES);
      if ($sonuc) {
         $mesaj = "Değişiklikler yapıldı!";
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
   <title>Sınıf</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            sinifDuzenlemeFormu($sonuc) ?>
            </main>
            <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>