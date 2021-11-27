<!DOCTYPE html>
<?php
    
    session_start();
    // Check if the user is already logged in, if yes then redirect him to index page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php");
        exit;
    }
// Start MySQL Connection
include('connect.php'); 
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hydroponic System | Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">

    <?php
        // Define variables and initialize with empty values
        $username = $password = "";
        $username_err = $password_err = $login_err = "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            // Check if username is empty
            if(empty(trim($_POST["username"]))){
                $username_err = "Please enter username.";
            } else{
                $username = trim($_POST["username"]);
            }
            
            // Check if password is empty
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter your password.";
            } else{
                $password = trim($_POST["password"]);
            }
            // Validate credentials
            if(empty($username_err) && empty($password_err)){
                //check if username and password exist
                $result = pg_query($con, "Select * from public.user where username = '$username' and password = '$password'");
                if(pg_num_rows($result)==1){
                    // Store data in session variables
                    session_start();
                    $_SESSION["loggedin"]=true;
                    $_SESSION["id"]=$row["id"];
                    $_SESSION["username"]=$row["username"];
                    // Redirect user to index page
                    header("location: index.php");
                }
                else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            }
        }
    
    ?>

    <div class="login-box">
        <div class="login-logo">
            <b>Hydroponic-App</b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in</p>
                <?php 
                if(!empty($login_err)){
                echo $login_err; 
                }
                ?>

                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-group mb-3">
                        <?php 
                        if (!empty($username_err)){
                            echo $username_err;
                        }
                        ?>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                    <?php 
                        if (!empty($password_err)){
                            echo $password_err;
                        }
                        ?>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                Remember Me
              </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <!-- /.social-auth-links -->

                <!-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">New Registration</a>
                </p> -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>