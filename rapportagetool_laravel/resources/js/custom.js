// Some globals
var timers = {
    "title": null ,
    "body": null,
    "footer": null,
};

var selectedBtnOptions = {};
var tempOptionStorage = {};
var usertypes = {
    "users":"users",
    "leaders":"leaders",
    "investigators":"investigators",
    "clients":"clients",
    "subjects":"subjects",
    "licenses":"licenses",
    "messages":"messages"};
//Specific global storage
var globalStorage = {};
var $floodProtect = true;


// private $containerId = array (
//     'leader' => 'leader',
//     'investigator' => 'investigator',
//     'client' => 'client'
// );




// Basic AJAX setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$( function() {
    $( "ul.droptrue" ).sortable({
        connectWith: "ul",
        handle: ".icon-move",
        placeholder: "ui-state-highlight",
    });

    $( "ul.dropfalse" ).sortable({
        connectWith: "ul",
        dropOnEmpty: false
    });

    $( "#sortable1, #sortable2, #sortable3" ).disableSelection();
} );


//Clipboard and other onready preloads
$( document ).ready(function() {
    var btns = document.querySelectorAll('.btnClipboard');
    var clipboardJs = new ClipboardJS(btns);
    clipboardJs.on('success', function (e) {
        $(document).find('#'+$(e.trigger)[0].dataset.clipboardReturnIdTarget).addClass("badge-success btn-outline-success");
    });
    clipboardJs.on('error', function (e) {
        console.log(e);
        $(document).find('#'+$(e.trigger)[0].dataset.clipboardReturnIdTarget).addClass("badge-danger");
    });

    //init some timers
    startTimer('title');
    clearTimeout(timers['title']);
    startTimer('body');
    clearTimeout(timers['body']);
    startTimer('footer');
    clearTimeout(timers['footer']);
});

//loader for modals etc
$loader = '<div class="d-flex justify-content-center">\n' +
    '  <div class="spinner-border text-primary" role="status">\n' +
    '    <span class="sr-only">Loading...</span>\n' +
    '  </div>\n' +
    '</div>';


// functions
$('#testModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var btnDataHeader = button.data('header');// Extract info from data-* attributes
    var btnDataBody = button.data('body');// Extract info from data-* attributes
    var name = $("Test").val();
    var returnValue;
    var modal = $(this);
    modal.find('.modal-title').text('Loading...');
    modal.find('.modal-body').html($loader);

    $.ajax({
        type: 'POST',
        url: '/ajaxTestRequest',
        data: {},
        success: function (data) {
            returnValue = JSON.stringify(data);
            modal.find('.modal-title').text(btnDataHeader);
            modal.find('.modal-body').html('<small>' + returnValue + '</small>');
        }
    });
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
});


$('#genericFormModal').on('show.bs.modal', function (event) {
    selectedBtnOptions = {};
    tempOptionStorage = {};
    var button = $(event.relatedTarget); // Button that triggered the modal
    var btnDataHeader = button.data('header');// Extract info from data-* attributes
    var btnDataCmd = button.data('cmd'); //Extract info from data-* attributes
    var btnDataUrl = button.data('url'); //Extract info from data-* attributes
    var btnDataSaveUrl = button.data('save-url'); //Extract info from data-* attributes
    var btnDataCategory = button.data('category'); //Extract info from data-* attributes
    $('#genericFormModalSaveBtn').attr({'data-category': btnDataCategory, 'data-url': btnDataSaveUrl});
    var returnValue;
    var modal = $(this);
    modal.find('.modal-title').text('Loading...');
    modal.find('.modal-body').html($loader);

    if(btnDataCmd === 'getAjax') {
        $.ajax({
            type: 'GET',
            url: '/' + btnDataUrl,
            data: {"category" : btnDataCategory},
            success: function (data) {
                returnValue = data;
                modal.find('.modal-title').text(btnDataHeader);
                modal.find('.modal-body').html(returnValue);
            }
        });
    }
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
});

