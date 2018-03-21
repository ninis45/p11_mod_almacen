function fnFormatDetails ( oTable, nTr )
{
          var aData = oTable.fnGetData( nTr );
          var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
          sOut += '<tr><td>Descripción:</td><td>'+aData[1]+' '+'</td></tr>';
          //sOut += '<tr><td>Link to source:</td><td><a href="#" class="btn btn-success">Agregar almacen</a></td></tr>';
          sOut += '<tr><td>Marca:</td><td>'+aData[2]+'</td></tr>';
          sOut += '<tr><td>Modelo:</td><td>'+aData[3]+'</td></tr>';
          sOut += '</table>';

          return sOut;
}

$(document).ready(function(){
    
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    var tr;
    
    nCloneTd.innerHTML = '<a href="javascript:;"  class="btn btn-warning btn-xs btn-collapse"><i class="fa fa-plus"></i></a>';
    nCloneTd.className = "center";
          
     $('.typeahead').typeahead({
        source:['Alabama','Costa Marfil']
        
    });
    $('#hidden-table-info thead tr').each( function () {
              this.insertBefore( nCloneTh, this.childNodes[0] );
          } );

    $('#hidden-table-info tbody tr').each( function () {
              this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
    });
     var oTable = $('#hidden-table-info').dataTable( {
              "aoColumnDefs": [
                  { "bSortable": false, "aTargets": [ 0,6 ] }
              ],
              "aaSorting": [[1, 'asc']]
     });
     
     $('#hidden-table-info tbody td a.btn-collapse').on('click', function () {
              var nTr = $(this).parents('tr')[0];
              if ( oTable.fnIsOpen(nTr) )
              {
                  /* This row is already open - close it */
                  this.src = "assets/advanced-datatable/examples/examples_support/details_open.png";
                  oTable.fnClose( nTr );
              }
              else
              {
                  /* Open this row */
                  this.src = "assets/advanced-datatable/examples/examples_support/details_close.png";
                  oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
              }
     } );
      var almacen = {
          box_right: $('#box-right'),
          box_left : $('#box-left'),
          box_form : $('#box-form'),
          tr       : false,
          init:function()
          {
                
                
              almacen.box_left.addClass('col-lg-12').removeClass('col-lg-8');
              almacen.box_right.addClass('hide');
          },
          open:function(e)
          {
              e.preventDefault();
              
              var url = $(this).attr('href');
              
              almacen.tr = $(this).closest('tr');
              
              almacen.box_left.removeClass('col-lg-12').addClass('col-lg-8');
              almacen.box_right.removeClass('hide');
              
              almacen.box_form.html('<div class="loading"></div>');
              
              almacen.box_form.load(url);
          },
          action:function(e)
          {
               e.preventDefault();
               var   url = $(this).attr('action'),
                    data = $(this).serialize();
                    
               $.post(url,data,function(response){
                   
                  
                   
                   pyro.add_notification(response.message);
                   
                   if(response.status == 'success')
                   {
                        var cantidad = response.data;
                        
                        almacen.tr.find('.cantidad_m').html(cantidad.cantidad_mostrador);
                        almacen.tr.find('.cantidad_w').html(cantidad.cantidad_web);
                        
                        almacen.init();
                        
                   }
                
              });
          }
        
     };
     $('a.ajax').on('click',almacen.open);
     
     $('body').delegate('#form-ajax','submit',almacen.action);
     
    
    
});

