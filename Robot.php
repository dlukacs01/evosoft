<?php

class Robot {

    // defining the room = grid = cells = 2-dimensional array = matrix with rows (X) and columns (Y)
    public $cells = array(
        array(-1,-1,-1,-1,-1),
        array(-1,0,0,0,-1),
        array(-1,0,0,1,-1),
        array(-1,-1,-1,-1,-1)
    );

    // up, right, down and left - These are PAIRS for moving the robot in the coordinate system
    public $move_row = array(-1,0,1,0);
    public $move_col = array(0,1,0,-1);

    public $currentRow;
    public $currentCol;
    public $currentDir;

    public $newRow;
    public $newCol;
    public $newDir;

    public $nincs_tovabb;

    function __construct($currentRow, $currentCol, $currentDir) {
        $this->currentRow = $currentRow;
        $this->currentCol = $currentCol;
        $this->currentDir = $currentDir;
    }

    function drawRoom() {
        echo "<table class='center'>";

        foreach($this->cells as $rows) {
            echo "<tr>";
            foreach($rows as $value) {
                if($value == -1) {
                    echo "<td class='wall-obstacle'>".$value."</td>";
                } else {
                    echo "<td>".$value."</td>";
                }
            }
            echo "</tr>";
        }

        echo "</table>";
        echo "<br>";
    }

    function isFree($row, $col) {
        if($this->cells[$row][$col] == 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkFinish() {
        if($this->cells[$this->currentRow][$this->currentCol] == 1 && $this->nincs_tovabb == true) {
            return true;
        } else {
            return false;
        }
    }

    function run() {

        while(!$this->checkFinish()) {

            $this->nincs_tovabb = true;

            for($i = 0; $i < 4; $i++) {

                $this->newDir = ($this->currentDir + $i) % 4;

                $this->newRow = $this->currentRow + $this->move_row[$this->newDir];
                $this->newCol = $this->currentCol + $this->move_col[$this->newDir];

                // ha valamelyik irányban találok szabad cellát
                if($this->isFree($this->newRow, $this->newCol)) {
                    $this->nincs_tovabb = false;
                    break;
                }
            }

            // [ha vissza kell lépni]

            if($this->nincs_tovabb == true) {

                // ha nem a kezdeti cellában vagyunk
                if($this->cells[$this->currentRow][$this->currentCol] != 1) {

                    $i = 0;
                    do {
                        // move until you find the previous cell
                        $this->newRow = $this->currentRow + $this->move_row[$i];
                        $this->newCol = $this->currentCol + $this->move_col[$i];
                        $i++;
                    } while ($this->cells[$this->newRow][$this->newCol] != $this->cells[$this->currentRow][$this->currentCol] - 1);

                    $this->currentRow = $this->newRow;
                    $this->currentCol = $this->newCol;
                    $this->currentDir = 0;

                }

            }

            // [ha nem kell visszalépni]

            else {

                // clean
                $this->cells[$this->newRow][$this->newCol] = $this->cells[$this->currentRow][$this->currentCol] + 1;

                // move
                $this->currentRow = $this->newRow;
                $this->currentCol = $this->newCol;

                // update dir
                $this->currentDir = $this->newDir;

                $this->drawRoom();

            }

        }

    }

}