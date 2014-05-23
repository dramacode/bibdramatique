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
    <?php 
if(isset($doc['head'])) echo $doc['head'];
else echo '<title>Bibliothèque dramatique</title>';
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $themeHref; ?>html.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $themeHref; ?>teipot.css" />
    <link rel="stylesheet" type="text/css" href="../crht.css" />
  </head>
  <body class="fixed">
    <div id="center">
      <header id="header">
        <h1>
          <a href="<?php echo $pot->baseHref; ?>">Bibliothèque dramatique, prototype</a>
        </h1>
        <?php // liens de téléchargements
          // if ($doc['downloads']) echo "\n".'<nav id="downloads"><small>Télécharger :</small> '.$doc['downloads'].'</nav>';
        ?>
      </header>
      <nav id="toolbar">
        <?php 
echo '<a href="',$pot->baseHref,'">Bibliothèque dramatique</a> » ';
        // nous avons un livre, glisser aussi les liens de téléchargement
if (isset($doc['breadcrumb'])) echo $doc['breadcrumb']; 
        ?>
      </nav>
      <div id="article">
      <?php
if (isset($doc['body'])) {
  echo $doc['body'];
  // page d’accueil d’un livre avec recherche plein texte, afficher une concordance
  if ($pot->q && (!$doc['artname'] || $doc['artname']=='index')) echo $pot->concBook($doc['bookid']);
}
// pas de livre demandé, montrer un rapport général
else {
  // charger des résultats en mémoire
  $pot->search();
  // nombre de résultats
  echo $pot->report();
  // présentation bibliographique des résultats
  echo $pot->biblio(array('byline', 'title', 'date', 'download'));
  // concordance s’il y a recherche plein texte
  echo $pot->concByBook();
  
  ?><div class="linkOld" style="width: 100%; text-align: center;"><a style="color: gray; font-size: 14px; border-bottom: none;" href="http://www.crht.paris-sorbonne.fr/">Suite des pièces…</a></div><?php
  
}
      ?>
      
      
      
      
      </div>
      <aside id="aside">
        <p> </p>
          <?php
// livre
if (isset($doc['bookid'])) {
  echo "\n<nav>";
  // auteur, titre, date
  if ($doc['byline']) $doc['byline']=$doc['byline'].'<br/>';
  echo "\n".'<header><a href="'.$pot->baseHref.$doc['bookname'].'/">'.$doc['byline'].$doc['title'].' ('.$doc['end'].')</a></header>';
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
      <span id="ruler"></span>
    </div>
    
    
    
    <footer id="footer">

    </footer>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Tree.js">//</script>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Sortable.js">//</script>
    <script type="text/javascript"><?php echo $doc['js']; ?></script>  
    
    
    <!-- Pour l'alignement des vers -->
    
    <script type="text/javascript">
    
    function getStringWidth(theString) {
    	var ruler = document.getElementById('ruler');
    	ruler.innerHTML=theString;
    	return ruler.offsetWidth;
    }
    
    
    (function() {
    var theVerses = document.getElementsByClassName('part-Y');
    var tempText;
	var theGoodPrevious;
    
    	for (var i = 0; i < theVerses.length; i++) {
    		theGoodPrevious = theVerses[i].previousElementSibling;	
    		while (theGoodPrevious.className.indexOf("l") == -1) {
    			theGoodPrevious = theGoodPrevious.previousElementSibling;
    		}
    		
    		var sizeOf = getStringWidth(theGoodPrevious.innerHTML);
    		var tempText = "<span class=\"space\" style=\"width:" + sizeOf + "px\"></span>" + theVerses[i].innerHTML;
    		theVerses[i].innerHTML=tempText;
    	}
    })();
    
    </script>
    <!-- Fin -->
    
    
  </body>
  
  
</html>
