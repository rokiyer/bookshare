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


function shareBook(url){
  $("#submit").click(function(event){
    event.preventDefault(); 
    var book_id = $("#book_id").attr('book_id');
    var description = $("#description").val();
    var data = {
      'book_id' : book_id ,
      'description' : description 
    };
    var succ_msg = "Your book have been shared";
    var another_one = $("#another_one").html();

    $.ajax({
      type: 'post',
      url: url ,
      dataType : 'json' ,
      data: data ,
      success: function(data){
        if(data.result == 0){
          $("#msg-box").addClass("alert-error");
          $("#msg-box").removeClass("alert-success");
          $("#msg-box").text(data.msg);
          $("#msg-box").show();
        }else if(data.result == 1){
          $("#msg-box").removeClass("alert-error");
          $("#msg-box").addClass("alert-success");
          $("#msg-box").text(succ_msg);
          $("#msg-box").append(another_one);
          $("#msg-box").show();
        }else{
          $("#msg-box").text('connect error');
          $("#msg-box").show();
        }
      }, // end of handling succ
      error:function(e){
        $("#msg-box").text('connect error');
        console.log(e);
      }
    }); //end of ajax

  }); //end of click action
}



function updateProfile(url ){
  $("#submit").click(function(event){
    event.preventDefault(); 
    var username = $("#username").val();
    var cellphone = $("#cellphone").val();
    var email = $("#email").val();
    var data = {
      'username' : username ,
      'cellphone' : cellphone ,
      'email' : email 
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
          $("#msg-box").text("Profile changed success!");
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


function updateItemDescription(url){
  $("#submit").click(function(event){
    event.preventDefault(); 
    var item_id = $("#item_id").attr("item_id");
    var description = $("#description").val();
    var data = {
      'item_id' : item_id ,
      'description' : description
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
          $("#msg-box").text("description changed success!");
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


function updateItemStatus(url){
  $(".item_status").click(function(event){
    var item_id = $(this).attr("item_id");
    var status = 0;
    if($(this).hasClass("share")){
      status = 1;
    }else if($(this).hasClass("unshare")){
      status = 2;
    }else{
      status = 3;
    }
    
    var data = {
      'item_id' : item_id ,
      'status' : status
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
          if(status == 1)
            $("#msg-box").text("Share book success!");
          else if(status == 2)
            $("#msg-box").text("Unshare book success!");
          else if(status == 3)
            $("#msg-box").text("Delete book success!");
          else
            $("#msg-box").text("Operation unknown");

          $("#msg-box").show();
          setTimeout("self.location.reload();",1000);
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

function requestBorrow(url){
  $("#request").click(function(event){
    var item_id = $("#item_id").attr("item_id");
    
    var data = {
      'item_id' : item_id
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
          $("#msg-box").text("Request has been sent to onwer .");
          $("#msg-box").show();
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


function updateTrade(url){
  $(".trade_op").click(function(event){
    var trade_id = $(this).attr("trade_id");
    var trade_op = $(this).attr("trade_op");
    
    var data = {
      'trade_id' : trade_id ,
      'trade_op' : trade_op
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
          if(trade_op == 'accept')
            $("#msg-box").text("Accept request success!");
          else if(trade_op == 'deny')
            $("#msg-box").text("Deny request success!");
          else if(trade_op == 'cancel')
            $("#msg-box").text("Cancel request success!");
          else if(trade_op == 'return')
            $("#msg-box").text("Confirm the book is returned!");
          else
            $("#msg-box").text("Operation unknown");

          $("#msg-box").show();
          setTimeout("self.location.reload();",1000);
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