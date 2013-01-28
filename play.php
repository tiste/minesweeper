<?php
include_once("minesweeper.php");
session_start();

if (isset($_POST["row"]) && isset($_POST["col"])) {
	$minesweeper = $_SESSION["board"];
	$board = $minesweeper->board;
	$row = $_POST["row"];
	$col = $_POST["col"];

	if ($board[$row][$col]->value != -1) {
		$board[$row][$col]->value = $minesweeper->haveAdjacent($row, $col);
	} else {
		$minesweeper->lose = 1;
	}

	$minesweeper->toString();
}
?>