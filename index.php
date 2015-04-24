<?php
// prendre le pot
include (dirname(__FILE__).'/teipot/Teipot.php');
// mettre le sachet SQLite dans le pot
$pot=new Teipot(dirname(__FILE__).'/bibdramatique.sqlite', 'fr');
// est-ce qu’un fichier statique (ex: epub) est attendu pour ce chemin ? 
// Si oui, l’envoyer maintenant depuis la base avant d’avoir écrit la moindre ligne
$pot->file($pot->path);
// Si un document correspond à ce chemin, charger un tableau avec différents composants (body, head, breadcrumb…)
$doc=$pot->doc($pot->path);
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
  echo $pot->biblio(array('byline', 'title', 'date', 'editor', 'download')); // présentation bibliographique des résultats
  echo $pot->concByBook(); // concordance s’il y a recherche plein texte
  
  ?><div class="linkOld" style="width: 100%; text-align: center;"><a style="color: gray; font-size: 14px; border-bottom: none;" href="http://www.bibliothequedramatique.fr/">Suite des pièces…</a><span style="width: 20px; white-space: nowrap;"></span>|<span style="width: 20px; white-space: nowrap;"</span><a style="color: gray; font-size: 14px; border-bottom: none;" href="http://cellf.paris-sorbonne.fr">Site du CELLF</a></div><?php
  
}
      ?>
      
      
      
      
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
	<span id="ruler"></span>
      </aside>
      
    </div>
    
    
    
    <footer id="footer">

    </footer>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Tree.js">//</script>
    <script type="text/javascript" src="<?php echo $themeHref; ?>Sortable.js">//</script>
    
    
    <!-- Pour l'alignement des vers -->
    <script type="text/javascript">
        
        function getStringWidth(theString) {
        	$("#ruler").html(theString);
        	return $("#ruler").width();
      	}
        
        
        (function() {
        // Cool! il y a juste des IE un peu paumés, mais tant pis , c’est trop simple http://quirksmode.org/dom/core/#t11
        var tempText;
        var theGoodPrevious;
        var verse;
        var op;
      
      	$("#ruler").addClass("l");
        
        $(".part-Y").each(function() {
        
        
        	theGoodPrevious = $(this).parent().prev(".sp").find(".l").last();
        	//theGoodPrevious = theGoodPrevious.remove(".l-n");
       		
        	var sizeOf = getStringWidth(theGoodPrevious.html());
        	//var sizeOf = getStringWidth(test.prev(".l").html());¨
        	
        	if ($(this).find(".l-n").length) {
        		verse = $(this).find(".l-n")[0].outerHTML;
        		$(this).find(".l-n").empty();
        		tempText = verse + "<span class=\"space\" style=\"width:" + sizeOf + "px\"></span>" + $(this).html();
        	}
        	else {
        		tempText = "<span class=\"space\" style=\"width:" + sizeOf + "px\"></span>" + $(this).html();
        	}
       
        	$(this).html(tempText); 
        })
    })();
    <!-- Fin -->
    </script>    <!-- Fin -->
    
    
  </body>
  
  
</html>
