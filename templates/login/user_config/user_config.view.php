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
    <link href="../../../public/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../public/styles/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="../../../public/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../../../public/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../../../public/assets/fontawesome/css/solid.css" rel="stylesheet">
    <link href="../../../public/styles/estils.css" rel="stylesheet">
    <title>User Config</title>
</head>
<body>
    <?php 
        $env = json_decode(file_get_contents("../../../environment/environment.json"));
        $environment = $env->environment;
        
        define('BASE_URL', $environment->protocol . $environment->baseUrl);

        include "../../../public/navbar.php"; 
    ?>
    <div class="container bg-light rounded-5" style="max-width: 30%;">
        <h1>Configuració d'usuari</h1>
        <div class="form justify-content-center">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

                <hr class="border-3 border-top border-dark">
                
                <!-- Avatar -->
                <label class="fw-bold">Avatar actual:</label>
                <div class="d-flex justify-content-center m-3">
                    <div class="ratio ratio-1x1" style="max-width: 40%; max-height:40%">
                        <img src="../../../<?php echo $usuari->avatar ?? 'public/assets/img/Blank-Avatar.jpg'; ?>" class="img-fluid img-cover border border-3 bg-primary border-primary rounded-circle" />
                    </div>
                </div>

                <label for="imatge" class="fw-bold">Escull una imatge de la teva galeria:</label>
                <select class="form-control form-select" name="imatge" id="imatge">
                    <option value="" <?php if($usuari->avatar == null): echo "selected"; endif; ?>>No afegir cap imatge</option>
                    <?php foreach($images as $image): ?>
                        <option value="<?php echo $image->id ?>" <?php if($image->path === $usuari->avatar): echo "selected"; endif; ?>><?php echo pathinfo($image->path,PATHINFO_FILENAME) ?></option>
                    <?php endforeach;?>
			    </select>
                <div class="my-3">
                    <label for="upload_img" class="fw-bold">O afegeix una nova: </label>
                    <input class="form-control" 
                                id="formFileSm" type="file" name="upload_img" accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>
                
                    <!-- Missatges d'error per avatar -->
                    <?php if (isset($errors['img']['fake'])) : ?>
                        <p class="text-danger">El fitxer no és una imatge</p>
                    <?php endif; ?>
                    <?php if (isset($errors['img']['repeated'])) : ?>
                        <p class="text-danger">Ja existeix un fitxer amb aquest nom al servidor</p>
                    <?php endif; ?>
                    <?php if (isset($errors['img']['formatNotAllowed'])) : ?>
                        <p class="text-danger">El fitxer té un format no permés: només es pot penjar PNG, JPEG, JPG i GIF</p>
                    <?php endif; ?>
                    <?php if (isset($errors['img']['sizeLimit'])) : ?>
                        <p class="text-danger">La mida màxima per PHP son 2MB, prova amb una imatge més petita</p>
                    <?php endif; ?>
                    
                <hr class="border-3 border-top border-dark">
            
                <!-- Nom usuari -->
                <label for="newUsername" class="fw-bold">Vols canviar el teu nom d'usuari?:</label>
                <input type="text" name="newUsername" class="form-control" value="<?php echo $_POST['newUsername'] ?? strtolower($usuari->username) ?>">

                    <!-- Missatges d'error per username -->
                    <?php if (isset($errors['username']['exists'])) : ?>
                        <p class="text-danger">El nom d'usuari ja existeix</p>
                    <?php endif; ?>

                <!-- Email -->
                <label for="newMail" class="fw-bold">Vols canviar el teu email?:</label>
                <input type="text" name="newMail" class="form-control" value="<?php echo $_POST['newMail'] ?? strtolower($usuari->email) ?>">

                    <!-- Missatges d'error per email -->
                    <?php if (isset($errors['email']['exists'])) : ?>
                        <p class="text-danger">El correu electrònic ja existeix</p>
                    <?php endif; ?>
                    <?php if (isset($errors['email']['invalid'])) : ?>
                        <p class="text-danger">El correu no està correctament escrit</p>
                    <?php endif; ?>

                <hr class="border-3 border-top border-dark mb-4">

                <!-- Submit -->
                <div class="container d-inline-flex justify-content-between mb-4">
                    <input type="submit" name="modificar" value="Modificar" class="btn btn-dark">
                    <input type="submit" name="eliminar" value="Eliminar el teu compte d'Usuari" class="btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</body>
</html>