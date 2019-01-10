KIKIPAIE
========================

Logiciel de répartition de dépense pour groupe humain. 
(todo decrire le projet).


Equipe 
--------------------------
Réaliser dans le cadre de la formation HumanBooster @ Bel Air Camp (2018/2019).

__ROLES :__ 

* Agent volant (consultant) : Oli et Jordan
* Template en twig (mise en forme avec twig): Marlene et Martin 
* Algorithme (réalisation de l'algo et page de calcul) : Théo et Nicolas
* Création nouveau budget (form de budget) : Wahid
* Ergonomie maquettage : Marlene et Oli
* Git + GitHub : Marlene
* Logo : Marlène
* Formulaire suppression et modification des participants : Hue et Jeremy
* Formulaire de supression de groupe : Issa, Wahid et Olivier
* Documentation : Saifi et Marion


Pour récuperer la BDD : SLACK Dev Web Villeurbanne !

coding rules
=================
    
* le nom des variables en anglais
* utilisation de symfony
* pensez à lire la documentation de symfony

Requirements 
===============
* Php 7.2


Installation Step By Step
=========================
1./ Cloner le projet depuis github

     git clone https://github.com/JeremyGuzzo/kikipaie.git

2./ Allez dans le répertoire récupérer

     cd kikipaie/

3./ Récupérer via composer les dépendances du projet

    composer install

4./ Configurer la base de donnée
Editer le fichier .env pour ajouter votre nom de base de donnée, login et mots de passe
mysql.
(Eg: DATABASE_URL=mysql://student:M0T_de_Passe@127.0.0.1:3306/kikipaye)

5./ Créer la base de données

     php bin/console doctrine:database:create

6./ Créer les tables etc...

     php bin/console doctrine:migrations:migrate

7./ Lancer le serveur php web-server

    php bin/console server:run

8./ Accéder au site web via un navigateur
http://127.0.0.1:8000

Problèmes et failles de sécurité
=================================
Problème rencontré lors de la création de la bdd avec doctrine

    Détail : la commande "php bin/console make:migration" nous renvoyait une erreur et ne créait pas la table "user".

    Solution : dump de la bdd de jérémy, tout fonctionnne.

fonctionnalités
================

* ajouter /supprimer des budgets
* ajouter /supprimer /modifier les participants
* calcul des budgets
 






