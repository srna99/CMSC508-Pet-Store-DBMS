<html>
	<head>
		<style>
            table {
            	border: 1px solid black;
            	border-collapse: collapse;
            }
            
            table {
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
		
		<h1>Update Leash</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['SN']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select SN,leash_length,price,animal from Leash order by SN;');
            $stmt->execute();
            
            // select an Leash to get to current related info
            echo "<form method='get'>";
            echo "Select an Leash:  ";
            echo "<select name='SN' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select an Leash -- </option>";

            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: Length $row[leash_length] Price: $row[price] for $row[animal]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $SN = $_GET["SN"];
            
            // get related info from pk
            $stmt = $conn->prepare('select SN, leash_length,price,quantity,animal from Leash where SN = :SN;');
            $stmt->bindValue(':SN', $SN);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editLeash.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Serial Number</td><td>$row[SN]</td></tr>";
            echo "<tr><td>Leash Length</td><td><input name='leash_length' type='number' min='1' step='1' size='11' required></td></tr>";
            echo "<tr><td>Price</td><td><input name='price' type='number' min='0.01' step='0.01' size='7' required></td></tr>";
            echo "<tr><td>Quantity</td><td><input name='quantity' type='number' min='0 step='1' size='11' required></td></tr>";
            echo "<tr><td>Animal</td><td>";
           
            $stmt = $conn->prepare("SELECT classification FROM Animal");
            $stmt->execute();

            echo "<select name='animal'>"; // get animal for drop down
            echo "<option disabled selected value> -- select an animal -- </option>";

            while ($row = $stmt->fetch()) {
                echo "<option value='" . $row['classification'] . "'>" . $row['classification'] . "</option>";
            }  
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editLeash_SN"] = $SN; 
            
        } else { // after submitting form
            
            try {
                
                // update Leash with edits
                $stmt = $conn->prepare("update Leash set leash_length = :leash_length, price = :price, quantity = :quantity, animal = :animal where SN = :SN;");
                
                $stmt->bindValue(':leash_length', $_POST['leash_length']);
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':quantity', $_POST['quantity']);
                $stmt->bindValue(':animal', $_POST['animal']);
                $stmt->bindValue(':SN', $_SESSION["editLeash_SN"]);
                
                $stmt->execute();
                
                echo "Successfully updated Leash.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editLeash_SN"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>