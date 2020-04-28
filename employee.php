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
		<h1>List of All Employees</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all employees
        $stmt = $conn->prepare('select e_id, first_name, last_name, salary, birthdate, phone_number, address,
            	    (select concat(first_name, " ", last_name) from Employee where e_id = e.manager) as manager_name,
            	    store 
            	    from Employee e
            	    order by first_name, last_name;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Salary</th>
            <th>Birthdate</th>
            <th>Phone number</th>
            <th>Address</th>
            <th>Manager name</th>
            <th>Store</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[e_id]</td>
            <td>$row[first_name]</td>
            <td>$row[last_name]</td>
            <td>" . money_format("%.2n", $row["salary"]) . "</td>
            <td>$row[birthdate]</td>";
            
            if ($row["phone_number"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["phone_number"] . "</td>";
            }
            
            if ($row["address"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["address"] . "</td>";
            }
            
            if ($row["manager_name"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["manager_name"] . "</td>";
            }
            
            echo "<td>$row[store]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>