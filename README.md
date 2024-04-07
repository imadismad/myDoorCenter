# myDoorCenter

## Librairie et framwork utilisé
### Framework Frontend
Bootstrap est utilisé en tant que framework frontend. Il est pour le moment stocké sur un serveur distant

### Librairie JavaScript
Voici la liste des librairies externe JavaScript utilisé.
| Nom | Auteur | Lien du projet |
|-----|--------|----------------|
| LibPhoneNumber | Nikolay Kuchumov | https://gitlab.com/catamphetamine/libphonenumber-js |

Les librairies sont quand displonibles au format min afin d'optimiser au maximum le téléchargement de ces derniers.

## Paramétrage
Un fichier de configuration permet de paramétrer la connexion à la base de donnée. Ce fichier se trouve à l'emplacement : BDD/config.php.
Les variables configurables sont :
| Nom variable | Valeur par défaut | Explication |
|:--|:--:|--|
| SQL_SERVER | localhost | l'adresse du serveur SQL |
| SQL_USER | root | Le nom d'utilisateur utilisé pour la connexion |
| SQL_PASSWORD | *vide* | Le mot de passe de l'utilisateur courant |
| SQL_BDD_NAME | DW | Le nom de la base de donnée |

## Architecture
L'architecture du projet est défini comme suit :
| Dossier | Contenu |
|--|--|
| css | Dossier qui contient l'ensemble des fichiers css du projet. Les fichiers qui sont associés à une page ont le même chemin que celui de la page. Par exemple : panier/commande.php aura son fichier css à css/panier/commande.css |
| js  | Dossier qui contient l'ensemble des fichiers js du projet. Les fichiers qui sont associés à une page ont le même chemin que celui de la page. Par exemple : panier/commande.php aura son fichier js à js/panier/commande.js |
| api | Contient les script pour l'API du site. |
| bdd | Contient les fonctions pour l'interaction avec la BDD. |
| php | Contient les fonctions PHP non relative à la base de donnée (utiliateur, etc). |
