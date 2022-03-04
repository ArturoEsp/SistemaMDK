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