# activate maintenance mode
php artisan down

# update source code
git fetch --all
git reset --hard origin/main

composer install --optimize-autoloader --no-dev
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# stop maintenance mode
php artisan up

chmod +x deploy.sh

# echo "**DONT FORGET**"
# echo "Edit variable APP_DEBUG become FALSE in .env file"
# exec $SHELL
