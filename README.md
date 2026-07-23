# SenEvent

Application web simple de gestion et de reservation d'evenements (PHP + MySQL + Bootstrap).

## Fonctionnalites

- Inscription et connexion des utilisateurs (mots de passe haches)
- Gestion des evenements : ajouter, modifier, supprimer, afficher (CRUD)
- Reservation d'evenements et consultation de ses reservations

## Prerequis

- XAMPP (Apache + MySQL + PHP 7.4 ou superieur)

## Installation sous XAMPP (Windows)

1. Copier le dossier **SenEvent** dans `C:\xampp\htdocs\`
2. Demarrer **Apache** et **MySQL** depuis le panneau XAMPP
3. Ouvrir phpMyAdmin : http://localhost/phpmyadmin
4. Onglet **Importer** > choisir le fichier `database/senevent.sql` > **Executer**
5. Ouvrir l'application : http://localhost/SenEvent/

## Premiere utilisation

1. Cliquer sur **Inscription** pour creer un compte
2. Se connecter
3. Ajouter, reserver et gerer des evenements

## Structure du projet

```
SenEvent/
├── index.php                 Page d'accueil
├── config.php                Connexion PDO a MySQL
├── register.php              Inscription
├── login.php                 Connexion
├── logout.php                Deconnexion
├── events.php                Liste des evenements
├── add_event.php             Ajouter un evenement
├── edit_event.php            Modifier un evenement
├── delete_event.php          Supprimer un evenement
├── reserve.php               Reserver un evenement
├── reservations.php          Mes reservations
├── cancel_reservation.php    Annuler une reservation
├── includes/                 En-tete, pied de page, controle d'acces
├── css/                      Style personnalise
└── database/senevent.sql     Script de la base de donnees
```

## Note

Le fichier `config.php` lit d'abord les variables d'environnement (DB_HOST, DB_NAME,
DB_USER, DB_PASS) et retombe sur les valeurs XAMPP par defaut. Cela prepare le projet
pour une future conteneurisation avec Docker et un deploiement sur Kubernetes,
sans avoir a modifier le code.

## Roles (mise a jour)

L'application distingue deux roles :

- **Administrateur** : peut ajouter, modifier et supprimer des evenements, en plus de reserver.
- **Utilisateur** : peut consulter les evenements et reserver, mais pas les gerer.

Un compte administrateur est cree automatiquement lors de l'import du SQL :

- Email : `admin@senevent.sn`
- Mot de passe : `admin123`

Tout compte cree via la page d'inscription recoit automatiquement le role **utilisateur**.
