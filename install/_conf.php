<?php
return array(
  "srcdir" => dirname( __FILE__ ), // dossier à mettre à jour
  "cmdup" => "git pull 2>&1", // commande de mise à jour dans le dossier srcdir (git préféré, svn possible)
  "pass" => NULL, // mot de passe à modifier, sinon impossible de mettre à jour
  "srcglob" => array( "xml/*.xml" ), // listes de dossiers à parcourir pour créer le site
  "sqlite" => "bibdramatique.sqlite", // nom de la base
  "formats" => "article, toc, epub, kindle", // formats à produire
  "logfile" => dirname( __FILE__ )."/admin.log", // enregistrement des opération effectuées sur l‘installation
);
?>
