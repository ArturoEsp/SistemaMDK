<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Crear nuevo evento<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="box-content">
    <div class="title">
        <h2>Crear un nuevo evento</h2>
        <span>Ingresa los datos</span>
    </div>
    <div class="wrapper">
        <form method="post" class="Form max768" id="create_event">
            <div class="input">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" placeholder="Nombre del evento">
            </div>
            <div class="input">
                <label for="description">Descripción</label>
                <input type="text" name="description" id="description" placeholder="Descripción del evento">
            </div>
            <div class="group-input">
                <div class="input">
                    <label for="date_start">Fecha de inicio</label>
                    <input type="date" name="date_start" id="date_start">
                </div>
                <div class="input">
                    <label for="date_end">Fecha de finalización</label>
                    <input type="date" name="date_end" id="date_end">
                </div>
            </div>
            <div class="input">
                <label for="place">Lugar</label>
                <input type="text" name="place" id="place" placeholder="Lugar del evento">
            </div>
            <div class="input">
                <label for="">Modalidades</label>
                <select id="mods" name="mods" multiple="multiple">
                    <?php foreach ($modalidades as $mod) : ?>
                        <option value="<?= $mod['id_modalidad'] ?>"><?= $mod['modalidad'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="group-buttons">
                <button class="success" type="submit" onclick="onSubmitEvent()">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#mods').select2();

        $("#create_event").validate({
            rules: {
                name: "required",
                date_start: "required",
                date_end: "required",
                mods: "required"
            },
            messages: {
                name: {
                    required: "Ingresa el nombre del usuario",
                },
                date_start: {
                    required: "Selecciona la fecha de inicio del evento",
                },
                date_end: {
                    required: "Selecciona la fecha de finalización del evento",
                },
                mods: {
                    required: "Selecciona al menos una modalidad",
                },
            },
            submitHandler: function(form) {

                const data = {
                    name: $('#name').val(),
                    description: $('#description').val(),
                    date_start: $('#date_start').val(),
                    date_end: $('#date_end').val(),
                    place: $('#place').val(),
                    mods: $('#mods').val(),
                };

                $('.success').prop('disabled', true);
                AJAXSaveEvent(data, function(res) {
                    const { status, data } = res;

                    if (status === 'error') {
                        $('.success').prop('disabled', false);
                        swal("Ocurrió un error!", data, "error");

                    } else if (status === 'ok') {
                        swal("Evento creado correctamente!", '', "success").then(
                            history.back()
                        )
                    }
                });

            }
        });

    });
</script>


<?= $this->endSection() ?>