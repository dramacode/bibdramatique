<?php
ini_set('display_errors', '1');
error_reporting(-1);
$conf = include( dirname(__FILE__)."/conf.php" );
include( dirname(dirname(__FILE__))."/Teinte/Web.php" );
include( dirname(dirname(__FILE__))."/Teinte/Base.php" );
$base = new Teinte_Base( $conf['sqlite'] );
$path = Teinte_Web::pathinfo(); // document demandé
$basehref = Teinte_Web::basehref(); //
$teinte = $basehref."../Teinte/";

// chercher le doc dans la base
$docid = current( explode( '/', $path ) );
$query = $base->pdo->prepare("SELECT * FROM doc WHERE code = ?; ");
$query->execute( array( $docid ) );
$doc = $query->fetch();

$q = null;
if ( isset($_REQUEST['q']) ) $q=$_REQUEST['q'];

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?php
if( $doc ) echo $doc['title'].' — ';
echo 'Bibliothèque dramatique, CELLF';
    ?></title>
    <link rel="stylesheet" type="text/css" href="<?= $teinte ?>tei2html.css" />
  </head>
  <body id="top">
    <div id="center">
      <header id="header">
        <h1><a href="<?php echo $basehref ?>">Bibliothèque dramatique</a>  |  <a href="http://cellf.paris-sorbonne.fr">Le CELLF</a></h1>
      </header>
      <div id="contenu">
        <aside id="aside">
          <?php
if ( $doc ) {
  // if (isset($doc['download'])) echo $doc['download'];
  // auteur, titre, date
  echo '
<header>
  <a class="title" href="' . $basehref . $doc['code'] . '">'.$doc['title'].'</a>
</header>
<form action="#mark1">
  <a title="Retour aux résultats" href="'.$basehref.'?'.$_COOKIE['lastsearch'].'"><img src="'.$basehref.'../theme/img/fleche-retour-corpus.png" alt="←"/></a>
  <input name="q" value="'.str_replace( '"', '&quot;', $base->p['q'] ).'"/><button type="submit">🔎</button>
</form>
';

  // table des matières, quand il y en a une
   if ( file_exists( $f="toc/".$doc['code']."_toc.html" ) ) readfile( $f );
}
// accueil ? formulaire de recherche général
else {
  echo'
<form action="">
  <input style="width: 100%;" name="q" class="text" placeholder="Rechercher de mots" value="'.str_replace( '"', '&quot;', $base->p['q'] ).'"/>
  <button type="reset" onclick="return Form.reset(this.form)">Effacer</button>
  <button type="submit" style="float: right; ">Rechercher</button>
</form>
  ';
}
          ?>
        </aside>
        <div id="main">
          <nav id="toolbar">
            <?php
            ?>
          </nav>
          <div id="article" class="<?php echo $doc['class']; ?>">
            <?php
if ( $doc ) {
  $html = file_get_contents( "article/".$doc['code']."_art.html" );
  if ( $q ) echo $base->hilite( $doc['id'], $q, $html );
  else echo $html;
}
else if ( $base->search ) {
  $base->biblio( array( "no", "creator", "date", "title", "occs" ), "SEARCH" );
}
// pas de livre demandé, montrer un rapport général
else {
  $base->biblio( array( "no", "creator", "date", "title", "editor", "downloads" ) );
  /*
  TODO search
  // nombre de résultats
  echo $pot->report();
  // présentation chronologique des résultats
  echo $pot->chrono();
  // présentation bibliographique des résultats
  echo $pot->biblio(array('date', 'byline', 'title', 'occs'));
  // concordance s’il y a recherche plein texte
  echo $pot->concByBook();
  */
}
            ?>
            <a id="gotop" href="#top">▲</a>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="<?= $teinte ?>Teinte.js">//</script>
    <script type="text/javascript" src="<?= $teinte ?>Tree.js">//</script>
    <script type="text/javascript" src="<?= $teinte ?>Sortable.js">//</script>
  </body>
</html>
<?php
function downloads( $code ) {
  $html = array();
  $html[] = '<a href="'.$basehref.'epub/'.$code.'.epub">epub</a>';
  $html[] = '<a href="'.$basehref.'kindle/'.$code.'.mobi">kindle</a>';
  $html[] = '<a target="_new" href="'.$basehref.'xml/'.$code.'.xml">tei</a>';
  $html[] = '<a target="_new" href="'.$basehref.'pdf/'.$code.'.pdf">pdf</a>';
  return implode( ", ", $html );
}
 ?>
