<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> filtrage</title>
	<!--<link rel="stylesheet" type="text/css" href="w3.css">-->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<script type="text/javascript">
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">ce nom ne figure  pas dans la liste</td></tr>'));
        }
    });
});
</script> 

	<hr>
    <div class="row">
        <div class="filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table">
                <thead>
				<tr class="filters">
                        <th><input type="text" class="form-control" placeholder="#" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nom" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Prenom" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Age" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Pays" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Sexe" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Date_inscrit" disabled></th>
                    </tr>
			</thead>
			<tbody>
				<?php 
				$db=new PDO("mysql:host=localhost;dbname=exampweb","root","");
				$stmt=$db->prepare("select * from textes");
				$stmt->execute();
				while($row=$stmt->fetch()){ 
				?>
				<tr>
					<td><?php echo $row['id_text'] ?></td>
					<td><?php echo $row['Nom'] ?></td>
					<td><?php echo $row['Prenom'] ?></td>
					<td><?php echo $row['Age'] ?></td>
					<td><?php echo $row['Paye'] ?></td>
					<td><?php echo $row['Sexe'] ?></td>
					<td><?php echo $row['Date_inscrit'] ?></td>
				</tr>
				<?php
			    }
			    ?>
			</tbody>
		</table>
	</div>
	</div>	
</body>
</html>