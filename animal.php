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
		<h1>List of All Types of Animals</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all animals
        $stmt = $conn->prepare('select classification, diet_type from Animal;');
        $stmt->execute();
        
        echo "<table>";
        echo "<thead><tr>
            <th>Species</th>
            <th>Diet type</th>
            </tr></thead>";
        echo "<tbody>";
        
        // show info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[classification]</td><td>$row[diet_type]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- click to get back to index -->
		<a href="index.php">Back to index</a>
	</body>
</html>