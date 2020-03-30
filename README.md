# Setting everything up:
* `git clone https://github.com/izio38/symphony-unit-tests.git`
* `cd symphony-unit-tests`
* `composer install`

# Running the application:
* `symfony serve` - inside the project root directory.

# Loading Fixtures:
`bin/console doctrine:fixtures:load`

# Running the test cases:
### Without Coverage:
* `./bin/phpunit`
### With Coverage:
* `./bin/phpunit --coverage-html coverage`

### TODO:
* Home:
    * Recherche trajet
* Si auth:
    * Mes trajets
        * conducteur
        * passagers
* Liste des trajets:
    * Départ, arrivée, date/heure.
    * Si auth: reserver
* Nouveau trajet:
    * Départ
    * Arrivé
    * Date/Heure
* Nouveau lieu:
    * Nom
    * Coordonnées
    
### TODO TEST
* page de nouveau trajet pas accessible si pas connecté
* page de nouveau lieu pas accessible si pas connecté
* quand on soumet un trajet, on est bien driver automatiquement