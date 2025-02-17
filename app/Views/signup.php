<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="<?= base_url('css/signup.css') ?>">
</head>

<body>
    <?php $user_exist= session()->getFlashdata('failed') ?>
    <?php if (isset($user_exist)): ?>
        <div class="exist">
            <p><?= session()->getFlashdata('failed') ?></p>
        </div>
    <?php endif; ?>
    <div class="box">
        <div class="form-container">
            <h2>Registro</h2>

            <?php $errors = session()->getFlashdata('validation'); ?>

            <form action="/signup" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="Ingresa tu nombre"
                    class="<?= !empty($errors['nombre']) ? 'error' : '' ?>">
                <?php if (!empty($errors['nombre'])): ?>
                    <p class="error"><?= $errors['nombre']; ?></p>
                <?php endif; ?>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña"
                    class="<?= !empty($errors['password']) ? 'error' : '' ?>">
                <?php if (!empty($errors['password'])): ?>
                    <p class="error"><?= $errors['password']; ?></p>
                <?php endif; ?>

                <label for="confirm_pswd">Confirmar Contraseña</label>
                <input type="password" id="confirm_pswd" name="confirm_pswd" placeholder="Confirma tu contraseña"
                    class="<?= !empty($errors['confirm_pswd']) ? 'error' : '' ?>">
                <?php if (!empty($errors['confirm_pswd'])): ?>
                    <p class="error"><?= $errors['confirm_pswd']; ?></p>
                <?php endif; ?>

                <button type="submit">Registrarse</button>
            </form>
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