<?php                 
    include('connect.php'); 
                    //Retrieve all records and display them
                    $result = pg_query($con, "SELECT * FROM datacollect WHERE id=(SELECT max(id) FROM datacollect)");
                    $data = pg_fetch_all($result,PGSQL_ASSOC);
                    echo json_encode($data);
                    // Used for row color toggle
                    
?>   
