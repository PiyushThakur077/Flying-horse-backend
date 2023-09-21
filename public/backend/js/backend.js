$(document).ready(function () {
  $("#dataTableBuilder").on("click", ".edit_meta", function () {
    var id = this.id;
    var url = APP_URL + '/admin/edit_meta';
    $.ajax({
      type: "POST",
      url: url,
      data: { 'id': id, method: 'get_meta' },
      dataType: 'JSON',
      async: false,
      success: function (msg) {
        if (msg.status_check == 1) {
          $('.edit_id').val(msg.id);
          $('#input_url').val(msg.url);
          $('#input_title').val(msg.title);
          $('#input_description').val(msg.description);
          $('#input_keywords').val(msg.keywords);
        }
      },
      error: function (request, error) {
        console.log(error);
      }
    });
  });
  $("#update_meta").on("click", function () {

    var edit_id = $('.edit_id').val();
    var page_url = $('#input_url').val();
    var title = $('#input_title').val();
    var description = $('#input_description').val();
    var keywords = $('#input_keywords').val();
    var url = APP_URL + '/admin/edit_meta';
    $.ajax({
      type: "POST",
      url: url,
      data: { 'edit_id': edit_id, 'url': page_url, 'title': title, 'description': description, 'keywords': keywords, method: 'update_meta' },
      dataType: 'JSON',
      async: false,
      success: function (msg) {
        if (msg.status_check == 1) {
          $('.edit_id').val(msg.id);
          $('#input_url').val(msg.url);
          $('#input_title').val(msg.title);
          $('#input_description').val(msg.description);
          $('#input_keywords').val(msg.keywords);
          $('#meta_message').css({ 'display': 'block', 'text-align': 'center' });
          $('#meta_message').html(msg.message);
        } else {
          $('#meta_message').css({ 'display': 'none', 'text-align': 'center' });
          $('.input_url').html(msg.url);
          $('.input_title').html(msg.title);
          $('.input_description').html(msg.description);
          $('.input_keywords').html(msg.keywords);

        }
      },
      error: function (request, error) {
        console.log(error);
      }
    });
  });
});


function page_loader_start() {
  $('body').prepend('<div id="preloader"></div>');
  //$('#preloader').fadeOut('slow',function(){$(this).remove();});
}
function page_loader_stop() {
  $('#preloader').fadeOut('slow', function () { $(this).remove(); });
}

// $(document.body).on('click', '.date-package-modal-admin', function(){
//     var fl = $(this).hasClass('tile-previous');
//     $('#model-message').html("");
//     if(!fl){
//         var sdate = $(this).attr('id');
//         var div = sdate.split('-');
//         var day = div[2];
//         var month = div[1];
//         var year = div[0];
//         var price = $(this).attr('data-price');
//         var status = $(this).attr('data-status');
//         //var date = day+'-'+month+'-'+year;
//         var date = month+'-'+day+'-'+year;
//         $('#dtpc_start_admin').val(date);
//         $('#dtpc_end_admin').val(date);
//         $('#dtpc_price').val(price);
//         $('#dtpc_status').val(status).change();

//         $("#dtpc_start_admin").datepicker({
//             //format: "dd-mm-yyyy",
//             format: "mm-dd-yyyy",
//             onSelect: function(date) {

//             },
//         });
//         $("#dtpc_end_admin").datepicker({
//             //format: "dd-mm-yyyy",
//             format: "mm-dd-yyyy",
//             onSelect: function(date) {

//             },
//         }); 
//         $('#hotel_date_package_admin').modal();
//     }
// });

// $(document.body).on('submit', "#dtpc_form", function(e){
//   e.preventDefault();
//   $('#error-dtpc-start').html('');
//   $('#error-dtpc-end').html('');
//   $('#error-dtpc-price').html('');

//   $('#cal_submit_btn').attr('disabled',true);
//   var start_date = $('#dtpc_start_admin').val();
//   var end_date = $('#dtpc_end_admin').val();
//   var price = $('#dtpc_price').val();
//   var status      = $('#dtpc_status').val();
//   var property_id = $('#dtpc_property_id').val();
//   var url = APP_URL+'/admin/ajax-calender-price/'+property_id;

//   if(start_date == ''){ $('#error-dtpc-start').html('Start date not given.'); return false; } else{ $('#error-dtpc-start').html('');  }
//   if(end_date == ''){ $('#error-dtpc-end').html('End date not given.'); return false; } else{ $('#error-dtpc-end').html('');  }
//   if(price == ''){ $('#error-dtpc-price').html('Price not given.'); return false; } else{ $('#error-dtpc-price').html('');  }
//   if(status == ''){ $('#error-dtpc-status').html('Status not select.'); return false; } else{ $('#error-dtpc-status').html('');  }

