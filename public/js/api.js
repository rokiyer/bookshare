  
// $(document).ready(function(){

//   $("#submit").click(function(event){
//     event.preventDefault(); 
//     var url = "<?php echo site_url('api/userLogin');?>";
//     var cellphone = $("#cellphone").val();
//     var password = $("#password").val();
//     var data = {
//       'cellphone' : cellphone ,
//       'password' : password 
//     };

//     $.ajax({
//       type: 'post',
//       url: url ,
//       dataType : 'json' ,
//       data: data ,
//       success: function(data){
//         if(data.result == 0){
//           $("#msg-box").text(data.msg);
//           $("#msg-box").show();
//         }else if(data.result == 1){
//           $("#msg-box").removeClass("alert-error");
//           $("#msg-box").addClass("alert-success");
//           $("#msg-box").text(data.msg);
//           $("#msg-box").show();
//         }else{
//           $("#msg-box").text('connect error');
//           $("#msg-box").show();
//         }
//       }, // end of handling succ
//       error:function(e){
//         alert("connect error");
//         console.log(e);
//       }
//     }); //end of ajax

//   }); //end of click action

// });


function userLogin(url , target_url){
  $("#submit").click(function(event){
    event.preventDefault(); 
    var cellphone = $("#cellphone").val();
    var password = $("#password").val();
    var data = {
      'cellphone' : cellphone ,
      'password' : password 
    };

    $.ajax({
      type: 'post',
      url: url ,
      dataType : 'json' ,
      data: data ,
      success: function(data){
        if(data.result == 0){
          $("#msg-box").text(data.msg);
          $("#msg-box").show();
        }else if(data.result == 1){
          $("#msg-box").removeClass("alert-error");
          $("#msg-box").addClass("alert-success");
          $("#msg-box").text(data.msg);
          $("#msg-box").show();
          window.location.href=target_url;
        }else{
          $("#msg-box").text('connect error');
          $("#msg-box").show();
        }
      }, // end of handling succ
      error:function(e){
        alert("connect error");
        console.log(e);
      }
    }); //end of ajax

  }); //end of click action
}



function userRegister(url , target_url){
  $("#submit").click(function(event){
    event.preventDefault(); 
    var cellphone = $("#cellphone").val();
    var password = $("#password").val();
    var confirm = $("#confirm").val();
    var data = {
      'cellphone' : cellphone ,
      'password' : password ,
      'confirm' : confirm
    };

    $.ajax({
      type: 'post',
      url: url ,
      dataType : 'json' ,
      data: data ,
      success: function(data){
        if(data.result == 0){
          $("#msg-box").text(data.msg);
          $("#msg-box").show();
        }else if(data.result == 1){
          $("#msg-box").removeClass("alert-error");
          $("#msg-box").addClass("alert-success");
          $("#msg-box").text(data.msg);
          $("#msg-box").show();
          window.location.href=target_url;
        }else{
          $("#msg-box").text('connect error');
          $("#msg-box").show();
        }
      }, // end of handling succ
      error:function(e){
        alert("connect error");
        console.log(e);
      }
    }); //end of ajax

  }); //end of click action
}