# sortir.com
Symfony project

[![pipeline status](https://gitlab.com/AzRunRCE/sortir.com/badges/master/pipeline.svg)](https://gitlab.com/AzRunRCE/sortir.com/commits/master)


### Production: http://sortir-com.herokuapp.com

#### Already registred user in database (Prod)
    - admin pass_1234
    - user pass_1234

# Installation

## 1. Download 
    - git clone https://github.com/Yann-Rousseaux/sortir.com.git
    - cd sortir.com
    - composer install
    
## 2. Set environment variable
    - set SORTIES_APPLICATION_PATH={your path install}
    - set APP_ENV=prod
    - set DATABASE_URL=mysql://root@{YourHostName}:3306/{YourBDDName}

## 3. Create database
    - php bin/console doctrine:database:create
    
## 4. Make migration
    - php bin/console doctrine:migrations:migrate
    
## 5. Install CKEditor
	- php bin/console ckeditor:install
	- php bin/console assets:install public
	
## 6. Cron Job 
### Linux & Mac OSX
    - */5 * * * * cd SORTIES_APPLICATION_PATH && php bin/console app:update-sorties-state > SORTIES_APPLICATION_PATH/var/og/prod.log           
### Windows
    - Use scheduled Task
    - Create a new task runned every 5 minutes
    - Set the working directory to the sorties application path
    - Set the executed command to: php bin/console app:update-sorties-state > SORTIES_APPLICATION_PATH/var/og/prod.log
    

## 7. (Optionally) Load Fixtures
    - php bin/console doctrine:fixtures:load

#  Informations  
## Usable command
    - php bin/console app:update-sorties-state
    
