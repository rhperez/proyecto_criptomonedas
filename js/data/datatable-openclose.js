// Call the dataTables jQuery plugin
$(document).ready(function() {
  var book = $("#current_book").val();
  var getBook = book != 'ALL_BOOKS' ? '&book='+ book : '';
  $('#dataTable').DataTable( {
    "ajax": '/proyecto_criptomonedas/api/requests.php?accion=getOpenTicksTable'+getBook,
    "order": [[ 5, "desc" ]],
    "rowCallback": function(row, data){
      if (data[4] < 0) {
        $('td:eq(4)', row).css('color', '#f52f57');
        $('td:eq(4)', row).html('<b>'+data[4]+'%</b>');
      } else {
        $('td:eq(4)', row).css('color', '#36b9cc');
        $('td:eq(4)', row).html('<b>'+data[4]+'%</b>');
      }
    },
    "language": {
      "emptyTable":     "No hay registros disponibles",
      "info":           "Mostrando _START_ - _END_ de _TOTAL_ registros",
      "infoEmpty":      "Mostrando 0 to 0 of 0 registros",
      "infoFiltered":   "(filtrado de _MAX_ registros totales)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Mostrar _MENU_ registros",
      "loadingRecords": "Cargando...",
      "processing":     "Procesando...",
      "search":         "Buscar:",
      "zeroRecords":    "No se encontraron coincidencias",
      "paginate": {
          "first":      "Primero",
          "last":       "Último",
          "next":       "Siguiente",
          "previous":   "Anterior"
      },
      "aria": {
          "sortAscending":  ": ordenar ascendentemente",
          "sortDescending": ": ordenar descendentemente"
      }
    }
  });

} );
