<!-- /**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    <link href="../../public/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../public/styles/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="../../public/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../../public/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../../public/assets/fontawesome/css/solid.css" rel="stylesheet">
    <link href="../../public/styles/estils.css" rel="stylesheet">
    <title>File Manager</title>
</head>
<body>
    <?php 
        $env = json_decode(file_get_contents("../../environment/environment.json"));
        $environment = $env->environment;
        
        define('BASE_URL', $environment->protocol . $environment->baseUrl);

        include "../../public/navbar.php"; 
    ?>
    <div class="container bg-light rounded" style="max-width: 30%;">
        <h1>Gestió de fitxers</h1>
        <div class="form-inline justify-content-center">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            
                <!-- Primer camp -->
                <label for="nom">Què vols canviar?</label>
                <input type="text" name="nom" class="form-control" value="<?php echo $_POST['nom'] ?? '' ?>">

                <?php if(isset($errors['nom']['missing'])): ?>
                    <small class="text-danger">Camp obligatori</small>
                <?php endif;?>

                <!-- Segon camp -->
                <label for="newNom">Per a què ho vols canviar?</label>
                <input type="text" name="newNom" class="form-control" value="<?php echo $_POST['newNom'] ?? '' ?>">

                <?php if(isset($errors['newNom']['missing'])): ?>
                    <small class="text-danger">Camp obligatori</small>
                <?php endif;?>

                <!-- Tercer camp -->
                <label for="path">A quina localització ho vols canviar? <br> (Ex. C:/Users/pepito/Documents/ )</label>
                <input type="text" name="path" class="form-control" value="<?php echo $_POST['path'] ?? '' ?>">

                <?php if(isset($errors['path']['missing'])): ?>
                    <small class="text-danger">Camp obligatori</small>
                <?php endif;?>
                <?php if(isset($errors['path']['fake'])): ?>
                    <small class="text-danger">La ruta especificada no és un directori o no existeix</small>
                <?php endif;?>

                <!-- Submit -->
                <input type="submit" name="modificar" value="Modificar" class="btn btn-dark my-2">
            </form>
        </div>
    </div>
</body>
</html>