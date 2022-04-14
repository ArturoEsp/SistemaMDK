<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Editar información<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="box-content">
    <div class="title">
        <h2>Editar participante</h2>
        <span>Edita la información del participante</span>
    </div>
    <div class="wrapper">
        <form class="Form max768" id="update_student">
            <div class="group-input">
                <div class="input">
                    <label for="">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Nombre del participante">
                </div>
                <div class="input">
                    <label for="">Apellidos</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Apellidos">
                </div>
                <div class="input">
                    <label for="age">Edad</label>
                    <input type="number" name="age" id="age">
                </div>
            </div>
            <div class="group-input">
                <div class="input">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo">
                        <option value="1">Mujer</option>
                        <option value="0">Hombre</option>
                    </select>
                </div>
                <div class="input">
                    <label for="height">Altura (centímetros)</label>
                    <input type="number" name="height" id="height">
                </div>
                <div class="input">
                    <label for="weight">Peso (Kilogramos)</label>
                    <input type="number" name="weight" id="weight">
                </div>
            </div>

            <div class="group-input">
                <div class="input">
                    <label for="">Categoría</label>
                    <select name="categories" id="categories">
                        <option disabled selected>** SELECCIONA **</option>

                    </select>
                </div>
                <div class="input">
                    <label for="type_student">Tipo de alumno</label>
                    <select name="type_student" id="type_student">
                        <option disabled selected>** SELECCIONA **</option>
                        <?php foreach ($tipos_alumno as $tipo) : ?>
                            <option value="<?= $tipo['id_ta'] ?>"><?= $tipo['ta_descrip'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="input">
                    <label for="level">Nivel</label>
                    <select name="level" id="level">
                        <option disabled selected>** SELECCIONA **</option>
                    </select>
                </div>
            </div>

            <div class="input">
                <label for="school_id">Escuela asignada</label>
                <select name="school_id" id="school_id">
                    <option disabled selected>** SELECCIONA ESCUELA **</option>
                    <?php foreach ($schools as $value) : ?>
                        <option value="<?= $value['id_escuela'] ?>"><?= $value['nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="input">
                <label for="photo">Fotografía (Si deseas cambiar la fotografiá, selecciona una nueva.)</label>
                <input type="file" name="photo" id="photo">
            </div>

            <div class="group-buttons">
                <button class="success" type="submit" id="edit-save">Guardar</button>
            </div>
        </form>
    </div>
</div>
<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const participante_id = atob(urlParams.get('s'));

    $(document).ready(function() {

        $('#weight').keyup(function(e) {
            listCategories(this.value, null)
        });

        $('#weight').on('input', function(e) {
            listCategories(this.value, null)
        });


        $('#sexo').change(function(e) {
            e.preventDefault();
            listCategories(null, this.value)
        });

        $('#age').keyup(function(e) {
            const age = this.value ? this.value : null;
            listLevels(age)
        });

        $("#update_student").validate({
            rules: {
                name: "required",
                lastname: "required",
                age: "required",
                weight: "required",
                height: "required",
                type_student: "required",
                school_id: 'required'
            },
            messages: {
                name: {
                    required: "Ingresa el nombre del alumno",
                },
                lastname: {
                    required: "Ingresa el apellido del alumno",
                },
                age: {
                    required: "Ingresa la edad",
                },
                weight: {
                    required: "Ingresa el peso",
                },
                height: {
                    required: "Ingresa la altura",
                },
                type_student: {
                    required: "Selecciona el tipo de alumno",
                },
                school_id: {
                    required: "Selecciona la escuela asignada",
                },

            },
            submitHandler: function(form) {
                onSubmitForm();
            }
        });

        getDataStudent(participante_id);
    });

    function listCategories(weight = null, genre = null) {
        const _genre = genre ? genre : $('#sexo').val();
        const _weight = weight ? weight : $('#weight').val();

        AJAXGetCategoriesByFilter(_weight, _genre, function(res) {
            const data = res?.data;

            $('#categories').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#categories').append("<option value=" + e.id_categoria + ">" + `${e.nom_cat} (${e.rango})` + "</option>");
            }
        });
    }

    function listLevels(age = 0) {
        AJAXGetLevelsByAge(age, function(res) {
            const data = res?.data;

            $('#level').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#level').append("<option value=" + e.id_nivel + ">" + `${e.descrip_niv} (${e.rango})` + "</option>");
            }
        });
    }

    function getDataStudent (id) {
        AJAXStudentById(id, function (res) {
            const { data, status } = res;
            if (status === 'error') {
                return swal("Ocurrió un error!", data, "error");
            }

            $('#name').val(data.nombres);
            $('#lastname').val(data.apellidos);
            $('#age').val(data.edad);
            $('#sexo').val(data.sexo);
            $('#height').val(data.altura);
            $('#weight').val(data.peso);
            $('#type_student').val(data.id_ta);
            $('#school_id').val(data.id_escuela);
            
            listCategories($('#weight').val(), $('#sexo').val());
            listLevels($('#age').val())

            $('#level').val(data.id_nivel);
            $('#categories').val(data.id_categoria);
        })
    }

    function onSubmitForm() {
        const photo = $('#photo').prop('files')[0];

        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('lastname', $('#lastname').val());
        formData.append('age', $('#age').val());
        formData.append('sexo', $('#sexo').val());
        formData.append('height', $('#height').val());
        formData.append('weight', $('#weight').val());
        formData.append('type_category', $('#categories').val());
        formData.append('type_student', $('#type_student').val());
        formData.append('type_nivel', $('#level').val());
        formData.append('school_id', $('#school_id').val());
        formData.append('photo', photo);

        AJAXUpdateStudent(participante_id, formData, function (res) {
            const { status, data } = res;
            $('#btn_success').prop('disabled', true);
            if (status === 'ok') {
                swal({title: "Actualización correcta!", 
                        text: "", 
                        icon: "success"
                }).then(function() { 
                    history.back();
                });
            }

            if (status === 'error') {
                $('#btn_success').prop('disabled', false);
                swal("Ocurrió un error!", data, "error");
            }
        });

    }

    
</script>

<?= $this->endSection() ?>