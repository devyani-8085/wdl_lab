<?php

$file = "data.json";

if (!file_exists($file)) {
    echo "No data found";
    exit;
}

$data = json_decode(file_get_contents($file), true);

echo "<h2>Stored User Data</h2>";

echo "<pre>";
print_r($data);
echo "</pre>";

?>