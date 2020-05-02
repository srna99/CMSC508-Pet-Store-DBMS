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
		
		<h1>Update Store's Manager</h1>
	
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
            $stmt = $conn->prepare('select manager as current_manager from Store where s_id = :s_id;');
            $stmt->bindValue(':s_id', $s_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='storeManager.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Change manager to</td><td>";
            
            $m_stmt = $conn->prepare('select e_id, concat(first_name, " ", last_name) as name, store from Employee 
                            where (e_id not in (select manager from Store) or e_id = :e_id) and e_id not in (select e_id from Cashier) and e_id not in (select e_id from Groomer) and e_id not in (select e_id from Stocker) and e_id not in (select e_id from Trainer);');
            $m_stmt->bindValue(":e_id", $row['current_manager']);
            $m_stmt->execute();
            
            // get all emp
            echo "<select name='manager'>";
            
            while ($m_row = $m_stmt->fetch()) {
                
                if ($m_row['e_id'] == $row['current_manager']){
                    echo "<option value='$m_row[e_id]' selected>$m_row[name] at Store $m_row[store]</option>";
                } else {
                    echo "<option value='$m_row[e_id]'>$m_row[name] at Store $m_row[store]</option>";
                }
                
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["storeManager_s_id"] = $s_id; 
            $_SESSION["storeManager_current_manager"] = $row['current_manager']; 
            
        } else { // after submitting form
            
            try {
                
                // update store with edits
                $stmt = $conn->prepare("update Store set manager = :manager where s_id = :s_id;");
                
                $stmt->bindValue(':manager', $_POST['manager']);
                $stmt->bindValue(':s_id', $_SESSION["storeManager_s_id"]);
                
                $stmt->execute();
                
                $store = $conn->lastInsertId();
                
                $stmt = $conn->prepare("update Employee set manager = null, store = :store where e_id = :e_id;");
                
                $stmt->bindValue(":store", $store);
                $stmt->bindValue(":e_id", $_POST['manager']);
                
                $stmt->execute();
                
                $stmt = $conn->prepare("update Employee set manager = :manager where e_id = :e_id;");
                
                $stmt->bindValue(":e_id", $_SESSION["storeManager_current_manager"]);
                $stmt->bindValue(":manager", $_POST['manager']);
                
                $stmt->execute();
                
                echo "Successfully updated store.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["storeManager_s_id"]);
            unset ($_SESSION["storeManager_current_manager"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>