# projet_toilettes

## Prérequis

En ligne de commande, faire:

```
composer install
```

## Au quotidien

Pour utiliser ce projet en local, il faut faire:

```
xampp --> php -S localhost:8000 -t public
```

docker --> docker-compose up -d

linux      docker compose up -d

## Attention !

Quand on clone ce repository, il faut avoir configuré git pour ne pas forcer les sauts de ligne en CRLF:

`git config --global core.autocrlf false`

C'est important car les fichiers `*.sh` doivent contenir des `\n` (car exécutés sur Linux), pas des `\r\n` (de Windows).

Utilise avec docker, il fait créer le fichier .htaccess dans le dossier public
`composer require symfony/apache-pack`
Do you want to execute this recipe? [y]

`sudo service mysql stop`
