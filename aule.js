
$(document).ready(function () {


   
var wrapper = $('tbody');
var count = 1;
var classeAula = "";
    $.ajax({
      type: "post",
      url: "data.php",
      data: {Aule: "0"},
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

   
    $(wrapper).on("click",".btn", function () {
        var object = $(this);
        var cod = $(this).attr('id');
        $.ajax({
            type: "post",
            url: "insert.php",
            data: {Prenotazione : cod},
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


   
    
    });
    