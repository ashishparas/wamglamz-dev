cd /var/www/dev/wreckt 
git pull origin dev-v.0.9
composer install
sudo chmod -R 0777 /var/www/dev/wreckt/storage /var/www/dev/wreckt/bootstrap /var/www/dev/wreckt/public/uploads 
/usr/bin/php /var/www/dev/wreckt/artisan migrate
exit