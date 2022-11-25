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
    <link href="../../../public/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../public/styles/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="../../../public/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../../../public/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../../../public/assets/fontawesome/css/solid.css" rel="stylesheet">
    <link href="../../../public/styles/estils.css" rel="stylesheet">
    <title>Password recovery</title>
</head>
<body>
    <?php 
        $env = json_decode(file_get_contents("../../../environment/environment.json"));
        $environment = $env->environment;
        
        define('BASE_URL', $environment->protocol . $environment->baseUrl);

        include "../../../public/navbar.php"; 
    ?>
    <div class="container bg-light rounded" style="max-width: 30%;">
        <h1>Recupera la contrasenya</h1>
        <div class="form-inline justify-content-center">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="container">
                <div class="form-group row mb-1">
                    <label class="col align-self-center">Introdueix el teu nom d'usuari o email: </label>
                    <input type="text" class="form-control col-12 <?php echo (!empty($errors['identifier']) || (isset($userExists) && !$userExists)) ? 'is-invalid' : '' ?>" name="identifier" placeholder="Nom d'usuari o email">
                </div>
                <div class="container d-inline-flex justify-content-end m-3">
                    <input type="submit" class="btn btn-dark align-self-center" name="check" value="Enviar">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <?php if(isset($userExists) && $userExists === true): ?>
                    <p class="text-success align-self-center fw-bold">S'ha enviat un correu al email de l'usuari</p>
                <?php elseif(isset($userExists) && $userExists === false) : ?>
                    <p class="text-danger align-self-center fw-bold">L'usuari no existeix</p>
                <?php endif; ?>
            </div>
            </form>
        </div>
    </div>
</body>
</html>