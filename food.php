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
		<h1>List of All Food</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all Accessories
        $stmt = $conn->prepare('select animal,brand,price,quantity,SN from Food order by animal;');
        $stmt->execute();
        
        echo "<table>";
        echo "<thead><tr>
            <th>animal</th>
            <th>brand</th>
            <th>price</th>
            <th>quantity</th>
            <th>SN</th>
            </tr></thead>";
        echo "<tbody>";
        
        // show info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[animal]</td><td>$row[brand]</td><td>$row[price]</td><td>$row[quantity]</td><td>$row[SN]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- click to get back to index -->
		<a href="index.php">Back to index</a>
	</body>
</html>