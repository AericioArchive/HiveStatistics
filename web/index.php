<html lang="en">
<head>
    <title>Hive Player Statistics</title>
    <style>
        table td {
            border-bottom: 2px solid #f1f1f1;
        }
    </style>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript">
        window.onload = function () {
            $.getJSON("assets/script/mysqlConnection.php", function (result) {
                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
                        text: "HiveMC Player Count"
                    },
                    data: [
                        {
                            type: "line",
                            dataPoints: result
                        }
                    ]
                });
                chart.render();
            });
        };
    </script>
</head>
<body>
<div class="main">
    <h1>hivebedrock.network Player Statistics</h1>
    <p>Updated every minute. Time is saved in GMT-10.</p>
    <div id="chartContainer" style="height: 300px; width: 50%;"></div>
    <div id="tableContainer">
        <?php
        $config = parse_ini_file('assets/config.ini');
        $db = new mysqli("hivestatistics.co3nfzhsaik3.us-west-1.rds.amazonaws.com", $config["username"], $config["password"], $config["dbname"], $config["port"]);
        if ($db->connect_error) {
            echo json_encode(["error" => $db->connect_error]);
            return;
        }
        $result = $db->query('SELECT * FROM stats');
        if ($result->num_rows > 0) {
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
</div>
</body>
</html>