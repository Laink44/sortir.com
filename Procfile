release: php bin/console doctrine:migrations:migrate -n && composer dump-autoload && php bin/console ckeditor:install && php bin/console assets:install public
web: $(composer config bin-dir)/heroku-php-apache2 public/
