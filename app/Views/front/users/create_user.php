<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Nuevo usuario<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="box-content">
    <div class="title">
        <h2>Registro de usuarios</h2>
        <span>Ingresa los datos</span>
    </div>
    <div class="wrapper">
        <form method="post" action="<?= base_url(route_to('create-user-form')) ?>" class="Form max768" id="create_user_form">
            <input type="hidden" name="id_user" value="">
            <div class="group-input">
                <div class="input">
                    <label for="">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Nombre del usuario">
                </div>
                <div class="input">
                    <label for="">Apellidos</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Apellidos">
                </div>
            </div>
            <div class="group-input">
                <div class="input">
                    <label for="">Usuario</label>
                    <input type="text" name="username" id="username" placeholder="Nombre de usuario">
                </div>
                <div class="input">
                    <label for="">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña">
                </div>
            </div>
            <div class="input">
                <label for="">Tipo de usuario</label>
                <select name="type_user" id="type_user">
                    <option disabled selected>** SELECCIONA TIPO **</option>
                    <?php foreach ($tipos_usuario as $tipo) : ?>
                        <option value="<?= $tipo['id_tu'] ?>"><?= $tipo['tu_descrip'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="group-buttons">
                <button class="success" type="submit">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#create_user_form").validate({
            rules: {
                name: "required",
                lastname: "required",
                username: "required",
                password: {
                    required: true,
                    minlength: 6,
                },
                type_user: "required"
            },
            messages: {
                name: {
                    required: "Ingresa el nombre del usuario",
                },
                lastname: {
                    required: "Ingresa el apellido del usuario",
                },
                username: {
                    required: "Ingresa el usuario",
                },
                password: {
                    required: "Ingresa la contraseña",
                    minlength: "La contraseña tiene que tener mínimo 6 caracteres",
                },
                type_user: {
                    required: "Selecciona su tipo de usuario",
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
</script>


<?= $this->endSection() ?>