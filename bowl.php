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
		<h1>List of All Types of Bowls</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all Bowls
        $stmt = $conn->prepare('select open_diameter,SN,substrate from Bowl order by SN;');
        $stmt->execute();
        
        echo "<table>";
        echo "<thead><tr>
            <th>open_diameter</th>
            <th>SN</th>
            <th>substrate</th>
            </tr></thead>";
        echo "<tbody>";
        
        // show info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[open_diameter]</td><td>$row[SN]</td><td>$row[substrate]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- click to get back to index -->
		<a href="index.php">Back to index</a>
	</body>
</html>