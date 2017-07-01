<?php
ob_start();
session_start();
require_once 'connect.php';


// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" ) {
    header("Location: home.php");
    exit;
}

$error = false;

if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs

  if(empty($email)){
    $error = true;
    $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if(empty($pass)){
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing using SHA256

        $res=mysqli_query($link, "SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
        
        if( $count == 1 && $row['userPass']==$password ) {
            $_SESSION['user'] = $row['userId'];
            header("Location: home.php");
         } else {
            $errMSG = "Incorrect Credentials, Try again...";
         }

    }

}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>BoulderTracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="container">

 <div class="jumbotron">
  <h1>What's Up!  Thanks for trying out the app!</h1>
  
  <p>This is where I'll periodically post updates about what has changed or is being worked on.</p>
     <p>Current Version: 1.1</p><br>
  Ready for Testing:
  <ul>
      <li>Search should completely work now! <br> (try it with "tjpage@indiana.edu" or "test@tester.com")
      </li>
 </ul>
 
 In Progress:
 <ul>
      <li>Commenting on other people's climbs</li>
      <li>Getting List of Users</li>
      <li>User profile pages</li>
      <li>Password Recovery/Change</li>
 </ul>
 
</div>

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

     <div class="col-md-12">

         <div class="form-group">
             <h2 class="">Sign In.</h2>
            </div>

         <div class="form-group">
             <hr />
            </div>

            <?php
   if ( isset($errMSG) ) {

    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
             </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
            <a href="register.php">Sign Up Here</a>
            </div>

        </div>

    </form>
    </div>

</div>

</body>
</html>
<?php ob_end_flush(); ?>