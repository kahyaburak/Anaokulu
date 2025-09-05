<?php

include "config.php";

izinliMi();


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Anaokulu yönetim sistemi.</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>


   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1>Yeni bir güne merhaba Admin</h1>
         <?= tarihGoster() ?>
         <p>Yukarıdaki menü ile sayfalar arasında geçiş yapabilir, ve yeni eklemeler ile düzenlemeler ile anaokulunu
            yönetebilirsin!</p>
      </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>