$(document).on('click', '.selectBtnRadio', function () {

    dontSet = false;
    if($(this).hasClass("btn-success")){
        dontSet = true;
        $(this).addClass("btn-primary");
        $(this).removeClass("btn-success");
        $(this).text("Select this user");
    }
    $(this).addClass("btn-success");
    $(this).removeClass("btn-primary");
    $(this).html("&nbsp;User selected&nbsp;&nbsp;");
    $(selectedBtnOptions[0]).addClass("btn-primary");
    $(selectedBtnOptions[0]).removeClass("btn-success");
    $(selectedBtnOptions[0]).text("Select this user");
    selectedBtnOptions = {};
    if (dontSet === false){
        selectedBtnOptions[0] = this;
    }
    tempOptionStorage = {};
    tempOptionStorage[0]=$(this)[0].dataset.value;
    console.log(tempOptionStorage);
});

$(document).on('click', '.selectBtnMulti', function () {

    dontSet = false;
    if($(this).hasClass("btn-success")){
        dontSet = true;
        $(this).addClass("btn-primary");
        $(this).removeClass("btn-success");
        $(this).text("Select this user");
        selectedBtnOptions[$(this)[0].dataset.value] = {};
        tempOptionStorage[$(this)[0].dataset.value] = {};
    } else {
        $(this).addClass("btn-success");
        $(this).removeClass("btn-primary");
        $(this).html("&nbsp;User selected&nbsp;&nbsp;");
        selectedBtnOptions[$(this)[0].dataset.value] = this;
        tempOptionStorage[$(this)[0].dataset.value] = $(this)[0].dataset.value;
    }
    console.log(tempOptionStorage);
});

$(document).on('click', '.modalSaveBtn', function () {
    //$('#containter-lead-investigator').html($(this)[0].dataset.save);
    $('#genericFormModal').modal().find('.modal-body').html($loader + "<br><p style=\"text-align:center\">Saving...</p></center>");
    $url = $(this)[0].dataset.url;
    $category = $(this)[0].dataset.category;
    $.ajax({
        type: 'POST',
        url: '/' + $url,
        data: {"category" : $category, "data" : tempOptionStorage},
        success: function (data) {
            returnValue = data;
            $('#ajax-output-' + $category).html(data);
            $('#genericFormModal').modal('hide');
            selectedBtnOptions = {};
            tempOptionStorage = {};
        }
    });
});




$('#genericDeleteModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-body').html($loader); // Clear all HTML and show the loading spinner
    var button = $(event.relatedTarget); // Button that triggered the modal
    var btnDataName = button.data('name');// Extract info from data-* attributes
    var btnDataDeleteCategory = button.data('category'); //Extract info from data-* attributes
    var btnDataDomId = button.data('domid'); //Extract info from data-* attributes
    var btnDataDeleteId = button.data('id'); //Extract info from data-* attributes
    var returnValue;

    $.ajax({
        type: 'GET',
        url: '/checkdelete/'+btnDataDeleteCategory+'/'+btnDataDeleteId,
        data: {},
        success: function (data) {
            returnValue = data;
            modal.find('.modal-body').html(returnValue);
            modal.find('#genericDeleteModalYesBtn').attr('data-category', btnDataDeleteCategory);
            modal.find('#genericDeleteModalYesBtn').attr('data-id', btnDataDeleteId);
            modal.find('#genericDeleteModalYesBtn').attr('data-domid', btnDataDomId);
        }
    });
});

$(document).on('click', '#genericDeleteModalYesBtn', function () {
    btnDataDomId = $(this)[0].dataset.domid;
    btnDataId = $(this)[0].dataset.id;
    btnDataCategory = $(this)[0].dataset.category;
    $.ajax({
        type: 'GET',
        url: '/delete/'+btnDataCategory+'/'+btnDataId,
        data: {},
        success: function (data) {
            $('#'+btnDataDomId).remove();
            $('#genericDeleteModal').modal('hide');
            window.location.replace('/' + btnDataCategory + '/' + btnDataId);
        }
    });
});


