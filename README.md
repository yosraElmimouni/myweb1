# Application PHP 8.4 pour Azure App Service

Ceci est une application web PHP moderne, construite avec le micro-framework **Slim 4** et le moteur de template **Twig**, prête à être déployée sur **Azure App Service**.

## Prérequis

*   Compte Azure actif.
*   Azure CLI ou Azure Portal pour le déploiement.
*   PHP 8.4 (ou compatible) pour l'exécution locale.

## Structure du Projet

| Fichier/Dossier | Description |
| :--- | :--- |
| `index.php` | Point d'entrée de l'application. |
| `templates/` | Contient les fichiers de template Twig (`.html.twig`). |
| `vendor/` | Dépendances Composer (générées après `composer install`). |
| `composer.json` | Définit les dépendances du projet. |
| `.env` | Fichier de configuration des variables d'environnement (à ne pas commiter). |
| `.gitignore` | Fichiers et dossiers à ignorer par Git. |
| `.deployment` | Fichier de configuration Azure pour le déploiement. |
| `web.config` | Fichier de configuration pour Azure App Service (Windows). |
| `startup.sh` | Script de démarrage pour Azure App Service (Linux). |

## Déploiement sur Azure App Service (Linux)

Azure App Service pour Linux est la méthode recommandée pour les applications PHP.

1.  **Créer un App Service** :
    *   Créez une nouvelle ressource **App Service**.
    *   Sélectionnez **Code** comme méthode de publication.
    *   **Pile d'exécution** : Sélectionnez **PHP 8.x** (la version 8.4 sera disponible sous peu, ou utilisez 8.3/8.2 en attendant).
    *   **Système d'exploitation** : **Linux**.

2.  **Configuration de la Racine du Document** :
    *   Dans le portail Azure, allez dans **Configuration** -> **Paramètres généraux**.
    *   Définissez le **Chemin de démarrage** (Startup Command) sur :
        ```bash
        /home/site/wwwroot/startup.sh
        ```
    *   **OU** (méthode alternative, si le script `startup.sh` n'est pas utilisé) :
        *   Définissez le **Chemin de démarrage** (Startup Command) sur :
            ```bash
            composer install --no-dev --optimize-autoloader && /usr/sbin/apache2ctl -D FOREGROUND
            ```
        *   La racine du document est maintenant la racine du dépôt (`/home/site/wwwroot`). Aucune configuration de chemin virtuel n'est nécessaire.

3.  **Déploiement du Code** :
    *   **Option 1 : Déploiement Zip (Recommandé)**
        *   Utilisez l'archive `php-azure-app.zip` fournie.
        *   Déployez via Azure CLI :
            ```bash
            az webapp deployment source config-zip --resource-group <votre-groupe-de-ressources> --name <nom-de-votre-app-service> --src php-azure-app.zip
            ```
    *   **Option 2 : Déploiement Git**
        *   Initialisez un dépôt Git dans le dossier racine du projet.
        *   Configurez le déploiement continu depuis un dépôt local ou GitHub.

## Variables d'Environnement

Les variables d'environnement définies dans le fichier `.env` local doivent être configurées dans Azure App Service :

1.  Dans le portail Azure, allez dans **Configuration** -> **Paramètres d'application**.
2.  Ajoutez les paires clé/valeur :
    *   `APP_ENV` : `production`
    *   `APP_DEBUG` : `false`

## Exécution Locale

1.  **Installation des dépendances** :
    ```bash
    composer install
    ```
2.  **Démarrage du serveur** :
    ```bash
    php -S localhost:8000
    ```
3.  Accédez à `http://localhost:8000` dans votre navigateur.
