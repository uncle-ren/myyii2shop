<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.js">
    $(document).ready( function () {
        $('#table_id_example').fn.DataTable();
    } );
</script>


<table id="table_id_example" class="display">
    <thead>
    <tr>
        <th>Column 1</th>
        <th>Column 2</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Row 1 Data 1</td>
        <td>Row 1 Data 2</td>
    </tr>
    <tr>
        <td>Row 2 Data 1</td>
        <td>Row 2 Data 2</td>
    </tr>
    </tbody>
</table>


<script type="text/javascript" charset="utf8" >

    $(document).ready( function () {
        $('#table_id_example').DataTable();
    } );

</script>