$('#genericRecoverModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-body').html($loader); // Clear all HTML and show the loading spinner
    var button = $(event.relatedTarget); // Button that triggered the modal
    var btnDataName = button.data('name');// Extract info from data-* attributes
    var btnDataDeleteCategory = button.data('category'); //Extract info from data-* attributes
    var btnDataDomId = button.data('domid'); //Extract info from data-* attributes
    var btnDataDeleteId = button.data('id'); //Extract info from data-* attributes
    var returnValue;

    $.ajax({
        type: 'GET',
        url: '/checkrecover/'+btnDataDeleteCategory+'/'+btnDataDeleteId,
        data: {},
        success: function (data) {
            returnValue = data;
            modal.find('.modal-body').html(returnValue);
            modal.find('#genericRecoverModalYesBtn').attr('data-category', btnDataDeleteCategory);
            modal.find('#genericRecoverModalYesBtn').attr('data-id', btnDataDeleteId);
            modal.find('#genericRecoverModalYesBtn').attr('data-domid', btnDataDomId);
        }
    });
});

$(document).on('click', '#genericRecoverModalYesBtn', function () {
    btnDataDomId = $(this)[0].dataset.domid;
    btnDataId = $(this)[0].dataset.id;
    btnDataCategory = $(this)[0].dataset.category;
    $.ajax({
        type: 'GET',
        url: '/recover/'+btnDataCategory+'/'+btnDataId,
        data: {},
        success: function (data) {
            $('#'+btnDataDomId).remove();
            $('#genericRecoverModal').modal('hide');
            window.location.replace('/' + btnDataCategory + '/' + btnDataId);
        }
    });
});


$(document).on('click', '.modalCancelBtn', function () {
    //Clear the temp variables
    selectedBtnOptions = {};
    tempOptionStorage = {};
});

$(document).on('click', '.modalNoBtn', function () {
    //Clear the temp variables
    selectedBtnOptions = {};
    tempOptionStorage = {};
});


$(document).on('click', '.btnDeleteItem', function () {
    var category = $(this)[0].dataset.category;
    var objId = $(this)[0].dataset.objid;
    var sourceCat = $(this)[0].dataset.sourcecat;
    var sourceId = $(this)[0].dataset.sourceid;

    $.ajax({
        type: 'POST',
        url: '/ajaxdynamicsearch/remove',
        data: {
            "sourceCat":sourceCat,
            "sourceId": sourceId,
            "category": category,
            "id":       objId
        },
        beforeSend: function () {
            $('#sbic' + category).html($loader);
        },
        success: function (data) {
            returnValue = data;
            $('#sbic' + category).html(data);
        }
    });
});

$('#genericEraseModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-body').html($loader); // Clear all HTML and show the loading spinner
    var button = $(event.relatedTarget); // Button that triggered the modal
    var btnDataName = button.data('name');// Extract info from data-* attributes
    var btnDataDeleteCategory = button.data('category'); //Extract info from data-* attributes
    var btnDataDomId = button.data('domid'); //Extract info from data-* attributes
    var btnDataDeleteId = button.data('id'); //Extract info from data-* attributes
    var returnValue;

    $.ajax({
        type: 'GET',
        url: '/checkerase/'+btnDataDeleteCategory+'/'+btnDataDeleteId,
        data: {},
        success: function (data) {
            returnValue = data;
            modal.find('.modal-body').html(returnValue);
            modal.find('#genericEraseModalYesBtn').attr('data-category', btnDataDeleteCategory);
            modal.find('#genericEraseModalYesBtn').attr('data-id', btnDataDeleteId);
            modal.find('#genericEraseModalYesBtn').attr('data-domid', btnDataDomId);
        }
    });
});

