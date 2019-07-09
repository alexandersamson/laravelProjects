// Some globals
var selectedBtnOptions = {};
var tempOptionStorage = {};
var usertypes = {
    "users":"users",
    "leaders":"leaders",
    "investigators":"investigators",
    "clients":"clients",
    "subjects":"subjects",
    "licenses":"licenses"};
//Specific global storage
var globalStorage = {};


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


//Clipboard
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
    url = $(this)[0].dataset.url;
    container = $(this)[0].dataset.container;
    $(container).find(url).remove();
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