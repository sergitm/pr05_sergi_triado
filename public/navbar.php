<!-- /**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/ -->
<nav class="navbar navbar-dark bg-dark">
    <ul class="nav navbar-nav">
        <li class="nav-items">
            <a class="nav-link active mx-5 fas fa-scroll" href="<?php echo BASE_URL ?>"> Articles</a>
            <a class="nav-link active mx-5 fas fa-image" href="<?php echo BASE_URL ?>templates/gallery/gallery.php"> Galeria</a>
            <?php if(isset($_SESSION['username'])): ?>
                <a class="nav-link active mx-5 fas fa-image" href="<?php echo BASE_URL ?>templates/gallery/gallery.php"> Gestio fitxers</a>
            <?php endif; ?>
        </li>
    </ul>
    <ul class="nav navbar-nav">
        <li class="nav-item">
            <?php if(isset($_SESSION['username'])) : ?>
                <div class="nav-link active mx-5">Hola, <?php echo $_SESSION['username'] ?> (<a href="<?php echo BASE_URL ?>templates/login/logout.php">Surt</a>)</div>
            <?php else : ?>
                <a class="nav-link active mx-5 fas fa-user" href="<?php echo BASE_URL ?>templates/login/login.php"> Log in</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>