//   if(price != '' && isNaN(price)){
//       $('#error-dtpc-price').html('Please enter a valid price.');
//       $('#cal_submit_btn').removeAttr('disabled');
//       return false;
//   }else{
//       $('#error-dtpc-price').html('');
//   }

//   var div    = start_date.split('-');
//   var day    = div[1];
//   var month  = div[0];
//   var year   = div[2];
//   var new_start_date   = day+'-'+month+'-'+year;

//   var div2    = end_date.split('-');
//   var day2    = div2[1];
//   var month2  = div2[0];
//   var year2   = div2[2];
//   var new_end_date   = day2+'-'+month2+'-'+year2;

//   $.ajax({
//       type: "POST",
//       url: url,
//       data: {'start_date':new_start_date, 'end_date':new_end_date, 'price':price, 'status':status},
//       async: false,
//       success: function(msg) {
//             var year_month = $('#calendar_dropdown').val();
//             year_month = year_month.split('-');
//             var year = year_month[0];
//             var month = year_month[1];
//             set_calendar(month, year);
//             $('#model-message').html("Price saved successfully");
//             $('#model-message').show(); 
//             $('#cal_submit_btn').removeAttr('disabled');
//       },
//       error: function(request, error) {
//           console.log(error);
//           $('#cal_submit_btn').removeAttr('disabled');
//       }
//   });
// });

// function set_calendar(month, year){
//   var property_id = $('#dtpc_property_id').val();
//   var dataURL = APP_URL+'/admin/ajax-calender/'+property_id;
//   var calendar = '';
//   $.ajax({
//     url: dataURL,
//     data: {'month': month, 'year': year},
//     type: 'post',
//     async: false,
//     dataType: 'json',
//     success: function (result) {
//       //if(result.success == 1)
//       $('#calender-dv').html(result.calendar);
//     },
//     error: function (request, error) {
//       console.log('error');
//     }
//   });
// }

function set_calendar(month, year) {
  var property_id = $('#dtpc_property_id').val();
  if ($("#addon_calendar_data").length == 0) {
    var dataURL = APP_URL + '/ajax-calender/' + property_id;
  } else {
    var dataURL = APP_URL + '/admin/admin-ajax-addon-calender/' + property_id;
  }

  var calendar = '';
  $.ajax({
    url: dataURL,
    data: { 'month': month, 'year': year },
    type: 'post',
    async: false,
    dataType: 'json',
    success: function (result) {
      //if(result.success == 1)
      $('#calender-dv').html(result.calendar);
    },
    error: function (request, error) {
      console.log(error);
    }
  });
}

var extraFields = 0;

