# HowTo?
*HowTo?* est une application web sous Symfony 5.2.5 permettant de créer, suivre et partager des tutoriels.

## Commande
Créer un utilisateur super-admin: ```php bin/console app:create-user```

## Fonctionnalités de la Version 1
- Ecrire des tutoriels;
- Capacité à utiliser du MarkDown pour l'écriture du tutoriel;
- L'auteur peut ajouter des questions et des réponses à son tutoriel;
- Un utilisateur connecté peut répondre au quiz pour accumuler des points.

## Fonctionnalités pour une Version 2
- Une boutique de points;
- Une page de profile personnalisable avec les cosmetiques achetés sur la boutique de points;
- Des succès à atteindre (obtenir un certain nombre de 'Like', créer un certain nombre de tutoriel, obtenir un certain nombre de points...);

## Traductions
- Ajouter les variables de traductions dans *src/translations/messages.[fr/en].yaml*, exemple: ```navbar:tutorials: Tutorials```
- Puis ajouter ces variables de traduction dans le Twig, exemple ```{% trans %}navbar.tutorials{% endtrans %}```

Puis lancer la génération automatique des variables dans les fichiers de traductions (*src/translations/*) avec les commandes suivantes:
- Pour générer les variables de traduction en français: ```php bin/console translation:update --force fr```
- Pour générer les variables de traduction en anglais: ```php bin/console translation:update --force en```

## Sources
- Traduction: [Nouvelle-Techno: Créer un site multilingue avec Symfony 4](https://nouvelle-techno.fr/actualites/live-coding-creer-un-site-multilingue-avec-symfony-4)

## Heruku
L'application est déployée sur Heroku : https://howtotutorial.herokuapp.com/
