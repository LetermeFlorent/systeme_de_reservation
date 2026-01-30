# 📖 Manuel d'Utilisation Animé

## ⚡ Installation Rapide

<details>
<summary><b>Étape 1 : Cloner et Dépendances (Cliquez pour voir)</b></summary>

```bash
git clone <url-du-projet>
composer install
```
*Installation des packages...*
`[████████████████████] 100%`
</details>

<details>
<summary><b>Étape 2 : Lancer l'environnement Docker</b></summary>

```bash
docker compose up -d
```
*Démarrage des conteneurs :*
- 📦 DB : `Running` ✅
- 📦 Web : `Running` ✅
</details>

## 🎮 Fonctionnalités par Profil

### 👤 Membres
1. **Connexion** : Entrez vos identifiants.
2. **Exploration** : Parcourez les activités avec des filtres dynamiques.
3. **Réservation** : Cliquez sur "Réserver" et recevez une notification immédiate.

### 🛡️ Administrateurs
> [!IMPORTANT]
> L'interface Admin est dotée d'un dashboard temps réel pour surveiller les inscriptions.

## 💡 Astuces
- ⌨️ Utilisez `php bin/console` pour voir toutes les commandes disponibles.
- 🧹 `cache:clear` est votre meilleur ami en cas de comportement étrange.