$(document.body).on('click', '.date-package-modal', function () {
  extraFields = 0;
  var times = ($(this).attr('data-times')).split(',');
  var dtimes = ($(this).attr('data-dtimes')).split(',');
  let timepickercl = '';
  let timepickercld = '';
  if(times[0] !== ''){
    timepickercl = 'timepicker1';  
  }  

  if(dtimes[0] !== ''){
    timepickercld = 'timepicker1';  
  }
  
  $('#timeContainer').html('<div class="primary-field"><input type="text" class="form-control'+ timepickercl +'" name="times[]" id="t0" placeholder="" /><span class="cpointer btn_upcomming" onClick="addTimeField()" class="icon-click"> Add more</span></div>');
  $('#delivery_times_container').html('<div class="primary-field"><input type="text" class="form-control '+ timepickercld +'" name="delivery_times[]" id="dt0" placeholder="" /><span class="cpointer btn_upcomming" onClick="addDelTimeField()" class="icon-click"> Add more</span></div>');
  
  $('#t0').on('click', function () {
    $('#t0').addClass("timepicker1").wickedpicker({
      now: "12:00",
      minutesInterval: 30
    });
  })

  $('#dt0').on('click', function () {
    $('#dt0').addClass("timepicker1").wickedpicker({
      now: "12:00",
      minutesInterval: 30
    });
  })
    
  var myPicker1 = $('.timepicker1').wickedpicker({
    now: "12:00",
    minutesInterval: 30
  });
  var fl = $(this).hasClass('tile-previous');
  $('#model-message').html("");
  $('#model-time-message').html("");
  if (!fl) {
    var sdate = $(this).attr('id');
    var div = sdate.split('-');
    var day = div[2];
    var month = div[1];
    var year = div[0];
    var price = $(this).attr('data-price');
    var status = $(this).attr('data-status');

    // var times = ($(this).attr('data-times')).split(',');
    // var dtimes = ($(this).attr('data-dtimes')).split(',');

    if (times[0]) { $('#t0').val(times[0]); }
    if (dtimes[0]) { $('#dt0').val(dtimes[0]); }

    for (let i = 1; i < times.length; i++) {
      var timeFieldId = "t" + i;
      var timeDivId = "div_t" + i;
      var timeClass = "timepicker_" + timeFieldId;
      $('#timeContainer').append('<div id="' + timeDivId + '" class="mt-2p extra-field"><input type="text" class="form-control ' + timeClass + '" name="times[]" id="' + timeFieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + timeDivId + ')" class="icon-click remove-field"> Remove</span></div>')
      $('.' + timeClass).wickedpicker({
        now: "12:00",
        minutesInterval: 30
      });
      $('#t' + i).val(times[i]);
    }
    for (let i = 1; i < dtimes.length; i++) {      
      var timeFieldId = "dt" + i;
      var timeDivId = "div_dt" + i;
      $('#'+timeDivId).remove();
      var timeClass = "timepicker_" + timeFieldId;
      $('#delivery_times_container').append('<div id="' + timeDivId + '" class="mt-2p extra-field"><input type="text" class="form-control ' + timeClass + '" name="delivery_times[]" id="' + timeFieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + timeDivId + ')" class="icon-click remove-field"> Remove</span></div>')
      $('.' + timeClass).wickedpicker({
        now: "12:00",
        minutesInterval: 30
      });
      $('#t' + i).val(dtimes[i]);
    }
    //var date   = day+'-'+month+'-'+year;
    var date = month + '-' + day + '-' + year;
    $('#dtpc_start').val(date);
    $('#dtpc_time_start').val(date);
    $('#dtpc_end').val(date);
    $('#dtpc_time_end').val(date);
    $('#dtpc_price').val(price);
    $('#dtpc_status').val(status).change();
    $("#dtpc_start").datepicker({
      dateFormat: "mm-dd-yy",
      //dateFormat: "dd-mm-yy",
      onSelect: function (date) {

      },
    });
    $("#dtpc_time_start").datepicker({
      dateFormat: "mm-dd-yy",
      //dateFormat: "dd-mm-yy",
      onSelect: function (date) {

      },
    });
    $("#dtpc_end").datepicker({
      dateFormat: "mm-dd-yy",
      //dateFormat: "dd-mm-yy",
      onSelect: function (date) {

      },
    });
    $("#dtpc_time_end").datepicker({
      dateFormat: "mm-dd-yy",
      //dateFormat: "dd-mm-yy",
      onSelect: function (date) {

      },
    });
    $('#hotel_date_package').modal();
  }
});


function addTimeField() {
  console.log('ptbb');
  var fieldId = "e" + extraFields;
  var divId = "div_e" + extraFields;
  $('#timeContainer').append('<div id="' + divId + '" class="mt-2p extra-field"><input type="text" class="form-control timepicker" name="times[]" id="' + fieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + divId + ')" class="icon-click remove-field"> Remove</span></div>')
  $('.timepicker').wickedpicker({
    now: "12:00",
    minutesInterval: 30
  });
  extraFields++;
}

var delTimeFields = 1;
function addDelTimeField() {
  console.log('bb');
  var fieldId = "del_time_e" + delTimeFields;
  var divId = "div_del_time_e" + delTimeFields;
  $('#delivery_times_container').append('<div id="' + divId + '" class="mt-2p extra-field"><input type="text" class="form-control timepicker" name="delivery_times[]" id="' + fieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + divId + ')" class="icon-click remove-field"> Remove</span></div>')
  $('.timepicker').wickedpicker({
    now: "12:00",
    minutesInterval: 30
  });
  delTimeFields++;
}

var weekendDelTimeFields = 1;
function addWeekendDelTimeField() {
  var fieldId = "weekend_del_time_e" + weekendDelTimeFields;
  var divId = "div_weekend_del_time_e" + weekendDelTimeFields;
  $('#weekend_delivery_times_container').append('<div id="' + divId + '" class="mt-2p extra-field"><input type="text" class="form-control weekend_timepicker" name="weekend_delivery_times[]" id="' + fieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + divId + ')" class="icon-click remove-field"> Remove</span></div>')
  $('.weekend_timepicker').wickedpicker({
    now: "12:00",
    minutesInterval: 30
  });
  weekendDelTimeFields++;
}


