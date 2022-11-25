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
    <title>Password change</title>
</head>

<body>
    <?php
    $env = json_decode(file_get_contents("../../../environment/environment.json"));
    $environment = $env->environment;

    define('BASE_URL', $environment->protocol . $environment->baseUrl);

    include "../../../public/navbar.php";
    ?>
    <div class="container bg-light rounded" style="max-width: 30%;">
        <h1>Canvia la contrasenya</h1>
        <div class="form-inline justify-content-center">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="container">
                    <div class="form-group row mb-1">
                        <label class="col align-self-center">Escriu la nova contrasenya: </label>
                        <input type="password" class="form-control col-12 <?php echo (!empty($errors['pwd']['missing'])) ? 'is-invalid' : '' ?>" name="pwd" placeholder="Nova contrasenya">
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col align-self-center">Repeteix la nova contrasenya: </label>
                        <input type="password" class="form-control col-12 <?php echo (!empty($errors['pwdR']['missing'])) ? 'is-invalid' : '' ?>" name="pwdR" placeholder="Repeteix nova contrasenya">
                    </div>
                    <input type="hidden" name="validation" id="hiddenField" value="<?php echo session_id() ?>" />
                    <div class="d-flex justify-content-center">
                        <ul style="list-style-type: none;">
                            <?php if (isset($errors['pwd']['invalid'])) : ?>
                                <small class="text-danger">
                                    <li class="col-10">La contrasenya no compleix els requisits.</li>
                                </small>
                            <?php endif; ?>
                            <?php if (isset($errors['pwd']['unmatched'])) : ?>
                                <small class="text-danger">
                                    <li class="col-10">La contrasenya no coincideix.</li>
                                </small>
                            <?php endif; ?>

                            <small class="<?php echo empty($errors['pwd']['invalid']) ? 'text-info' : 'text-danger' ?>">
                                <li class="col-10">La contrasenya ha de tenir 8 caràcters mínim.</li>
                            </small>
                            <small class="<?php echo empty($errors['pwd']['invalid']) ? 'text-info' : 'text-danger' ?>">
                                <li class="col-10">La contrasenya ha de combinar números, símbols, majúscules i minúscules. Exemple: P@ssw0rd o qA!12345</li>
                            </small>
                        </ul>
                    </div>
                    <div class="container d-inline-flex justify-content-end m-3">
                        <input type="submit" class="btn btn-dark align-self-center" name="change" value="Canviar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>