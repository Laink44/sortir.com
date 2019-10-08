release: php bin/console ckeditor:install && php bin/console doctrine:migrations:migrate -n && composer dump-autoload
web: $(composer config bin-dir)/heroku-php-apache2 public/