$(document).on('click', '#genericEraseModalYesBtn', function () {
    btnDataDomId = $(this)[0].dataset.domid;
    btnDataId = $(this)[0].dataset.id;
    btnDataCategory = $(this)[0].dataset.category;
    $.ajax({
        type: 'GET',
        method: 'DELETE',
        url: '/'+btnDataCategory+'/'+btnDataId,
        data: {_method: 'delete'},
        success: function (data) {
            $('#'+btnDataDomId).remove();
            $('#genericRecoverModal').modal('hide');
            window.location.replace('/' + btnDataCategory, {'success' : 'Permanently erased'});
        },
        // error: function(xhr) {
        //     console.log(xhr.responseText); // this line will save you tons of hours while debugging
        //     // do something here because of error
        // }
    });
});



$(document).on('click', '.btnModalInfoUser', function () {
    //$('#containter-lead-investigator').html($(this)[0].dataset.save);
    $('#genericInfoModal').modal().find('.modal-body').html($loader + "<br><p style=\"text-align:center\">Loading...</p></center>");
    title = $(this)[0].dataset.header;
    category = "";
    if($(this)[0].dataset.category === usertypes.investigators || $(this)[0].dataset.category === usertypes.leaders){
        category = usertypes.users;
    } else {
        category = $(this)[0].dataset.category;
    }

    personId = $(this)[0].dataset.url;

    $.ajax({
        type: 'GET',
        url: '/profile-modal/'+ category +'/' + personId,
        data: {},
        success: function (data) {
            returnValue = data;
            $('#genericInfoModal').modal().find('.modal-title').html(title);
            $('#genericInfoModal').modal().find('.modal-body').html(returnValue);
        }
    });
});











$(document).on('click', '.dynamicSearchBox', function () {
    this.select();
});


$(document).on('input', '.dynamicSearchBox', function () {
    //DynamicSearchController@getSearchItems needs data:
    //categories
    //returnCols
    //searchCols
    //searchString
    category = $(this)[0].dataset.category;
    variant = $(this)[0].dataset.variant;
    sourceCat = $(this)[0].dataset.source;
    sourceId = $(this)[0].dataset.sourceid;
    permissionFilter = $(this)[0].dataset.permissionfilter;
    objId = $(this)[0].dataset.id;
    objTargetId = $(this)[0].dataset.targetid;
    console.log($(this)[0].dataset.targetid);
    var myanchor = this;
    var a, b, i, n = $(this).value;
    var results;
    var categories, searchCols, returnCols = [];

    if(category === 'casefiles'){
        categories = ['casefiles'];
        searchCols = ['name','casecode'];
        returnCols = [['id','name','casecode']];
    }
    if(category === 'posts'){
        categories = ['posts'];
        searchCols = ['name'];
        returnCols = [['id','name']];
    }
    if(category === 'leaders'){
        categories = ['leaders'];
        searchCols = ['name'];
        returnCols = [['id','name','permission']];
    }
    if(category === 'investigators'){
        categories = ['investigators'];
        searchCols = ['name'];
        returnCols = [['id','name','permission']];
    }
    if(category === 'clients'){
        categories = ['clients'];
        searchCols = ['name','city','email','phone'];
        returnCols = [['id','name','permission']];
    }
    if(category === 'subjects'){
        categories = ['subjects'];
        searchCols = ['name','city','email','phone'];
        returnCols = [['id','name']];
    }
    if(category === 'users'){
        categories = ['users'];
        searchCols = ['name','email','city','phone'];
        returnCols = [['id','name','permission']];
    }
    $(myanchor).removeClass("bg-success-light");
    $(myanchor).removeClass("border-success");
    document.getElementById(objTargetId).value = '';
    if ($(this).val().length > 2 && $floodProtect === true){
        $.ajax({
            type: 'POST',
            url: '/ajaxdynamicsearch',
            context: $(this),
            data: {
                "searchString": $(this).val(),
                "categories": categories,
                "searchCols": searchCols,
                "returnCols": returnCols,
                "permissionfilter": permissionFilter,
            },
            success: function (data) {
                killAll();
                results = Array.prototype.concat.apply([], JSON.parse(data));
                if(results.length > 0 ){
                    console.log(results.length);
                    a = document.createElement("DIV");
                    a.setAttribute("id",  + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    a.innerHTML += "<input type='hidden' value=''>";
                    myanchor.parentNode.appendChild(a);
                    for(var i = 0; i < results.length; i++){
                        b = document.createElement("DIV");
                        if(category === 'casefiles'){
                            b.innerHTML = "" + results[i]['name'] + " <small class='text-muted'>("+results[i]['casecode']+")</small>";
                        } else {
                            b.innerHTML = "" + results[i]['name'] + " <small class='text-muted'>(#" + results[i]['id'] + ")</small>";
                        }
                        b.innerHTML += "<input type='hidden' value='" + results[i]['id'] + "'>";
                        b.innerHTML += "<input type='hidden' value='" + results[i]['name'] + "'>";
                        b.addEventListener("click", function(e) {
                            if(variant === 'addToList'){
                                console.log("value:"+ $(this).find('input')[0].value);
                                console.log(category);
                                $.ajax({
                                    type: 'POST',
                                    context: $(this),
                                    url: '/ajaxdynamicsearch/addtolist',
                                    data: {"category" : category, "sourceCat" : sourceCat, "sourceId" : sourceId, "id" : $(this).find('input')[0].value},
                                    beforeSend: function(){
                                        $('#'+objTargetId).html($loader);
                                    },
                                    success: function (data) {
                                        returnValue = data;
                                        $('#'+objTargetId).html(data);
                                    }
                                });
                            } else {
                                document.getElementById(objTargetId).value = this.getElementsByTagName('input')[0].value;
                                myanchor.value = this.getElementsByTagName('input')[1].value;
                                $(myanchor).addClass("border-success");
                                $(myanchor).addClass("bg-success-light");
                            }
                            killAll();
                        });
                        a.appendChild(b);
                    }
                } else {
                    console.log("empty");
                    killAll();
                }
            }
        });

        $floodProtect = false;
        setTimeout(function(){ $floodProtect = true }, 100);

    } else {
        killAll();
    }

    function killAll() {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            x[i].parentNode.removeChild(x[i]);
        }
    }
});



