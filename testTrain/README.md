# 📌 Projet : Tests et Analyse des Performances sur une Application de Gestion de Tâches

Ce projet vise à tester et analyser les performances d'une **application web de gestion de tâches**, en mettant en place
des tests **unitaires**, **E2E (end-to-end)** et une **simulation de charge**.

---

## ✅ Exercice 1 : Tests Unitaires avec PHPUnit

Les fonctionnalités principales de l'application ont été testées avec PHPUnit :

- ✅ **Ajout d'une tâche**
- ✅ **Suppression d'une tâche**
- ✅ **Vérification de la liste des tâches**
- ✅ **Gestion des erreurs (index invalide, etc.)**

📌 **Résultats des tests unitaires :**  
![image](https://github.com/user-attachments/assets/3817b062-c8ec-42aa-a3a1-52a2ad9ecec6)

---

## ✅ Exercice 2 : Tests E2E avec Cypress

Les tests **End-to-End (E2E)** ont été réalisés avec Cypress afin de **simuler le parcours d'un utilisateur** :

1. 🔹 Connexion à l'application
2. 🔹 Ajout d'une nouvelle tâche
3. 🔹 Vérification de son affichage
4. 🔹 Suppression de la tâche et vérification de sa disparition

📌 **Résultats des tests Cypress :**  
![image](https://github.com/user-attachments/assets/3432c6b3-3fbf-4cb2-8020-f00d58532a73)

---

## ✅ Exercice 3 : Ajout d'une Échéance + Tests de Non-Régression

J'ai **ajouté la fonctionnalité "échéance" aux tâches**, ce qui a nécessité une modification des tests.  
📌 **Après l'ajout de cette nouvelle fonctionnalité, j'ai relancé la suite de tests pour vérifier que les fonctionnalités
existantes ne sont pas impactées.**

📌 **Résultats des tests avec l'échéance intégrée :**  
![image](https://github.com/user-attachments/assets/e1af7016-377f-4a14-83fd-859d07408938)

---

## ✅ Exercice 4 : Simulation de Charge avec JMeter

J'ai simulé **plusieurs utilisateurs interagissant avec l'application simultanément** afin d'analyser les **performances
du serveur** sous forte charge.

- 🔹 **Simulation :** 50 utilisateurs effectuant des requêtes simultanées.
- 🔹 **Analyse des résultats :** Temps de réponse moyen, erreurs, débit (requests/sec).

📌 **Rapport de simulation JMeter :**  
![image](https://github.com/user-attachments/assets/eb73abc2-f3f2-4ace-96bc-359785e25c61)  
![image](https://github.com/user-attachments/assets/91e72b68-faca-4675-a6c9-39dbde87aa44)

---

## 🎯 Conclusion

Ce projet a permis de :

✅ **Vérifier la stabilité et la fiabilité des fonctionnalités avec PHPUnit.**  
✅ **Tester l’expérience utilisateur via des tests automatisés E2E avec Cypress.**  
✅ **Ajouter une nouvelle fonctionnalité (échéance) et valider qu’elle n’a pas cassé les fonctionnalités existantes.**  
✅ **Analyser les performances et identifier les goulots d’étranglement grâce à JMeter.**

🚀 **Les résultats montrent que l’application répond bien sous charge et que les nouvelles fonctionnalités sont bien
intégrées.**  
