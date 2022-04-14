<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Control de Escuelas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Registrar escuela</h2>
            <span>Ingresa los datos de la escuela</span>
        </div>
        <div class="wrapper">
            <form class="Form" id="create-school">
                <div class="input">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Ingresa el nombre de la escuela">
                </div>
                <div class="input">
                    <label for="teacher">Selecciona el maestro asignado</label>
                    <select name="teacher" id="list-teachers">
                        <option value=""></option>
                    </select>
                </div>
                <div class="input">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" id="address" placeholder="Ingresa la dirección de la escuela.">
                </div>
                <div class="group-buttons">
                    <button class="success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Escuelas</h2>
            <span>Lista de escuelas</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="search-input">
                    <input type="text" id="search" placeholder="Buscar...">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de la escuela</th>
                            <th>Maestro asignado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="alumnos_data">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function printBodySchools() {
        let data = []
        AJAXGetSchools(function(res) {
            if (res.status === 'ok') data = res.data;

            $('#alumnos_data').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#alumnos_data').append("<tr>\
                    <td>" + e.IdEscuela + "</td>\
                    <td>" + e.NombreEscuela + "</td>\
                    <td>" + `${e.NombreMaestro} ${e.ApellidoMaestro}` + "</td>\
                    <td class='options'>\
                        <div>\
                            <button class='delete' onclick='deleteSchool(" + e.IdEscuela + ")'><i class='fa-solid fa-trash'></i></button>\
                        </div>\
                    </td>\
                </tr>");

            }
        });
    }

    function printListTeachersAvailables() {
        AJAXGetListTeacher(function(res) {
            const data = res.data;
            $('#list-teachers').empty();

            if (res.data.length === 0)
                return $('#list-teachers').append("<option>Sin maestros disponibles</option>");

            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#list-teachers').append("\
                    <option value=" + e.id_alumno + ">" + `${e.nombres} ${e.apellidos}` + "</td>\
            ");

            }
        })
    }

    function deleteSchool(id) {
        swal({
                title: "¿Deseas eliminar la escuela?",
                text: "Al eliminar la escuela. Se mantendra la información de los alumnos",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXDeleteSchool(id, function(res) {
                        const { status } = res;
                        if (status === 'ok') {
                            printBodySchools();
                            return swal("Escuela eliminada correctamente.");
                        }
                    })
                }
            });
    }

    $(document).ready(function() {

        printListTeachersAvailables();
        printBodySchools();

        $("#create-school").validate({
            rules: {
                name: "required",
                teacher: "required",
            },
            messages: {
                name: {
                    required: "Ingresa el nombre de la escuela.",
                },
                teacher: {
                    required: "Selecciona un profesor disponible.",
                },
            },
            submitHandler: function(form) {
                const data = {
                    name: $('#name').val(),
                    teacher: $('#list-teachers').val(),
                    address: $('#address').val(),
                };

                AJAXStoreSchool(data, function(res) {
                    form.reset();
                    printBodySchools();
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>