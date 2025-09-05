<?php
// Veritabanı sabitleri
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'anaokulu');
define('TABLE_CLASSES', 'classes');
define('TABLE_STUDENTS', 'students');
define('TABLE_TEACHERS', 'teachers');
define('TABLE_USERS', 'users');
define('TABLE_WORKERS', 'workers');

function baglan()
{
   try {
      $baglanti = mysqli_connect(HOST, USER, PASS, database: DB);
      if ($baglanti) {
         return $baglanti;
      } else {
         throw new Exception('Bağlanılamadı');
      }
   } catch (Exception $e) {
      echo "Bir şeyler yanlış gitti. Bağlanılamadı";
      echo "Hata: " . $e->getMessage();
   }
   return null;
}

function sorgula($handle, $query)
{
   return mysqli_query($handle, $query);
}

function birKayitAl($handle, $id, $table)
{
   $query = "SELECT * FROM $table WHERE id='$id'";
   return sorgula($handle, $query);
}

function tumKayitlariAl($handle, $table, $column = null, $value = null)
{
   $query = "SELECT * FROM $table";

   if ($column !== null && $value !== null) {
      $escapedValue = mysqli_real_escape_string($handle, $value);
      $query .= " WHERE $column = '$escapedValue'";
   }

   return sorgula($handle, $query);
}

function ogrenciSayisi($handle, $class_id)
{
   $escapedClassId = mysqli_real_escape_string($handle, $class_id);
   $query = "SELECT COUNT(*) AS total FROM students WHERE class_id = '$escapedClassId'";
   $sonuc = mysqli_query($handle, $query);
   if ($sonuc) {
      $row = mysqli_fetch_assoc($sonuc);
      return $row['total'];
   } else {
      die("Sorgu başarısız: " . mysqli_error($handle));
   }
}

function birKayitSil($handle, $id, $table)
{
   $query = "DELETE FROM $table WHERE id='$id'";
   return sorgula($handle, $query);
}

function ogretmenSinifGuncelle($handle, $data, $table)
{
   $class_id = mysqli_insert_id($handle);
   $teacher_id = $data["teacher_id"];
   $query = "UPDATE $table SET class_id='$class_id' WHERE id='$teacher_id'";
   return sorgula($handle, $query);
}

function ogrenciKayitGuncelle($handle, $data, $table)
{
   $name = $data['name'];
   $surname = $data['surname'];
   $illnesses = $data['illnesses'];
   $parentName = $data['parent_name'];
   $parentPhone = $data['parent_phone'];
   $birthYear = $data['birth_year'];
   $class_id = $data['class_id'];
   $id = $data['id'];
   $query = "UPDATE $table SET name='$name',surname='$surname',illnesses='$illnesses',parent_name='$parentName',parent_phone='$parentPhone',birth_year='$birthYear',class_id='$class_id' WHERE id='$id'";
   return sorgula($handle, $query);
}

function ogretmenKayitGuncelle($handle, $data, $table)
{
   $name = $data["name"];
   $surname = $data["surname"];
   $id = $data["id"];
   $query = "UPDATE $table SET name='$name', surname='$surname' WHERE id='$id'";
   return sorgula($handle, $query);
}

function calisanKayitGuncelle($handle, $data, $table)
{
   $id = $data['id'];
   $name = $data["name"];
   $surname = $data["surname"];
   $pay = $data["pay"];
   $department = $data["department"];
   $phone_number = $data["phone_number"];
   $tc_number = $data["tc_number"];
   $query = "UPDATE $table SET name='$name', surname='$surname',pay='$pay', department='$department', phone_number='$phone_number',tc_number='$tc_number' WHERE id='$id'";
   return sorgula($handle, $query);
}

function SinifKayitGuncelle($handle, $data, $table)
{
   $name = $data["name"];
   $id = $data["id"];
   $query = "UPDATE $table SET name='$name'WHERE id='$id'";
   return sorgula($handle, $query);
}

function birKayitEkle($handle, $table, $data)
{
   $str = "";
   foreach ($data as $value) {
      $str .= "'$value',";
   }
   $str = rtrim($str, ",");
   $query = "INSERT INTO $table VALUES(NULL,$str)";
   if ($table == TABLE_USERS) {
      $query = "INSERT INTO $table VALUES(NULL,$str,0)";
   }
   return sorgula($handle, $query);
}

function ogrenciKayitiEkle($handle, $table, $data)
{
   $columns = implode(",", array_keys($data));
   $values = "";
   foreach ($data as $value) {
      $values .= "'$value',";
   }
   $values = rtrim($values, ",");
   $query = "INSERT INTO $table (id, $columns, giris_tarihi) VALUES (NULL, $values, DEFAULT)";
   return sorgula($handle, $query);
}

function ogretmenKayitiEkle($handle, $table, $data)
{
   $name = $data["name"];
   $surname = $data["surname"];
   $pay = $data["pay"];
   $query = "INSERT INTO $table (id, name, surname, class_id, pay) VALUES (NULL, '$name', '$surname', NULL, '$pay')";
   return sorgula($handle, $query);
}

function calisanKayitiEkle($handle, $table, $data)
{
   $name = $data["name"];
   $surname = $data["surname"];
   $pay = $data["pay"];
   $department = $data["department"];
   $phone_number = $data["phone_number"];
   $tc_number = $data["tc_number"];
   $query = "INSERT INTO $table (id, name, surname, pay, starting_date, department, phone_number, tc_number) VALUES (NULL, '$name', '$surname', '$pay',DEFAULT,'$department','$phone_number','$tc_number')";
   return sorgula($handle, $query);
}

function kullaniciMevcut($handle, $username, $table)
{
   $query = "SELECT * FROM $table WHERE username='$username'";
   $sonuc = sorgula($handle, $query);
   if (mysqli_num_rows($sonuc) > 0) {
      return true;
   }
   return false;
}

function sifreDogrula($handle, $username, $password, $table)
{
   $query = "SELECT password FROM $table WHERE username='$username'";
   $sonuc = sorgula($handle, $query);
   if (mysqli_num_rows($sonuc) > 0) {
      $row = mysqli_fetch_array($sonuc);
      if (password_verify($password, $row['password'])) {
         return true;
      }
   }
   return false;
}

function adminMi($handle, $username, $table)
{
   $query = "SELECT isAdmin FROM $table WHERE username = '$username'";
   $sonuc = sorgula($handle, $query);
   $kullanici = mysqli_fetch_assoc($sonuc);
   if ($kullanici['isAdmin'] == 1)
      return true;
   return false;

}

function uygunHocalar($handle, $table)
{
   $teachers = [];
   $query = "SELECT id, name, surname FROM $table WHERE class_id IS NULL";
   $sonuc = sorgula($handle, $query);
   if ($sonuc && $sonuc->num_rows > 0) {
      while ($row = $sonuc->fetch_assoc()) {
         $teachers[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'surname' => $row['surname']
         ];
      }
   }
   return $teachers;
}

function uygunSiniflar($handle, $table)
{
   $classes = [];
   $query = "SELECT * FROM $table";
   $sonuc = sorgula($handle, $query);
   if ($sonuc && $sonuc->num_rows > 0) {
      while ($row = $sonuc->fetch_assoc()) {
         $classes[] = [
            'id' => $row['id'],
            'name' => $row['name']
         ];
      }
   }
   return $classes;
}
