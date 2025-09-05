<?php

include "config.php";

izinliMi();

$mesaj = "Yeni Öğretmen ekleme işlemini burada yapınız.";
$formGoster = true;
if (isset($_POST["submit"])) {
   unset($_POST["submit"]);
   try {
      $sonuc = ogretmenKayitiEkle($baglanti, TABLE_TEACHERS, $_POST);
      if ($sonuc) {
         $mesaj = "Öğretmen ekleme işlemi başarıyla tamamlandı!";
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
   <title>Öğretmen Ekle</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            ogretmenEklemeFormu() ?>
            </main>
            <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>