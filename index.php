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
/*$ger = new gerecht($db->getConnection());
*/


/// VERWERK 
$data = $art->selecteerArtikel(1);
$data_user = $usr->selecteerUser(2);
$data_keuk = $keu->selecteerKeuken_Type(4);
$data_ingr = $ing->selecteerIngredient(1);

$data_geri = $gei->selecteerGerecht_info(1);
/*
$data_gere = $ger->selecteerGerecht(1);
$data_calo = $ger->calcCalories(1);
$data_prij = $ger->calcPrijs(1);
*/


/// RETURN
var_dump($data_ingr);
echo "<br><br><br>";
var_dump($data_geri);
echo "<br><br><br>";
/*var_dump($data_calo);
echo "<br><br><br>";
var_dump($data_prij);
*/

