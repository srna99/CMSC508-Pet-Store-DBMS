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
		
		<h1>Update Animal</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['classification']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select classification from Animal order by classification;');
            $stmt->execute();
            
            // select an animal to get to current related info
            echo "<form method='get'>";
            echo "<select name='classification' onchange='this.form.submit();'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[classification]'>$row[classification]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $classification = $_GET["classification"];
            
            // get related info from pk
            $stmt = $conn->prepare('select classification, diet_type from Animal where classification = :classification;');
            $stmt->bindValue(':classification', $classification);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editAnimal.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Animal</td><td>$row[classification]</td></tr>";
            
            echo "<tr><td>Diet type</td><td>";
            
            // make dropdown menu for diet type with current info automatically selected
            echo "<select name='diet_type'>";
            
            switch ($row[diet_type]) {
                
                case "Carnivore":
                    echo "<option value='Carnivore' selected>Carnivore</option>";
                    echo "<option value='Herbivore'>Herbivore</option>";
                    echo "<option value='Omnivore'>Omnivore</option>";
                    break;
                    
                case "Herbivore":
                    echo "<option value='Carnivore'>Carnivore</option>";
                    echo "<option value='Herbivore' selected>Herbivore</option>";
                    echo "<option value='Omnivore'>Omnivore</option>";
                    break;
                    
                case "Omnivore":
                    echo "<option value='Carnivore'>Carnivore</option>";
                    echo "<option value='Herbivore'>Herbivore</option>";
                    echo "<option value='Omnivore' selected>Omnivore</option>";
                    break;
                    
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editAnimal_classification"] = $classification; 
            
        } else { // after submitting form
            
            try {
                
                // update animal with edits
                $stmt = $conn->prepare("update Animal set diet_type = :diet_type where classification = :classification;");
                
                $stmt->bindValue(':first_name', $_POST['diet_type']);
                $stmt->bindValue(':classification', $_SESSION["editAnimal_classification"]);
                
                $stmt->execute();
                
                echo "Successfully updated animal.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editAnimal_classification"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>