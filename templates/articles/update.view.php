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
	<title>Update Article</title>
</head>
<body>
	<?php 
        $env = json_decode(file_get_contents("../../environment/environment.json"));
        $environment = $env->environment;
        
        define('BASE_URL', $environment->protocol . $environment->baseUrl);

        include "../../public/navbar.php"; 
    ?>
	<div class="contenidor">
		<h1>Actualitzar article</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="number" name="id" class="form-control w-auto" value="<?php echo $article->id ?>" readonly>
			<textarea class="form-control" name='newArticle' rows='5' placeholder="Escriu un nou article"><?php echo $article->article ?></textarea><br>
			<input class="btn btn-dark mb-4" type="submit" name="updateArticle" value="Actualitzar">
		</form>
	</div>
</body>
</html>