<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Control de areas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Registrar de area</h2>
            <span>Ingresa los datos de la área</span>
        </div>
        <div class="wrapper">
            <form class="Form" id="create_area">
                <div class="input">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Ingresa del área">
                </div>
                <div class="input">
                    <label for="status">Disponibilidad</label>
                    <select name="status" id="status">
                        <option value="1">Disponible</option>
                        <option value="0">No disponible</option>
                    </select>
                </div>
                <div class="group-buttons">
                    <button class="success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Areas</h2>
            <span>Lista de areas disponibles</span>
        </div>
        <div class="wrapper">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Area</th>
                            <th>Disponibilidad</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="areas_data">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function printBodyAreas() {
        let data = []
        AJAXGetAllAreas(function(res) {
            if (res.status === 'ok') data = res.data;

            $('#areas_data').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#areas_data').append(`
                    <tr>
                        <td>${e.id_area}</td>
                        <td>${e.nombre}</td>
                        <td>
                            <select name="status" id="status" class="status-select" onchange='updateStatus(this, ${e.id_area})'>
                                <option value="1" ${e.status === '1' && 'selected'}>Disponible</option>
                                <option value="0" ${e.status === '0' && 'selected'}>No disponible</option>
                            </select>
                        </td>
                        <td class='options'>
                            <div>
                                <button class='delete' onclick='deleteArea(${e.id_area})'><i class='fa-solid fa-trash'></i></button>
                            </div>
                        </td>
                    </tr>
                `);

            }
        });
    }

    function onSubmitForm() {
        const data = {
            name: $('#name').val(),
            status: $('#status').val()
        };
        AJAXSaveArea(data, function(res) {
            printBodyAreas();
        })
    }

    function updateStatus(val, id) {
        const status = (val.value || val.options[val.selectedIndex].value)
        AJAXUpdateArea(id, { status }, function(res) {
            const { status } = res;
            if (status === 'ok') {
                swal({
                        title: 'Actualización de área',
                        text: 'Se actualizo el status correctamente.',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                    })
                    .then(() => {
                        
                    })
            }
        })
    }

    function deleteArea(id) {
        swal({
                title: "¿Deseas eliminar la área?",
                text: "Al eliminar la área no podrá recuperar su información.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXDeleteArea(id, function(res) {
                        if (res.status === 'ok') {
                            printBodyAreas();
                        }
                    })
                }
            });
    }

    $(document).ready(function() {
        printBodyAreas();
        $("#create_area").validate({
            rules: {
                name: "required",
                status: "required",
            },
            messages: {
                name: {
                    required: "Ingresa el nombre del área",
                },
                status: {
                    required: "Selecciona la disponibilidad del área.",
                },
            },
            submitHandler: function(form) {
                onSubmitForm();
                form.reset();
            }
        });
    });
</script>

<?= $this->endSection() ?>