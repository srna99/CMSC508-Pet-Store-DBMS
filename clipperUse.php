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
		<h1>Clipper Usage History</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all clipper usage history
        $stmt = $conn->prepare('select groomer, clipper, animal, date_used from Clipper_Usage_History order by date_used;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>Groomer</th>
            <th>Clipper</th>
            <th>Animal</th>
            <th>Date used</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[groomer]</td>
            <td>$row[clipper]</td>
            <td>$row[animal]</td>
            <td>$row[date_used]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>