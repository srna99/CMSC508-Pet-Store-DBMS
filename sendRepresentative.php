<html>
	<head>
		<style>
            table, th, td {
            	border: 1px solid black;
            	border-collapse: collapse;
            }
            
            table {
                margin-bottom: 30px;
                margin-left: 0.5em;
            }
            
            th, td {
                padding-left: 10px;
                padding-right: 10px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
            
            h1 {
                margin-top: 0.8em;
                margin-left: 0.5em;
            }
        </style>
	</head>
	
	<body>
		<h1>List of Representatives Associated By Store</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // get all reps
        $stmt = $conn->prepare('select store, concat(r.first_name, " ", r.last_name) as representative, (select shelter_name from Shelter where s_id = r.shelter) as shelter from Send_To s left join Representative r on s.representative =r.r_id order by store, representative;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>Store</th>
            <th>Representative</th>
            <th>Shelter</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[store]</td>
            <td>$row[representative]</td>
            <td>$row[shelter]</td>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>