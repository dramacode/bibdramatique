# bibdramatique
Installation web de la Bibliothèque dramatique du CELLF, Université Paris-Sorbonne.

Ces instructions n’indiqueront aucun mots de passes mais sont laissées à ceux qui
reprendraient le projet.

## Structure des dossiers (et droits)

L’application produit beaucoup de données et de fichiers, ce qui demande
à ce que PHP (ici utilisateur apache) puisse écrire dans certains dossiers.

drwxrwsr-x 11 cellf cellf  4,0K mai 19 15:48 .

# dossiers contenant les différents formats exportables
# si apache ne peut pas écrire dans ., créer ses dossiers à l’avance
# en autorisant l’écriture à Apache/PHP

drwxrwsr-x  2 cellf apache  12K mai 19 17:11 article
drwxrwsr-x  2 cellf apache  12K mai 19 17:09 kindle
drwxrwsr-x  2 cellf apache  12K mai 19 17:11 toc
drwxrwsr-x  2 cellf apache  12K mai 19 17:11 epub

# dossier contenant la base de données sqlite produite par l’application
# Apache/PHP doit pouvoir écrire dans le dossier

drwxrwsr-x  2 cellf apache 4,0K mai 19 17:11 data

# dossier contenant les documents xml
# mis à jour par l’application avec une commande git
# mkdir xml
# git clone https://github.com/dramacode/bibdramatique.git xml
# chown -R cellf:apache xml
# chmod -R g+ws xml

drwxrwsr-x  4 cellf apache  12K mai 19 17:11 xml

# Librairies externes , pour transformations, contrôlées par l'administrateur
# Attention avant de mettre à jour, à vérifier avec un développeur

# git clone https://github.com/oeuvres/Livrable.git
drwxrwsr-x  5 root   cellf  4,0K mai 19 15:45 Livrable
# git clone https://github.com/oeuvres/Teinte.git
drwxrwsr-x  3 root   cellf  4,0K mai 19 15:32 Teinte

# Pages personnalisables, se trouvent dans xml/install

-rw-r--r--  1 root   root    637 mai 19 15:29 conf.php
-rw-r--r--  1 root   root    346 mai 19 15:48 .htaccess
-rw-rw-r--  1 cellf cellf  3,9K mai 19 15:38 index.php
-rw-r--r--  1 root   root   1,5K mai 19 15:41 pull.php

# dossier directement administré par Amélie Canu

drwxr-xr-x  2 acanu  cellf  4,0K mai 19 15:24 pdf
