<?php                 
    include('connect.php'); 
                    //Retrieve all records and display them
                    $result = pg_query($con, "SELECT * FROM alertnotification WHERE id=1");
                    $data = pg_fetch_all($result,PGSQL_ASSOC);
                    echo json_encode($data);
                    // Used for row color toggle
?>