$(document).ready(function(){
    
    //Il wrapper indica l'area dove andranno poi ad essere "agganciati" o eliminati gli elementi html
    var wrapper = $(".table-inbox");
    //Il lastCodNotizia è l'ultimo codice identificativo delle notizie che troviamo all'interno del database,
    //ciò servirà ad avere una progressione nell'inserimento delle notizie oltre che ad evitare duplicati.
    var lastCodNotizia = 0;
    var lastCodTag = 0;

    $.ajax({
        type: "post",
        url: "data.php",
        data: {Last:"0"},
        dataType: "json",
        success: function (data) {
            
            if(data[0][0] == null) {lastCodNotizia = 1} else {lastCodNotizia = (Number(data[0][0]) +1);}

            
            if(data[1][0] == null) {lastCodTag = 1} else {lastCodTag = (Number(data[1][0]) + 1);};
            
        }
    });


    function checkSyntax(element) {
        
        
           
        if(element.includes("#") && (/\s/.test(element) == false)){
            return true;
        }else return false;    
        
        
    }

function getNotizie() {
    
    $.ajax({
        type: "post",
        url: "data.php",
        data: {Notizie: "0",Preferenze:preferenze},
        dataType: "json",
        success: function (data) {
        
            $.each(data, function (index) { 
  
              $(wrapper).append('<tr class="unread" accesskey="'+data[index].Cod+'"  data-toggle="modal" data-target="#modal'+data[index].Cod+'">'+
              '<td class="inbox-small-cells"><i class="fa fa-star"></i></td>'+
              '<td class="view-message  mittente" >'+data[index].Mittente+'</td>'+
              '<td class="view-message oggetto">'+data[index].Oggetto+'</td>'+
              '<td class="view-message tags">'+data[index].Tags+'</td>'+
              '<td class="view-message  inbox-small-cells">&emsp;<i class="fa fa-paperclip"></i></td>'+
              '<td class="view-message  data_pubblicazione">'+data[index].Data_pubblicazione+'</td>'+
              '<td class="view-message ">&emsp;<button type="button"  class="btn btn-outline-primary eliminaNotizia"><span class="far fa-trash-alt"></span></button></td>'+
              '</tr>' );
  
          $(wrapper).append('<div class="modal fade"  id="modal'+data[index].Cod+'" tabindex="-1" role="dialog" aria-labelledby="titoloModal'+data[index].Cod+'" aria-hidden="true">'+
                        '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">'+
                        '<h5 class="modal-title" id="titoloModal'+data[index].Cod+'">'+data[index].Oggetto+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                        '<span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+data[index].Contenuto+'</div>'+
                        '<div class="modal-footer"></div></div></div></div>' ); 
            });
        
        
        }
        
      });
   
}

getNotizie();


if (refresh[0] == 1) {
    setInterval(() => {
        $(wrapper).html('<tr class="titles"><td>#</td><td>Proprietario</td><td>Titolo</td><td>Tags</td><td>Allegati</td><td>Data pubblicazione</td></tr>');
        getNotizie();
    }, refresh[1]);
} 
 


$("#searchbar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".table-inbox tr").filter(function() {

      $(this).toggle($(this.cells[3]).text().toLowerCase().indexOf(value) > -1)
    });
  });


  
