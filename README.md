# **GéoAfrica**

Créez une expérience interactive pour apprendre et tester les connaissances géographiques sur l’Afrique à travers un jeu éducatif.

---

## **Présentation du projet**
Un outil pédagogique interactif conçu pour enrichir les programmes scolaires en permettant aux élèves d’explorer le continent africain. Ce site web interactif propose d’apprendre les pays africains, leurs capitales, leurs villes principales, leurs langues officielles et leur population, tout en testant leurs connaissances.

---

## **Objectifs du projet**
1. Permettre aux élèves de développer leurs connaissances géographiques sur l’Afrique.
2. Offrir un outil accessible et intuitif pour les enseignants.
3. Démontrer les compétences techniques du développeur dans la conception d’applications web dynamiques.

---

## **Fonctionnalités clés**

### **Gestion des pays et villes africains**
- Ajouter un pays africain avec ses villes principales, sa population et ses langues officielles.
- Modifier ou supprimer les informations d’un pays ou d’une ville.
- Afficher dynamiquement la liste des pays africains avec leurs détails.

### **Base de données relationnelle**
- Conception d’une base de données relationnelle normalisée avec des relations claires entre les entités (Pays, Villes).
- Gestion des entités avec les attributs suivants :
  - **Pays** : ID, Nom, Population, Langue(s) officielle(s), Continent.
  - **Villes** : ID, Nom, Description, Type (capitale ou autre).

### **Actions CRUD dynamiques**
- Création : Ajouter de nouveaux pays et villes avec leurs attributs.
- Lecture : Afficher les pays et leurs villes depuis la base de données.
- Mise à jour : Modifier les informations d’un pays ou d’une ville existants.
- Suppression : Supprimer un pays et ses villes associées.

### **Améliorations bonus**
- Filter pour rechercher des pays par langue.

---

## **Pages à développer**

1. **Accueil** : Vue générale du projet, introduction au jeu éducatif.
2. **Liste des Pays** : Affichage interactif des pays africains et de leurs villes associées.
3. **Détails d’un Pays** : Informations complètes sur un pays (population, langues, villes).
4. **L'ajoute d'un Pays** : Interface pour ajouter, modifier et supprimer des pays et villes.

---

## **Modélisation des données**
- **Diagramme de cas d’utilisation** : Identification des fonctionnalités principales.
- **ERD (Diagramme Relationnel)** : Représentation claire des entités et de leurs relations.

---

## **Technologies et outils utilisés**

- **Frontend** : HTML, TailwindCSS.
- **Backend** : PHP.
- **Base de données** : MySQL pour la gestion des entités relationnelles.
- **Scripts SQL** : Requêtes CRUD pour manipuler les données.
- **Gestion des tâches** : GitHub Projects.
