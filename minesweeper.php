<?php

class Cell {
	private $row;
	private $col;
	public $value;
	public $visible;

	function __construct($row, $col) {
		$this->row = $row;
		$this->col = $col;
		$this->value = 0;
		$this->visible = false;
	}
}


class Minesweeper {
	private $nbCell;
	public $board = array();
	public $boardVisited = array();
	public $lose = 0;

	function __construct() {
		$this->nbCell = 10;

		for ($i=1; $i<=$this->nbCell; $i++) {
			for ($j=1; $j<=$this->nbCell; $j++) {
				$this->board[$i][$j]=new Cell($i, $j);
			}
		}

		for ($i=1; $i<=$this->nbCell; $i++) {
			$this->board[rand(1, $this->nbCell)][rand(1, $this->nbCell)]->value = -1;
		}
	}

	function toString() {
		$board = "<table>";
		for ($i=1; $i<=$this->nbCell; $i++) {
			$board .= "<tr>";
			for ($j=1; $j<=$this->nbCell; $j++) {
				$board .= "<td class='btn".(($this->board[$i][$j]->value==-1 && $this->lose) ? ' btn-danger' : '').(($this->board[$i][$j]->visible) ? ' disabled' : '')."' onclick='clickTd(this)' id='".$i.";".$j."'>".(($this->board[$i][$j]->visible) ? $this->board[$i][$j]->value : '')."</td>";
			}
			$board .= "</tr>";
		}
		$board .= "</table>";

		$this->setNotVisited();
		echo($board);

		if ($this->lose) {
			echo("<div id='lose'><h1>You lose</h1></div>");
		} else if ($this->haveWin()) {
			echo("<div id='lose'><h1>You win</h1></div>");
		}
	}

	function haveWin() {
		$flag=1;
		for ($i=1; $i<=$this->nbCell ; $i++) { 
			for ($j=1; $j<=$this->nbCell ; $j++) { 
				if (!$this->board[$i][$j]->visible && $this->board[$i][$j]->value!=-1) {
					$flag=0;
				} 
			}
		}

		return $flag;
	}

	function setNotVisited() {
		for ($i=1; $i<=$this->nbCell ; $i++) { 
			for ($j=1; $j<=$this->nbCell ; $j++) { 
				$this->boardVisited[$i][$j] = false;
			}
		}
	}

	function haveAdjacent($row, $col) {
		if ($row>0 && $row<=$this->nbCell && $col>0 && $col<=$this->nbCell && !$this->boardVisited[$row][$col]) {
			$this->boardVisited[$row][$col] = true;
			$nbBomb=0;

			if (isset($this->board[$row-1][$col]) && $this->board[$row-1][$col]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row-1][$col+1]) && $this->board[$row-1][$col+1]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row][$col+1]) && $this->board[$row][$col+1]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row+1][$col+1]) && $this->board[$row+1][$col+1]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row+1][$col]) && $this->board[$row+1][$col]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row+1][$col-1]) && $this->board[$row+1][$col-1]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row][$col-1]) && $this->board[$row][$col-1]->value==-1) {
				$nbBomb++;
			}

			if (isset($this->board[$row-1][$col-1]) && $this->board[$row-1][$col-1]->value==-1) {
				$nbBomb++;
			}

			if (!$nbBomb) {
				$this->haveAdjacent($row-1, $col);
				$this->haveAdjacent($row, $col+1);
				$this->haveAdjacent($row+1, $col);
				$this->haveAdjacent($row, $col-1);
			}

			$this->board[$row][$col]->visible = true;
			$this->board[$row][$col]->value = $nbBomb;

			return $nbBomb;
		}
	}
}

?>