// Some globals
var selectedBtnOptions = {};
var tempOptionStorage = {};
var usertypes = {
    "leader":"leader",
    "investigator":"investigator",
    "client":"client"};
// private $containerId = array (
//     'leader' => 'leader',
//     'investigator' => 'investigator',
//     'client' => 'client'
// );

//Specific global storage
var globalStorage = {};

// Basic AJAX setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
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
    var password = $("********").val();
    var email = $("testtesttest").val();
    var returnValue;
    var modal = $(this);
    modal.find('.modal-title').text('Loading...');
    modal.find('.modal-body').html($loader);

    $.ajax({
        type: 'POST',
        url: '/ajaxTestRequest',
        data: {name: name, password: password, email: email},
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
    var btnDataSave = button.data('save'); //Extract info from data-* attributes
    $('#genericFormModalSaveBtn').attr('data-save', btnDataSave);
    var returnValue;
    var modal = $(this);
    modal.find('.modal-title').text('Loading...');
    modal.find('.modal-body').html($loader);

    if(btnDataCmd === 'getAjax') {
        $.ajax({
            type: 'GET',
            url: '/' + btnDataUrl,
            data: {},
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
    $urlMethod = $(this)[0].dataset.save;
    $.ajax({
        type: 'POST',
        url: '/' + $urlMethod,
        data: {"data" : tempOptionStorage},
        success: function (data) {
            returnValue = data;
            $('#ajax-output-' + $urlMethod).html(data);
            $('#genericFormModal').modal('hide');
            selectedBtnOptions = {};
            tempOptionStorage = {};
        }
    });
});

$(document).on('click', '.modalCancelBtn', function () {
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

    preUrl = "";
    console.log($(this)[0].dataset.usertype);
    if($(this)[0].dataset.usertype === usertypes.investigator || $(this)[0].dataset.usertype === usertypes.leader){
        preUrl = "users"
    } else if($(this)[0].dataset.usertype === usertypes.client){
        preUrl = "clients"
    }
    url = $(this)[0].dataset.url;

    $.ajax({
        type: 'GET',
        url: '/'+preUrl+'/profile-modal/' + url,
        data: {},
        success: function (data) {
            returnValue = data;
            $('#genericInfoModal').modal().find('.modal-body').html(returnValue);
        }
    });
});