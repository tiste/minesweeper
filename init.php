<?php
include_once("minesweeper.php");
session_start();

$minesweeper = new Minesweeper();
$minesweeper->toString();
$_SESSION["board"] = $minesweeper;
?>