<?php

require __DIR__. "/../entity/Game.php";
require __DIR__. "/../entity/Rating.php";

class GameRepository {

    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=localhost;dbname=gamebook_tests',
            'root',
            '123...abc'
        );
    }

    public function findById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM game WHERE id=?');
        $statement->execute([$id]);

        $game = $statement->fetchObject('Game');

        return $game;
    }

    public function saveGameRating($gameId, $userId, $score)
    {
        $statement = $this->pdo->prepare(
            'REPLACE INTO rating (game_id, user_id, score)
             VALUES (?, ?, ?)');

        return $statement->execute([$gameId, $userId, $score]);
    }

    public function findUserById($id){
        $games = [];
        for ($i=1; $i <= 6; $i++) { 
            $game = new Game($i);
            $game->setTitle("Game ". $i);
            $game->setImagePath("/images/game.jpg");
            $rating = new Rating();
            $rating->setScore(4.5);
            $game->setRatings([$rating]);
            $games[] = $game;
        }
        return $games;
    }
}