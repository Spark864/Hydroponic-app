<?php 
    include('connect.php'); 
          $query = "Select * from controlpanel where id < 3 order by id ";
        $result = pg_query($con,$query);
        
        $data = pg_fetch_all($result,PGSQL_ASSOC); 
        
                    
        $query3 = "Select * from controlpanel where id = 12 order by id ";
        $result = pg_query($con,$query3);
        
        $data2 = pg_fetch_all($result,PGSQL_ASSOC);
        echo json_encode(array($data, $data2));   
            exit;
?>