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
            <?php if (isset($_SESSION['username'])) : ?>
                <a class="nav-link active mx-5 fas fa-image" href="<?php echo BASE_URL ?>templates/file_manager/file_manager.php"> Gestio fitxers</a>
            <?php endif; ?>
        </li>
    </ul>
    <ul class="navbar-nav mx-2">
        <?php if (isset($_SESSION['username'])) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fas fa-user" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Hola, <?php echo $_SESSION['username'] ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item fa-solid fa-door-open fw-bold" href="<?php echo BASE_URL ?>templates/login/logout.php"> Surt</a></li>
                    <li><a class="dropdown-item fa-solid fa-gear fw-bold" href="<?php echo BASE_URL ?>templates/login/user_config/user_config.php"> Configuracio usuari</a></li>
                </ul>
            </li>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link active mx-5 fas fa-user" href="<?php echo BASE_URL ?>templates/login/login.php"> Log in</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>