var pickTimeFields = 1;
function addPickTimeField() {
  var fieldId = "pick_time_e" + pickTimeFields;
  var divId = "div_pick_time_e" + pickTimeFields;
  $('#pickup_times_container').append('<div id="' + divId + '" class="mt-2p extra-field"><input type="text" class="form-control pickup_timepicker" name="pickup_times[]" id="' + fieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + divId + ')" class="icon-click remove-field"> Remove</span></div>')
  $('.pickup_timepicker').wickedpicker({
    now: "12:00",
    minutesInterval: 30
  });
  pickTimeFields++;
}

var weekendPickTimeFields = 1;
function addWeekendPickTimeField() {
  var fieldId = "weekend_pick_time_e" + weekendPickTimeFields;
  var divId = "div_weekend_pick_time_e" + weekendPickTimeFields;
  $('#weekend_pickup_times_container').append('<div id="' + divId + '" class="mt-2p extra-field"><input type="text" class="form-control weekend_pickup_timepicker" name="weekend_pickup_times[]" id="' + fieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + divId + ')" class="icon-click remove-field"> Remove</span></div>')
  $('.weekend_pickup_timepicker').wickedpicker({
    now: "12:00",
    minutesInterval: 30
  });
  weekendPickTimeFields++;
}

var delZipFields = 1;
function addDelZipField() {
  var fieldId = "del_zip_e" + delZipFields;
  var divId = "div_del_zip_e" + delZipFields;
  $('#delivery_zipcodes_container').append('<div id="' + divId + '" class="mt-2p extra-field"><input type="text" class="form-control" name="delivery_zipcodes[]" id="' + fieldId + '" placeholder="" /><span class="cpointer btn_upcomming" onClick="removeTimeField(' + divId + ')" class="icon-click remove-field"> Remove</span></div>')
  delZipFields++;
}

function removeTimeField(id) {
  $(id).remove();
}

$(document.body).on('submit', "#dtpc_form", function (e) {
  e.preventDefault();
  $('#error-dtpc-start').html('');
  $('#error-dtpc-end').html('');
  $('#error-dtpc-price').html('');
  $('#error-dtpc-status').html('');
  page_loader_start();
  $('#cal_submit_btn').attr('disabled', true);
  $('#cal_submit_btn').text('Please wait..');
  var start_date = $('#dtpc_start').val();
  var end_date = $('#dtpc_end').val();
  var price = $('#dtpc_price').val();
  var status = $('#dtpc_status').val();
  var property_id = $('#dtpc_property_id').val();
  if ($("#addon_calendar_data").length == 0) {
    var url = APP_URL + '/ajax-calender-price/' + property_id;
  } else {
    var url = APP_URL + '/ajax-addon-calender-price/' + property_id;
  }
  if (start_date == '') { $('#error-dtpc-start').html('Start date not given.'); return false; } else { $('#error-dtpc-start').html(''); }
  if (end_date == '') { $('#error-dtpc-end').html('End date not given.'); return false; } else { $('#error-dtpc-end').html(''); }
  if (price == '') { $('#error-dtpc-price').html('Price not given.'); return false; } else { $('#error-dtpc-price').html(''); }
  if (status == '') { $('#error-dtpc-status').html('Status not selected.'); return false; } else { $('#error-dtpc-status').html(''); }

  if (price != '' && isNaN(price)) {
    $('#error-dtpc-price').val('Please enter a valid price.');
    $('#cal_submit_btn').removeAttr('disabled');
    $('#cal_submit_btn').text('Submit');
    return false;
  } else {
    $('#error-dtpc-price').html('');
  }

  var div = start_date.split('-');
  var day = div[1];
  var month = div[0];
  var year = div[2];
  var new_start_date = day + '-' + month + '-' + year;

  var div2 = end_date.split('-');
  var day2 = div2[1];
  var month2 = div2[0];
  var year2 = div2[2];
  var new_end_date = day2 + '-' + month2 + '-' + year2;

  $.ajax({
    type: "POST",
    url: url,
    data: { 'start_date': new_start_date, 'end_date': new_end_date, 'price': price, 'status': status },
    async: true,
    success: function (msg) {
      //if(msg.status){
      var year_month = $('#calendar_dropdown').val();
      year_month = year_month.split('-');
      var year = year_month[0];
      var month = year_month[1];
      set_calendar(month, year);
      $('#model-message').html("Price saved successfully");
      $('#model-message').show();
      $('#cal_submit_btn').removeAttr('disabled');
      $('#cal_submit_btn').text('Submit');
      page_loader_stop();
      //}
    },
    error: function (request, error) {
      console.log(error);
      $('#cal_submit_btn').removeAttr('disabled');
      $('#cal_submit_btn').text('Submit');
      page_loader_stop();
    }
  });
});

