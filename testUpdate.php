<?php 
    // Start MySQL Connection
    include('connect.php'); 
    
    $alert= "";
        if(isset($_POST['update_wp'])){
            
                
            for ($x = 1; $x <= 7; $x++) {
                $name = 'action' . $x;
                $action = $_REQUEST[$name];
                
                $updateData = "UPDATE controlpanel SET 
                    action='".$action."'
                WHERE id=" . $x;
                pg_query($con,$updateData);

                
              }


                    $alert = '<div class="alert alert-success" role="alert">Records successfully updated</div>';
                
                }

        
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

<form method='post' action=''><?php echo $alert; ?>
                
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        
                        <th>Object</th>
                        <th>Action</th>
                        
                    </tr>
                    <?php 
                    $query = "Select * from controlpanel where id < 8 order by id ";
                    $result = pg_query($con,$query);
                    $loop = 0;
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                        $actionName = 'action' . $row['id'];
                        $loop = 1 + $loop;
                        // echo "<script>console.log('Debug Objects: " . $loop . "' );</script>";
                    ?>
                        <tr>
                            
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= <?php
                                                echo $actionName;
                                            
                                        ?>>
                                    <option value="On"
                                        <?php
                                        if($action == 'On')
                                            {
                                                echo "selected";
                                            }
                                            
                                        ?>
                                        
                                    >On</option>
                                    
                                    <option value="Off"
                                    <?php
                                        if($action == 'Off')
                                            {
                                                echo "selected";
                                                
                                            }
                                        ?>
                                    >Off</option>

                                 </select>
                               
                                
                            </td>

                            
                        </tr>
                    <?php
                    
                    // echo "<script>console.log('Debug Objects: " . $loops . "' );</script>";
                    }
                    ?>
                </table>
                <p><input type='submit' value='Update Selected Records' class="btn btn-success" name='update_wp'></p>
            </form>

<?php
    // $result = pg_query($con, "Select * from controlpanel");

    // echo "<table>";
    //     while($row=pg_fetch_array($result)){
            
    //         echo "<tr>";
    //             echo "<td align='center' width='200'>" . $row['id'] . "</td>";
    //             echo "<td align='center' width='200'>" . $row['object'] . "</td>";

    //             echo "<td align='center' width='200'>" . 
                
    //             . "</td>";
    //         echo "</tr>";
    //     }
    
    // echo "</table>";

?>




</body>


</html>