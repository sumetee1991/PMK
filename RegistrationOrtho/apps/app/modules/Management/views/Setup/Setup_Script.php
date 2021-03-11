<script type = "text/javascript">
	$(document).ready(function () {
		var RequestData ;
      var location;
      var uid;

      $('#location2Div').removeClass('div_hidden');
      $('#location1Div').addClass('div_hidden');

      $(document).on("click", '[data-link]', function (e) {

        $('[data-tabcounter]').attr('xxxxx');

        var targetlink = $(this).data('link');

         // alert(targetlink);

         location=$(this).attr('location');
         uid=$(this).attr('uid');

         // alert(location);
         // alert(uid);
        RequestData = base_path_url + 'getSetupData_JSON'+'/'+2+'/'+uid;


         if(targetlink=='location1'){
          // targetlink='AltDashboard';
          // $('#filterDiv').addClass('div_hidden');
          $('#location1Div').removeClass('div_hidden');
          $('#location2Div').addClass('div_hidden');

       }else if(targetlink=='location2'){
         // targetlink='AltDashboardlocation2';
         // $('#filterDiv').addClass('div_hidden');
         $('#location1Div').addClass('div_hidden');
         $('#location2Div').removeClass('div_hidden');
         // $('#counterDiv').addClass('div_hidden');


      }

     //  else if(targetlink == 'Cus') {

     //     targetlink='Filter/0';
     //     // link(targetlink);

     //     $('#filterDiv').addClass('div_hidden');
     //     $('#counterDiv').addClass('div_hidden');



     //  }else if(targetlink == 'Filter') {

     //     targetlink='AltDashboard';
     //     // link(targetlink);

     //     $('#filterDiv').addClass('div_hidden');
     //     $('#counterDiv').addClass('div_hidden');
     //  }else if(targetlink == 'Dashboard') {

     //     targetlink='Dashboard';
     //     // link(targetlink);
     //     $('#filterDiv').addClass('div_hidden');
     //     $('#counterDiv').addClass('div_hidden');

     //  }else if(targetlink == 'Dashboardlocation2') {

     //     targetlink='Dashboardlocation2';
     //     // link(targetlink);
     //     $('#filterDiv').addClass('div_hidden');
     //     $('#counterDiv').addClass('div_hidden');




     //  }else if(targetlink == 'AltDashboardlocation2') {

     //     targetlink='AltDashboardlocation2';
     //     // link(targetlink);
     //     $('#filterDiv').addClass('div_hidden');
     //     $('#counterDiv').addClass('div_hidden');



     //  }else if(targetlink == 'AltDashboard'){
     //     targetlink='AltDashboard';
     //     // link(targetlink);
     //     $('#filterDiv').addClass('div_hidden');
     //     $('#counterDiv').removeClass('div_hidden');


     //  }else if(targetlink=='Filterlocation2'){

     //   targetlink='AltDashboardlocation2';
     //    // link(targetlink);
     //    $('#filterDiv').addClass('div_hidden');
     //    $('#counterDiv').removeClass('div_hidden');
     // }

     $('[data-link], .active').removeClass('active');
     $(this).addClass('active');

     var queuelocation = $(this).attr('location');
     localStorage.setItem('queuelocation',queuelocation);


    // alert(localStorage.getItem('queuelocation'));
     // } else {
  //      if (!($('#counterDiv').hasClass('div_hidden'))) {
  //       $('#counterDiv').addClass('div_hidden');
  //    }
  //    if (($('#filterDiv').hasClass('div_hidden'))) {
  //       $('#filterDiv').removeClass('div_hidden');
  //    }
  // }
//   if (targetlink == 'location1') {
//    $('#filterDiv').addClass('div_hidden');
// }

$(document).on("click", '[data-link-station]', function (e) {
 location=$(this).attr('location');
 var uid=$(this).attr('uid');
 var link=$(this).data('link-station');
 // alert(uid);

 if(link == 'Cus') {
   link='Filter/0';

   localStorage.setItem('station',uid);

}else if(link=='Filter'){

  link='AltDashboard';

  localStorage.setItem('station',uid);

}else if(link=='Dashboard'){
   link='Dashboard';

   localStorage.setItem('station',uid);

}else if(link=="Filterlocation2"){
  link='AltDashboardlocation2';

  localStorage.setItem('station',uid);

}else if('Dashboardlocation2'){
  link='Dashboardlocation2';

  localStorage.setItem('station',uid);
}


RequestData = base_path_url + 'getSetupData_JSON'+'/'+location+'/'+uid;
$.ajax({
  type  : 'ajax',
  url   : RequestData,
  dataType : 'json',
  success : function(data){
// console.log(data['Counter']);
var ButtonColumn='';
for(var i=0;i<data['Counter'].length;i++){


   ButtonColumn += '<div class="colBtn">';
   ButtonColumn += '    <a class="button medium block c_lightblue"  cl data-tabcounter="' + data['Counter'][i]['counterno'] + '" data-tabaction="tabcounter" href="'+link+'">' + data['Counter'][i]['countername'] + '</a>';
   ButtonColumn += '</div>';

               // alert(data['Counter'][i]['countername']);
            }

            $('#counterRow').html(ButtonColumn);






         }
      }
      );

});





// function link(link){


//    $.ajax({
//      type  : 'ajax',
//      url   : RequestData,
//      dataType : 'json',
//      success : function(data){

// // alert(data['Counter'].length);
// console.log(data['Counter']);
// var ButtonColumn='';
// for(var i=0;i<data['Counter'].length;i++){


//    ButtonColumn += '<div class="colBtn">';
//    ButtonColumn += '    <a class="button medium block c_lightblue"  cl data-tabcounter="' + data['Counter'][i]['counterno'] + '" data-tabaction="tabcounter" href="'+link+'">' + data['Counter'][i]['countername'] + '</a>';
//    ButtonColumn += '</div>';

//                // alert(data['Counter'][i]['countername']);
//             }

//             $('#counterRow').html(ButtonColumn);






//          }
//       }
//       );
// }
// alert(targetlink);


// $(['data-tabcounter']).click(function(){
// alert('dddd');
// });

// localStorage.setItem('Counter',);



     //    if (targetlink != 'Filter') {
     //      if (!($('#filterDiv').hasClass('div_hidden'))) {
     //       $('#filterDiv').addClass('div_hidden');
     //    }
     $('#counterDiv').removeClass('div_hidden');
     // var link=$('[data-tabcounter]').prop('href', './' + targetlink);




     setupActiveTab();
  });

$(document).on("click", '[data-tabcounter]', function (e) {
   var tabcounter =$(this).data('tabcounter');

   localStorage.setItem('Counter',tabcounter);

});

$.getJSON(RequestData, function (data) {
   var ButtonColumn = '';
   data['Counter'].forEach(function (Value, Index) {
    var CounterData = {
     'ID': Value['counterno'],
     'Name': Value['countername'],
  };
  ButtonColumn += '<div class="colBtn">';
  ButtonColumn += '    <a class="button medium block c_lightblue" data-tabcounter="' + CounterData['ID'] + '" data-tabaction="tabcounter" href="">' + CounterData['Name'] + '</a>';
  ButtonColumn += '</div>';
});
   $('#counterRow').html(ButtonColumn).promise().done(function () {
    if (localStorage.getItem('SetupLink')) {
     var localSetup = localStorage.getItem('SetupLink');

     $('[data-link="' + localSetup + '"]').click();
  } else {
     $('[data-link="Filter"]').click();
  }
});
});

$(document).on("click", dataAttribute['Full']['TabAction'], function (e) {
   var targetActionAttr = $(this).data(dataAttribute['Name']['TabAction']);
   if (targetActionAttr == dataAttribute['Name']['Counter']) {
    $('[data-' + targetActionAttr + ']').removeClass('active');
 }
 $(this).toggleClass('active');

 saveLocalTabVar(targetActionAttr);
 Object.keys(localTab).forEach(function (key) {
    localStorage.setItem(key, localTab[key]);
 });
});

$(document).on("click", '[data-sidenav]', function () {
   var target = $(this).data('sidenav');
   $(this).toggleClass('active');
   $(target).hasClass('active') ? $(target).removeClass('active') : $(target).addClass('active');
});

$(document).on("click", dataAttribute['Full']['Setup'], function (e) {
   var setupAction = $(this).data(dataAttribute['Name']['Setup']);
   switch (setupAction.toLowerCase()) {
    case 'save':
    Object.keys(localTab).forEach(function (key) {
      localStorage.setItem(key, localTab[key]);
   });
    window.close();
    break;
    case 'clear':
    setupActiveTab();
    break;
 }
});


}); 
</script>