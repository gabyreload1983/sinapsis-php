<?php 

require ('./config/dbConnection.php');

// write a query
$sql = 'SELECT * FROM users';

// make query & get result
$result = mysqli_query($conn,$sql);

// fetch the resulting rows as an array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection
mysqli_close($conn); 


?>

<!DOCTYPE html>
<html lang="en">

<?php include('./templates/header.php') ?> 

<div class="container min-vh-100">
    <h2>Users</h2>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">CODIGO</th>
      <th scope="col">EMAIL</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($users as $user) { ?>
    <tr>
      <td><?php echo $user['id']; ?></td>
      <td><?php echo $user['code']; ?></td>
      <td><?php echo $user['email']; ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>

   

</div>

<?php include('./templates/footer.php') ?> 


</html>