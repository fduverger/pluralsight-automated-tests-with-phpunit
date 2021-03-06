<?php

require __DIR__. "/../src/repository/GameRepository.php";

$repo = new GameRepository();
$games = $repo->findUserById(1);

?>

<ul>
<?php foreach ($games as $game): ?>
    <li>
        <span class="title"><?php echo $game->getTitle() ?></span><br>
        <a href="add-rating.php?game=<?php echo $game->getId() ?>">Rate</a>
        <?php echo $game->getAverageScore() ?><br>
        <img src="<?php echo $game->getImagePath() ?>">
    </li>
<?php endforeach ?>
</ul>