<?php 
    // Start MySQL Connection
    include('connect.php'); 
    
    include('checkLogin.php');

    $alert= "";
          if(isset($_POST['btn_update'])){
              
            //Update to database 

            //Turning on/off water pumps and led light 
              for ($x = 1; $x <= 7; $x++) {
                  $name = 'action' . $x;
                  $action = $_REQUEST[$name];
                  
                  $updateData = "UPDATE controlpanel SET 
                      action='".$action."'
                  WHERE id=" . $x;
                  pg_query($con,$updateData);
                }
            
            //Set duration and freqency     
              for ($x = 8; $x <= 10; $x++) {
                $name = 'duration' . $x;
                $action = $_REQUEST[$name];
                
                $updateData = "UPDATE controlpanel SET 
                    action='".$action."'
                WHERE id=" . $x;
                pg_query($con,$updateData);
            }
            $alert = '<div class="alert alert-success" role="alert">Actions successfully updated</div>';
            
          }

          //Set start time 
          if(isset($_POST['update_time'])){
            echo "<script>console.log('Debug time: " . $time . "' );</script>";
            $query = "Select * from controlpanel where id = 10";
            $result = pg_query($con,$query);
            
            $row = pg_fetch_array($result);
                
                $id = $row['id'];
                $object = $row['object'];
                $action = $row['action'];

                echo "<script>console.log('Debug time: " . $action . "' );</script>";
                $number = (int)$action + 10;
                echo "<script>console.log('Debug number: " . $number . "' );</script>";
            for ($x = 11; $x <= $number; $x++) {
            
            $currentTime = 'time' . $x;
            $time  = $_REQUEST[$currentTime];
              
            //echo "<script>console.log('Debug time: " . $time . "' );</script>";

            $sql = "UPDATE controlpanel SET time ='$time' WHERE id =" . $x;
            pg_query($con,$sql);
          
            $alert = '<div class="alert alert-success" role="alert">Times successfully updated</div>';
            }
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
    <a href="index3.html" class="brand-link">
     
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

          <li class="nav-item">
            <a href="aboutUs.php" class="nav-link">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
              <p>
                About Us
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
                    // $loop = 0;
                    while($row = pg_fetch_array($result) ){
                        
                        $id = $row['id'];
                        $object = $row['object'];
                        $action = $row['action'];
                         //$actionName = 'action' . $row['id'];
                        // $loop = 1 + $loop;
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
                    
                    // echo "<script>console.log('Debug Objects: " . $loops . "' );</script>";
                    }

                    $query2 = "Select * from controlpanel where id > 7 and id < 10 order by id ";
                    
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
                  <td><input type='number' name='duration<?= $id ?>' value='<?= $action ?>' ></td>

                  </tr>

                  <?php
                    
                    // echo "<script>console.log('Debug Objects: " . $loops . "' );</script>";
                    }

                    $query2 = "Select * from controlpanel where id = 10 order by id ";
                    
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
                  <td><input type='number' name='duration<?= $id ?>' min="0" max="5" value='<?= $action ?>' ></td>

                  </tr>
                  <?php
                    // }
                    // $query3 = "Select action from controlpanel where id = 10";
                    
                    // $result2 = pg_query($con,$query3);
                    
                    // // echo "<script>console.log('Debug Objects1: " . $result2 . "' );</script>";
                    
                    // $freq = pg_fetch_array($result2); 

                    // $startTime = (int)$freq['action'] + 10;

                    // //echo "<script>console.log('Debug Objects2: " . $startTime . "' );</script>";

                    // $query4 = "Select * from controlpanel where id > 10 and id <=" . $startTime . " order by id";
                    // $result3 = pg_query($con,$query4);

                    // while($row = pg_fetch_array($result3) ){
                     
                    //   $id = $row['id'];
                    //   $object = $row['object'];
                    //   $time = $row['time'];
                    ?>
                  <!-- <tr>
                  <td><?= $object ?></td>
                  
                  <td><input type='time' name='time<?= $id ?>' value='<?= $time ?>' ></td>

                  </tr> -->

                  <?php
                    }
                    ?>

                </table>

                <p><input type='submit' value='Update Actions' class="btn btn-success" name='btn_update'></p>
            </form>

            <form method='post' action=''>
                
                <table class="table table-bordered">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        
                        <th>Object</th>
                        <th>Time</th>
                        
                    </tr>
                    <?php
                    
                    $query3 = "Select action from controlpanel where id = 10";
                    
                    $result2 = pg_query($con,$query3);
                    
                    // echo "<script>console.log('Debug Objects1: " . $result2 . "' );</script>";
                    
                    $freq = pg_fetch_array($result2); 

                    $startTime = (int)$freq['action'] + 10;

                    //echo "<script>console.log('Debug Objects2: " . $startTime . "' );</script>";

                    $query4 = "Select * from controlpanel where id > 10 and id <=" . $startTime . " order by id";
                    $result3 = pg_query($con,$query4);

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

               <p><input type='submit' value='Update Times' class="btn btn-success" name='update_time'></p>
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
