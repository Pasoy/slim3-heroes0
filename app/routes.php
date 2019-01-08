<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//DISPLAY HEROES
$app->get('/', function (Request $request, Response $response) {
    $mapper = new HeroMapper($this->db);
    $heroes = $mapper->getHeroes();

    $response = $this->view->render($response, "heroes.phtml", ["heroes" => $heroes, "router" => $this->router]);
    return $response;
});

$app->post('/', function (Request $request, Response $response) {

});

$app->get('/new', function (Request $request, Response $response) {
    $response = $this->view->render($response, "heroadd.phtml");
    return $response;
});

//ADD NEW HERO
$app->post('/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $hero_data = [];
    $hero_data['hero_name'] = filter_var($data['hero_name'], FILTER_SANITIZE_STRING);
    $hero_data['hero_role'] = filter_var($data['hero_role'], FILTER_SANITIZE_STRING);
    $hero_data['hero_abilities'] = filter_var($data['hero_abilities'], FILTER_SANITIZE_STRING);
    $hero_data['hero_difficulty'] = filter_var($data['hero_difficulty'], FILTER_SANITIZE_STRING);

    $hero = new HeroEntity($hero_data);
    $hero_mapper = new HeroMapper($this->db);
    $hero_mapper->save($hero);
    $response = $response->withRedirect("/");
    return $response;
});

$app->get('/edit/{hero_id}', function (Request $request, Response $response, $args) {
    $hero_id = (int)$args['hero_id'];
    $mapper = new HeroMapper($this->db);
    $hero = $mapper->getHeroById($hero_id);

    $response = $this->view->render($response, "heroedit.phtml", ["hero" => $hero]);
    return $response;
})->setName('hero-edit');

//EDIT HERO
$app->post('/edit/{hero_id}', function (Request $request, Response $response, $args) {
    $hero_id = (int)$args['hero_id'];
    $hero_mapper = new HeroMapper($this->db);
    $hero = $hero_mapper->getHeroById($hero_id);

    $data = $request->getParsedBody();
    $hero_data = [];
    $hero_data['hero_name'] = filter_var($data['hero_name'], FILTER_SANITIZE_STRING);
    $hero_data['hero_role'] = filter_var($data['hero_role'], FILTER_SANITIZE_STRING);
    $hero_data['hero_abilities'] = filter_var($data['hero_abilities'], FILTER_SANITIZE_STRING);
    $hero_data['hero_difficulty'] = filter_var($data['hero_difficulty'], FILTER_SANITIZE_STRING);

    $new_hero = new HeroEntity($hero_data);

    $hero_mapper->edit($hero, $new_hero);
    $response = $response->withRedirect("/");
    return $response;
});

//DELETE
$app->get('/delete/{hero_id}', function (Request $request, Response $response, $args) {
    $hero_id = (int)$args['hero_id'];
    $hero_mapper = new HeroMapper($this->db);
    $hero_mapper->remove($hero_id);

    $response = $response->withRedirect("/");
    return $response;
})->setName('hero-delete');

//DISPLAY HERO
$app->get('/view/{hero_id}', function (Request $request, Response $response, $args) {
    $hero_id = (int)$args['hero_id'];
    $mapper = new HeroMapper($this->db);
    $hero = $mapper->getHeroById($hero_id);
    $response = $this->view->render($response, "herodetail.phtml", ["hero" => $hero]);
    return $response;
})->setName('hero-detail');

$app->get('/search', function (Request $request, Response $response) {
    $mapper = new HeroMapper($this->db);
    $heroes = $mapper->search("AAAAAAAAAAAAAAAA");

    $response = $this->view->render($response, "herosearch.phtml", ["heroes" => $heroes, "router" => $this->router]);
    return $response;
});

$app->post('/search', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $search_data = filter_var($data['search'], FILTER_SANITIZE_STRING);
    if (!isset($search_data) || trim($search_data) == '') {
        $search_data = 'none';
    }

    $response = $response->withRedirect("/search/$search_data");
    return $response;
});

$app->get('/search/{search}', function (Request $request, Response $response, $args) {
    $name = $args['search'];

    $mapper = new HeroMapper($this->db);
    $heroes = $mapper->search($name);

    $response = $this->view->render($response, "herosearch.phtml", ["heroes" => $heroes, "router" => $this->router]);
    return $response;
});