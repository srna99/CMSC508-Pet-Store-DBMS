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
		<h1>List of All Donations Received</h1>
	
        <?php
        require_once ('connection.php');
        
        setlocale(LC_MONETARY, 'en_US');
        
        // get all pets
        $stmt = $conn->prepare('select d_id, (select company_name from Company where c_id = company) as company, store, amount, date_donated from Donates;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>Company</th>
            <th>Store</th>
            <th>Amount</th>
            <th>Date received</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[d_id]</td>
            <td>$row[company]</td>
            <td>$row[store]</td>
            <td>" . money_format("%.2n", $row["amount"]) . "</td> 
            <td>$row[date_donated]</td>
            </tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>