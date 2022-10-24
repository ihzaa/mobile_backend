composer install
copy .env.example .env
php artisan key:generate
echo "**DONT FORGET**"
echo "Edit variable in .env file as needed"
exec $SHELL
