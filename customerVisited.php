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
		<h1>List of All Stores Visited by a Customer</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if (!isset($_GET['customer'])) {
            
            $stmt = $conn->prepare('select c_id, first_name, last_name, birthdate from Customer order by first_name, last_name, birthdate;');
            $stmt->execute();
            
            // select a pet to get to current related info
            echo "<form method='get'>";
            echo "Select a customer:  ";
            
            // make dropdown menu for customer
            echo "<select name='customer' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a customer -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[c_id]'>$row[first_name] $row[last_name] (born $row[birthdate])</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        } else {
        
            // get all stores visited by customer
            $stmt = $conn->prepare('select store from Shops_At where customer = :customer order by store;');
            $stmt->bindValue(":customer", $_GET["customer"]);
            $stmt->execute();
            
            // make table
            echo "<table>";
            // row headings
            echo "<thead><tr><th>Store</th>";
            echo "<tbody>";
            
            // info from query
            while ($row = $stmt->fetch()) {
                echo "<tr><td>$row[store]</td></tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        }
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>