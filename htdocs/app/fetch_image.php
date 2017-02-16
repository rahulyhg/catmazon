<?php

header("content-type:image/jpeg");

$host = 'localhost';
$user = 'root';
$pass = '';

mysql_connect($host, $user, $pass);

mysql_select_db('catmazon');

$id=$_GET['id'];

$select_image="select * from image where id='$id'";

$var=mysql_query($select_image);

if($row=mysql_fetch_array($var))
{
 $image_content=$row["image"];
}
echo $image;
?>