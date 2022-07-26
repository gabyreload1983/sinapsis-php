<?php 
$ordenes = "";

if(isset($_GET['submit'])){
    $estado = $_GET['estado'];
    $url = "$estado";
    $json_data = file_get_contents($url);
    $response_data = json_decode($json_data);

    $ordenes = $response_data->ordenes;

}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('./templates/header.php') ?>

<div class="container min-vh-100">
    <h2>Orders</h2>

    <form action="orders.php" method="get">

        <select type="text" name="estado" class="form-select" aria-label="Default select example">
            <option selected>Open this select menu</option>
            <option value="pendiente">Pendientes</option>
            <option value="en-proceso">En Proceso</option>
            <option value="finalizado">Finalizados</option>
        </select>

        <input type="submit" name="submit" value="Submit">
    </form>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">Orden</th>
      <th scope="col">Cliente</th>
      <th scope="col">Sector</th>
      <th scope="col">Articulo</th>
    </tr>
  </thead>
  <tbody>
    <?php if($ordenes){ ?>
        <?php foreach ($ordenes as $orden) { ?>
            <tr>
                <td><?php echo $orden->nrocompro; ?></td>
                <td><?php echo $orden->nombre; ?></td>
                <td><?php echo $orden->codiart; ?></td>
                <td><?php echo $orden->descart; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
  </tbody>
</table>


<script></script>

<?php include('./templates/footer.php') ?>


</html>