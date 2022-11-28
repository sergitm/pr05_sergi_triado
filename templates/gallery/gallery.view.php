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
    <title>Galeria</title>
</head>

<body>
    <!-- Barra de navegació -->
    <?php
    $env = json_decode(file_get_contents("../../environment/environment.json"));
    $environment = $env->environment;

    define('BASE_URL', $environment->protocol . $environment->baseUrl);

    include "../../public/navbar.php";
    ?>

    <div class="contenidor">
        <h1>Galeria d'imatges</h1>

        <!-- Formulari per establir el número d'imatges per pàgina -->
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="number" name="img_x_pag" placeholder="Imatges per pàgina" min=1 
                value="<?php if (!empty($_GET['img_x_pag'])) { echo htmlspecialchars(stripslashes(trim($_GET['img_x_pag']))); } ?>">
        </form>

        <!-- Formulari per penjar una imatge -->
        <?php if (isset($_SESSION['username'])) : ?>
            <form class="form-inline my-1" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-10">
                        <input class="form-control <?php if (isset($errors['img']['missing'])) { echo 'is-invalid'; } ?>" 
                            id="formFileSm" type="file" name="upload_img" accept="image/png, image/jpeg, image/jpg, image/gif">
                    </div>
                    <div class="col-auto">
                        <input class="btn btn-dark form-control" type="submit" name="enviar" value="Enviar">
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <!-- Missatges de control del formulari -->
        <?php if (isset($errors['img']['missing'])) : ?>
            <p class="text-danger">No s'ha seleccionat cap imatge</p>
        <?php endif; ?>
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
        <?php if (isset($success)) : ?>
            <p class="text-success">La imatge s'ha penjat satisfactòriament</p>
        <?php endif; ?>
        <?php if (isset($failure)) : ?>
            <p class="text-danger">Hi ha hagut un error al penjar l'imatge</p>
        <?php endif; ?>

        <!--Aquí mostrem les imatges-->
        <section class="articles">
            <?php if ($num != 0) : ?>
                <div class="row row-cols-4">
                    <?php foreach ($result->imatges as $imatge) : ?>
                        <div class="card m-1 bg-dark">
                            <img src="../../<?php echo $imatge->path ?>" class="card-img-top img-fluid border border-white" alt="" />
                            <div class="card-body">
                                <p class="card-text text-white"><?php echo ucwords(strtolower($imatge->user)) . " - " . basename($imatge->path) ?></p>
                            </div>
                            <?php if(isset($_SESSION['username'])): ?>
                            <div class="card-body">
                                <form class="d-inline-flex" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <button type="submit" class="btn btn-dark" name="<?php echo $imatge->id ?>" formaction="../gallery/update.php">
										<i class="fas fa-pen-to-square" aria-hidden="true"></i>
									</button>
									<button type="submit" class="btn btn-dark" name="<?php echo $imatge->id ?>" formaction="../gallery/delete.php">
										<i class="fas fa-trash" aria-hidden="true"></i>
									</button>
                                </form>
                            </div>
                            <?php endif;?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <ul>
                    <li>
                        <p class="text-info">No hi han imatges.</p>
                    </li>
                </ul>
            <?php endif; ?>
        </section>

        <!-- Aquí paginem -->
        <section class="paginacio">
            <ul>
                    <li <?php echo ($pagina === 1) ? "class=disabled" : "" ?>>
						<a href="<?php echo ($pagina !== 1) ? '?pagina=' . ($pagina-1) . '&img_x_pag=' . $img_x_pag : '#' ?>">&laquo;</a>
					</li> <!-- Decidim quan el botó "Anterior" estarà deshabilitat -->
					<?php for ($i=1; $i <= $maxim_pagines; $i++) { ?>
						<li <?php echo ($i===$pagina) ? "class=active" : "" ?>>
							<a href="<?php echo '?pagina=' . $i . '&img_x_pag=' . $img_x_pag ?>"><?php echo $i ?></a>
						</li>
					<?php } ?>
					<li <?php echo ($pagina == $maxim_pagines) ? "class=disabled" : "" ?>>
						<a href="<?php echo ($pagina != $maxim_pagines) ? '?pagina=' . ($pagina+1) . '&img_x_pag=' . $img_x_pag : '#' ?>">&raquo;</a>
					</li> <!-- Decidim quan el botó "Seguent" estarà deshabilitat -->	
            </ul>
        </section>
    </div>
</body>

</html>