// Call the dataTables jQuery plugin
$(document).ready(function() {
  var book = $("#current_book").val();
    $('#dataTable').DataTable( {
        "ajax": '/proyecto_criptomonedas/api/requests.php?accion=getTicksTable&book='+book
    } );
} );
