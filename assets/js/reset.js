$(document).ready(function(){
    //console.log('Reset Script is Live ...');


    $('#password-reset-form').on('submit',function(event){
            event.preventDefault();
            var data=$('#password-reset-form').serialize();
            $.ajax({
                type:'POST',
                url:'./API/FORGET.php',
                data:data,
                beforeSend:function(){
                    $('.loader').removeClass('hide');
                },
                success:function(response){
                    $('.loader').addClass('hide');
                   // console.log(response);
                    var msg= JSON.parse(response);
                    if(msg.Success!=null)
                    {
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

                    }else{
                        $('#alert-box-forget').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong> <i class="fas fa-exclamation-circle"></i> Warning!! </strong> `+msg.Error+`.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>`);
                    }
                }
            })
    });
    $('#resetPasswordForm').on('submit',function(event){
        event.preventDefault();
        var data=$('#resetPasswordForm').serialize();
      //  console.log(data);
      $.ajax({
        type:'POST',
        data:data,
        url:'./API/RESETPASSWORD.php',
        beforeSend:function(){
            $('.loader').removeClass('hide');
        },
        success:function(response){
            var msg=JSON.parse(response);
            $('.loader').addClass('hide');
           // console.log(msg);
            if(msg.Success!=null)
            {
                $('#alert-box-reset').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> <i class="fas fa-exclamation-circle"></i> Warning!! </strong> `+msg.Success+`.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>`);
            }else{
                console.log(msg.Error);
                $('#alert-box-reset').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
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