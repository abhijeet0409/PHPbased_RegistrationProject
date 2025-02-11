<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ioclm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchName = isset($_GET['search']) ? $_GET['search'] : '';

// Select records from the 'entry' table based on search
if (!empty($searchName)) {
    $sql = "SELECT * FROM entry WHERE Name LIKE '%$searchName%' ORDER BY `Entry Time` ASC";
} else {
    $sql = "SELECT * FROM entry ORDER BY `Entry Time` ASC";
}

$result = $conn->query($sql);

// Search form
echo "<form method='get' action='' style='position: absolute; top: 10px; right: 10px;'>";
echo "<strong style='color: white;'>Search by Name:</strong> <input type='text' name='search' value='$searchName'>";
echo "<input type='submit' value='Search' style='color: blue;'>";
echo "</form>";

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Read Data</title>";
echo "<link rel='stylesheet' type='text/css' href='r.css'>";
echo "</head>";
echo "<body style='text-align: center;'>";

echo "<a href='new.html' style='position: absolute; top: 10px; left: 10px; color: yellow; font-weight: bold;'>Go Back</a>";

if ($result->num_rows > 0) {
    // Group data by date from the 'entry time' column
    $dataByDate = array();
    while ($row = $result->fetch_assoc()) {
        $entryDateTime = $row['Entry Time']; // Assuming 'entry time' is the column containing date and time
        $date = date('Y-m-d', strtotime($entryDateTime));
        $dataByDate[$date][] = array_diff_key($row, ['uid' => 0]); // Exclude 'uid' column
    }

    // Sort data by date in ascending order
    ksort($dataByDate);

    foreach ($dataByDate as $date => $data) {
        echo "<h2 style='font-weight: bold; color: white;'>Records for $date</h2>";
        echo "<table border='1' style='margin: 0 auto;'>";
        echo "<tr>";
        $headers = array_keys($data[0]);
        foreach ($headers as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";

        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

        // Add Export button for each table
        echo "<form method='post' action='e.php'>";
        echo "<input type='hidden' name='filename' value='$date.xls'>";
        echo "<input type='hidden' name='data' value='" . htmlspecialchars(json_encode($data)) . "'>";
        echo "<input type='submit' value='Export'>";
        echo "</form>";
    }
} else {
    echo "0 results";
}

echo "</body>";
echo "</html>";

$conn->close();
?>
