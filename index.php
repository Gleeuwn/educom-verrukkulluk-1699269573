<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$keu = new keuken_type($db->getConnection());
$ing = new ingredient($db->getConnection());





/// VERWERK 
$data = $art->selecteerArtikel(1);
$data_user = $usr->selecteerUser(2);
$data_keuk = $keu->selecteerKeuken_Type(4);
$data_ingr = $ing->selecteerIngredient(1);




/// RETURN
var_dump($data_ingr);
echo "<br><br><br>";
echo "<br><br><br>";
echo "<br><br><br>";


