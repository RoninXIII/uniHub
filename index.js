$(document).ready(function(){
    
    //Il wrapper indica l'area dove andranno poi ad essere "agganciati" o eliminati gli elementi html
    var wrapper = $(".table-inbox");
    //Il lastCod è l'ultimo codice identificativo delle notizie che troviamo all'interno del database,
    //ciò servirà ad avere una progressione nell'inserimento delle notizie oltre che ad evitare duplicati.
    var lastCod = 0;
    $.ajax({
      type: "post",
      url: "data.php",
      data: {Notizie: "0"},
      dataType: "json",
      success: function (data) {
      
          $.each(data, function (index) { 

            $(wrapper).append('<tr class="unread"  data-toggle="modal" data-target="#modal'+data[index].Cod+'">'+
            '<td class="inbox-small-cells"><i class="fa fa-star"></i></td>'+
            '<td class="view-message  mittente" >'+data[index].Mittente+'</td>'+
            '<td class="view-message oggetto">'+data[index].Oggetto+'</td>'+
            '<td class="view-message tags">'+data[index].Tags+'</td>'+
            '<td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>'+
            '<td class="view-message  data_pubblicazione">'+data[index].Data_pubblicazione+'</td>'+
            '</tr>' );

        $(wrapper).append('<div class="modal fade"  id="modal'+data[index].Cod+'" tabindex="-1" role="dialog" aria-labelledby="titoloModal'+data[index].Cod+'" aria-hidden="true">'+
                      '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">'+
                      '<h5 class="modal-title" id="titoloModal'+data[index].Cod+'">'+data[index].Oggetto+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                      '<span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+data[index].Contenuto+'</div>'+
                      '<div class="modal-footer"></div></div></div></div>' ); 
          });
       lastCod = parseInt(data[data.length -1].Cod) +1;
      
      }
      
    });

 

$("#searchbar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".table-inbox tr").filter(function() {

      $(this).toggle($(this.cells[3]).text().toLowerCase().indexOf(value) > -1)
    });
  });


  
    $(document).on("click","#buttonPosta", function(){ 
    
        var titolo = $('#titolo').val();
        var contenuto = $('#contenuto').val();
        var tags = $('#tags').val().trim().split(",");
        var dataAttuale = new Date();
        dataAttuale = dataAttuale.toLocaleString();
        var categoria = $('#category').val();
        

        $.ajax({
            url: "./insert.php",
            type: "post",
            data: {Titolo:titolo,Contenuto:contenuto,Utente:utente,Tags:tags,Categoria:categoria},
            success: function (data) {
                var dataParsed = JSON.parse(data);

                if(dataParsed == "Notizia postata correttamente!"){
                    alert(dataParsed);
                    $(wrapper).append('<tr class="unread" data-toggle="modal" data-target="#modal'+lastCod+'"><td class="inbox-small-cells"><i class="fa fa-star"></i></td>'+
                                      '<td class="view-message  mittente">'+utente+'</td>'+
                                      '<td class="view-message oggetto">'+titolo+'</td>'+
                                      '<td class="view-message tags">'+tags+'</td>'+
                                      '<td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>'+
                                      '<td class="view-message data_attuale">'+dataAttuale+'</td></tr>');
                    
                    $(wrapper).append('<div class="modal fade"  id="modal'+lastCod+'" tabindex="-1" role="dialog" aria-labelledby="titoloModal'+lastCod+'" aria-hidden="true">'+
                                      '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">'+
                                      '<h5 class="modal-title" id="titoloModal'+lastCod+'">'+titolo+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                      '<span aria-hidden="true">&times;</span></button></div><div class="modal-body">'+contenuto+'</div>'+
                                      '<div class="modal-footer"></div></div></div></div>' );                     
                                     
                    $('#exampleModalCenter').modal('hide');
                lastCod++;
                }else alert(dataParsed);
            }

        });
    });



    var contenutoModal = $('#modalPostaNotizia').children().clone();

    var selectAule="";
    $.ajax({
        type: "post",
        url: "data.php",
        data: {Aule: "0"},
        dataType: "json",
        success: function (data) {
         aule = data;
         for (var index = 0; index < data.length; index++) {
              selectAule = selectAule+"<option>"+data[index].nome+"</option>";
             
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
        '<div class="col-md-6"><div class="form-group"><label for="tags">Tags</label><input type="text" class="form-control" id="tags" placeholder="Tags"></div></div></div></div></div></div>'+
        '<div class="modal-footer"><button type="button" id="buttonPosta" class="btn btn-primary">Posta <span class="fas fa-thumbs-up" aria-hidden="true"></span></button></div>');
}
else {
    $("#modalPostaNotizia").html(contenutoModal);
 
}
  });



 
});