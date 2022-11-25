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
    <link href="../../public/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../public/styles/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="../../public/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../../public/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../../public/assets/fontawesome/css/solid.css" rel="stylesheet">
    <link href="../../public/styles/estils.css" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body>
    <?php 
        $env = json_decode(file_get_contents("../../environment/environment.json"));
        $environment = $env->environment;
        
        define('BASE_URL', $environment->protocol . $environment->baseUrl);

        include "../../public/navbar.php"; 
    ?>
    <div class="container bg-light rounded" style="max-width: 50%;">
        <h1>Formulari de registre</h1>
        <div class="form-inline justify-content-center">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="container">
                <div class="form-group row mb-1">
                    <label class="col justify-content-end">Introdueix un nom d'usuari: </label>
                    <input type="text" class="form-control col-5 <?php echo (isset($errors['username']['missing'])) ? 'is-invalid' : '' ?>" name="username" placeholder="Username" 
                        value="<?php echo (empty($_POST['username'])) ? '' : $_POST['username'] ?>">
                    <?php if(isset($errors['username']['exists'])) : ?>
                            <small class="text-danger col-10">L'usuari ja existeix</small>
                    <?php endif; ?>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-7 justify-content-end">Introdueix el teu email: </label>
                    <input type="text" class="form-control col-5 <?php echo (isset($errors['email']['missing'])) ? 'is-invalid' : '' ?>" name="email" placeholder="Adreça electrònica"
                        value="<?php echo (empty($_POST['email'])) ? '' : $_POST['email'] ?>">
                    <?php if(isset($errors['email']['exists'])) : ?>
                            <small class="text-danger col-10">L'email ja existeix</small>
                    <?php endif; ?>                    
                </div>
                <div class="form-group row mb-1">
                    <label class="col-7 justify-content-end">Introdueix la teva contrasenya: </label>
                    <input type="password" class="form-control col-5 <?php echo (isset($errors['pwd']['missing'])) ? 'is-invalid' : '' ?>" name="pwd" placeholder="Password">
                </div>
                <div class="form-group row mb-1">
                    <label class="col-7 justify-content-end">Torna a escriure la contrasenya: </label>
                    <input type="password" class="form-control col-5 <?php echo (isset($errors['pwdR']['missing'])) ? 'is-invalid' : '' ?>" name="pwdRepeat" placeholder="Repeteix la password">
                </div>
                    <ul style="list-style-type: none;">
                        <?php if(isset($errors['pwd']['invalid'])) : ?>
                                <small class="text-danger"><li class="col-10">La contrasenya no compleix els requisits.</li></small>
                        <?php endif; ?>
                        <?php if(isset($errors['pwd']['unmatched'])) : ?>
                                <small class="text-danger"><li class="col-10">La contrasenya no coincideix.</li></small>
                        <?php endif; ?>
                        <small class="<?php echo
                            (isset($errors['username']['missing']) ||
                            isset($errors['email']['missing']) || 
                            isset($errors['pwd']['missing']) || 
                            isset($errors['pwdR']['missing'])) ? 'text-danger' : 'text-info' ?>"><li class="col-10">Els camps que es posin vermells són obligatoris.</li></small> 
                    
                        <small class="<?php echo empty($errors['pwd']['invalid']) ? 'text-info' : 'text-danger' ?>">
                            <li class="col-10">La contrasenya ha de tenir 8 caràcters mínim.</li>
                        </small>  
                        <small class="<?php echo empty($errors['pwd']['invalid']) ? 'text-info' : 'text-danger' ?>">
                            <li class="col-10">La contrasenya ha de combinar números, símbols, majúscules i minúscules. Exemple: P@ssw0rd o qA!12345</li>
                        </small>
                    </ul>
                <div class="container d-inline-flex justify-content-between mb-3">
                    <a href="login.php" class="align-self-center">Ja tens compte? Entra!</a>
                    <input type="submit" class="btn btn-dark align-self-center" name="registrar" value="Enregistrar-se">
                </div>
            </div>
            </form>
        </div>
    </div>
</body>
</html>