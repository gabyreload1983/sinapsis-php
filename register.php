<?php 

require ('./config/dbConnection.php');

$code = $email = $password = '';
$errors = array('code' => '', 'email' => '', 'password' => '');


if(isset($_POST['submit'])){

  if(empty($_POST['code'])){
    $errors['code'] = 'Must be enter a code';
  }else{
    $code = $_POST['code'];
    if(strlen($code) < 3){
      $errors['code'] = 'The code must have at least 3 characters ';
    }
  }
  
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
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // check if the code already exists
    $sql = "SELECT * FROM users WHERE code = '$code'";
    $result = mysqli_query($conn,$sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(count($result)){
      $errors['code'] = "The code $code already exists";
    }
    
    // check if the email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(count($result)){
      $errors['email'] = "The email $email already exists";
    }

    // check if there is an error
    if(!array_filter($errors)){

      $sql = "INSERT INTO users(code, email, password) VALUES ('$code', '$email', '$password')";
      if(mysqli_query($conn,$sql)){
        // success
        header('Location: home.php');
      }else{
        //error
        echo 'query error: ' . mysqli_error($conn);
      }
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include('./templates/header.php') ?>

<div class="container min-vh-100">
  <h2>Register</h2>

<form class="mt-5" action="register.php" method="POST">
  <div class="mb-3">
    <label for="code" class="form-label">code Tecnico</label>
    <input type="text" class="form-control" id="code" name="code" value="<?php echo htmlspecialchars($code) ?>">
    <div class="text-danger">
      <?php echo $errors['code']; ?>
    </div>
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