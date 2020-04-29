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
		<h1>List of All Pet Transactions</h1>
	
        <?php
        require_once ('connection.php');
        
        setlocale(LC_MONETARY, 'en_US');
        
        // get all transactions
        $stmt = $conn->prepare('select customer, pet_name, animal, price, date_bought from Pet_Transaction order by date_bought;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>Customer</th>
            <th>Pet name</th>
            <th>Animal</th>
            <th>Price</th>
            <th>Date bought</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[customer]</td>
            <td>$row[pet_name]</td>
            <td>$row[animal]</td>
            <td>" . money_format("%.2n", $row["price"]) . "</td>
            <td>$row[date_bought]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>