  function fetchNotes(){
  var email="email="+localStorage.getItem('email');
  $.ajax({
    type:'POST',
    data:email,
    url:'./API/NotesKeeper.php',
    beforeSuccess:function(){
    },
    success:function(response)
    {
      var display=JSON.parse(response);
      //console.log(display);
      if(display.Error !=null)
      {
        console.log(display.Error);

        $('#notes-error').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong> <i class="fas fa-exclamation-circle"></i> Warning!! </strong> `+display.Error+`.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>`);

        

      }else{
        console.log(display.records);
        var i=0;
        for(i=0;i<display.records.length ; i++)
        {
          var sr=i+1;
          var sym=null;
          if(display.records[i].alertStatus == 'true')
          {
            sym="fa-bell";
          }else{
            sym="fa-bell-slash"
          }
          $('#note-keeper-container').append(`
          <div class="col-md-4">
          <div class="card">
              <div class="card-header">
                  # `+sr+`
                  <span class="float-right">
                    <a href="?view=singleNotesEdit" class='btn btn-outline-prim btn-sm'><i class="fa fa-edit"></i> </a>
                    <a  onClick="deletenotes('`+display.records[i].id+`')" class='btn btn-danger btn-sm text-white'><i class="fa fa-trash"></i> </a>                    
                    </span>
              </div>
              <div class="card-body">
                `+display.records[i].notes+`
              </div>
              <div class="card-footer text-info">
                  <i class="fas fa-clock"></i> `+display.records[i].postedOn+`
                  <span class="float-right">
                    Notification   <i class="fas `+sym+`"></i>
                  </span>
               </div>
          </div>
      </div>
          `);
        }
      }
    }
  });
}
function deletenotes(id ){
  var email = localStorage.getItem('email');
  var deleteData="email="+email+"&notes="+id;
  $.ajax({
    type:'POST',
    url:'./API/DELETENOTES.php',
    data:deleteData,
    beforeSuccess:function(){

    },
    success:function(response){
      console.log(response);

      var msg=JSON.parse(response);
        if(msg.Success !=null)
        {
          const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000
          });
          
          toast({
            type: 'success',
            title: msg.Success
          });
          setTimeout(function(){
            //localStorage.setItem('email',)
              //set local storage variable email for current Email
            window.location.replace("?view=account");
          },2000);
        }else{
          const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
          });
          
          toast({
            type: 'error',
            title: msg.Error
          });

        }
     
    }
  })
}

$(document).ready(function(){

    console.log('Start Posting Notes by hackdroidbykhan');
    
    $('#notes-form').submit(function(event){
        event.preventDefault();
        var notesData=$('#notes-form').serialize();
        console.log(notesData);

        $.ajax({
                type:'POST',
                data:notesData,
                url:'./API/NOTESPOSTING.php'
                ,beforeSuccess:function(){

                }
                ,success:function(response){
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
                            //localStorage.setItem('email',)
                              //set local storage variable email for current Email
                            window.location.replace("index.php?view=account");
                          },1000);
                }
                else{
                    $('.loader').addClass('hide');
                    console.log(msg.Error);
                    const toast = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                      });
                      
                      toast({
                        type: 'error',
                        title: msg.Error
                      });
                }
                }
        });
    });

   $(window).on('load',function(){
   fetchNotes();
   });
});

