# 📌 Projet : Validation et Tests d'une Application de Gestion des Utilisateurs

Ce projet vise à **tester** et **analyser** les performances d'une application web de gestion des utilisateurs, en
mettant
en place des tests **unitaires**, **End-to-End (E2E)** et une **simulation de charge**.

---

## ✅ Exercice 1 : Tests Unitaires avec PHPUnit

Les fonctionnalités principales de l'application ont été testées avec PHPUnit. Dès les premiers tests :

1. **Problème détecté**

- Les méthodes `updateUser()` et `removeUser()` ne jetaient aucune exception lorsque l’utilisateur n’existait pas,
  entraînant des tests en échec.

2. **Solution apportée**

- Nous avons modifié ces méthodes dans `UserManager.php` pour vérifier le `rowCount()` et lever une `Exception` si
  aucune ligne n’est affectée.

3. **Résultats après modification**

- Les tests `testInvalidUpdateThrowsException()` et `testInvalidDeleteThrowsException()` sont désormais passés avec
  succès.

![Résultats PHPUnit](img_1.png)

---

## ✅ Exercice 2 : Tests E2E avec Cypress

Les tests **End-to-End (E2E)** ont été réalisés avec Cypress pour **simuler un parcours utilisateur** :

1. 🔹 **Ajout** d’un utilisateur via le formulaire (nom, email, rôle).
2. 🔹 **Vérification** qu’il apparaît dans la liste.
3. 🔹 **Modification** de l’utilisateur (nouveau nom ou email).
4. 🔹 **Suppression** et **vérification** qu’il n’est plus dans la liste.

### 🚧 Complications rencontrées

- **Test de suppression** : Cypress échouait à vérifier la disparition de l’élément.
    - Bien que l’API retournait `200`, la liste n’était pas rafraîchie à temps, l’élément restait visible.

### 🔧 Modifications apportées

- Ajout d’une requête `GET` après suppression pour vérifier que l’API ne renvoie plus l’utilisateur.
- Ajout d’un `cy.reload()` afin de rafraîchir la liste dans le DOM.
- Utilisation de `cy.request()` pour valider directement sur l’API que l’utilisateur est effectivement supprimé dans la
  base.

📌 **Résultats des tests Cypress** :
![Résultats Cypress](img_2.png)

---

## ✅ Exercice 3 : Ajout de la fonctionnalité “Rôle” + Tests de Non-Régression

Pour cette étape, nous avons **ajouté une nouvelle colonne** `role` dans la base de données, et modifié l’interface et
l’API pour gérer ce champ (défaut : `user`).

1. **Avant la modification**

- Tous les tests (unitaires + E2E) étaient au vert.

2. **Après la modification**

- Nous avons relancé tous les tests pour vérifier l’absence de régression (ajout, suppression, etc.).
- Aucune fonctionnalité existante n’a été cassée.

### 🚧 Problèmes rencontrés

- Besoin d’**ajouter la colonne** `role` (via `ALTER TABLE users ADD COLUMN role ...`) sous peine d’erreur SQL.
- Dans Cypress, il a fallu adapter le formulaire (sélection du `<select id="role">`).

📌 **Résultats des tests avec la nouvelle fonctionnalité** :  
![img_3.png](img_3.png)  
![img_4.png](img_4.png)

Tous les tests restent au vert, et la nouvelle fonctionnalité est bien couverte.

---

## ✅ Exercice 4 : Simulation de Charge avec JMeter

Enfin, nous avons simulé **plusieurs utilisateurs** (jusqu’à 500) interagissant avec l’application simultanément pour
analyser la **performance** du serveur sous charge :

1. 🔹 **Configuration**

- JMeter Thread Group : 500 threads, ramp-up = 10s, Loop Count = 1
- Requête **POST** sur `http://localhost:8000/src/api.php`
- Génération d’un email unique par thread (ex: `user${__threadNum}@example.com`) pour éviter les doublons.

2. 🔹 **Analyse des résultats**

- Temps de réponse moyen bas (< 100 ms)
- Aucune erreur 4xx/5xx tant que l’email est unique
- Throughput ~ 50 req/s (en fonction de la RAM/CPU du poste)

### 🚧 Problèmes rencontrés

- **100% d’erreurs** initialement lorsque l’on utilisait le **même** email, l’API refusait les doublons (contrainte
  UNIQUE).
- **“Email invalide”** si le format form-data n’était pas correct (JMeter envoyait parfois `name=xx&email=xx` mais pas
  en
  `x-www-form-urlencoded` → on a ajouté un Header `Content-Type: application/x-www-form-urlencoded`).

📌 **Rapport JMeter** :  
![img_5.png](img_5.png) ![img_6.png](img_6.png)  
Temps de réponse moyen satisfaisant, aucun goulot d’étranglement pour 500 requêtes.

---

## 🎯 Conclusion

Ce projet a permis de :

✅ **Vérifier la fiabilité** du backend (Tests Unitaires PHPUnit) : ajout, mise à jour, suppression, récupération.  
✅ **Tester le parcours utilisateur** (Cypress E2E) : tout le chemin, du formulaire à l’API.  
✅ **Intégrer une nouvelle fonctionnalité (rôle)** en évitant toute régression grâce à la relance des tests initiaux.  
✅ **Analyser les performances** et repérer des erreurs (duplicat d’email, configuration form-data) grâce à JMeter.

> Les résultats montrent que **l’application répond bien** sous charge (500 utilisateurs simultanés) et que
> **l’ajout de la fonctionnalité “rôle”** n’a **pas cassé** les fonctionnalités existantes. Les tests d’intégration et
> de non-régression valident **l’ensemble** du périmètre.

---  

*(Réalisé par : LABARRE Loris
*(Date de rendu : 06/02/2025)*  
