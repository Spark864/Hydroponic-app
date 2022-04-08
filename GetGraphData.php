<?php                 
    include('connect.php'); 
                    //Retrieve all records and display them
                    $date = date('Y-m-d H:i:s');
                    $timestamp = strtotime($date);
                    $date2 = date('Y-m-d H:i:s', strtotime('-1 day'));
                    $timestamp2 = strtotime($date2);
                    $result = pg_query($con, "SELECT * FROM datacollect WHERE date >= '${date2}' AND date <  '${date}'");
                    
                    
                    $data = pg_fetch_all($result,PGSQL_ASSOC);
                    echo json_encode($data);
                    // Used for row color toggle

                  
                   
                    
?>         