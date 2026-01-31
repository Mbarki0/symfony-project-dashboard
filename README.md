# Hématologie & Gestion Patients

![Symfony](https://img.shields.io/badge/Symfony-6.x-000000?style=flat-square&logo=symfony)
![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=flat-square&logo=php)
![EasyAdmin](https://img.shields.io/badge/EasyAdmin-4.x-blue?style=flat-square)
![Webpack Encore](https://img.shields.io/badge/Webpack-Encore-green?style=flat-square)

Une application Full Stack Symfony hybride combinant une **plateforme pédagogique** (Atlas d'hématologie, Quiz interactifs) et un **système de gestion de dossiers médicaux** (GED Patient).

## Fonctionnalités

Le projet est divisé en deux grands pôles fonctionnels unifiés par une gestion des droits avancée.

### Pôle Pédagogique (E-Learning)
- **Atlas Cellulaire :** Banque d'images consultable avec moteur de recherche (Type de cellules, pathologies...).
- **Système de Quiz :**
  - Parcours par niveaux (`Level` -> `Quiz` -> `Question`).
  - Correction automatique des QCM.
  - Historique des résultats et suivi de progression par élève.

### Pôle Médical (Gestion Patients)
- **Dossiers Patients Complets :** Stockage des analyses (Hémogramme, Myélogramme, etc.).
- **Imagerie Médicale :** Upload et gestion centralisée des fichiers images liés aux dossiers patients.
- **Sécurité des Données :** Accès strictement restreint aux utilisateurs habilités.

### Administration & Sécurité
- **Back-Office EasyAdmin :** Interface d'administration complète et responsive.
- **Gestion des Rôles Dynamique :** Système de permissions sur-mesure basé sur des attributs fonctionnels (`manageImages`, `managePatients`, `manageQuiz`) convertis dynamiquement en Rôles Symfony.
- **Tableau de Bord Contextuel :** Les menus de l'administration s'adaptent automatiquement aux droits de l'utilisateur connecté.

---

## Stack Technique

- **Backend :** Symfony 6 (PHP 8.1+)
- **Base de données :** MySQL / MariaDB (Doctrine ORM)
- **Administration :** EasyAdmin Bundle 4
- **Frontend :** Twig, Webpack Encore, Stimulus
- **Gestion des Assets :**
  - *VichUploaderBundle* pour l'Atlas public.
  - *Script Custom* pour la gestion sécurisée des dossiers patients.
- **Outils :** KnpPaginator, StofDoctrineExtensions (Timestampable).

---
