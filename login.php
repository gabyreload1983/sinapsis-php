<?php 

require ('./config/dbConnection.php');

$email = $password = '';
$errors = array('login' => '','email' => '', 'password' => '');


if(isset($_POST['submit'])){

  if(empty($_POST['email'])){
    $errors['email'] = 'Must be enter an email';
  }else{
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors['email'] = 'email must be a valid email address';
    }
  }
  
  if(empty($_POST['password'])){
    $errors['password'] = 'Must be enter a password';
  }else{
    $password = $_POST['password'];
    if(strlen($password) < 4){
      $errors['password'] = 'The password must have at least 4 characters ';
    } 
  }

  // check if there is an error
  if(!array_filter($errors)){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // check if the email already exists
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn,$sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(!count($result)){
      $errors['login'] = "The email or password is wrong";
    }else{
        header('Location: index.php');
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include('./templates/header.php') ?>

<div class="container min-vh-100">

<h2>Log in</h2>

<form class="mt-5" action="login.php" method="POST">
    <div class="text-danger">
        <?php echo $errors['login']; ?>
    </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
    <div class="text-danger">
      <?php echo $errors['email']; ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
    <div class="text-danger">
      <?php echo $errors['password']; ?>
    </div>
  </div>
 
  <input name="submit" type="submit" class="btn btn-primary" />
</form>
   

</div>

<?php include('./templates/footer.php') ?>


</html>