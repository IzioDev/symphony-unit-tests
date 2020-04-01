## Binôme

- BILLOT Romain
- SOMVEILLE Quentin

## Introduction

Il nous a été demandé de créer une application de covoiturage sous Symfony. Le but de cette création était d'apprendre à écrire des tests unitaires et fonctionnels / end-to-end ainsi que de découvrir le TDD (test driven development). L'application devait permettre de lister les trajets proposés par les autres utilisateur, de pouvoir réserver un trajet lorsque l'on est connecté et bien sûr de permettre la création de trajet par tous les utilisateurs.

Nous avons choisi d'utiliser une base de donnée MySQL qui tourne dans un container Docker. Nous aurions aussi aimé pouvoir faire tourner l'application dans un Docker afin de ne pas avoir à télécharger les dépendances de Symfony sous nos ordinateurs.

# L'application

## Fonctionnalitées

### Utilisateur

- Inscription
- Connection / Déconnexion

# Les tests

## Types de tests utilisés

- Test unitaires : Couvre toutes les entitées de l'application et certains chemin des controllers (ce que l'on ne peut pas tester en fonctionnels).
- Test fonctionnels / end-to-end : Couvre toutes les routes avec tous les cas de figure possible d'une entrée utilisateur (une valeur null, une valeur qui n'existe pas ... etc). ils tests principalement les retour à l'utilisateur (présence de message de succès ou d'erreur) mais aussi (dans le cas d'un formulaire de création) si les entitées sont bien présente en base de données après le retour de l'envoie de la requête via le forulaire. Ces tests fonctionnels tournent en série (un à un). Nous avons fait en sorte qu'ils `purge` la base de donnée avant chaque test et qu'ils lancent les `fixtures` (création de deux utilisateurs dont un administrateur).

## Tests Unitaires

Nous avons 31 tests unitaires sur notre application. Majoritairement situés sur les entitées (getter et setter). Mais aussi sur certains controllers. Par exemple, le `UserSecurityController` jette une `Exception` dans le cas où l'on appel la route `(GET) /logout`, en effet, cette requête est interceptée par le firewall de Symfony et donc finalement ne peut pas être testée en test fonctionnel. Nous avons donc utilisé un test unitaire pour pallier à ce problème.

```php
public function testLogoutThrowError()
{
    $userSecurityController = new UserSecurityController();
    $this->expectException(Exception::class);

    $userSecurityController->logout();
}
```

## Tests fonctionnels / end-to-end

Nous nous sommes rendu compte que dans une application comme celle-ci (qui fait peut de traitement de données mais plus de l'interraction utilisateur), il était essentiel de couvrire tous les cas possible du côté de l'utilisateur, c'est pourquoi nous avons décidés de nous concentrer principalement sur ces derniers.
Prenons par exemple un formulaire de création, nous testons d'abord dans les bonnes conditions (les valeurs entrées sont les valeurs attendues dans le controller) mais aussi lorsqu'une valeur est mauvais (ex. on entre un `string` alors qu'on attend un `number`) .

```php
// Test dans les bonnes condition
public function testLocationCreateShouldPersistToDatabase()
{
    $user = $this->createUserClient();
    $user->request('GET', '/location/create');

    $button = $user->getCrawler()->selectButton('location_form[submit]');
    $form = $button->form([
    'location_form[name]' => "Grenoble", // string
    'location_form[lat]' => 101.5, // number
    'location_form[lon]' => 101.5, // number
], 'POST');
    // Submit it
    $user->submit($form, [], []);

    $this->assertSelectorExists(".flash-success");

    $em = $this->em;
    $locationRepository = $em->getRepository(Location::class);
    $grenobleLocation = $locationRepository->findOneBy(["name" => "Grenoble"]);

    $this->assertNotEmpty($grenobleLocation);
}

// Test dans les mauvaises conditions
public function testShouldAddDangerMessageIfFormIsNotValid()
{
    $user = $this->createUserClient();
    $user->request('GET', '/location/create');

    $button = $user->getCrawler()->selectButton('location_form[submit]');
    $form = $button->form([
        'location_form[name]' => "Grenoble", // string
        'location_form[lat]' => 'not valid', // string
        'location_form[lon]' => 101.5, // number
    ], 'POST');
    // Submit it
    $user->submit($form, [], []);

    $this->assertSelectorExists(".flash-danger");
}
```

Dans le deuxième cas, on vérifi que la validation nous jette avec un message d'erreur. On pourrait aller encore plus loins et tester le contenu de ce message d'erreur. D'expérience, ce n'est pas une bonne chose pour une interface qui n'est pas critique (dans cet exemple le message d'erreur de la création d'un lieu), à chaque fois que l'on va vouloir modifier ce message, il faudra changer le test. Nous préférions nous concentrer sur les parties critiques (réservation et annulation d'un trajet).

Un autre type intéressant de test end-to-end sont les routes " cachées ", de base l'interface ne propose pas d'y accèder, mais par modification d'URL, c'est possible. Prenons cet exemple :

```php
public function testUserShouldNotBeAbleToBookUndefinedPath()
{
    $this->setUpLyonAnnecyPath();

    $user = $this->createUserClient();
    $user->request('GET', "/path/2/book");

    $this->assertResponseStatusCodeSame(404);
}
```

Ici, on créer un nouveau trajet (qui n'est pas dans les Fixtures car pas utilisé de partout), il aura donc pour `id` 1 car c'est le premier, puis on tente de reserver un trajet avec l'`id` 2. On attend que cette route nous renvoit une `404 - Not Found`.

Nous avons fait beaucoup de test et parfois ils sont redondant à lire, nous vous conseillons d'aller voir les principaux: `AccountControllerTest`, `LocationControllerTest`, `PathControllerBookTest`, `SignInControllerTest`.

## Difficultées rencontrées

(TODO) parler du Web Fixtures Test Case (fixture + cleanup + authed clients)

## Perspectives d'amélioration

Ajouter plus de test unitaires sur les controller et les repository.
