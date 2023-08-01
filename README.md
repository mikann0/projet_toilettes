# projet_toilettes

## Prérequis

En ligne de commande, faire:

```
composer install
```

## Au quotidien

Pour utiliser ce projet en local, il faut faire:

```
php -S localhost:8000 -t public
```

## Attention !

Quand on clone ce repository, il faut avoir configuré git pour ne pas forcer les sauts de ligne en CRLF:

`git config --global core.autocrlf false`

C'est important car les fichiers `*.sh` doivent contenir des `\n` (car exécutés sur Linux), pas des `\r\n` (de Windows).