$( document ).ready(function() { //if the container is visible on the page
    $('.searchBoxItemsContainer').each(function(i, obj) {
        var sourceCat = $(this)[0].dataset.sourcecat;
        var targetCat = $(this)[0].dataset.targetcat;
        var sourceId = $(this)[0].dataset.sourceid;
        var objTargetId = $(this)[0].dataset.targetid;
        $.ajax({
            type: 'GET',
            url: '/ajaxdynamicsearch/receivelist',
            data: {
                "sourceCat": sourceCat,
                "sourceId": sourceId,
                "targetCat": targetCat,
            },
            beforeSend: function () {
                $('#' + objTargetId).html($loader);
            },
            success: function (data) {
                returnValue = data;
                $('#' + objTargetId).html(data);
            }
        });
    });
});


/////////////////////
//////AUTOSAVE///////
/////////////////////
function startTimer($timer, $category, $id, $inputId, $inputName){
    timers[$timer] = window.setTimeout(function(){
        // console.log(document.getElementById($inputId).value);
        $.ajax({
            type: 'POST',
            url: '/ajaxautosave/'+$category+'/'+$id,
            data: {
                "input": $inputName,
                "data": document.getElementById($inputId).value
            },
            success: function (data) {
                // console.log(data);
            }
        });
    },5000)
}
$(document).on('input', '.autosave-input', function () {
    var cooldownGroup = $(this)[0].dataset.cooldowngroup;
    var sourceCat = $(this)[0].dataset.sourcecat;
    var sourceId = $(this)[0].dataset.sourceid;
    var sourceInputName = $(this)[0].dataset.sourceinput;
    var inputId = $(this)[0].dataset.inputid;
    clearTimeout(timers[cooldownGroup]);
    startTimer(cooldownGroup, sourceCat, sourceId, inputId, sourceInputName);
});