<!DOCTYPE html>
<html lang="pt_BR">
  <head>
    <meta charset="utf-8">

    <title>Calculadora IP </title>

    <!-- Bootstrap CSS -->
    <link href="template/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="template/login.css" rel="stylesheet">

  </head>

  <body>

	<?php
	if(!empty($msg)){	
		echo "  <br><br>
			<div class='row'>
				<div class='container'>
					<div class='alert alert-danger'>
						<strong> ".$msg." </strong>
					</div>
				</div>
			</div>
			<br><br>";
	}
	?>
    
    <div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading"><center>Calculadora IP IPv4</center></h2><br><br>
        <label for="ip" class="sr-only">IP</label>
        <input type="text" id="ip" name="ip" class="form-control" value="<?php echo $_POST['ip']; ?>" placeholder="IP = 192.168.0.1" required autofocus><br>
        <label for="mascara" class="sr-only">M&aacute;scara</label>
        <input type="text" id="mascara" name="mascara" class="form-control" value="<?php echo $_POST['mascara']; ?>" placeholder="Mascara= 24" required><br>
        <label for="mascara" class="sr-only">Subnet</label>
        <input type="text" id="subnet" name="subnet" class="form-control" value="<?php echo $_POST['subnet']; ?>"><br><br>
        <button class="btn btn-lg btn-primary btn-block" name="calcular" value=1 type="submit">Calcular</button>
      </form>

    </div>
    <div class="row">
      <div class="container">
    <?php
    if(!empty($resultado) /*&& empty($msg)*/){  
      echo "<br><br><pre>";
      echo $resultado;
      echo "</pre>";
    }
    ?>
      </div>
    </div>
    
  </body>
</html>
