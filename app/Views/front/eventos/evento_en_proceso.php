<?php
$event = session('event');
$modalidades_string = "";
foreach ($event['modalidades'] as $key) {
    $modalidades_string .= $key->modalidad . ', ';
}
?>

<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Evento en proceso<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="wrapper_boxs">
    <div class="box-content">
        <div class="title">
            <h2><?= $event['nombre'] ?></h2>
            <span>Evento en proceso</span>
        </div>
        <div class="wrapper">
            <form class="Form max768">
                <div class="input">
                    <label for="name">Nombre</label>
                    <input type="text" value="<?= $event['nombre'] ?>" disabled>
                </div>
                <div class="input">
                    <label for="description">Descripción</label>
                    <input type="text" value="<?= $event['descripcion'] ?>" disabled>
                </div>
                <div class="group-input">
                    <div class="input">
                        <label for="date_start">Fecha de inicio</label>
                        <input type="date" id="start_date" value="<?= $event['fecha_inicio'] ?>">
                    </div>
                    <div class="input">
                        <label for="date_end">Fecha de finalización</label>
                        <input type="date" id="end_date" value="<?= $event['fecha_fin'] ?>">
                    </div>
                </div>
                <div class="input">
                    <label for="place">Lugar</label>
                    <input type="text" value="<?= $event['lugar'] ?>" disabled>
                </div>
                <div class="input">
                    <label for="place">Modalidades</label>
                    <input type="text" value="<?= $modalidades_string ?>" disabled>
                </div>

                <div class="group-buttons">
                   <button class="cancel" type="button" onclick="cancelEvent()">Finalizar evento</button>
                   <button class="success" type="button" onclick="updateEvent()">Guardar información</button>
                </div>
            </form>
        </div>
    </div>
    <div class="box-content">
        <div class="title">
            <h2><?= $event['nombre'] ?></h2>
            <span>Gráficas</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="buttons">
                    <a class="button-a" id="a-register" href="graficas/nueva" >Nueva gráfica</a>
                </div>
            </div>
            <div class="wrapper_graficas" id="graficas">

            </div>
        </div>
    </div>
</div>
</div>

<script>

    function statusNameGrafica(status) {
        switch (status) {
            case 'EN_CURSO': return 'En curso';
            case 'CANCELADO': return 'Cancelado';
            case 'FINALIZADO': return 'Finalizado';
            default: return 'Sin status'
        }
    }

    function cancelEvent () {
        swal({ title: "¿Deseas cancelar el evento?",
                text: "",
                icon: "info",
                buttons: true,
                dangerMode: false,
                buttons: ["No", "Si, cancelar"],
            }).then((success) => {
                if (success) {
                    AJAXCancelEvent(<?= $event['id'] ?>, function (res) {        
                        const { status, data } = res;
                        if (status === 'error') return swal("Ocurrió un error!", data, "error");
                        swal({title: "Se ha cancelado el evento correctamente!", text: "", icon: "success"}).then(function(){ document.location.reload(true) } );
                    })
                }
        });
    }

    function updateEvent () {
        swal({ title: "¿Deseas actualizar la información del evento?",
                text: "",
                icon: "info",
                buttons: true,
                dangerMode: false,
                buttons: ["No", "Si, actualizar"],
            }).then((success) => {
                if (success) {
                    const data = {
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                        event_id: <?= $event['id'] ?>,
                    };

                    AJAXUpdateEvent(data, function (res) {        
                        const { status, data } = res;
                        if (status === 'error') return swal("Ocurrió un error!", data, "error");
                        swal({title: "Se ha actualizado el evento!", text: "", icon: "success"}).then(function(){ document.location.reload(true) } );
                    })
                }
        });
    }

    $(document).ready(function() {
        AJAXGetGraficasByEventId(<?= $event['id'] ?>, function(res) {
            const { status, data } = res;
            $('#graficas').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#graficas').append(`
                    <div class="item-grafica">
                        <div class="name">
                            <h4>${e.nombre} <span class="status ${e.status}">${statusNameGrafica(e.status)}</span></h4>
                            <div>
                                <p>Modalidad: ${e.modalidad}</p>
                                <p>${e.no_participantes} participantes</p>
                            </div>
                        </div>
                        <div class="buttons">
                            <a href="/graficas/view/${e.id}" target="_blank"><i class="fa-solid fa-eye"></i></a>
                            <a href="/graficas/edit/${e.id}"><i class="fa-solid fa-pen"></i></a>
                        </div>
                    </div>
                `);

            }
        });

    });
</script>


<?= $this->endSection() ?>