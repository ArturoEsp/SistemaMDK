function AJAXFindUsersByParams (keyWords = null, type_user = null, callBack) {
    
    let paramsSearch = '';
    if (keyWords) paramsSearch += `keyWords=${keyWords}&`;
    if (type_user) paramsSearch += `type_user=${type_user}&`;

    $.ajax({
        method : 'GET',
        url: `${base_url}/users/search-users?${paramsSearch}`,
        dataType: "JSON",
        cache: true,
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXDeleteUserById (id = null, callBack) {
    $.ajax({
        method: 'DELETE',
        url: `${base_url}/users/user?id=${id}`,
        dataType: "JSON",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetUserById (id = null, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/users/user/${id}`,
        dataType: "JSON",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXUpdateUserById (id = null, data = {}, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/users/user/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Escuelas
function AJAXSaveSchool (data = {}, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/escuelas/save`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetListTeacher (callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/escuelas/teachers`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXStoreSchool (data = {}, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/escuelas/save`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetSchools (callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/escuelas/all`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXDeleteSchool (id = 0, callBack) {
    $.ajax({
        method: 'DELETE',
        url: `${base_url}/escuelas/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Participantes

function AJAXGetCategoriesByFilter (weight = 0, genre = 0, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/categories/${weight ? weight : 0}/${genre}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetLevelsByAge (age = 0, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/levels/${age}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXSaveStudent (data = {}, callBack) {
    $.ajax({
        method: 'POST',
        url: `${base_url}/participantes/save`,
        dataType: "json",
        contentType: false,
        processData: false,
        data: data,
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXStudentsBySchool (id, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/escuela/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}