<?php
$session = session('event');
$modalidades = $session['modalidades'];
?>

<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Lista de Participantes<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Registro del evento "<?= $session['nombre'] ?>"</h2>
            <span>Selecciona a los alumnos a registrar</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="dropdown-list">
                    <span>Selecciona la modalidad</span>
                    <select name="mod" id="mod">
                        <?php foreach ($modalidades as $property => $value) : ?>
                            <option value="<?= $value->id_modalidad ?>"><?= $value->modalidad ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <select multiple="multiple" id="select-students" name="my-select[]">
            </select>
            <div class="group-buttons">
                <button class="success" type="button" id="btn_success" onclick="onSubmit()">Guardar</button>
            </div>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Participantes</h2>
            <span>Lista de participantes registrados</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="dropdown-list">
                    <select name="" id="mod-register">
                        <?php foreach ($modalidades as $property => $value) : ?>
                            <option value="<?= $value->id_modalidad ?>"><?= $value->modalidad ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="wrapper_students" id="students-register">
                
            </div>
        </div>
    </div>
</div>

<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const school_id = urlParams.get('id')

    function listStudents(id = null, id_mod = null) {
        AJAXGetAvailablesStudents(id, id_mod, function(res) {
            const data = res.data;
            console.log(data);
            $('#select-students').empty();
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    $('#select-students').append(`
                        <option value='${e.id_alumno}'>${e.nombres} ${e.apellidos}</option>
                    `);
                }

                $("#select-students").multiSelect('destroy');
                
                $('#select-students').multiSelect({
                    selectableHeader: "<div class='custom-header'>Selecciona los participantes</div>",
                    selectionHeader: "<div class='custom-header'>Participantes seleccionados</div>",
                });
            } else{
                $("#select-students").multiSelect('destroy');
            }
        })
    }

    function listStudentsRegister (mod_id) {
        AJAXGetStudentsInEventBySchoolMod(school_id, mod_id,function (res) {
            const data = res.data;
            console.log(data);
            $('#students-register').empty();
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    $('#students-register').append(`
                        <div class="item-event">
                            <div class="photo">
                                <img src="../uploads/${e.fotografia ? e.fotografia : 'custom.png'}" alt="photo">
                            </div>
                            <div class="details">
                                <div>
                                    <span>${e.nombres} ${e.apellidos}</span>
                                    <span class="status ${e.status === 'ASIGNADO' && 'assign'}">${
                                        e.status === 'ASIGNADO' ? 'Asignado': 'No asignado'
                                    }</span>
                                </div>
                                <div class="buttons">
                                    ${e.status !== 'ASIGNADO' && 
                                        `<button onclick='onDeleteParticipante(${e.id_registro})' class='delete'><i class='fa-solid fa-trash'></i></button>`
                                    }
                                </div>
                            </div>
                        </div>
                    `);
                    
                }
            }
        })
    }

    function onDeleteParticipante(participante_id){
        swal({
                title: "¿Deseas eliminar el registro de este participante?",
                text: "",
                icon: "info",
                buttons: true,
                dangerMode: false,
                buttons: ["Cancelar", "Si, eliminar"],
            })
            .then((success) => {
                if (success) {
                    AJAXDeleteParticipanteEvent(participante_id, function (res) {
                                        
                         const { status, data } = res;
                         if (status === 'error') {
                            swal("Ocurrió un error!", data, "error");
                         }
                         swal({title: "Participante eliminado del evento!", 
                                text: "", 
                                icon: "success"
                            }).then(function(){ document.location.reload(true) } );

                    })
                }
            });

    }

    function onSubmit() {
        const students_id = $('#select-students').val();
        const mod_id = $('#mod').val();

        if (students_id.length === 0) {
            return swal("Ocurrió un error!", 'No has seleccionado participantes.', "error");
        }

        const _data = {
            school_id: school_id,
            students_id: students_id,
            mod_id: mod_id
        };

        swal({
                title: "Nuevos participantes",
                text: "¿Es correcta la lista de los participantes para el registro del evento?",
                icon: "info",
                buttons: true,
                dangerMode: false,
                buttons: ["Cancelar", "Si, enviar"],
            })
            .then((success) => {
                if (success) {
                    $('#btn_success').prop('disabled', true);
                    AJAXRegisterStudentsEvent(_data, function (res) {
                        const { status, data } = res;
                        if (status === 'ok') {
                            swal({title: "Participantes registrados correctamente!", 
                                text: "", 
                                icon: "success"
                            }).then(function(){ 
                                    document.location.reload(true)
                                }
                            );
                        }
                        if (status === 'error') {
                            $('#btn_success').prop('disabled', false);
                            swal("Ocurrió un error!", data, "error");
                        }
                    }) 
                    
                }
            });
    }

    $(document).ready(function() {
        listStudents(school_id, $('#mod').val());
        listStudentsRegister($('#mod').val())

        $('#mod-register').change(function(e) {
            e.preventDefault();
            listStudentsRegister(this.value)
        });

        $('#mod').change(function(e) {
            e.preventDefault();
            listStudents(school_id, this.value)
        });
    });
</script>

<?= $this->endSection() ?>