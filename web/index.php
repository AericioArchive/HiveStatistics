<html lang="en">
<head>
    <title>Hive Player Statistics</title>
    <style>
        table td {
            border-bottom: 2px solid #f1f1f1;
        }
    </style>
</head>
<body>
<div class="main">
    <h1>hivebedrock.network Player Statistics (minutes collected: 357)</h1>
</div>
<div class="php_script">
    <?php
    $db = new mysqli("db4free.net", "aericio", "3bJDGkw85g6sHnZN", "hivestatistics");
    if ($db->connect_error) {
        echo json_encode(["error" => $db->connect_error]);
        return;
    }

    $result = $db->query('SELECT * FROM stats');
    if ($result == false) {
        echo "result = false";
    } else {
        echo "result = true";
    }

    if ($result->num_rows < 0) {
        echo '<table>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr><td>' . $row['id'] . '</td><td>' . $row['time'] . '</td><td>' . $row['players'] . '</td></tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No data to display</p>';
    }
    $db->close();
    ?>
</div>
</body>
</html>