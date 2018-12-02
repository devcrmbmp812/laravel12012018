jQuery(document).ready(function(){


  var school_id = jQuery('#school_id').val();
  var user_type = jQuery('#user_type').val();

  if (school_id != "" && user_type != "teacher") {
    jQuery.get('/teachers/list/' + school_id, function(data) {
      console.log(data);
      jQuery.each(data, function(index,subCatObj){
        console.log("got-"+subCatObj);
        jQuery('#teacher_id').append('<option value=\"'+subCatObj.id+'\">'+subCatObj.name+'</option>');
      });
    });
   }
   if (school_id != "" && user_type == "teacher") {
/*
    var role_id = jQuery('#role_id').val();

    var ajaxUrl = "/classrooms/parents/"+school_id;
    if (role_id === "5") {
      ajaxUrl = "/classrooms/parents/"+school_id;
    }

    jQuery.get(ajaxUrl, function(data) {
      console.log(data);
      jQuery('#classroom_id').empty();
      jQuery('#classroom_id').append('<option value=\"0\">None Assigned</option>');
      jQuery.each(data, function(index2,subCatObj2){
        console.log("got4-"+subCatObj2);
        jQuery('#classroom_id').append('<option value=\"'+subCatObj2.id+'\">'+subCatObj2.name+'</option>');
      });
    });
*/
   }

	/*
    var role_check = jQuery('#role_id').val();

    var ajaxUrl = "/classrooms/byschool/"+school_id;
    if (role_check === "5") {
      ajaxUrl = "/classrooms/parents/"+school_id;
    }

    jQuery.get(ajaxUrl, function(data) {
      console.log(data);
      jQuery('#classroom_id').empty();
      jQuery('#classroom_id').append('<option value=\"0\">None Assigned</option>');
      jQuery.each(data, function(index2,subCatObj2){
        console.log("got4-"+subCatObj2);
        jQuery('#classroom_id').append('<option value=\"'+subCatObj2.id+'\">'+subCatObj2.name+'</option>');
      });
    });
	*/


  jQuery('#school_id').on('change', function(e){
    console.log("select box checked");
    console.log(e);
    var school_id = e.target.value;

    jQuery.get('/teachers/list/' + school_id, function(data) {
      console.log(data);
      jQuery('#teacher_id').empty();
      jQuery('#teacher_id').append('<option value=\"0\">Select</option>');
      jQuery.each(data, function(index,subCatObj){
        console.log("got-"+subCatObj);
        jQuery('#teacher_id').append('<option value=\"'+subCatObj.id+'\">'+subCatObj.name+'</option>');
      });
    });

  /* Check and see what role type, then base URL off of that */


    var role_id = jQuery('#role_id').val();

    var teacher_id = jQuery('#teacher_id').val();
    var ajaxUrl = "/classrooms/byschool/"+school_id;
    if (role_id === "5") {
      ajaxUrl = "/classrooms/parents/"+school_id;
    }

    jQuery.get(ajaxUrl, function(data) {
      console.log(data);
      jQuery('#classroom_id').empty();
      jQuery('#classroom_id').append('<option value=\"0\">None Assigned</option>');
      jQuery.each(data, function(index2,subCatObj2){
        console.log("got4-"+subCatObj2);
        jQuery('#classroom_id').append('<option value=\"'+subCatObj2.id+'\">'+subCatObj2.name+'</option>');
      });
    });
  });

  jQuery('#teacher_id').on('change', function(e){
    console.log("select box checked");
    console.log(e);
    var teacher_id = e.target.value;
    jQuery.get('/classrooms/list/'+teacher_id, function(data) {
      console.log(data);
      jQuery('#classroom_id').empty();
      jQuery.each(data, function(index2,subCatObj2){
        console.log("got4-"+subCatObj2);
        jQuery('#classroom_id').append('<option value=\"'+subCatObj2.id+'\">'+subCatObj2.name+'</option>');
      });
    });
  });

  jQuery('#role_id').on('change', function(e){
  console.log("select box checked");
  console.log(e);
  var role_id = e.target.value;

  //alert("RoleID:"+role_id);
  if (role_id === "1" || role_id === "2" || role_id === "4") {
  jQuery('#school_card').hide();
  jQuery('#teacher_card').hide();
  jQuery('#parent_card').hide();
  }
  if (role_id === "3") {
  jQuery('#school_card').show();
  jQuery('#teacher_card').show();
  jQuery('#parent_card').hide();
  }       
  if (role_id === "5") {
  jQuery('#school_card').show();
  jQuery('#parent_card').show();
  jQuery('#teacher_card').hide();
  }

  console.log("select box checked");
  console.log(e);
  var school_id = jQuery('#school_id').val();

  if (school_id != "") {
	alert('school id blank2');
    jQuery.get('/teachers/list/' + school_id, function(data) {
      console.log(data);
      jQuery('#teacher_id').empty();
      jQuery('#teacher_id').append('<option value=\"0\">Select</option>');
      jQuery.each(data, function(index,subCatObj){
        console.log("got-"+subCatObj);
        jQuery('#teacher_id').append('<option value=\"'+subCatObj.id+'\">'+subCatObj.name+'</option>');
      });
    });

      /* Check and see what role type, then base URL off of that */

      var school_id = jQuery('#school_id').val();
      var role_id = jQuery('#role_id').val();
      var ajaxUrl = "/classrooms/byschool/"+school_id;
      if (role_id === "5") {
      ajaxUrl = "/classrooms/parents/"+school_id;
      }

      jQuery.get(ajaxUrl, function(data) {
        console.log(data);
        jQuery('#classroom_id').empty();
        jQuery('#classroom_id').append('<option value=\"0\">None Assigned</option>');
        jQuery.each(data, function(index2,subCatObj2){
          console.log("got4-"+subCatObj2);
          jQuery('#classroom_id').append('<option value=\"'+subCatObj2.id+'\">'+subCatObj2.name+'</option>');
        });
      });
  }
});
});
