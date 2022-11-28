<!-- 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
 -->

 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="../../public/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../public/styles/bootstrap/js/bootstrap.bundle.min.js"></script>
	<link href="../../public/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../../public/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../../public/assets/fontawesome/css/solid.css" rel="stylesheet">
	<link rel="stylesheet" href="../../public/styles/estils.css"> <!-- feu referència al vostre fitxer d'estils -->
	<title>Update Image</title>
</head>
<body>
	<?php 
        $env = json_decode(file_get_contents("../../environment/environment.json"));
        $environment = $env->environment;
        
        define('BASE_URL', $environment->protocol . $environment->baseUrl);

        include "../../public/navbar.php"; 
    ?>
	<div class="contenidor">
		<h1>Actualitzar nom de la imatge</h1>
        <form class="form-inline d-flex justify-content-center" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="number" name="id" class="form-control" value="<?php echo $imatge->id ?>" hidden>
            <input type="text" class="form-control" name='path' value="<?php echo $img_path . '/' ?>" hidden>
            <input type="text" class="form-control" name='name' value="<?php echo $img_name ?>" hidden>
            <input type="text" class="form-control" name='extension' value="<?php echo $img_ext ?>" hidden>
            <div class="form-group row">
                <div class="col">
                    <input type="text" class="form-control col-3" name='newName' placeholder="Escriu un nou nom" 
                        value="<?php echo (!empty($_POST['newName'])) ? $_POST['newName'] : $img_name ?>">
                </div>
                <div class="col">
                    <input class="btn btn-dark mb-4" type="submit" name="updateName" value="Actualitzar">
                </div>
            </div>
		</form>
	</div>
</body>
</html>