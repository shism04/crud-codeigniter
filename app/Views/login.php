<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>

<body>
    <?php $login_error = session()->getFlashdata('error') ?>
    <?php if (isset($login_error)): ?>
        <div class="exist">
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="box">
        <div class="form-container">
            <h2>Iniciar Sesión</h2>

            <form action="/login" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="Ingresa tu nombre">

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña">

                <button type="submit">Iniciar Sesión</button>
            </form>

            <p>¿No tienes cuenta? <a href="/signup">Regístrate aquí</a></p>
        </div>
    </div>
</body>

<script>
    const inputs = document.querySelectorAll('input');
    inputs.forEach((input) => {
        input.addEventListener('keyup', () => {
            input.classList.remove('error');
        });
    });
</script>

</html>
