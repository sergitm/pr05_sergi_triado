<!-- /**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/ -->
<nav class="navbar navbar-dark bg-dark">
    <ul class="nav navbar-nav">
        <li class="nav-items">
            <a class="nav-link active mx-5 fas fa-house" href="<?php echo BASE_URL ?>"></a>
        </li>
    </ul>
    <ul class="nav navbar-nav">
        <li class="nav-item">
            <?php if(isset($_SESSION['username'])) : ?>
                <div class="nav-link active mx-5">Hola, <?php echo $_SESSION['username'] ?> (<a href="templates/login/logout.php">Surt</a>)</div>
            <?php else : ?>
                <a class="nav-link active mx-5 fas fa-user" href="<?php echo BASE_URL ?>templates/login/login.php"> Log in</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>