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
    <link href="public/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/styles/bootstrap/js/bootstrap.bundle.min.js"></script>
	<link href="public/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="public/assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="public/assets/fontawesome/css/solid.css" rel="stylesheet">
	<link rel="stylesheet" href="public/styles/estils.css"> <!-- feu referència al vostre fitxer d'estils -->
	<title>Articles</title>
</head>
<body>
	<div class="contenidor">
		<h1>Articles</h1>

		<!-- Input per modificar els posts per pàgina -->
		<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<input type="number" name="post_x_pag" placeholder="Posts per pàgina" min=1 
				value="<?php echo (!empty($_GET['post_x_pag'])) ? htmlspecialchars(stripslashes(trim($_GET['post_x_pag']))) : '' ?>">
		</form>
		<section class="articles"> <!--aqui guardem els articles-->
			<ul>
				<?php if ($num != 0) : ?>
					<?php foreach ($result->articles as $article) { ?>
						<!-- Body de l'article -->
						<li><?php echo $article->id . ".- " . $article->article ?>
						<!-- Imatge de l'article -->
						<div class="d-flex justify-content-center">
							<img src="<?php echo $article->imatge ?>" class="rounded img-fluid"/>
						</div>

						<!-- Botons de modificar i eliminar -->
						<?php if (isset($_SESSION['username'])) : ?>
							<div class="d-flex justify-content-between">
								<form class="d-inline-flex" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
									<button type="submit" class="m-1 btn btn-dark" name="<?php echo $article->id ?>" formaction="templates/articles/update.php">
										<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
									</button>
									<button type="submit" class="m-1 btn btn-dark" name="<?php echo $article->id ?>" formaction="templates/articles/delete.php">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</button>
								</form>
								<!-- Autor -->
								<p class="<?php if(!isset($_SESSION['username'])) {echo 'ml-auto';} ?>"><?php echo ucwords(strtolower($article->autor)) ?></p>
							</div>
						<?php else : ?>
							<!-- Autor -->
							<p class="d-flex flex-row-reverse"><?php echo ucwords(strtolower($article->autor)) ?></p>
						<?php endif; ?>
						</li>
					<?php } ?>
				<?php else : ?>
					<li><p class="text-info">No hi han articles.</p></li>
				<?php endif; ?>
			</ul>
		</section>

		<!-- Formulari per introduir un nou article -->
		<?php if(isset($_SESSION['username'])): ?>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
			<textarea class="form-control my-1" name='article' rows='5' placeholder="Escriu un nou article"></textarea>
			<input class="form-control" 
						id="formFileSm" type="file" name="upload_img" accept="image/png, image/jpeg, image/jpg, image/gif">
			<!-- Missatges de control de formulari -->
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
			<?php if (isset($insert) && $insert === true) { ?>
				<p style="color:green">Article afegit.</p>
			<?php } elseif (isset($insert) && $insert === false) { ?>
				<p style="color:red">Article no afegit.</p>
				<?php } ?>
			<!-- Submit -->
			<input class="btn btn-dark my-4" type="submit" name="insertArticle" value="Publicar">
		</form>
		<?php endif; ?>

		<!-- Paginació -->
		<section class="paginacio">
			<ul>
					<li <?php echo ($pagina === 1) ? "class=disabled" : "" ?>>
						<a href="<?php echo ($pagina !== 1) ? '?pagina=' . ($pagina-1) . '&post_x_pag=' . $post_per_pag : '#' ?>">&laquo;</a>
					</li> <!-- Decidim quan el botó "Anterior" estarà deshabilitat -->
					<?php for ($i=1; $i <= $maxim_pagines; $i++) { ?>
						<li <?php echo ($i===$pagina) ? "class=active" : "" ?>>
							<a href="<?php echo '?pagina=' . $i . '&post_x_pag=' . $post_per_pag ?>"><?php echo $i ?></a>
						</li>
					<?php } ?>
					<li <?php echo ($pagina == $maxim_pagines) ? "class=disabled" : "" ?>>
						<a href="<?php echo ($pagina != $maxim_pagines) ? '?pagina=' . ($pagina+1) . '&post_x_pag=' . $post_per_pag : '#' ?>">&raquo;</a>
					</li> <!-- Decidim quan el botó "Seguent" estarà deshabilitat -->	
			</ul>
		</section>
	</div>
</body>
</html>