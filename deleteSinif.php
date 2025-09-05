<?php

include "config.php";

izinliMi();

$mesaj = "";

if (isset($_GET["id"])) {
   $id = $_GET["id"];
   try {
      $sonuc = birKayitSil($baglanti, $id, TABLE_CLASSES);
      if ($sonuc) {
         $mesaj = "Sınıf başarıyla silindi!";
      } else {

         throw new Exception("Sınıf silinemedi");
      }
   } catch (Exception $e) {
      $mesaj = $e->getMessage();
      if ($e->getCode() === 1451) {
         $mesaj = "Sınıf silmeden önce sınıfın öğretmenini ve öğrencilerini silmelisiniz.";
      }
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
      </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>