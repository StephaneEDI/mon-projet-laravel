# Société Viticole

Application web de gestion d’un domaine viticole, réalisée avec Laravel. Elle regroupe la vitrine des cépages, les comptes clients, les demandes de commande et les outils d’administration pour le suivi des contrats, des cuves et des livraisons.

## Fonctionnalités

- Vitrine publique alimentée par les cépages enregistrés : caractéristiques, stock et prix.
- Comptes client et espace personnel avec historique des commandes et suivi de livraison.
- Panier conservé en session, contrôle du stock et création d’une demande de commande.
- Espace administrateur protégé par rôle pour gérer les cépages, négociants, cuves, contrats et livraisons.
- Suivi des livraisons par étapes : à effectuer, en cours et effectuée.
- Relations entre contrats, négociants, cépages et livraisons historiques.

> Les données de cépages et de cuves préfixées par `Demo` sont des exemples destinés aux essais. Remplace-les par les données réelles avant une utilisation opérationnelle.

## Prérequis

- PHP 8.1 ou supérieur et Composer.
- MySQL ou MariaDB.
- Node.js et npm si tu souhaites compiler les ressources front-end.

## Installation locale

1. Récupérer le dépôt et installer les dépendances PHP :

```bash
git clone <URL_DU_DEPOT>
cd societe-viticole
composer install
```

2. Créer la configuration locale à partir du modèle :

```bash
cp .env.example .env
php artisan key:generate
```

Sous PowerShell, remplacer la copie par :

```powershell
Copy-Item .env.example .env
```

3. Créer une base de données MySQL/MariaDB, puis renseigner `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD` dans `.env`.

4. Créer les tables et le lien public des images :

```bash
php artisan migrate
php artisan storage:link
```

5. Pour remplir la vitrine et l’écran des cuves avec les exemples de démonstration :

```bash
php artisan db:seed --class=DemoCepagesSeeder
php artisan db:seed --class=DemoCuvesSeeder
```

Ces seeders peuvent être relancés sans créer de doublons pour les références de démonstration.

6. Lancer l’application :

```bash
php artisan serve
```

L’adresse locale par défaut est `http://127.0.0.1:8000`.

Pour compiler les ressources front-end, si nécessaire :

```bash
npm install
npm run build
```

## Premier compte administrateur

Le formulaire d’inscription crée uniquement des comptes client. Après avoir créé le compte qui doit gérer le site, attribuer son rôle depuis la base de données :

```sql
UPDATE utilisateurs
SET Role_utilisateur = 'admin'
WHERE Email_utilisateur = 'admin@example.com';
```

Remplacer l’adresse par celle du compte concerné. Un utilisateur ayant le rôle `admin` accède au panneau d’administration après connexion.

## Tests

Lancer les tests automatisés avec :

```bash
php artisan test
```

Ils couvrent notamment les accès selon les rôles, la gestion des contrats et négociants, les commandes et le suivi des livraisons.

## Limites actuelles

- La confirmation du panier enregistre une demande de commande ; le paiement en ligne n’est pas activé dans cette version.
- Une cuve conserve sa capacité totale et le cépage qui lui est affecté, mais pas encore son volume courant ni ses mouvements de stock.
- Les coordonnées de contact de la vitrine se configurent avec `COMPANY_CONTACT_EMAIL`, `COMPANY_WHATSAPP_NUMBER` et `COMPANY_WHATSAPP_MESSAGE` dans le `.env` local.
- Les identifiants, mots de passe, fichiers `.env`, bases locales, dépendances et caches ne doivent pas être publiés.
