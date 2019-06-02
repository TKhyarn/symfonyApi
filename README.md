Anaxago symfony-starter-kit
===================

# Description

Ce projet est un kit de démarage avec :
- Symfony 3.4 minimum
- php 7.1 minimum

La base de données contient trois tables :
- user => pour la gestion et la connexion des utilisateurs 
- project => pour la liste des projets
- interest => pour la liste des projets qui interessent les utilisateurs

Les données préchargés sont
- pour les users 

| email     | password    | Role |
| ----------|-------------|--------|
| john@local.com  | john   | ROLE_USER    |
| admin@local.com | admin | ROLE_ADMIN   | 

 - une liste de 3 projets
 
 - 3 lignes dans la table interest
 
La connexion et l'enregistrement des utilisateurs sont déjà configurés et opérationnels


# Installation
- ```composer install```
- ```composer init-db ```

    - Script personnalisé permet de créer la base de données, de lancer la création du schéma et de précharger les données
    - Ce script peut être réutilisé pour ré-initialiser la base de données à son état initial à tout moment

# Description de l'api

##### Get("api/projects")
Liste l'ensemble des projets et leurs informations de la table project au format json

##### Get("api/projects/{id}")
Retourne au format json les informations du projet portant l'identifiant {id}

##### Post("api/auth-tokens")
Retourne un token d'identification à rajouter dans le header : X-Auth-Token => value
Format du json à envoyer: 
```json
{
	"login":"john@local.com",
	"password":"john"
}
```
##### Get("api/interests")
Liste les interets de l'utilisateur identifié

##### POST("api/interests")
Permet à un utilisateurs de marquer son interet envers un projet et d'investir.
Format du json à envoyer:
```json
{
	"project_id":1,
	"amount":2
}
```
# TODO :
- Implémenter des tests fonctionnels 
- Renforcer la gestion d'erreur
- Chercher du coté des events listener pour réaliser mailer les investisseurs lorsque le projet est financé. Ou sinon comparer les valeurs des champs invested et cost. Si invested >= cost on cherche dans la table interest tous les users qui ont investi et on envoit un mail avec swiftmailer.
