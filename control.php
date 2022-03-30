<?php 
    // Start MySQL Connection
    include('connect.php'); 
  
    include('checkLogin.php');

    $alert= "";
    $alertLight= "";
    

    $sql = "Select lum from datacollect Order by id desc limit 1";
    
    $result = pg_query($con,$sql);
    
    while($row = pg_fetch_array($result) ){
        $lum = $row['lum'];
    }

    if ($lum > 10){
        $alertLight = '<div class="alert alert-warning" role="alert">
        Warning! Lumen is higher than 2 
      </div>';
    }
    // ------------------Water Pump 1 and 2--------------------------------
          if(isset($_POST['update_wp'])){
           
                for ($x = 1; $x <= 4; $x++) {
                  $name = 'action' . $x;
                  $action = $_REQUEST[$name];
                  
                  $updateData = "UPDATE controlpanel SET 
                      action='".$action."'
                  WHERE id=" . $x;
                  pg_query($con,$updateData);
                }
            
            $alert = '<div id = "alert" class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Successfully Updated</strong>
          </div>';
          header('Location: control.php');
          }
          
          // ------------------Water Pump 1 & 2 timer--------------------------------
          if(isset($_POST['update_timer_wp'])){
           
            for ($x = 5; $x <= 6; $x++) {
              $name = 'action' . $x;
              $action = $_REQUEST[$name];
              
              $updateData = "UPDATE controlpanel SET 
                  action='".$action."'
              WHERE id=" . $x;
              pg_query($con,$updateData);
             
            }

            $query = "Select * from controlpanel where id = 4";
            $result = pg_query($con,$query);
            
            $row = pg_fetch_array($result);
                
                $id = $row['id'];
                $object = $row['object'];
                $action = $row['action'];

                //echo "<script>console.log('Debug action: " . $action . "' );</script>";
                $number = (int)$action + 6;
               

            for ($x = 7; $x <= $number; $x++) {
            
            $currentTime = 'time' . $x;
            $time  = $_REQUEST[$currentTime];
              
            

            $sql = "UPDATE controlpanel SET time ='$time' WHERE id =" . $x;
            pg_query($con,$sql);
          
            $alert = '<div id = "alert" class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Successfully Updated</strong>
          </div>';
          }
          header('Location: control.php');
        }
        //------------------Water Pump 3--------------------------------
          //Set start time 

          if(isset($_POST['update_wp3'])){
            
            for ($x = 12; $x <= 13; $x++) {
              $name = 'action' . $x;
              $action = $_REQUEST[$name];
              
              $updateData = "UPDATE controlpanel SET 
                  action='".$action."'
              WHERE id=" . $x;
              pg_query($con,$updateData);
             
            }
            $name = 'action26';
            $action = $_REQUEST[$name];
            $sql = "UPDATE controlpanel SET action ='$action' WHERE id = 26";
            pg_query($con,$sql);

            $currentTime = 'time14';
            $time  = $_REQUEST[$currentTime];
              
            //echo "<script>console.log('Debug time: " . $time . "' );</script>";

            $sql = "UPDATE controlpanel SET time ='$time' WHERE id = 14";
            pg_query($con,$sql);
          
            $alert = '<div id = "alert" class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Successfully Updated</strong>
          </div>';
          header('Location: control.php');
          }

        //------------------LED Light--------------------------------
        if(isset($_POST['update_led'])){
           
          for ($x = 15; $x <= 18; $x++) {
              $name = 'action' . $x;
              $action = $_REQUEST[$name];
              
              $updateData = "UPDATE controlpanel SET 
                  action='".$action."'
              WHERE id=" . $x;
              pg_query($con,$updateData);
            }
        
            $alert = '<div id = "alert" class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Successfully Updated</strong>
          </div>';
          header('Location: control.php');
      }

      //------------------LED Light Timer--------------------------------
      if(isset($_POST['update_time_led'])){
       
          $name = 'action20';
          $action = $_REQUEST[$name];
          
          $updateData = "UPDATE controlpanel SET 
              action='".$action."'
          WHERE id=20";
          pg_query($con,$updateData);
         
        $query = "Select * from controlpanel where id = 18";
        $result = pg_query($con,$query);
        
        $row = pg_fetch_array($result);
            
            $id = $row['id'];
            $object = $row['object'];
            $action = $row['action'];

          
            $number = (int)$action + 20;
           

        for ($x = 21; $x <= $number; $x++) {
        
        $currentTime = 'time' . $x;
        $time  = $_REQUEST[$currentTime];
          
       
        $sql = "UPDATE controlpanel SET time ='$time' WHERE id =" . $x;
        pg_query($con,$sql);
      
        $alert = '<div id = "alert" class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Successfully Updated</strong>
          </div>';
      }
      header('Location: control.php');
    }

    


                
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hydroponic app</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script>
          window.setTimeout(function() {
          $("#alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove(); 
          });
      }, 4000);
      
      
        </script>
        <style>
      .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
      }

      .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
      }

      .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
      }

      .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
      }

      input:checked + .slider {
        background-color: #2196F3;
      }

      input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
      }

      input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
        border-radius: 34px;
      }

      .slider.round:before {
        border-radius: 50%;
      }


