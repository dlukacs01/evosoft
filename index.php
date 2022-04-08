<?php

require_once "Robot.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>evosoft</title>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 50%;
        }

        td {
            border: 1px solid #000;
            text-align: center;
            padding: 8px;
        }
        table.center {
            margin-left: auto;
            margin-right: auto;
        }
        table tr td.wall-obstacle {
            background-color: lightcoral;
        }
    </style>

</head>
<body>

<?php

// Initialize robot with default row and col coordinates, and set the default direction
$robot = new Robot(5, 3, 0);

// Draw the "starter-state-table" (grid)
$robot->drawRoom();

// Turn on the robot, and let it clean the entire room
$robot->run();

?>

</body>
</html>
