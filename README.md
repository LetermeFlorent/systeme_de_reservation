## 🏅 Application de Gestion (Club Sportif / Centre d'Activités) - Symfony 🐘

Ce projet est une application web développée avec le framework **PHP Symfony** et l'ORM **Doctrine**. Elle semble conçue comme un système de gestion pour une structure organisant des activités, probablement un **club de sport**, un **centre de loisirs**, ou une **association**.

---

### ✨ Fonctionnalités Principales :

*   **Gestion des Utilisateurs et Rôles 👤:**
    *   Système d'authentification complet (`LoginController`) avec gestion des rôles (probablement Admin, Coach, Membre).
    *   Inscription de nouveaux utilisateurs (`RegistrationController`) avec hachage sécurisé des mots de passe (`UserPasswordHasherInterface`).
    *   Gestion des différents types d'utilisateurs via l'héritage d'entités Doctrine (`User` -> `Admin`, `Coach`, `Member`).
    *   Page de paramètres (`SettingsController`) permettant aux utilisateurs connectés de modifier leurs informations (email, nom, prénom, mot de passe).
*   **Gestion des Entités Métier (CRUD) 📝:**
    *   Contrôleurs dédiés pour la gestion complète (Créer, Lire, Mettre à jour, Supprimer) des entités principales :
        *   `ActivityController` : Gestion des activités proposées. Inclut une méthode `memberhome` pour afficher les activités aux membres.
        *   `SessionController` : Gestion des sessions (créneaux horaires) pour les activités.
        *   `CoachController` : Gestion des coachs/instructeurs.
        *   `MemberController` : Gestion des membres inscrits.
        *   `LevelController` : Gestion des niveaux (probablement de difficulté ou de compétence pour les activités).
        *   `ReservationController` : Gestion des réservations faites par les utilisateurs pour les sessions/activités.
        *   `AdminController` : Gestion des administrateurs de l'application.
        *   `DefineController` : Gestion d'une entité "Define" (probablement pour définir des paramètres comme la capacité maximale et le prix d'une session ou activité).
*   **Interface d'Administration (Probable) ⚙️:** La structure avec des contrôleurs CRUD dédiés pour chaque entité suggère fortement la présence d'une interface d'administration permettant de gérer toutes les données de l'application.
*   **Interaction avec la Base de Données via Doctrine ORM 💾:**
    *   Utilisation d'Entités Doctrine (`Activity`, `User`, `Session`, etc.) pour mapper les objets PHP aux tables de la base de données.
    *   Utilisation de Repositories Doctrine (`ActivityRepository`, `UserRepository`, etc.) pour les requêtes BDD, y compris des méthodes personnalisées (ex: `ActivityRepository::findAllActivitiesWithSessionsAndLevels`).
    *   Gestion des transactions et persistance des données via l'`EntityManagerInterface`.
*   **Formulaires Symfony 📜:** Utilisation du composant `Form` de Symfony pour la création et la validation des formulaires d'ajout/modification des données (`ActivityType`, `UserType`, `RegistrationFormType`, etc.).
*   **Routing via Attributs 🛣️:** Définition des routes directement dans les contrôleurs en utilisant les attributs `#[Route]`.
*   **Sécurité Symfony 🔒:** Utilisation des composants de sécurité de Symfony pour l'authentification, la gestion des rôles et la protection CSRF (visible dans les méthodes `delete`).

---

### 🚀 Technologies et Composants Symfony :

*   **Framework:** Symfony PHP
*   **ORM:** Doctrine
*   **Templating:** Twig (implicite via `render()`)
*   **Composants Symfony:** Security, Form, Doctrine Bridge, Routing, FrameworkBundle, etc.

---

Ce projet constitue une base solide pour une application de gestion complète, exploitant les fonctionnalités clés de Symfony pour structurer le code, gérer les données et sécuriser l'accès.
