<div class="container">
    <form class="form justify-content-center" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label class="fw-bold d-flex justify-content-center">Estàs segur que vols eliminar el teu compte?</label>
        <div class="container d-inline-flex justify-content-center m-4">
            <input type="submit" name="EliminarNo" value="No" class="btn btn-success m-2">
            <input type="submit" name="<?php echo $usuari->id ?>" value="Si" class="btn btn-danger m-2" formaction="delete.php">
        </div>
    </form>
</div>