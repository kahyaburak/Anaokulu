<?php

include "config.php";

izinliMi();

$mesaj = "Yeni sınıf ekleme işlemini burada yapınız.";
$formGoster = true;
$availableTeachers = uygunHocalar($baglanti, TABLE_TEACHERS);

if (isset($_POST["submit"])) {
   unset($_POST["submit"]);
   try {
      $sonuc = birKayitEkle($baglanti, TABLE_CLASSES, $_POST);
      $sonuc2 = ogretmenSinifGuncelle($baglanti, $_POST, TABLE_TEACHERS);
      if ($sonuc) {
         $mesaj = "Sınıf ekleme işlemi başarıyla tamamlandı!";
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
   <title>Sınıf Ekle</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            sinifEklemeFormu($availableTeachers) ?>
            </main>
            <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>