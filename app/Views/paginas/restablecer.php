<?= view('plantilla/navbar'); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restablecer Contraseña - Juego Educativo</title>
    <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/login.css'); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="contenedor">
        <div class="formulario">
            <h1>¿Olvidaste tu contraseña?</h1>
            <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>

            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-info text-center">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/restablecer/enviar'); ?>" method="post">
                <input type="email" id="email" name="email" placeholder="Ej: usuario@correo.com" required />
                <button type="submit">Enviar enlace</button>
            </form>

            <div class="acciones">
                <a href="<?= base_url('/login'); ?>">Volver al inicio de sesión</a>
            </div>
        </div>
    </div>
</body>

</html>
