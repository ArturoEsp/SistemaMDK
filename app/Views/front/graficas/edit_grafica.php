<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Editar gráfica<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Datos generales</h2>
            <span>Editar información de la grafica</span>
        </div>
        <div class="wrapper">
            <form class="Form max768" id="create_student">

            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Matchs</h2>
            <span>Lista de Matchs</span>
        </div>
        <div class="wrapper">
            <div class="wrapper_matchs" id="matchs_template">
                
            </div>
        </div>
    </div>
</div>

<script>

    function playerNotScore (id_registro, nombre, apellidos, position, match_id) {
        return `
        <div class="player">
            <input type="number" placeholder="Puntos" id="score_${position}_${match_id}">
            <select id="player_${position}_${match_id}">
                <option selected value="${id_registro}">${nombre} ${apellidos} (seleccionado)</option>
                <option value="empty">** ELIMINAR PARTICIPANTE **</option>
            </select>
        </div>
        `
    }

    function playerWithScore (id_registro, nombre, apellidos, score) {
        return `
        <div class="player">
            <input type="text" value="${score}" disabled>
            <select disabled>
                <option selected value="${id_registro}" selected>${nombre} ${apellidos} (seleccionado)</option>
            </select>
        </div>
        `
    }

    function roundNumber (no_match, total) {
        switch(total) {
            case 4:
                if (no_match === '1' || no_match == '2') return '1';
                if (no_match === '3') return '2';
                break;
            case 8:
                if (no_match === '1' || no_match == '2' || no_match == '3' || no_match == '4') return '1';
                if (no_match === '5' || no_match == '6') return '2';
                if (no_match === '7') return '3';
                break;
            case 16:
                break;
        }
    }

    function updateMatch (match_id) {
        const player_left = $(`#player_left_${match_id}`).val();
        const player_right = $(`#player_right_${match_id}`).val();

        const score_left = $(`#score_left_${match_id}`).val();
        const score_right = $(`#score_right_${match_id}`).val();

        const data = {
            match_id: match_id,
            left_player_id: player_left,
            right_player_id: player_right,
            left_player_score: score_left,
            right_player_score: score_right
        };

        AJAXUpdateMatch(data, function (res) {
            console.log(res);
        })
    }

    $(document).ready(function() {
        const no_participantes = <?= $grafica['no_participantes'] ?>;
        
        AJAXGetMatchsGrafica(<?= $grafica['id'] ?>, function(res) {
            const { status, data } = res;
            console.log(data);
            if (status === 'ok') {
                let template = '';
                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    let player_left = '', player_right = '';

                    if (e.left_player_score)
                        player_left = playerWithScore(e.left_player_registro_id, e.left_player_nombre, e.left_player_apellidos, e.left_player_score);
                    else
                        player_left = playerNotScore(e.left_player_registro_id, e.left_player_nombre, e.left_player_apellidos, 'left', e.match_id);

                    if (e.right_player_score)
                        player_right = playerWithScore(e.right_player_registro_id, e.right_player_nombre, e.right_player_apellidos, e.right_player_score);
                    else
                        player_right = playerNotScore(e.right_player_registro_id, e.right_player_nombre, e.right_player_apellidos, 'right', e.match_id);

                    let disabledButton = (e.right_player_score && e.left_player_score) ? 'disabled' : '';
                    const string_match = `
                    <div class="match_round">
                        <h2>Round ${roundNumber(e.no_match, no_participantes)} - ${e.nombre_area}</h2>
                            <div class="matchs">
                                ${player_left}
                                <span>VS</span>
                                ${player_right}
                            </div>
                        <button class="btn_save" ${disabledButton} onclick="updateMatch(${e.match_id})">Guardar</button>
                    </div>
                    
                    `;
                    template += string_match;
                }
                $('#matchs_template').append(template);
            }
        })

    });
</script>

<?= $this->endSection() ?>