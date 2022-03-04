<?php $session = session(); ?>

<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?> Accede a tu cuenta <?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="login-div">
    <div class="box-content w480">
        <div class="title">
            <h2>Bienvenid@</h2>
            <span>Accede a tu cuenta</span>
        </div>
        <div class="wrapper">
            <form method="POST" action="<?= base_url(route_to('signin')) ?>" class="Form" id="form-login">
                <div class="input">
                    <label for="username">Usuario</label>
                    <input type="text" name="username" id="username" placeholder="Tu usuario">
                </div>
                <div class="input">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Tu contraseña">
                </div>
                <div class="group-buttons">
                    <button class="success" type="submit">Entrar</button>
                </div>
                <?= $session->getFlashdata('msg'); ?>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-login").validate({
            rules: {
                username: "required",
                password: {
                    required: true,
                },
            },
            messages: {
                username: {
                    required: "Ingresa tu usuario",
                },
                password: {
                    required: "Ingresa tu contraseña",
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
</script>

<?= $this->endSection() ?>