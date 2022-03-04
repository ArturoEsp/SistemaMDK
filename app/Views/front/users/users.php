<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Lista de usuarios<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Editar datos</h2>
            <span>Actualiza la información del usuario</span>
        </div>
        <div class="wrapper">
            <form class="Form max768" id="create_user_form">
                <input type="hidden" id="id_hidden">
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
                    <button class="cancel" id="edit-cancel" disabled onclick="onCancelEdit()">Cancelar</button>
                    <button class="success" type="button" onclick="onUpdateUser(1)" id="edit-save" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Usuarios</h2>
            <span>Lista de usuarios registrados</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="buttons">
                    <a class="button-a" href="users/create-user">Crear usuario</a>
                </div>
                <div class="search-input">
                    <input type="text" id="search" placeholder="Buscar...">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <div class="dropdown-list">
                    <select name="dropdown-types" id="dropdown-types">
                        <option value="">Mostrar todos</option>
                        <?php foreach ($tipos_usuario as $tipo) : ?>
                            <option value="<?= $tipo['id_tu'] ?>"><?= $tipo['tu_descrip'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="users_data">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function printBodyUsers(data = []) {
        $('#users_data').empty();
        for (let i = 0; i < data.length; i++) {
            const e = data[i];
            $('#users_data').append("<tr>\
                    <td>" + e.id_alumno + "</td>\
                    <td>" + e.nombres + "</td>\
                    <td>" + e.apellidos + "</td>\
                    <td>" + e.usuario + "</td>\
                    <td class='options'>\
                        <div>\
                            <button class='edit' onclick='setEditUser(" + e.id_alumno + ")'><i class='fa-solid fa-user-pen'></i></button>\
                            <button class='delete' onclick='onDeleteUser(" + e.id_alumno + ")'><i class='fa-solid fa-trash'></i></button>\
                        </div>\
                    </td>\
                </tr>");

        }
    }
    $(document).ready(function() {

        AJAXFindUsersByParams(null, null, function(data) {
            printBodyUsers(data);
        })

        $('#search').keyup(function(e) {
            AJAXFindUsersByParams(this.value, null, function(data) {
                printBodyUsers(data);
            });
        });

        $('#dropdown-types').on('change', function(e) {
            AJAXFindUsersByParams(null, this.value, function(data) {
                printBodyUsers(data);
            });
        });
    });

    function onDeleteUser(id = null) {
        swal({
                title: "¿Deseas eliminar el usuario?",
                text: "Al eliminar el usuario se perderá su información.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXDeleteUserById(id, function(res) {
                        if (res.status === 'ok') {
                            AJAXFindUsersByParams(null, null, function(data) {
                                printBodyUsers(data);
                            });
                        }
                    })
                }
            });
    }

    function setEditUser(id = null) {
        AJAXGetUserById(id, function(res) {
            $('#edit-save').prop('disabled', false);
            $('#edit-cancel').prop('disabled', false);
            const user = res.data;

            $('#id_hidden').val(res.data.id_alumno)
            $('#name').val(res.data.nombres)
            $('#lastname').val(res.data.apellidos)
            $('#username').val(res.data.usuario)
            $('#type_user').val(res.data.id_tu)
        })
    }

    function onCancelEdit() {
        $('#edit-save').prop('disabled', true);
        $('#edit-cancel').prop('disabled', true);
        $('#name').val('')
        $('#lastname').val('')
        $('#username').val('')
    }

    function onUpdateUser() {
        const id = $('#id_hidden').val();

        const data = {
            name: $("#name").val(),
            lastname: $("#lastname").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            type_user: $('#type_user').val()
        };

        AJAXUpdateUserById(id, data, function(res) {
            if (res?.status === 'error')
                return swal("Ocurrió un error", "Intentalo de nuevo.", "error");

            AJAXFindUsersByParams(null, null, function(data) {
                printBodyUsers(data);
                $('#edit-save').prop('disabled', true);
                $('#edit-cancel').prop('disabled', true);
                $('#name').val('')
                $('#lastname').val('')
                $('#username').val('')
            })
        });
    }
</script>

<?= $this->endSection() ?>