<?php

require __DIR__. "/../src/repository/GameRepository.php";

$repo = new GameRepository();
$games = $repo->findUserById(1);

?>

<ul>
<?php foreach ($games as $game): ?>
    <li>
        <?php echo $game->getTitle() ?><br>
        <?php echo $game->getAverageScore() ?><br>
        <img src="<?php echo $game->getImagePath() ?>">
    </li>
<?php endforeach ?>
</ul>