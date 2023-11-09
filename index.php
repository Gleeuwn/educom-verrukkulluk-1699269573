<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");
require_once("lib/gerecht.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$keu = new keuken_type($db->getConnection());
$ing = new ingredient($db->getConnection());
$gei = new gerecht_info($db->getConnection());
$ger = new gerecht($db->getConnection());



/// VERWERK 
$data = $art->selecteerArtikel(1);
$data_user = $usr->selecteerUser(2);
$data_keuk = $keu->selecteerKeuken_Type(4);
$data_ingr = $ing->selecteerIngredient(1);

$data_geri = $gei->selecteerGerecht_info(1,'O');

$data_gere = $ger->ophalenGerecht(1);
$data_calo = $ger->calcCalories(1);
$data_prij = $ger->calcPrijs(1);
$data_beoo = $ger->selecteerBeoordeling(1);
$data_bere = $ger->selecteerBereidingswijze(1);
$data_opme = $ger->selecteerOpmerkingen(1);
$data_keuk = $ger->selecteerKeuken(1);
$data_type = $ger->selecteerType(1);
$data_detf = $ger->determineFavorite(1,1);



/// RETURN
var_dump($data_geri);
echo "<br><br><br>";
var_dump($data_gere);
echo "<br><br><br>";
var_dump($data_calo);
echo "<br><br><br>";
var_dump($data_prij);
echo "<br><br><br>";
var_dump($data_beoo);
echo "<br><br><br>";
var_dump($data_bere);
echo "<br><br><br>";
var_dump($data_opme);
echo "<br><br><br>";
var_dump($data_detf);
echo "<br><br><br>";
var_dump($data_keuk);
echo "<br><br><br>";
var_dump($data_type);

