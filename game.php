<?php

namespace Ticktacktoe;

include_once "src/Ticktacktoe/UserPlayer.php";
include_once "src/Ticktacktoe/AIPlayer.php";
include_once "src/Ticktacktoe/Game.php";

echo "Choose your side:\n";
echo "X) x\n";
echo "O) o\n";
echo "Any other symbol if you would like to run AI vs AI\n";

$side = readline();

$ai = new AI();
$gameCount = 1;

$playerX = null;
$playerO = null;

switch ($side) {
    case 'X':
    case 'x':
        $playerX = new UserPlayer('x');
        $playerO = new AIPlayer('o', $ai);
        break;
    
    case 'O':
    case 'o':
        $playerX = new AIPlayer('x', $ai);
        $playerO = new UserPlayer('o');
        break;
    
    default:
        $playerX = new AIPlayer('x', $ai);
        $playerO = new AIPlayer('o', $ai);
        
        echo "Enter game count\n";
        $gameCount = intval(readline());
        
        if ($gameCount <= 0) {
            $gameCount = 1;
        }
        
        break;
}

$game = new Game();

for ($i = 0; $i < $gameCount; $i ++) {
    echo 'New game #'.($i+1)."\n";
    $game->start();
    while (1) {

        if ($game->isDraw()) {
            $playerX->draw();
            $playerO->draw();
            break;
        }

        $playerX->makeStep($game);
        if ($game->isWin($playerX->getSide())) {
            $playerX->win();
            $playerO->loose();
            break;
        }

        if ($game->isDraw()) {
            $playerX->draw();
            $playerO->draw();
            break;
        }

        $field = $playerO->makeStep($game);
        if ($game->isWin($playerO->getSide())) {
            $playerO->win();
            $playerX->loose();
            break;
        }
    }

    $game->printField();
}

$ai->save();
