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

$uid = isset($_GET['uid']) ? $_GET['uid'] : ''; // Check if 'uid' is set in $_GET

// Fetch existing data for the specified uid
$sql = "SELECT * FROM entry WHERE uid = '$uid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['Name'];
    $purpose = $row['Purpose'];
    $phone = $row['Phone No.'];
    $type = $row['Type'];
    $entryTime = $row['Entry Time'];
    $exitTime = $row['Exit Time'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['update'])) {
        $updates = array();
        
        if(!empty($_POST['new_name'])) {
            $updates[] = "Name = '".$conn->real_escape_string($_POST['new_name'])."'";
        }
        if(!empty($_POST['new_purpose'])) {
            $updates[] = "Purpose = '".$conn->real_escape_string($_POST['new_purpose'])."'";
        }
        if(!empty($_POST['new_phone'])) {
            $updates[] = "`Phone No.` = '".$conn->real_escape_string($_POST['new_phone'])."'";
        }
        if(!empty($_POST['new_type'])) {
            $updates[] = "Type = '".$conn->real_escape_string($_POST['new_type'])."'";
        }
        if(!empty($_POST['new_entrydt'])) {
            $updates[] = "`Entry Time` = '".$conn->real_escape_string($_POST['new_entrydt'])."'";
        }
        if(!empty($_POST['new_exitdt'])) {
            $updates[] = "`Exit Time` = '".$conn->real_escape_string($_POST['new_exitdt'])."'";
        }

        if (!empty($updates)) {
            // Update data in the database based on UID
            $sql = "UPDATE entry SET " . implode(", ", $updates) . " WHERE uid = '$uid'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Record updated successfully');</script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "No fields to update.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Data</title>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; color: #333;">UPDATE DATA HERE</h2>
        <div style="text-align: right; padding: 10px;">
            <a href="new.html" class="go-back-link">Go Back</a>
            <link rel="stylesheet" type="text/css" href="updation.css">
        </div>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?uid='.$uid; ?>">
            New Name: <input type="text" name="new_name" value="<?php echo isset($name) ? $name : ''; ?>"><br>
            New Purpose: <input type="text" name="new_purpose" value="<?php echo isset($purpose) ? $purpose : ''; ?>"><br>
            New Phone: <input type="text" name="new_phone" value="<?php echo isset($phone) ? $phone : ''; ?>"><br>
            New Type: <input type="" name="new_type" value="<?php echo isset($type) ? $type : ''; ?>"><br>
            New Entry Time: <input type="datetime-local" name="new_entrydt" value="<?php echo isset($entryTime) ? $entryTime : ''; ?>"><br>
            New Exit Time: <input type="datetime-local" name="new_exitdt" value="<?php echo isset($exitTime) ? $exitTime : ''; ?>"><br>
            <input type="submit" name="update" value="Update" style="background-color: #007bff; color: white; text-align: center;">
        </form>
    </div>
</body>
</html>
