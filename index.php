<?php
// Code from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<html>
    <head>
    	<title>CMSC 508 Pet Store DBMS</title>
    	
    	<style>
    	    #content {
                max-width: 800px;
                margin: auto;
                padding-bottom: 50px;
                display: flex;
            }
            
            .column {
                flex: 50%;
                padding: 10px;
            }
            
    	    h1 {
                text-align: center;
                margin-top: 0.8em;
            }
            
            h2 {
                text-align: center;
                margin-bottom: 0.8em;
            }
            
            ul {
              text-align: center;
              list-style: inside;
            }
            
            .links {
                text-align: center;
            }
            
            a {
                display: inline-block;
                margin-bottom: 5px;
            }
            
            #logout {
                display: block;
                text-align: right;
                max-width: 650px;
                margin: auto;
                padding-top: 10px;
                padding-right: 10px;
            }
    	</style>
    </head>
    
    <body>
    	<a href="logout.php" id="logout">Log Out</a>
    	
    	<h1>Pet Store DBMS</h1>
    	
    	<div id="content">
    		<div class="column">
            	<h2>Pets</h2>
            	<div class="links">
            		<a href="animal.php">Display All Types of Animals</a>
            		<br><a href="addAnimal.php">Add New Type of Animal</a>
            		<br><a href="editAnimal.php">Edit Diet Type of Animal</a>
            		<br><a href="deleteAnimal.php">Delete A Type of Animal</a>
            		<br>
            		<br><a href="pet.php">Display All Pets</a>
            		<br><a href="addPet.php">Add New Pet</a>
            		<br><a href="editPet.php">Edit Pet</a>
            		<br><a href="deletePet.php">Delete A Pet</a>
            	</div>
        		
        		<h2>Stock</h2>
            	<div class="links">
        			<a href="accessory.php">Display All Accessories</a>
        			<br><a href="addAccessory.php">Add New Accessory</a>
        			<br><a href="editAccessory.php">Edit An Accessory</a>
        			<br><a href="deleteAccessory.php">Delete An Accessory</a>
        			<br>
        			<br><a href="bedding.php">Display All Beddings</a>
        			<br><a href="addBedding.php">Add New Bedding</a>
        			<br><a href="editBedding.php">Edit A Bedding</a>
        			<br><a href="deleteBedding.php">Delete A Bedding</a>
        			<br>
        			<br><a href="food.php">Display All Foods</a>
        			<br><a href="addFood.php">Add New Food</a>
        			<br><a href="editFood.php">Edit A Food</a>
					<br><a href="deleteFood.php">Delete A Food</a>
					<br>
        			<br><a href="medication.php">Display All Medications</a>
        			<br><a href="addMedication.php">Add New Medication</a>
        			<br><a href="editMedication.php">Edit A Medication</a>
					<br><a href="deleteMedication.php">Delete A Medication</a>
					<br>
        			<br><a href="vitamin.php">Display All Vitamin</a>
        			<br><a href="addVitamin.php">Add New Vitamin</a>
        			<br><a href="editVitamin.php">Edit A Vitamin</a>
					<br><a href="deleteVitamin.php">Delete A Vitamin</a>
					<br>
        			<br><a href="toy.php">Display All Toy</a>
        			<br><a href="addToy.php">Add New Toy</a>
        			<br><a href="editToy.php">Edit A Toy</a>
					<br><a href="deleteToy.php">Delete A Toy</a>
					<br>
        			<br><a href="decor.php">Display All Decor</a>
        			<br><a href="addDecor.php">Add New Decor</a>
        			<br><a href="editDecor.php">Edit A Decor</a>
					<br><a href="deleteDecor.php">Delete A Decor</a>
					<br>
        			<br><a href="leash.php">Display All Leash</a>
        			<br><a href="addLeash.php">Add New Leash</a>
        			<br><a href="editLeash.php">Edit A Leash</a>
					<br><a href="deleteLeash.php">Delete A Leash</a>
					<br>
        			<br><a href="litter.php">Display All Litter</a>
        			<br><a href="addLitter.php">Add New Litter</a>
        			<br><a href="editLitter.php">Edit A Litter</a>
					<br><a href="deleteLitter.php">Delete A Litter</a>
					<br>
        			<br><a href="crate.php">Display All Crate</a>
        			<br><a href="addCrate.php">Add New Crate</a>
        			<br><a href="editCrate.php">Edit A Crate</a>
        			<br><a href="deleteCrate.php">Delete A Crate</a>
					<br>
					<br><a href="collar.php">Display All Collars</a>
        			<br><a href="addCollar.php">Add New Collar</a>
        			<br><a href="editCollar.php">Edit A Collar</a>
        			<br><a href="deleteCollar.php">Delete A Collar</a>
					<br>
					<br><a href="light.php">Display All Lights</a>
        			<br><a href="addLight.php">Add New Light</a>
        			<br><a href="editLight.php">Edit A Light</a>
        			<br><a href="deleteLight.php">Delete A Light</a>
					<br>
					<br><a href="filter.php">Display All Filters</a>
        			<br><a href="addFilter.php">Add New Filter</a>
        			<br><a href="editFilter.php">Edit A Filter</a>
					<br><a href="deleteFilter.php">Delete A Filter</a>
					<br><a href="tankFilter.php">Display All Filters for Tanks</a>
					<br><a href="addTankFilter.php">Add A Filter for Tank</a>
					<br><a href="deleteTankFilter.php">Delete A Filter for Tank</a>
					<br>
					<br><a href="habitat.php">Display All Habitats</a>
					<br><a href="livesIn.php">Display All Habitats connected to an Animal</a>
					<br><a href="decorates.php">Display All Decor connected to an Habitat</a>
					<br><a href="bowl.php">Display All Bowls</a>
        			<br><a href="cage.php">Display All Cages</a>
        			<br><a href="tank.php">Display All Tanks</a>
					<br><a href="addHabitat.php">Add a Habitat</a>
					<br><a href="editHabitat.php">Edit A Habitat</a>
					<br><a href="deleteHabitat.php">Delete A Habitat</a>
					<br><a href="addLivesIn.php">Add a Animal to a Habitat</a>
					<br><a href="deleteLivesIn.php">Delete an Animal from a Habitat</a>
					<br><a href="addDecorates.php">Add a Decor to a Habitat</a>
					<br><a href="deleteDecorates.php">Delete an Decor from a Habitat</a>
        		</div>
        	</div>
        		
        	<div class="column">
            	<h2>Customers</h2>
            	<div class="links">
            		<a href="customer.php">Display All Customers</a>
            		<br><a href="addCustomer.php">Add New Customer</a>
            		<br><a href="editCustomer.php">Edit A Customer</a>
            		<br><a href="deleteCustomer.php">Delete A Customer</a>
            		<br>
            		<br><a href="customerTransactions.php">Display All Customer Transactions</a>
            		<br><a href="addCustomerTransaction.php">Add New Transaction</a>
            		<br><a href="customerVisited.php">Display All Stores Visited By A Customer</a>
            	</div>
            	
            	<h2>Personnel and Related Matters</h2>
            	<div class="links">
            		<a href="employee.php">Display All Employees</a>
            		<br><a href="manager.php">Display All Store Managers</a>
                	<br><a href="cashier.php">Display All Cashiers</a>
                	<br><a href="groomer.php">Display All Groomers</a>
                	<br><a href="stocker.php">Display All Stockers</a>
                	<br><a href="trainer.php">Display All Trainers</a>
                	<br><a href="addEmployee.php">Add New Employee</a>
                	<br><a href="editEmployee.php">Edit An Employee</a>
                	<br><a href="increaseSalaryManager.php">Increase Salary of Managers</a>
                	<br><a href="increaseSalaryStore.php">Increase Salary of Employees By Store</a>
                	<br><a href="deleteEmployee.php">Delete An Employee</a>
                	<br>
                	<br><a href="clipper.php">Display All Clippers</a>
                	<br><a href="clipperUse.php">Display Clipper Usage History</a>
                	<br><a href="addClipper.php">Add New Clipper</a>
                	<br><a href="addClipperUse.php">Add Clipper Usage</a>
                	<br><a href="deleteClipper.php">Delete A Clipper</a>
                	<br>
                	<br><a href="groomingAcc.php">Display All Grooming Accessories</a>
                	<br><a href="groomingAccUse.php">Display Grooming Accessory Usage History</a>
                	<br><a href="addGroomingAcc.php">Add New Grooming Accessory</a>
                	<br><a href="addGroomingAccUse.php">Add Grooming Accessory Usage</a>
                	<br><a href="deleteGroomingAcc.php">Delete A Grooming Accessory</a>
                	<br>
                	<br><a href="treatment.php">Display Treatment History</a>
                	<br><a href="addTreatment.php">Add New Treatment Record</a>
                	<br>
                	<br><a href="lesson.php">Display Lesson History</a>
                	<br><a href="addLesson.php">Add New Lesson</a>
            	</div>
            	
            	<h2>Stores and Businesses</h2>
            	<div class="links">
            		<a href="store.php">Display All Stores</a>
            		<br><a href="addStore.php">Add New Store Location</a>
            		<br><a href="storeAddress.php">Change Store's Address</a>
            		<br><a href="storeManager.php">Update Store's Manager</a>
            		<br><a href="deleteStore.php">Close A Store Location</a>
            		<br>
                	<br><a href="shelter.php">Display All Shelters Collaborated With</a>
                	<br><a href="addShelter.php">Add New Shelter</a>
                	<br><a href="editShelter.php">Edit A Shelter</a>
                	<br><a href="deleteShelter.php">Delete A Shelter</a>
                	<br><a href="representative.php">Display All Shelter Representatives</a>
                	<br><a href="sendRepresentative.php">Display All Representatives By Store</a>
                	<br><a href="addSendRepresentative.php">Associate A Representative With Store</a>
                	<br><a href="deleteSendRepresentative.php">Disassociate A Representative From Store</a>
                	<br><a href="addRepresentative.php">Add New Representative</a>
                	<br><a href="editRepresentative.php">Edit A Representative</a>
                	<br><a href="deleteRepresentative.php">Delete A Representative</a>
                	<br>
                	<br><a href="company.php">Display All Companies That Donated</a>
                	<br><a href="donation.php">Display All Donations Received</a>
                	<br><a href="addCompany.php">Add New Company</a>
                	<br><a href="addDonation.php">Add New Donation</a>
                	<br><a href="editCompany.php">Edit A Company</a>
                	<br><a href="deleteCompany.php">Delete A Company</a>
            	</div>
            </div>
    	</div>
    </body>
</html>