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
		<h1>List of All Stores</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all stores
        $stmt = $conn->prepare('select s_id, s.address as address, concat(first_name, " ", last_name) as manager from Store s left join Employee e on s.manager = e.e_id order by s_id;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>Address</th>
            <th>Manager</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[s_id]</td>
            <td>$row[address]</td>
            <td>$row[manager]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>