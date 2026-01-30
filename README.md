# 🚀 Système de Réservation

![Symfony](https://img.shields.io/badge/Symfony-6.4-black?style=for-the-badge&logo=symfony)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker)

## 🌟 Présentation
Ce projet est une plateforme **interactive** de gestion de réservations. Il centralise la planification entre :
- 👥 **Membres** (en quête de sport)
- 🧠 **Coachs** (experts passionnés)
- 🏋️ **Activités** (du débutant au pro)

## 🔄 Flux de l'Application
```mermaid
graph LR
  A[Membre] -->|Consulte| B(Activités)
  B -->|Réserve| C{Session Dispo ?}
  C -- Oui --> D[Confirmation ✅]
  C -- Non --> E[Liste d'attente ⏳]
  D --> F[Coach Notifié 🔔]
```

## 🛠️ Structure
- 📂 `src/` : Le cerveau de l'app.
- 🎨 `templates/` : L'interface utilisateur (Twig).
- 🏗️ `migrations/` : L'évolution de la base de données.
