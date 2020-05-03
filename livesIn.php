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
		<h1>Lives In</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all usage history
        $stmt = $conn->prepare('select animal,habitat from Lives_In order by filter;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>animal</th>
            <th>habitat</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[animal]</td>
            <td>$row[habitat]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>