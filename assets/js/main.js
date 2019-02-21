
$(document).ready(function(){
    //console.log('hello');

   $('.timepicker').pickatime();
  $('.datepicker').pickadate();


    $('#login-form').submit(function(event){
        event.preventDefault();
        //console.log('form login start here');
        var loginData= $('#login-form').serialize();
        console.log(loginData);
        var email=$('#email').val();
       // alert(email);
        $.ajax({
            type:'POST',
            url:'./API/LOGIN.php',
            data:loginData,
            beforeSend:function(){

            },
            success:function(response){
                var msg=JSON.parse(response);
                //console.log(msg);
                if(msg.Success !=null){
                    console.log(msg.Success);
                    $('.loader').addClass('hide');
                    //redirect user to dash board
                    const toast = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                      });
                      
                      toast({
                        type: 'success',
                        title: msg.Success
                      });
                      setTimeout(function(){
                        localStorage.setItem('email',email);
                          //set local storage variable email for current Email
                        window.location.replace("./");
                      },1000);
            }
            else{
                $('.loader').addClass('hide');
                console.log(msg.Error);
                $('#alert-box-login').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> <i class="fas fa-exclamation-circle"></i> Warning!! </strong> `+msg.Error+`.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>`);
            }
            }
        });
    });
    $('#register-form').submit(function(event){
        event.preventDefault();
        var registerData=$('#register-form').serialize();
        console.log(registerData);
        $.ajax({
            type:'POST',
            url:'./API/REGISTER.php',
            data:registerData,
            beforeSend:function(){
                $('.loader').removeClass('hide');
            },
            success:function(response){
                var msg=JSON.parse(response);
                //console.log(msg);
                if(msg.Success !=null){
                    console.log(msg.Success);
                    $('.loader').addClass('hide');
                    console.log(msg.Error);
                    $('#alert-box').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> <i class="fas fa-check"></i> Success!! </strong> `+msg.Success+`.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>`);   
            }
            else{
                $('.loader').addClass('hide');
                console.log(msg.Error);
                $('#alert-box').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> <i class="fas fa-exclamation-circle"></i> Warning!! </strong> `+msg.Error+`.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>`);
            }

            }
        });
    });

    
});
