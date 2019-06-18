
$(document).ready(function () {


   
    var wrapper = $('#table1 tbody');
    var wrapper2 = $('#table2 tbody');
    var count = 1;
    var count2 = 1;
   // var classeUtente = "";
    
        $.ajax({
          type: "post",
          url: "data.php",
          data: {Utenti: "0",Bugs: "0"},
          dataType: "json",
          success: function (data) {
           
              $.each(data[0], function (index) { 

                $(wrapper).append('<tr id="'+data[0][index].cod+'"><th scope="row">'+count+'</th><td class="username">'+data[0][index].username+'</td>'+
                '<td class="userEmail">'+data[0][index].email+'</td><td class="livelloAttuale">'+data[0][index].livello+'</td>'+
                '<td class="livello"><select class="form-control"><option value="0">0</option><option value="1">1</option><option value="2">2</option>'+
                '<option value="3">3</option></select>&ensp;<button type="button"  class="btn btn-outline-primary">Salva</button></td>'+
                '<td class="eliminaUtente"><button  type="button" class="btn btn-outline-danger">Elimina</button></td></tr>');
                count++;
              });

              $.each(data[1], function (index) { 
              
                            $(wrapper2).append('<tr accesskey="'+data[1][index].cod+'"  data-toggle="modal" data-target="#modal'+data[1][index].cod+'"><th scope="row">'+count2+'</th><td class="Titolo">'+data[1][index].titolo+'</td>'+
                            '<td class="data">'+data[1][index].data+'</td><td class="username">'+data[1][index].utente+'</td>'+
                            '<td class="eliminaBug"><button id="'+data[1][index].cod+'" type="button" class="btn btn-outline-danger">Elimina</button></td></tr>');

                            $(wrapper2).append('<div class="modal fade"  id="modal'+data[1][index].cod+'" tabindex="-1" role="dialog" aria-labelledby="titoloModal'+data[1][index].cod+'" aria-hidden="true">'+
                            '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">'+
                            '<h5 class="modal-title" id="titoloModal'+data[1][index].cod+'">'+data[1][index].titolo+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+data[1][index].descrizione+'</div>'+
                            '<div class="modal-footer"></div></div></div></div>' ); 
              
                            count2++;
                          });
           
          }
          
        });
    
       
        $(wrapper).on("click",".eliminaUtente .btn", function () {
            var confirmation = confirm("Sei sicuro di voler procedere all'eliminazione dell'utente selezionato?");
            
            if(confirmation == false || confirmation == null) return;

            var object = $(this);
            var cod = $(this).closest("tr").attr('id');
            $.ajax({
                type: "post",
                url: "delete.php",
                data: {Elimina_user : cod},
                success: function (data) {
                    var dataParsed = JSON.parse(data);
                    

                    if(dataParsed == "Eliminazione effettuata!"){
                        $(object).closest("tr").remove();
                        
                        alert(dataParsed);
                    }
                }
            });
        });
    
        $(wrapper2).on("click",".eliminaBug .btn",function(e){
          
          e.stopPropagation();

     
          var confirmation = confirm("Sei sicuro di voler procedere all'eliminazione del report selezionato?");
            
          if(confirmation == false || confirmation == null) return;

          var object = $(this);
          var cod = $(this).attr('id');

          $.ajax({
            type: "post",
            url: "delete.php",
            data: {Elimina_report : cod},
            success: function (data) {
                var dataParsed = JSON.parse(data);
                

                if(dataParsed == "Eliminazione effettuata!"){
                    $(object).closest("tr").remove();
                    
                    alert(dataParsed);
                }
            }
        });

        });

          
        $(wrapper).on("click",".livello .btn", function () {
          

          var object = $(this);
          var livello = $(this).parent().find("option:selected").val();

          var utente = $(this).closest("tr").find(".username").html();

         
          
          $.ajax({
              type: "post",
              url: "update.php",
              data: {Username : utente, Livello:livello},
              success: function (data) {
                  var dataParsed = JSON.parse(data);
                  

                  if(dataParsed == "Utente promosso!"){
                    $(object).closest("tr").find(".livelloAttuale").html(livello);
                      
                      alert(dataParsed);
                  }
              }
          });
      });
    
       
        
        });
        