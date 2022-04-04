<?php

class Robot {

    // defining the room = grid = cells = 2-dimensional array = matrix with rows (X) and columns (Y)
    private array $cells = array(
        array(-1,-1,-1,-1,-1),
        array(-1,0,0,0,-1),
        array(-1,0,0,1,-1),
        array(-1,-1,-1,-1,-1)
    );

    // 0:up, 1:right, 2:down, 3:left - These are PAIRS for moving the robot in the coordinate system
    private array $move_row = array(-1,0,1,0);
    private array $move_col = array(0,1,0,-1);

    private int $current_row;
    private int $current_col;
    private int $current_dir;

    private int $new_row;
    private int $new_col;
    private int $new_dir;

    private bool $no_further = false; // Typed property must not be accessed before initialization

    public function __construct(int $current_row, int $current_col, int $current_dir) {
        $this->current_row = $current_row;
        $this->current_col = $current_col;
        $this->current_dir = $current_dir;
    }

    public function drawRoom() : void {
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

    private function isFree(int $row, int $col) : bool {
        if($this->cells[$row][$col] == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function checkFinish() : bool {
        if($this->cells[$this->current_row][$this->current_col] == 1 && $this->no_further == true) {
            return true;
        } else {
            return false;
        }
    }

    public function run() : void {

        while(!$this->checkFinish()) {

            $this->no_further = true;

            // checking all the surrounding cells
            for($i = 0; $i < 4; $i++) {

                // The direction where the robot wants to go / try first is based on the previous direction
                $this->new_dir = ($this->current_dir + $i) % 4;

                // setting next / surrounding cells, in every direction
                $this->new_row = $this->current_row + $this->move_row[$this->new_dir];
                $this->new_col = $this->current_col + $this->move_col[$this->new_dir];

                // if one of them is free, go ahead
                if($this->isFree($this->new_row, $this->new_col)) {
                    $this->no_further = false;
                    break;
                }
            }

            // [if we have to go back]

            if($this->no_further == true) {

                // If we are on the starter cell, we dont have to go back, since that is our starting point
                if($this->cells[$this->current_row][$this->current_col] != 1) {

                    $i = 0;
                    do {
                        // move until you find the previous cell
                        $this->new_row = $this->current_row + $this->move_row[$i];
                        $this->new_col = $this->current_col + $this->move_col[$i];
                        $i++;
                    } while ($this->cells[$this->new_row][$this->new_col] != $this->cells[$this->current_row][$this->current_col] - 1);

                    $this->current_row = $this->new_row;
                    $this->current_col = $this->new_col;
                    $this->current_dir = 0;

                }

            }

            // [if we dont have to go back]

            else {

                // clean
                $this->cells[$this->new_row][$this->new_col] = $this->cells[$this->current_row][$this->current_col] + 1;

                // move
                $this->current_row = $this->new_row;
                $this->current_col = $this->new_col;

                // update dir
                $this->current_dir = $this->new_dir;

                // draw current HTML table = state
                $this->drawRoom();

            }

        }

    }

}