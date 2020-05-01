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
		
		<h1>Add New Lesson</h1>
	
        <?php
        
        require_once ('connection.php');
        
        date_default_timezone_set("EST");
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            echo "<form method='post' action='addLesson.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Trainer</td><td>";
            
            $stmt = $conn->prepare('select e_id, concat(first_name, " ", last_name) as name, store from Employee where e_id in (select e_id from Trainer);');
            $stmt->execute();
            
            // get all trainers
            echo "<select name='trainer'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[e_id]'>$row[name] at Store $row[store]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td>Lesson type</td><td><input name='type' type='text' size='25' required></td></tr>";
            echo "<tr><td>Scheduled date</td><td><input name='lesson_time' type='datetime-local' min=" . date("Y-m-d H:i:s", time()) . " required></td></tr>";
            echo "<tr><td>Capacity</td><td><input name='capacity' type='number' min='1' max='50' step='1' size='8'></td></tr>";
            
            echo "<tr><td>Animal</td><td>";
            
            $stmt = $conn->prepare('select classification from Animal order by classification;');
            $stmt->execute();
            
            // get all animals
            echo "<select name='animal'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[classification]'>$row[classification]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Lesson(lesson_time, type_of, capacity) values (:lesson_time, :type, :capacity);");
                
                $stmt->bindValue(":lesson_time", $_POST['lesson_time']);
                $stmt->bindValue(":type", trim($_POST['type']));
                
                if($_POST['capacity'] !=  "" || $_POST['capacity'] != null) {
                    $stmt->bindValue(':capacity', $_POST['capacity']);
                } else {
                    $stmt->bindValue(':capacity', null, PDO::PARAM_INT);
                }
                
                $stmt->execute();
                
                $lesson = $conn->lastInsertId();
                
                $stmt = $conn->prepare("insert into Trains values(:trainer, :lesson, :animal, now());");
                
                $stmt->bindValue(':trainer', $_POST['trainer']);
                $stmt->bindValue(':lesson', $lesson);
                $stmt->bindValue(':animal', $_POST['animal']);
                
                $stmt->execute();
                
                echo "Successfully added new lesson.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>