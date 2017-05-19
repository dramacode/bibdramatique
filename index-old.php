<?php
$pdo = new PDO('sqlite:'.dirname(__FILE__).'/bibdramatique.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$qobj = $pdo->prepare("SELECT * FROM object WHERE playcode = ? AND type = ?");
// $play = $pdomol->query("SELECT * FROM play WHERE code = ".$pdomol->quote($playcode))->fetch();

$themeHref = Web::basehref() . 'teipot/';


?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <?php
if(isset($doc['head'])) echo $doc['head'];
else echo '<title>Bibliothèque dramatique</title>';
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $themeHref; ?>html.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $themeHref; ?>teipot.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Web::basehref() ?>bibdramatique.css" />
    
    <script type="text/javascript" src="<?php echo Web::$basehref ?>js/jquery-1.11.1.min.js"></script>
  </head>
  <body class="fixed">
    <div id="center">
      <header id="header">
        <h1>
           <a href="<?php echo Web::basehref() ?>">Bibliothèque dramatique</a>  |  <a href="http://cellf.paris-sorbonne.fr">Le CELLF</a>

        </h1>
        <?php // liens de téléchargements
          // if ($doc['downloads']) echo "\n".'<nav id="downloads"><small>Télécharger :</small> '.$doc['downloads'].'</nav>';
        ?>
      </header>
      <div id="main">
        <nav id="toolbar">
          <?php
  echo '<a href="' . Web::basehref() . '">Bibliothèque dramatique</a> » ';
          // nous avons un livre, glisser aussi les liens de téléchargement
  if (isset($doc['breadcrumb'])) echo $doc['breadcrumb'];
          ?>
        </nav>
        <div id="article">
        <?php
  if (isset($doc['bookname'])) {

    if (isset($doc['body'])) echo $doc['body'];
    else {}; // bug back
    // page d’accueil d’un livre avec recherche plein texte, afficher une concordance
    if ($pot->q && (!$doc['artname'] || $doc['artname']=='index')) echo $pot->concBook($doc['bookname']);
  }
  // pas de livre demandé, montrer un rapport général
  else {
    $pot->search(); // charger des résultats en mémoire
    // echo $pot->chrono(); // chronologie, bof, moins clair que le tableau
    echo $pot->report(); // nombre de résultats
    echo $pot->biblio(array('byline', 'title', 'date', 'editor', 'download'=>array('epub', 'html', 'pdf', 'tei', 'txt'))); // présentation bibliographique des résultats
    echo $pot->concByBook(); // concordance s’il y a recherche plein texte

    ?><div class="linkOld" style="width: 100%; text-align: center;"><a style="color: gray; font-size: 14px; border-bottom: none;" href="http://www.bibliothequedramatique.fr/">Suite des pièces…</a><span style="width: 20px; white-space: nowrap;"></span>|<span style="width: 20px; white-space: nowrap;"</span><a style="color: gray; font-size: 14px; border-bottom: none;" href="http://cellf.paris-sorbonne.fr">Site du CELLF</a></div><?php

  }
        ?>




        </div>
      </div>
      <aside id="aside">
        <p> </p>
          <?php
// livre
if (isset($doc['bookname'])) {
  if(isset($doc['download'])) echo "\n".'<nav id="download">' . $doc['download'] . ', <a href="../' . $doc['bookname'] . '.pdf">pdf</a>' . '</nav>';
  echo "\n<nav>";
  // auteur, titre, date
  if ($doc['byline']) $doc['byline']=$doc['byline'].'<br/>';
  echo "\n".'<header><a href="' . Web::basehref() . $doc['bookname'] . '/">' . $doc['byline'] . $doc['title'] . ' (' . $doc['end'] . ')</a></header>';
  // table des matières
  echo $doc['toc'];
  echo "\n</nav>";
}
// accueil ? formulaire de recherche général
else {
  echo'
    <form action="" style="text-align:center">
      <input name="q" placeholder="Rechercher" class="text" value="'.str_replace('"', '&quot;', $pot->q).'"/>
      <button type="submit">Rechercher</button>
    </form>
  ';
}
?>
      </aside>

    </div>


    <script type="text/javascript" src="<?php echo $themeHref; ?>Tree.js">//</script>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Sortable.js">//</script>



  </body>


</html>
