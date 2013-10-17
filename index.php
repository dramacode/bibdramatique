<?php
// prendre le pot
include (dirname(__FILE__).'/teipot/Teipot.php');
// mettre le sachet SQLite dans le pot
$pot=new Teipot(dirname(__FILE__).'/crht.sqlite', 'fr');
// est-ce qu’un fichier statique (ex: epub) est attendu pour ce chemin ? 
// Si oui, l’envoyer maintenant depuis la base avant d’avoir écrit la moindre ligne
$pot->file($pot->path);
// Si un document correspond à ce chemin, charger un tableau avec différents composants (body, head, breadcrumb…)
$doc=$pot->doc($pot->path);
// chemin css, js ; baseHref est le nombre de '../' utile pour revenir en racine du site
$themeHref=$pot->baseHref.'teipot/';


?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <?php echo $doc['head']; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $themeHref; ?>html.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $themeHref; ?>teipot.css" />
  </head>
  <body>
    <header id="header">
      <h1>
        <a href="<?php echo $pot->baseHref; ?>">CRHT, prototype</a>
      </h1>
      <?php // liens de téléchargements
        // if ($doc['downloads']) echo "\n".'<nav id="downloads"><small>Télécharger :</small> '.$doc['downloads'].'</nav>';
      ?>
    </header>
    <div id="center">
      <nav id="toolbar">
        <?php 
        echo '<a href="',$pot->baseHref,'">CRHT</a> » ';
        // nous avons un livre, glisser aussi les liens de téléchargement
        echo $doc['breadcrumb']; 
        ?>
      </nav>
      <div id="main">
      <?php
if ($doc['body']) {
  echo $doc['body'];
  // page d’accueil d’un livre avec recherche plein texte, afficher une concordance
  if ($pot->q && (!$doc['artName'] || $doc['artName']=='index')) echo $pot->concBook($doc['bookId']);
}
// pas de livre demandé, montrer un rapport général
else {
  // charger des résultats en mémoire
  $pot->search();
  // nombre de résultats
  echo $pot->report();
  // présentation bibliographique des résultats
  echo $pot->biblio(array('author','title','date'));
  // concordance s’il y a recherche plein texte
  echo $pot->conc();
}
      ?>
      </div>
      <aside id="aside">
        <p> </p>
          <?php
// livre
if ($doc['bookId']) {
  echo "\n<nav>";
  // auteur, titre, date
  if ($doc['byline']) $doc['byline']=$doc['byline'].'<br/>';
  echo "\n".'<header><a href="'.$pot->baseHref.$doc['bookName'].'/">'.$doc['byline'].$doc['title'].' ('.$doc['end'].')</a></header>';
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
    <footer id="footer">
      Prototype d'application TEI
    </footer>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Tree.js">//</script>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Sortable.js">//</script>
    <script type="text/javascript"><?php echo $doc['js']; ?></script>  
  </body>
</html>