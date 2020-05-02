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
		
		<h1>Change Store's Address</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['s_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select s_id, address from Store order by s_id;');
            $stmt->execute();
            
            // select a store to get to current related info
            echo "<form method='get'>";
            echo "Select a store:  ";
            
            // make dropdown menu for pets
            echo "<select name='s_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a store -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>Store $row[s_id] at $row[address]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $s_id = $_GET["s_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select address from Store where s_id = :s_id;');
            $stmt->bindValue(':s_id', $s_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='storeAddress.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Address</td><td><input name='address' type='text' value='$row[address]' size='25' required></td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["storeAddress_s_id"] = $s_id; 
            
        } else { // after submitting form
            
            try {
                
                // update store with edits
                $stmt = $conn->prepare("update Store set address = :address where s_id = :s_id;");
                
                $stmt->bindValue(':address', trim($_POST['address']));
                $stmt->bindValue(':s_id', $_SESSION["storeAddress_s_id"]);
                
                $stmt->execute();
                
                echo "Successfully updated store.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["storeAddress_s_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>