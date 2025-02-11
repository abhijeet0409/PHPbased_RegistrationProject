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

// Check if a record deletion request is made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteId = $conn->real_escape_string($_POST['delete']);

    // Delete the record from the database
    $sql = "DELETE FROM entry WHERE uid = $deleteId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully.');</script>";
        echo "<meta http-equiv='refresh' content='0'>"; // Refresh the page
    } else {
        echo "<div style='text-align: center;'>Error deleting record: " . $conn->error . "</div>";
    }
}

// Check if an update request is made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Redirect to update page with the record ID
    header("Location: updation.php?uid=" . $_POST['update']);
    exit;
}

// Search by Name
$searchName = isset($_GET['search']) ? $_GET['search'] : '';
echo "<a href='new.html' style='position: absolute; top: 10px; left: 10px; color: yellow; font-weight: bold;'>Go Back</a>";

if (!empty($searchName)) {
    $sql = "SELECT * FROM entry WHERE Name LIKE '%$searchName%' ORDER BY `Entry Time` ASC";
} else {
    $sql = "SELECT * FROM entry ORDER BY `Entry Time` ASC";
}

$result = $conn->query($sql);

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Manipulate Data</title>";
echo "<link rel='stylesheet' type='text/css' href='r.css'>";
echo "</head>";
echo "<body>";

// Search form
echo "<form method='get' action='' style='position: absolute; top: 10px; right: 10px;'>";
echo "<strong style='color: white;'>Search by Name:</strong> <input type='text' name='search' value='$searchName'>";
echo "<input type='submit' value='Search' style='color: blue;'>";
echo "</form>";

if ($result->num_rows > 0) {
    // Group data by date from the 'Entry Time' column
    $dataByDate = array();
    while ($row = $result->fetch_assoc()) {
        $entryDateTime = $row['Entry Time'];
        $date = date('Y-m-d', strtotime($entryDateTime));
        $dataByDate[$date][] = $row;
    }

    // Sort data by date in ascending order
    ksort($dataByDate);

    // Output data in separate tables for each date
    foreach ($dataByDate as $date => $data) {
        echo "<div style='text-align: center;'>";
        echo "<h2 style='font-weight: bold; color: white;'>Records for $date</h2>";
        echo "<table border='1' style='margin: 0 auto;'>";
        echo "<tr>";

        // Output table headers based on database columns excluding 'uid'
        foreach ($data[0] as $key => $value) {
            if ($key !== 'uid') {
                echo "<th>$key</th>";
            }
        }
        echo "<th>Action</th><th>Update</th></tr>";

        // Output data rows with delete and update buttons in separate columns
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                if ($key !== 'uid') {
                    echo "<td>$value</td>";
                }
            }
            echo "<td><form method='post'><input type='hidden' name='delete' value='" . $row['uid'] . "'><input type='submit' value='Delete' style='color: blue;'></form></td>";
            echo "<td><form method='post'><input type='hidden' name='update' value='" . $row['uid'] . "'><input type='submit' value='Update' style='color: blue;'></form></td></tr>";
        }

        echo "</table>";
        echo "</div>";
    }
} else {
    echo "0 results";
}

echo "</body>";
echo "</html>";

$conn->close();
?>
