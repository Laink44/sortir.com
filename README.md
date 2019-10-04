# sortir.com
Symfony project

[![pipeline status](https://gitlab.com/AzRunRCE/sortir.com/badges/master/pipeline.svg)](https://gitlab.com/AzRunRCE/sortir.com/commits/master)


### Production: http://sortir-com.herokuapp.com

#### Utilisateur existant en BDD (Prod)
 * admin  pass_1234
 * user  pass_1234

### Load Fixtures
    - php bin/console doctrine:fixtures:load
    
### Database migration
  - php bin/console doctrine:migrations:migrate

### Connection string
  - DATABASE_URL= in .env file
