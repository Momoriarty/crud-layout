
<head>
    <link rel="stylesheet" type="text/css" href="assest/tictactoe.css">
</head>
<body>
    <h1>Tic Tac Toe</h1>
    <div id="board">
        <?php
        for ($i = 0; $i < 3; $i++) {
            echo "<div class='row'>";
            for ($j = 0; $j < 3; $j++) {
                echo "<div class='cell' onclick='makeMove($i, $j)'></div>";
            }
            echo "</div>";
        }
        ?>
    </div>
    <script src="assest/tictactoe.js"></script>
</body>

