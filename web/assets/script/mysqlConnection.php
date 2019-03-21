<?php
$config = parse_ini_file('../config.ini');
$db = new mysqli("hivestatistics.co3nfzhsaik3.us-west-1.rds.amazonaws.com", $config["username"], $config["password"], $config["dbname"], $config["port"]);
if ($db->connect_error) {
    echo json_encode(["error" => $db->connect_error]);
    return;
}
$data_points = [];
$result = $db->query('SELECT * FROM stats');
while ($row = $result->fetch_assoc()) {
    $point = ["x" => $row['id'], "y" => $row['players']];
    array_push($data_points, $point);
}
echo json_encode($data_points, JSON_NUMERIC_CHECK);
$db->close();
?>