$(document.body).on('submit', "#dtpc_time_form", function (e) {
  e.preventDefault();
  $('#error-dtpc-time-start').html('');
  $('#error-dtpc-time-end').html('');
  $('#error-dtpc-time').html('');
  page_loader_start();
  $('#cal_time_submit_btn').attr('disabled', true);
  $('#cal_time_submit_btn').text('Please wait..');
  var start_date = $('#dtpc_time_start').val();
  var end_date = $('#dtpc_time_end').val();
  var times = [];
  var dtimes = [];
  $("input[name='times[]']").each(function () {
    times.push($(this).val());
  });
  $("input[name='delivery_times[]']").each(function () {
    dtimes.push($(this).val());
  });
  var property_id = $('#dtpc_time_property_id').val();
  if ($("#addon_time_calendar_data").length == 0) {
    var url = APP_URL + '/ajax-calender-time/' + property_id;
  } else {
    var url = APP_URL + '/admin/admin-ajax-addon-calender-time/' + property_id;
  }
  if (start_date == '') { $('#error-dtpc-time-start').html('Start date not given.'); return false; } else { $('#error-dtpc-time-start').html(''); }
  if (end_date == '') { $('#error-dtpc-time-end').html('End date not given.'); return false; } else { $('#error-dtpc-time-end').html(''); }
  // if (times == '' || times == []) { $('#error-dtpc-time').html('Time not given.'); return false; } else { $('#error-dtpc-time').html(''); }
  if (times == '') {times == []}
  if (dtimes == '') {dtimes == []}

  // if (time != '' && isNaN(price)) {
  //   $('#error-dtpc-price').val('Please enter a valid price.');
  //   $('#cal_submit_btn').removeAttr('disabled');
  //   $('#cal_submit_btn').text('Submit');
  //   return false;
  // } else {
  //   $('#error-dtpc-price').html('');
  // }

  var div = start_date.split('-');
  var day = div[1];
  var month = div[0];
  var year = div[2];
  var new_start_date = day + '-' + month + '-' + year;

  var div2 = end_date.split('-');
  var day2 = div2[1];
  var month2 = div2[0];
  var year2 = div2[2];
  var new_end_date = day2 + '-' + month2 + '-' + year2;

  $.ajax({
    type: "POST",
    url: url,
    data: { 'start_date': new_start_date, 'end_date': new_end_date, 'times': times, 'dtimes': dtimes },
    async: true,
    success: function (msg) {
      //if(msg.status){
      var year_month = $('#calendar_dropdown').val();
      year_month = year_month.split('-');
      var year = year_month[0];
      var month = year_month[1];
      set_calendar(month, year);
      $('#model-time-message').html("Time saved successfully");
      $('#model-time-message').show();
      $('#cal_time_submit_btn').removeAttr('disabled');
      $('#cal_time_submit_btn').text('Submit');
      page_loader_stop();
      //}
    },
    error: function (request, error) {
      console.log(error);
      $('#cal_time_submit_btn').removeAttr('disabled');
      $('#cal_time_submit_btn').text('Submit');
      page_loader_stop();
    }
  });
});

function select_year_data(elem) {
  var selected_val = $(elem).val();
  if (selected_val != '') {
    var split_vals = selected_val.split('-');
    var selected_year = split_vals[0];
    var selected_month = split_vals[1];
    set_calendar(selected_month, selected_year);
  }
}

$(document).on('click', '.month-nav-next', function (e) {
  e.preventDefault();
  var year = $(this).attr('data-year');
  var month = $(this).attr('data-month');
  set_calendar(month, year);
});

$(document).on('click', '.month-nav-previous', function (e) {
  e.preventDefault();
  var year = $(this).attr('data-year');
  var month = $(this).attr('data-month');
  set_calendar(month, year);
});

$(document).on('change', "#del_time_0", function (e) {
  let cck = $("#del_time_0").val();
   if(cck != ''){
       $('.icon-clear-delete').removeClass('hide');
   }else{
       $('.icon-clear-delete').addClass('hide');
   }
});

$(document).on('change', "#t0", function (e) {
  let cck = $("#t0").val();
   if(cck != ''){
       $('.t0').removeClass('hide');
   }else{
       $('.t0').addClass('hide');
   }
});

/*
 * Preloader
 */
$(window).load(function () {
	$('.preloader').fadeOut("slow");
});


