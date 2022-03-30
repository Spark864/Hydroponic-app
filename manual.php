<?php 
    // Start MySQL Connection
    include('connect.php'); 
    
    include('checkLogin.php');
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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manual</h1>
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
                    <h3>Data Page</h3>
                    
                    <b style="font-size: 18px;margin-left:50px;margin-right:50px">Description</b>
                    <p style="font-size: 18px;margin-left:50px;margin-right:50px">&nbsp&nbsp&nbsp&nbsp The user can view 5 parameters from the hydroponic sensor readings. The 5 parameters update every second so the user can monitor the hydroponic in real time. The user can view an 24 hour period hourly graph of the hydroponic parameters that updates every 10 seconds. The user can hover over the data point to see the time and the data of the point. The user can choose a parameter from the 5 parameters. The table below the hourly graph shows all the 5 parameters and the date and time of the data when it is taken. The table is updated every 5 seconds and user can sort the data from descending or ascending and download a pdf of the table.</p>

                    <br>
                    

                    <h3>Control Panel</h3>
                    <b style="font-size: 18px;margin-left:50px;margin-right:50px">Description</b>
                    <p style="font-size: 18px;margin-left:50px;margin-right:50px">&nbsp&nbsp&nbsp&nbsp Control Panel includes several functions that can be changed the status of the devices and settings for controlling the devices. 
                      Its main features are users can set the duration, frequency, and timers for each component (Water Pumps and LED Light). 
                      Also, users can control the components directly through the control panel.
                    </p>
                    <div style="padding-left:50px; padding-right:50px;">
                    <b style="font-size: 18px; ">Functions</b>
                    
                    <table style="font-size: 18px;" class="table table-bordered">

                    <tr>
                      <td>Water Pumps (1, 2, 3) & LED Light</td>
                      <td>It allows users to turn on/off the hardware</td>
                    </tr>
                    <tr>
                      <td>Set Timer</td>
                      <td>This is an option allows users to use the timer for controlling the devices.</td>
                    </tr>

                    <tr>
                      <td>Duration (minutes)</td>
                      <td>It allows users to set the time for how long the device is turned on
                        . Once the time is up, the device will be turned off automatically.
                      </td>
                    </tr>

                    <tr>
                      <td>Frequency (per day)</td>
                      <td>It allows users to set the number of timers they want.</td>
                    </tr>

                    <tr>
                      <td>Timer</td>
                      <td>It allows users to input the time for controlling the devices automatically.</td>
                    </tr>
                    <tr>
                      <td>Preset Temperature</td>
                      <td>It allows users to set the preset the temperature. If the recevied temperature is lower than the preset temperature, the system will turn on the LED light until the recevied te,perature is higher than the preset temperature. </td>
                    </tr>

                    </table>

                    </div>
                   
                    
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
