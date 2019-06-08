
$(document).ready(function () {



   

var count = 1;
var classeAula = "";


 $(document).on("click","#search", function () {
     
var polo = $('#category').val();
var data = $('#dataAppello').val();

$('table.aule').html('<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Nome</th>'+
                 '<th scope="col">Polo</th><th scope="col">Locazione</th><th scope="col">Prenotazione</th></tr></thead>'+
                 '<tbody></tbody>');
                 var wrapper = $('table.aule>tbody');                 

      $.ajax({
      type: "post",
      url: "data.php",
      data: {Aule:"0", Polo:polo, DataAppello:data},
      dataType: "json",
      success: function (data) {
         
          $.each(data, function (index) { 
            if(data[index].prenotata == 1){ classeAula = "disabled"}else {classeAula =""}
            $(wrapper).append('<tr><th scope="row">'+count+'</th><td class="nome">'+data[index].nome+'</td>'+
            '<td class="Polo">'+data[index].polo+'</td><td class="locazione">'+data[index].locazione+'</td>'+
            '<td class="prenotazione"><button id="'+data[index].cod+'" type="button" class="btn btn-outline-success"  '+classeAula+'>Prenota</button></td></tr>');
            count++;
          });
       
      }
      
    });

 });

 $.ajax({
     type: "post",
     url: "data.php",
     data: {Polo:"0"},
     dataType: "json",
     success: function (data) {
         
        $.each(data, function (index) { 
          
            $("#category").append('<option>'+data[index].polo+'</option>');
    
          });
     }
 });

 

   
    $(wrapper).on("click",".btn", function () {
        var object = $(this);
        var aula = object.closest("td.nome").val();
        var polo = object.closest("td.Polo").val();
        $.ajax({
            type: "post",
            url: "insert.php",
            data: {Polo:polo,Aula:aula,Utente:utente},
            success: function (data) {
                var dataParsed = JSON.parse(data);
                alert(dataParsed);
                if(dataParsed == "Aula prenotata!"){
                    $(object).attr("disabled","true");
                    return;
                }
            }
        });
    });


    $('#datetimepicker2').datetimepicker({
        icons: {
            time: 'fas fa-clock',
            date: 'fas fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check-o',
            clear: 'fas fa-trash',
            close: 'fas fa-times'
        },
        locale:"it",
        format: "D-M-YYYY H:mm:ss "
    });
   
    
    });
    