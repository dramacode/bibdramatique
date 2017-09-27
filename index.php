<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Bibliothèque dramatique du CELLF</title>
    <link rel="stylesheet" type="text/css" href="http://oeuvres.github.io/Teinte/tei2html.css" />
  </head>
  <body>
    <main id="center">
      <article id="article">
        <h1><a href="http://bibdramatique.paris-sorbonne.fr/">Bibliothèque dramatique</a> source XML/TEI</h1>
        <table class="sortable">
          <thead>
            <tr>
              <th>Auteurs</th>
              <th>Titre</th>
              <th>Date</th>
              <th>Éditeurs</th>
            </tr>
          </thead>
          <tbody>
          <?php
include_once( "../../Teinte/Doc.php" );
foreach( glob( "*_*.xml") as $file ) {
  $doc = new Teinte_Doc( $file );
  $meta = $doc->meta();
  echo '
<tr>
  <td class="byline">'.$meta['byline'].'</td>
  <td class="title">
    <a href="'.basename( $file ).'">'.$meta['title'].'</a>
  </td>
  <td class="date">'.$meta['date'].'</td>
  <td class="editor">'.$meta['editby'].'</td>
</tr>
  ';
}
          ?>
          </tbody>
        </table>
      </article>
    </main>
    <script src="http://oeuvres.github.io/Teinte/Sortable.js">//</script>
  </body>
</html>
