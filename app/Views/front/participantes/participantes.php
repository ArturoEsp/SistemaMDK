<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Lista de Participantes<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Agregar participante</h2>
            <span>Ingresa un alumno a tu escuela</span>
        </div>
        <div class="wrapper">
            <form class="Form max768" id="create_student">

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

                <div class="group-input">
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
                        <label for="grade_id">Grado actual</label>
                        <select name="grade_id" id="grade_id">
                            <option disabled selected>** SELECCIONA GRADO **</option>
                            <?php foreach ($grados as $value) : ?>
                                <option value="<?= $value['id_grado'] ?>"><?= $value['nom_grado'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="input">
                    <label for="photo">Fotografía</label>
                    <input type="file" name="photo" id="photo">
                </div>

                <div class="group-buttons">
                    <button class="success" type="submit" id="edit-save">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Participantes</h2>
            <span>Lista de participantes de mis escuelas</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="buttons">
                    <a class="button-a" id="a-register" href="participantes/registro-evento">Registrar a evento</a>
                </div>
                <div class="dropdown-list">
                    <select name="filter_school" id="filter_school">
                        <?php foreach ($schools as $value) : ?>
                            <option selected value="<?= $value['id_escuela'] ?>"><?= $value['nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="wrapper_students" id="students">

            </div>
        </div>
    </div>
</div>

<script>
    function listStudents(id = null) {

        AJAXStudentsBySchool(id, function(res) {
            const data = res.data;
            $('#students').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#students').append(`
            <div class="item">
                    <div class="photo">
                        <div class="image">
                            <img src="uploads/${e.fotografia ? e.fotografia : 'custom.png'}" alt="">
                        </div>
                        <div class="edit">
                            <a href="participantes/edit?s=${btoa(e.id_alumno)}">Editar</a>
                        </div>
                    </div>
                    <div class="information">
                        <div class="row green">
                            <span>${e.nombres} ${e.apellidos}</span>
                            <span>ID ${e.id_alumno}</span>
                        </div>
                        <div class="row ">
                            <span>${e.edad} años</span>
                            <span><a href="#">Grados</a></span>
                        </div>
                        <div class="row green">
                            <span>${e.sexo === '1' ? 'Mujer' : 'Hombre'}</span>
                            <span>${e.altura} cm., ${e.peso} kg.</span>
                        </div>
                        <div class="row ">
                            <span>Categoría: ${e.nom_cat}</span>
                            <span>Nivel: ${e.descrip_niv}</span>
                        </div>
                    </div>
                </div>
            `);

            }
        })
    }
    $(document).ready(function() {
        const school_id = $('#filter_school').val();
        listStudents(school_id);
        $("#a-register").attr('href', `participantes/registro-evento?id=${school_id}`)

        $('#weight').keyup(function(e) {
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

        $('#filter_school').change(function(e) {
            e.preventDefault();
            $("#a-register").attr('href', `participantes/registro-evento?id=${this.value}`)
            listStudents(this.value);
        });


        $("#create_student").validate({
            rules: {
                name: "required",
                lastname: "required",
                age: "required",
                weight: "required",
                height: "required",
                type_student: "required",
                school_id: 'required',
                grade_id: 'required'
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
                grade_id: {
                    required: "Selecciona su grado actual",
                },

            },
            submitHandler: function(form) {
                onSubmitForm();
                form.reset();
            }
        });

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
        formData.append('grade_id', $('#grade_id').val());
        formData.append('photo', photo);

       AJAXSaveStudent(formData, function(res) {
            const { status, data } = res;
            $('#edit-save').prop('disabled', true);

            if (status === 'ok') {
                $('#edit-save').prop('disabled', false);
                listStudents($('#filter_school').val());
                swal("Alumno registrado correctamente.", "", "success");
            }

            if (status === 'error') {
                $('#edit-save').prop('disabled', false);
                swal("Ocurrió un error!", data, "error");
            }
        })
    }
</script>

<?= $this->endSection() ?>