<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Crear nueva gráfica<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="box-content">
    <div class="title">
        <h2>Crear gráfica</h2>
        <span>Ingresa los datos</span>
    </div>
    <div class="wrapper">
        <form method="post" class="Form max768" id="create_event">
            <div class="input">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" placeholder="Nombre de la grafica">
            </div>
            <div class="group-input">
                <div class="input">
                    <label for="mod_id">Modalidad</label>
                    <select name="mod_id" id="mod_id">
                        <?php foreach ($modalidades as $mod) : ?>
                            <option value="<?= $mod['id_modalidad'] ?>"><?= $mod['modalidad'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="input">
                    <label for="nivel_id">Nivel</label>
                    <select name="nivel_id" id="nivel_id">
                        <?php foreach ($niveles as $nivel) : ?>
                            <option value="<?= $nivel['id_nivel'] ?>"><?= $nivel['descrip_niv'] . ' - ' . $nivel['rango'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="group-input">
                <div class="input">
                    <label for="number_participants">No. de Participantes</label>
                    <select name="number_participants" id="number_participants">
                        <option selected value="4">4</option>
                        <option value="8">8</option>
                        <option value="16">16</option>
                    </select>
                </div>
                <div class="input">
                    <label for="genre">Genero</label>
                    <select name="genre" id="genre">
                        <option selected value="mix">Mixto</option>
                        <option value="mens">Hombres</option>
                        <option value="women">Mujeres</option>
                    </select>
                </div>
            </div>
            <p id="total"></p>
            <div class="group-buttons">
                <button class="success" type="button" onclick="onSubmit()">Crear</button>
            </div>
        </form>
    </div>
</div>

<script>
    let _totalParticipantes = 0;

    function totalParticipantes (mod_id, nivel_id, genre) {
        AJAXParticipantesParamsGrafica({mod_id, nivel_id, genre}, function (res) {
            const { status, data } = res;
            console.log(data);
            if (status === 'ok') {
                const total = data.length;
                _totalParticipantes = data.length;
                $('#total').text(`Existen ${total} participantes disponibles.`);
            }
        })
    }

    function onSubmit () {
        const data = {
            name: $('#name').val(),
            mod_id: $('#mod_id').val(),
            nivel_id: $('#nivel_id').val(),
            genre: $('#genre').val(),
            number_participants: $('#number_participants').val(),
        };
        
        AJAXCreateGrafica(data, function (res) {
            console.log(res);
        })
    }
    

    $(document).ready(function() {
        const mod_id = $('#mod_id').val();
        const nivel_id = $('#nivel_id').val();
        const genre = $('#genre').val();

        totalParticipantes(mod_id, nivel_id, genre);

        $('#mod_id').change(function(e) {
            e.preventDefault();
            const nivel_id = $('#nivel_id').val();
            const genre = $('#genre').val();
            totalParticipantes(this.value, nivel_id, genre);
        });

        $('#nivel_id').change(function(e) {
            e.preventDefault();
            const mod_id = $('#mod_id').val();
            const genre = $('#genre').val();
            totalParticipantes(mod_id, this.value, genre);
        });

        $('#genre').change(function(e) {
            e.preventDefault();
            const mod_id = $('#mod_id').val();
            const nivel_id = $('#nivel_id').val();
            totalParticipantes(mod_id, nivel_id, this.value);
        });

    });
</script>


<?= $this->endSection() ?>