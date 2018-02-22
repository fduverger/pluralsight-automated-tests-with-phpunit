<?php
require __DIR__.'/../src/repository/GameRepository.php';

$requestBody = json_decode(file_get_contents('php://input'), true);
$clean = [];
$clean['user'] = filter_var($requestBody['user'], FILTER_SANITIZE_NUMBER_INT);

$repo = new GameRepository();
$games = $repo->findUserById($clean['user']);

$data = [];
foreach ($games as $game) {
    $data[] = $game->toArray();
}

header('Content-Type: application/json');
echo json_encode(
    array('data' => $data)
);