$(document).on("click",".eliminaNotizia", function(e){
    e.stopPropagation();
    var row = $(this).closest("tr");
    
    var id = row.attr("accesskey");
    var modal = $(document).find('#modal'+id);
    
   
    $.ajax({
        type: "post",
        url: "delete.php",
        data: {CodElimina:id},
        success: function (data) {
            var dataParsed = JSON.parse(data);

            if(dataParsed == "Eliminazione effettuata!"){
                row.remove();
                modal.remove();
            }
            alert(dataParsed);
        }
    });
    return;

});

  
    $(document).on("click","#buttonPosta", function(){ 
    
        var decisione = confirm("Confermi i dati inseriti?");
        if(decisione == false){
            return;
        }
        var titolo = $('#titolo').val();
        var contenuto = $('#contenuto').val();
        var tags = $('#tags').val().trim().split(",");

        tags.forEach(element => {
           var val= checkSyntax(element);
           if(val == false){
            alert("La sintassi non è corretta, inserire # prima di ogni tag!!!");
            return;
           }
        });
        
        
        var dataAttuale = new Date();
        dataAttuale = dataAttuale.toLocaleString();
        var categoria = $('#category').val();
        var aula = "";
        var dataAppello = null;
        if(categoria == "Appello"){
            var arr = $('#aula').val().trim().split("-");
            aula = arr[0];
            var polo = arr[1];
            dataAppello = $('#dataAppello').val();
            var footer = 'L\'esame si svolgerà nell\'aula '+aula+' (Polo: '+polo+' il '+dataAppello+')';
        
        }

        $.ajax({
            url: "./insert.php",
            type: "post",
            data: {CodNotizia:lastCodNotizia,CodTag:lastCodTag,Titolo:titolo,Contenuto:contenuto,Utente:utente,Tags:tags,Categoria:categoria,Aula:aula,Data:dataAppello},
            success: function (data) {
                var dataParsed = JSON.parse(data);

                if(dataParsed == "Notizia postata correttamente!"){
                    alert(dataParsed);
                    $(wrapper).append('<tr class="unread" data-toggle="modal" data-target="#modal'+lastCodNotizia+'"><td class="inbox-small-cells"><i class="fa fa-star"></i></td>'+
                                      '<td class="view-message  mittente">'+utente+'</td>'+
                                      '<td class="view-message oggetto">'+titolo+'</td>'+
                                      '<td class="view-message tags">'+tags+'</td>'+
                                      '<td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>'+
                                      '<td class="view-message data_attuale">'+dataAttuale+'</td></tr>');
                    
                    $(wrapper).append('<div class="modal fade"  id="modal'+lastCodNotizia+'" tabindex="-1" role="dialog" aria-labelledby="titoloModal'+lastCodNotizia+'" aria-hidden="true">'+
                                      '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">'+
                                      '<h5 class="modal-title" id="titoloModal'+lastCodNotizia+'">'+titolo+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                      '<span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+contenuto+'</div>'+
                                      '<div class="modal-footer">'+footer+'</div></div></div></div>' );                     
                                     
                    $('#exampleModalCenter').modal('hide');
                lastCodNotizia++;
                lastCodTag = lastCodTag + tags.length;
                }else alert(dataParsed);
            }

        });
    });



    var contenutoModal = $('#modalPostaNotizia').children().clone();

    var selectAule="";
    $.ajax({
        type: "post",
        url: "data.php",
        data: {Aule: "0",Utente:utente},
        dataType: "json",
        success: function (data) {
       
         for (var index = 0; index < data.length; index++) {
              selectAule = selectAule+"<option>"+data[index].aula+" - "+data[index].polo+"</option>";
             
         }
      
        }
        
      });



    $(document).on('change','#category',function(){
      
if(this.value == "Appello"){
    $("#modalPostaNotizia").html('<div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Posta un appello</h5>'+
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>'+
        '<div class="modal-body"><div id="collapseOne" class="panel-collapse collapse show" style=""><div class="panel-body"><div class="row">'+
        '<div class="col-md-12"><div class="v panel-group" id="accordion"><form><input type="text" id="titolo" class="form-control" placeholder="Titolo" required="">'+
        '</form></div><div class="form-group"><textarea id="contenuto" class="form-control" placeholder="Contenuto (max 1500 caratteri)" rows="5" required=""></textarea>'+
        '</div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label for="category">Categoria</label>'+
        '<select class="form-control" id="category"><option>Appello</option><option>Notizia</option></select>'+
        '<br/><label for="aula">Aula</label><select class="form-control" id="aula">'+selectAule+'</select></div></div>'+
        '<div class="col-md-6"><div class="form-group"><label for="tags">Tags</label><input type="text" class="form-control" id="tags" placeholder="Tags"><br>'+
        '<label for="dataAppello">Data appello</label><div class="input-group date" id="datetimepicker2" data-target-input="nearest">'+
        '<input type="text" id="dataAppello" class="form-control datetimepicker-input" data-target="#datetimepicker2"/><div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">'+
        '<div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div></div>'+
        '</div></div></div></div></div></div>'+
        '<div class="modal-footer"><button type="button" id="buttonPosta" class="btn btn-primary">Posta <span class="fas fa-thumbs-up" aria-hidden="true"></span></button></div>');

        

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
}
else {
    $("#modalPostaNotizia").html(contenutoModal);
 
}
  });

 


 
});