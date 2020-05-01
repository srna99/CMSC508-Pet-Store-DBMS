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
		<h1>List of All Cashiers</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all stockers
        $stmt = $conn->prepare('select e_id, concat(first_name, " ", last_name) as name, employment_status, product_to_stock from Stocker left join Employee using(e_id) order by name;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>Name</th>
            <th>Employment status</th>
            <th>Product to stock</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            
            echo "<tr><td>$row[e_id]</td>
            <td>$row[name]</td>
            <td>$row[employment_status]</td>";
            
            if ($row["product_to_stock"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["product_to_stock"] . "</td>";
            }
            
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>