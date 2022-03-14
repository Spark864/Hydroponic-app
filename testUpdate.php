<?php 
    // Start MySQL Connection
    include('connect.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Test Update</title>
<meta name="description" content="If we want to fetch all rows from the actor table the following PostgreSQL SELECT statement can be used.">
</head>
<body>
<h1>Test Update</h1>


<?php
    $result = pg_query($con, "Select * from controlpanel");

    echo "<table>";
        while($row=pg_fetch_array($result)){
            
            echo "<tr>";
                echo "<td align='center' width='200'>" . $row['id'] . "</td>";
                echo "<td align='center' width='200'>" . $row['object'] . "</td>";
                echo "<td align='center' width='200'>" . $row['action'] . "</td>";
            echo "</tr>";
        }
    
    echo "</table>";

?>

</body>
</html>