<?php
$path="";
if (isset($_SERVER['PATH_INFO'])) $path=preg_replace('@/+@', '/',ltrim($_SERVER['PATH_INFO'], '/'));
if (substr($path, -strlen('chrono.png')) === 'chrono.png') {
  // prendre le pot
  include (dirname(__FILE__).'/teipot/Teipot.php');
  // mettre le sachet SQLite dans le pot
  $pot=new Teipot(dirname(__FILE__).'/crht.sqlite', 'fr');
  // si on demande une version png d’une requête, la sortir ici
  header('Content-Type: image/png');
  echo $pot->chronoPng();
  exit;
}
if (!isset($_REQUEST['start'])) $_REQUEST['start']='';
if (!isset($_REQUEST['end'])) $_REQUEST['end']='';
if (!isset($_REQUEST['q'])) $_REQUEST['q']='';

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Chronologies multiples</title>
    <style type="text/css">
.noselect { -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; -o-user-select: none; user-select: none; }
    </style>
  </head>
  <body>
    <?php
  echo'
    <form action="">
      <div><label>De <input name="start" class="year" type="number" size="5" maxlength="4" placeholder="année" value="'.$_REQUEST['start'].'"/></label> <label>à <input class="year" type="number" size="5" maxlength="4" placeholder="année" name="end" value="'. $_REQUEST['end'] .'"/></label></div>
      <textarea name="q" rows="20" cols="100" wrap="off" required="required" placeholder="Indiquez une ou plusieurs expressions à chercher (une par ligne)">'.$_REQUEST['q'].'</textarea>
      <br/><button type="submit">Rechercher</button>
    </form>
  ';

    // print_r($pot->chronoData());
    // echo $pot->chrono();
    // echo '<img src="data:image/png;base64,' . base64_encode($pot->chronoPng()). '"/>'; // marche mais n’est pas copié-collable
    
    $lines= preg_split("/[\r\n]+/", $_REQUEST['q']);
    foreach ($lines as $q) {
      if (!$q=trim($q)) continue;
      echo "\n<p>".'<img src="chrono.php/chrono.png?q='.str_replace('"', '&quot;', $q).'&start='.$_REQUEST['start'].'&end='.$_REQUEST['end'].'"/></p>';
    }
    ?>
  </body>
</html>