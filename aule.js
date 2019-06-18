
$(document).ready(function () {


var count = 1;
var classeAula = "";
var wrapper = $('table.aule>tbody');


if(livello == 1){
    $("table.searchTable").css('display', 'none');
    $("div.buttonSearch").css('display', 'none');
    $("body").append('<hr><div class="aggiungiAula" align="center">'+
    '<br><input id="nomeAula" class="form-control" type="text" placeholder="Aula"> - <input id="poloAula" class="form-control" type="text" placeholder="Polo"> - <input id="locazioneAula" type="text" class="form-control" placeholder="Locazione">'+
    '<br><br><button type="button" id="buttonAggiungiAula" class="btn btn-outline-success">'+
    '<span class="fas fa-arrow-up"></span>&ensp;Aggiungi!&ensp;<span class="fas fa-arrow-up"></span></button></div>');

    getAule();
}else{

    $("table.aule").css('display', 'none');
}
function getAule() {
    
    $.ajax({
        type: "post",
        url: "data.php",
        data: {Aule:"1"},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index) { 
                 
                $(wrapper).append('<tr><th scope="row">'+count+'</th><td class="nome">'+data[index].nome+'</td>'+
                '<td class="Polo">'+data[index].polo+'</td><td class="locazione">'+data[index].locazione+'</td>'+
                '</tr>');
                count++;
            });
        }
    });
}


$(document).on("click","#buttonAggiungiAula", function(){

    var nome = $('#nomeAula').val();
    var polo = $('#poloAula').val();
    var locazione = $('#locazioneAula').val();

    
$.ajax({
    type: "post",
    url: "insert.php",
    data: {Nome:nome,Polo:polo,Locazione:locazione},
    success: function (data) {
        var dataParsed = JSON.parse(data);

        if(dataParsed == "L'aula è stata aggiunta al database!"){

            $('table.aule>tbody').append('<tr><th scope="col">'+count+'</th><th scope="col">'+nome+'</th><th scope="col">'+polo+'</th><th scope="col">'+locazione+'</th></tr>');
        }

        alert(dataParsed);
    }
});


});

 $(document).on("click","#search", function () {
     
var polo = $('#polo').val();
 data = $('#dataAppello').val();
 durata = $('select#durata :selected').attr('value');

$('table.prenotazioni').html('<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Nome</th>'+
                 '<th scope="col">Polo</th><th scope="col">Locazione</th><th scope="col">Prenotazione</th></tr></thead>'+
                 '<tbody></tbody>');
                 

      $.ajax({
      type: "post",
      url: "data.php",
      data: {Aule:"0", Polo:polo, DataAppello:data, Durata:durata},
      dataType: "json",
      success: function (data) {
         
          $.each(data, function (index) { 
         
            $('table.prenotazioni>tbody').append('<tr><th scope="row">'+count+'</th><td class="nome">'+data[index].nome+'</td>'+
            '<td class="Polo">'+data[index].polo+'</td><td class="locazione">'+data[index].locazione+'</td>'+
            '<td class="prenotazione"><button id="'+data[index].cod+'" type="button" class="btn btn-outline-success">Prenota</button></td></tr>');
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
          
            $("#polo").append('<option>'+data[index].polo+'</option>');
    
          });
     }
 });

 

   
    $(document).on("click","td.prenotazione .btn", function () {
        var object = $(this);
        var aula = $(this).attr('id');
        var polo = $(this).closest('tr').children('td.Polo').html();

        $.ajax({
            type: "post",
            url: "insert.php",
            data: {Polo:polo,Aula:aula,Utente:utente,DataAppello:data,Durata:durata},
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
    