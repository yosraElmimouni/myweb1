#!/bin/bash

# Définir le répertoire racine de l'application
export APP_ROOT=/home/site/wwwroot

# Installer les dépendances Composer
cd $APP_ROOT
composer install --no-dev --optimize-autoloader

# Définir le répertoire public comme racine du document pour le serveur web
# Azure App Service Linux utilise Nginx par défaut.
# Cette commande est un placeholder, la configuration réelle se fait dans le portail Azure
# ou via un fichier de configuration Nginx personnalisé si nécessaire.
# Pour l'instant, nous nous assurons que Composer est exécuté.

echo "Démarrage de l'application PHP..."
# La commande de démarrage par défaut d'Azure App Service pour PHP est souvent:
# /usr/sbin/apache2ctl -D FOREGROUND
# ou
# /usr/sbin/nginx

# Si vous utilisez un framework comme Slim, vous devrez peut-être configurer
# la racine du document sur /home/site/wwwroot/public.
# Cela se fait généralement dans les paramètres de configuration d'Azure App Service.

# Si vous utilisez le conteneur par défaut, le répertoire racine est /home/site/wwwroot.
# Nous allons nous assurer que le serveur web pointe vers le répertoire 'public'.
# Pour les besoins de cette démo, nous nous concentrons sur l'installation des dépendances.

# Laisser le conteneur démarrer le serveur web
exec "$@"
