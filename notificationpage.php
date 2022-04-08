<?php 
    // Start MySQL Connection
    include('connect.php'); 
    
    include('checkLogin.php');
    $result = pg_query($con, "SELECT * FROM alertnotification WHERE id=1");
    $data = pg_fetch_all($result,PGSQL_ASSOC);
    
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
<!--      
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
      <li class="nav-item">
        <!-- <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        </a> -->
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <!-- <?php echo $alertLight; ?> -->
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notification Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <style>
    /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  margin: 10px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- general form elements -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Alert Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id = "notificationform">
                <div class="card-body">
                  <div class="form-group">
                    <label>Humidity</label>
                    <input class="form-control" name="alerthumidity" value=<?=$data[0]['humidity']?>>
                    <!-- Rounded switch -->
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Temperature</label>
                    <input class="form-control" name="alerttemperature" value=<?=$data[0]['temperature']?>>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>PH</label>
                    <input class="form-control" name="alertph" value=<?=$data[0]['ph']?>>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>PPM</label>
                    <input class="form-control" name="alertppm" value=<?=$data[0]['ppm']?>>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Sunlight</label>
                    <input class="form-control" name="alertsunlight" value=<?=$data[0]['lum']?>>
                    <label class="switch">
                      <input type="checkbox">
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Tolerance</label>
                    <input class="form-control" name="Tolerance" value=<?=$data[0]['controlTolerance']?>>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="notificationsubmit">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            <?php
              if(isset($_POST["notificationsubmit"])){
                if(isset($_POST["alerthumidity"])){
                  echo 
                  $updateData = "UPDATE alertnotification SET humidity = ". $_POST["alerthumidity"];
                  pg_query($con,$updateData);
                }
                if(isset($_POST["alerttemperature"])){
                  $updateData = "UPDATE alertnotification SET temperature = ". $_POST["alerttemperature"];
                  pg_query($con,$updateData);
                }
                if(isset($_POST["alertph"])){
                  $updateData = "UPDATE alertnotification SET ph = $_POST[alertph]";
                  pg_query($con,$updateData);
                }
                if(isset($_POST["alertppm"])){
                  $updateData = "UPDATE alertnotification SET ppm = $_POST[alertppm]";
                  pg_query($con,$updateData);
                }
                if(isset($_POST["alertsunlight"])){
                  $updateData = "UPDATE alertnotification SET lum = $_POST[alertsunlight]";
                  pg_query($con,$updateData);
                }
                if(isset($_POST["Tolerance"])){
                  $updateData = "UPDATE alertnotification SET controlTolerance = $_POST[Tolerance]";
                  pg_query($con,$updateData);
                }
              }
            ?>


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

<script>

</script>
</body>
</html>
