// Call the dataTables jQuery plugin
$(document).ready(function() {
  var book = $("#current_book").val();
  var getBook = book != 'ALL_BOOKS' ? '&book='+ book : '';
  $('#dataTable').DataTable( {
    "ajax": '/proyecto_criptomonedas/api/requests.php?accion=getTicksTable'+getBook,
    "order": [[ 0, "desc" ]],
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