</style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
        <button onclick="window.location ='logout.php'">
          <i class="fas fa-sign-out-alt"></i> Logout
          
      </button>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
     
      <span class="brand-text font-weight-light">Hydroponic System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      

      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="index.php" class="nav-link">
            <i class="fa fa-home" aria-hidden="true"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="data.php" class="nav-link">
            <i class="fa fa-database" aria-hidden="true"></i>
              <p>
                Data
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="control.php" class="nav-link">
            <i class="fa fa-cog" aria-hidden="true"></i>
              <p>
                Control Panel
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="manual.php" class="nav-link">
            <i class="fa fa-book" aria-hidden="true"></i>
              <p>
                Manual
              </p>
            </a>
          </li>

          
         
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Main content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <?php echo $alertLight; ?>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
            <h1>Control Panel</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
    <section class="content">
        <div class="container-fluid">
      
                    <!-- /.row -->
            <div class="row">
            <div class="col-12">
                

                <div class="card">
                
                <!-- /.card-header -->
                <div class="card-body" >


                <!------------------------------------- Water Pump 1 and 2 ------------------------------------------>
                
                <form method='post' action=''>
                
                  <?php echo $alert; ?>
                  
                <h3>Water Pump 1 & 2 (For Plants)</h3>
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        <th>Object</th>
                        <th>Action</th>
                        
                    </tr>
                    <?php 
                     $query = "Select * from controlpanel where id < 3 order by id ";
                    $result = pg_query($con,$query);
                   
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                         
                    ?>
                        <tr>
                            
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= 'action<?= $id ?>'>
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
                    
                    
                    }

                    $query2 = "Select * from controlpanel where id = 3 order by id ";
                    
                    $result = pg_query($con,$query2);
                    while($row = pg_fetch_array($result) ){
                        
                      $id = $row['id'];
                      $object = $row['object'];
                      $action = $row['action'];
                      
                  ?>

                  <tr>
                  <td><?= $object ?></td>
                  <td><input type='number' name='action<?= $id ?>' value='<?= $action ?>' min="0" style="width: 4em" ></td>

                  </tr>

                  <?php
                    
                   
                    }

                    $query2 = "Select * from controlpanel where id = 4 order by id ";
                    
                    $result = pg_query($con,$query2);
                    while($row = pg_fetch_array($result) ){
                        
                      $id = $row['id'];
                      $object = $row['object'];
                      $action = $row['action'];
                      
                  ?>

                  <tr>
                  <td><?= $object ?> </td>
                  <td><input type='number' name='action<?= $id ?>' min="1" max="5" value='<?= $action ?>' style="width: 4em"></td>

                  </tr>
                  <?php
                     }
                    
                    ?>
                  <!-- <tr>
                  <td><?= $object ?></td>
                  
                  <td><input type='time' name='time<?= $id ?>' value='<?= $time ?>' ></td>

                  </tr> -->

                 

                </table>

                <p><input type='submit' value='Update' class="btn btn-success" name='update_wp'></p>
            </form>

            <!------------------------------------- Set Timer - Water Pump 1 & 2 ------------------------------------------>
            <form method='post' action=''>
                <h3>Water Pump 1 & 2 - Set Timer</h3>
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        <th>Object</th>
                        <th>Timer</th>
                        
                    </tr>
                   
                  <?php 
                     $query3 = "Select * from controlpanel where id > 4 and id < 7 order by id ";
                    $result = pg_query($con,$query3);
                   
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                        //echo "<script>console.log('Debug Objects1: " . $id . "' );</script>";
                         
                    ?>
                        <tr>
                            
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= 'action<?= $id ?>'>
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
                    }
                     $query4 = "Select action from controlpanel where id = 4";
                    
                    $frequency = pg_query($con,$query4);
                    
                    // echo "<script>console.log('Debug Objects1: " . $result2 . "' );</script>";
                    
                    $freq = pg_fetch_array($frequency); 

                    $startTime = (int)$freq['action'] + 6;

                    //echo "<script>console.log('Debug Objects2: " . $startTime . "' );</script>";

                    $query5 = "Select * from controlpanel where id > 6 and id <=" . $startTime . " order by id";
                    $result3 = pg_query($con,$query5);

                    while($row = pg_fetch_array($result3) ){
                     
                      $id = $row['id'];
                      $object = $row['object'];
                      $time = $row['time'];
                    ?>
                    <tr>
                  <td><?= $object ?></td>
                  
                  <td><input type='time' name='time<?= $id ?>' step='any' value='<?= $time ?>' ></td>

                  </tr>
                  <?php
                    }
                    ?>
                </table>

               <p><input type='submit' value='Update' class="btn btn-success" name='update_timer_wp'></p>
            </form>

            <!------------------------------------- Water Pump 3 ------------------------------------------>
            <form method='post' action=''>
                <h3>Water Pump 3 (For Filtering)</h3>
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        <th>Object</th>
                        <th>Action</th>
                        
                    </tr>
                   
                  <?php 
                     $query3 = "Select * from controlpanel where id = 12 order by id ";
                    $result = pg_query($con,$query3);
                   
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                         
                    ?>
                        <tr>
                            
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= 'action<?= $id ?>'>
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
                  }
                  $query2 = "Select * from controlpanel where id = 13 order by id ";
                  
                  $result = pg_query($con,$query2);
                  while($row = pg_fetch_array($result) ){
                      
                    $id = $row['id'];
                    $object = $row['object'];
                    $action = $row['action'];
                    //$actionName = 'action' . $row['id'];
                    //$loop = 1 + $loop;
                    // echo "<script>console.log('Debug Objects: " . $loop . "' );</script>";
                ?>
                <tr>
                <td><?= $object ?></td>
                <td><input type='number' name='action<?= $id ?>' value='<?= $action ?>' min="0" style="width: 4em"></td>

                </tr>    

                <?php
                  }
                
                  $query2 = "Select * from controlpanel where id = 26 order by id ";
                  
                  $result = pg_query($con,$query2);
                  while($row = pg_fetch_array($result) ){
                      
                    $id = $row['id'];
                    $object = $row['object'];
                    $action = $row['action'];
                    //$actionName = 'action' . $row['id'];
                    //$loop = 1 + $loop;
                    // echo "<script>console.log('Debug Objects: " . $loop . "' );</script>";
                ?>
                <tr>
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= 'action<?= $id ?>'>
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
                    }
                    
                    $query5 = "Select * from controlpanel where id = 14 order by id";
                    $result3 = pg_query($con,$query5);

                    while($row = pg_fetch_array($result3) ){
                     
                      $id = $row['id'];
                      $object = $row['object'];
                      $time = $row['time'];
                    ?>
                    <tr>
                  <td><?= $object ?></td>
                  
                  <td><input type='time' name='time<?= $id ?>' step='any' value='<?= $time ?>' ></td>

                  </tr>
                  <?php
                    }
                    ?>
                </table>
                    
               <p><input type='submit' value='Update' class="btn btn-success" name='update_wp3'></p>
            </form>

             <!------------------------------------- LED Light ------------------------------------------>
            <form method='post' action=''>
                <h3>LED Light</h3>
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        <th>Object</th>
                        <th>Action</th>
                        
                    </tr>
                    <?php 
                     $query = "Select * from controlpanel where id = 15 order by id ";
                    $result = pg_query($con,$query);
                   
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                         
                    ?>
                        <tr>
                            
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= 'action<?= $id ?>'>
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
                    
                    
                    }

                    $query2 = "Select * from controlpanel where id = 16 order by id ";
                    
                    $result = pg_query($con,$query2);
                    while($row = pg_fetch_array($result) ){
                        
                      $id = $row['id'];
                      $object = $row['object'];
                      $action = $row['action'];
                      //$actionName = 'action' . $row['id'];
                      //$loop = 1 + $loop;
                      // echo "<script>console.log('Debug Objects: " . $loop . "' );</script>";
                  ?>

                  <tr>
                  <td><?= $object ?></td>
                  <td><input type='number' name='action<?= $id ?>' step="any" min="0" value='<?= $action ?>' style="width: 4em"></td>

                  </tr>

                  <?php
                    
                    }

                    $query2 = "Select * from controlpanel where id = 17 order by id ";
                    
                    $result = pg_query($con,$query2);
                    while($row = pg_fetch_array($result) ){
                        
                      $id = $row['id'];
                      $object = $row['object'];
                      $action = $row['action'];
                      
                  ?>

                  <tr>
                  <td><?= $object ?></td>
                  <td><input type='number' name='action<?= $id ?>' min="0" value='<?= $action ?>' style="width: 4em"></td>

                  </tr>
                  <?php
                    
                    }

                    $query2 = "Select * from controlpanel where id = 18 order by id ";
                    
                    $result = pg_query($con,$query2);
                    while($row = pg_fetch_array($result) ){
                        
                      $id = $row['id'];
                      $object = $row['object'];
                      $action = $row['action'];
                      
                  ?>

                  <tr>
                  <td><?= $object ?></td>
                  <td><input type='number' name='action<?= $id ?>' min="1" max="5" value='<?= $action ?>' style="width: 4em"></td>

                  </tr>
                  <?php
                     }
                    
                    ?>
                  <!-- <tr>
                  <td><?= $object ?></td>
                  
                  <td><input type='time' name='time<?= $id ?>' value='<?= $time ?>' ></td>

                  </tr> -->

                 

                </table>

                <p><input type='submit' value='Update' class="btn btn-success" name='update_led'></p>
            </form>

             <!------------------------------------- Set Timer - LED Light ------------------------------------------>
            <form method='post' action=''>
                <h3>LED Light - Set Timer</h3>
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        <th>Object</th>
                        <th>Timer</th>
                        
                    </tr>
                    <?php 
                     $query = "Select * from controlpanel where id = 20 order by id ";
                    $result = pg_query($con,$query);
                   
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                         
                    ?>
                        <tr>
                            
                            
                            <td><?= $object ?></td>
                            <td>
                                <select name= 'action<?= $id ?>'>
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
                }  
                     $query4 = "Select action from controlpanel where id = 18";
                    
                    $frequency = pg_query($con,$query4);
                    
                    // echo "<script>console.log('Debug Objects1: " . $result2 . "' );</script>";
                    
                    $freq = pg_fetch_array($frequency); 

                    $startTime = (int)$freq['action'] + 20;

                    //echo "<script>console.log('Debug Objects2: " . $startTime . "' );</script>";

                    $query5 = "Select * from controlpanel where id > 20 and id <=" . $startTime . " order by id";
                    $result3 = pg_query($con,$query5);

                    while($row = pg_fetch_array($result3) ){
                     
                      $id = $row['id'];
                      $object = $row['object'];
                      $time = $row['time'];
                    ?>
                    <tr>
                  <td><?= $object ?></td>
                  
                  <td><input type='time' name='time<?= $id ?>' step='any' value='<?= $time ?>' ></td>

                  </tr>
                  <?php
                    }
                    ?>
                </table>

               <p><input type='submit' value='Update' class="btn btn-success" name='update_time_led'></p>
            </form>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
        <!-- /.row -->
        </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- <button onclick="window.open('logout.php')">Logout</button> -->

  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
     
    </div>
    
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->

</body>
</html>
