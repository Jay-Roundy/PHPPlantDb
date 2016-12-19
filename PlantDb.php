<?php

    class PlantDb 
    {
        //database/form vars
        private $plant_id;
        private $plant_date;
        private $plant_name;
        private $scientific_name;
        private $category;
        private $life_cycle;
        private $soil_preference;
        private $sun_preference;
        private $water_preference;
        private $frost_tolerance;
        private $seed_planting;
        private $planting_area;
        private $image;
        
        //user vars
        private $user_id;
        private $user_name;
        private $password;
        
        //history/comment vars
        private $history_id;
        private $history_date;
        private $comment;
        
        //setters and getters for plant db
        public function setPlantName($plant_name)
        {
            $this->plant_name = $plant_name;
        }
        
        public function getPlantName()
        {
            return $this->plant_name;
        }
        
        public function setScientificName($scientific_name)
        {
            $this->scientific_name = $scientific_name;
        }
        
        public function getScientificName()
        {
            return $this->scientific_name;
        }
        
        public function setCategory($category)
        {
            $this->category = $category;
        }
        
        public function getCategory()
        {
            return $this->category;
        }
        
        public function setLifeCycle($life_cycle)
        {
            $this->life_cycle = $life_cycle;
        }
        
        public function getLifeCycle()
        {
            return $this->life_cycle;
        }
        
        public function setSoilPreference($soil_preference)
        {
            $this->soil_preference = $soil_preference;
        }
        
        public function getSoilPreference()
        {
            return $this->soil_preference;
        }
        
        public function setSunPreference($sun_preference)
        {
            $this->sun_preference = $sun_preference;
        }
        
        public function getSunPreference()
        {
            return $this->sun_preference;
        }
        
        public function setWaterPreference($water_preference)
        {
            $this->water_preference = $water_preference;
        }
        
        public function getWaterPreference()
        {
            return $this->water_preference;
        }
        
        public function setFrostTolerance($frost_tolerance)
        {
            $this->frost_tolerance = $frost_tolerance;
        }
        
        public function getFrostTolerance()
        {
            return $this->frost_tolerance;
        }
        
        public function setSeedPlanting($seed_planting)
        {
            $this->seed_planting = $seed_planting;
        }
        
        public function getSeedPlanting()
        {
            return $this->seed_planting;
        }
        
        public function setPlantingArea($planting_area)
        {
            $this->planting_area = $planting_area;
        }
        
        public function getPlantingArea()
        {
            return $this->planting_area;
        }
        
        public function setImage($image)
        {
            $this->image = $image;
        }
        
        public function getImage()
        {
            return $this->image;
        }
        
        public function setPlantId($plant_id)
        {
            $this->plant_id = $plant_id;
        }
        
        public function getPlantId()
        {
            return $this->plant_id;
        }

        public function getPlantDate()
        {
            return $this->plant_date;
        }
        
        //getters and setters for user db
        public function setUserId($user_id)
        {
            $this->user_id = $user_id;
        }
        
        public function getUserId()
        {
            return $this->user_id;
        }
        
        public function setUserName($user_name)
        {
            $this->user_name = $user_name;
        }
        
        public function getUserName()
        {
            return $this->user_name;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }
        
        public function getPassword()
        {
            return $this->password;
        }
        
        //getters and setters for history/comment db
        public function setHistoryId($history_id)
        {
            $this->history_id = $history_id;
        }
        
        public function getHistoryId()
        {
            return $this->history_id;
        }
        
        public function setHistoryDate($history_date)
        {
            $this->history_date = $history_date;
        }
        
        public function getHistoryDate()
        {
            return $this->history_date;
        }
        
        public function setComment($comment)
        {
            $this->comment = $comment;
        }
        
        public function getComment()
        {
            return $this->comment;
        }
        
        //function to insert values into database from form
        public function insertPlantInfo()
        {
            require_once('connectvars.php');
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $query = "INSERT INTO plant_db (Name, ScientificName, Category, Lifecycle,
                    SoilPreference, SunPreference, WateringPreference, FrostTolerance,
                    SeedPlanting, PlantingAreaRequired, Image) 
                    VALUES ('$this->plant_name', '$this->scientific_name', '$this->category',
                    '$this->life_cycle', '$this->soil_preference', '$this->sun_preference',
                    '$this->water_preference', '$this->frost_tolerance', '$this->seed_planting',
                    '$this->planting_area', '$this->image')";
            
            mysqli_query($dbc, $query)
	                or die('Error querying database');
	                    
	        mysqli_close($dbc);
        }
        
        //retrieve count of database entries for pagination use
        public function countPlantDbEntries($table_name)
        {
        	/* used from http://www.phpeasystep.com/phptu/29.html*/
        	
            // include your code to connect to DB.	
            require_once('connectvars.php');
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        	
        	//set table for query
        	$tbl_name = $table_name;
        	
        	/* 
        	   First get total number of rows in data table. 
        	   If you have a WHERE clause in your query, make sure you mirror it here.
        	*/
        	$query = "SELECT COUNT(*) as num FROM $tbl_name";
        	
        	$result = mysqli_query($dbc, $query)
	                or die('Error querying database');
	                
        	$total = mysqli_fetch_array($result);
        	$total_pages = $total['num'];
        	
            return $total_pages;
        }             
        
        //retrieve plants from database
        public function retrievePlantDbEntries($start_num, $limit_num, $tbl_name)
        {
            require_once('connectvars.php');
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            //set start and limit and table variables
            $start = $start_num;
            $limit = $limit_num;
            $table = $tbl_name;
            
        	/* Get data. */
        	$sql = "SELECT * FROM $table LIMIT $start, $limit"; //add columns to retrieve and start and limit vars
        	$result = mysqli_query($dbc, $sql);

            return $result;
        }

        //code to write the pagination links into a result variable
        public function setPagination($lastpage, $targetpage, $prev, $adjacents, $page, $lpm1, $next)
        {
        	/* 
        		Now we apply our rules and draw the pagination object. 
        		We're actually saving the code to a variable in case we want to draw it more than once.
        	*/
        	$pagination = "";
        	
        	if($lastpage > 1)
        	{	
        		$pagination .= "<div class=\"pagination\">";
        		
        		//previous button
        		if ($page > 1) 
        			$pagination.= "<a href=\"$targetpage?page=$prev\">previous</a>";
        		else
        			$pagination.= "<span class=\"disabled\">previous</span>";	
        		
        		//pages	
        		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
        		{	
        			for ($counter = 1; $counter <= $lastpage; $counter++)
        			{
        				if ($counter == $page)
        					$pagination.= "<span class=\"current\">$counter</span>";
        				else
        					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
        			}
        		}
        		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
        		{
        			//close to beginning; only hide later pages
        			if($page < 1 + ($adjacents * 2))		
        			{
        				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
        				{
        					if ($counter == $page)
        						$pagination.= "<span class=\"current\">$counter</span>";
        					else
        						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
        				}
        				$pagination.= "...";
        				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
        				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
        			}
        			//in middle; hide some front and some back
        			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
        			{
        				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
        				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
        				$pagination.= "...";
        				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        				{
        					if ($counter == $page)
        						$pagination.= "<span class=\"current\">$counter</span>";
        					else
        						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
        				}
        				$pagination.= "...";
        				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
        				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
        			}
        			//close to end; only hide early pages
        			else
        			{
        				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
        				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
        				$pagination.= "...";
        				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
        				{
        					if ($counter == $page)
        						$pagination.= "<span class=\"current\">$counter</span>";
        					else
        						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
        				}
        			}
        		}
        		
        		//next button
        		if ($page < $counter - 1) 
        			$pagination.= "<a href=\"$targetpage?page=$next\">next</a>";
        		else
        			$pagination.= "<span class=\"disabled\">next</span>";
        		$pagination.= "</div>\n";		
        	} 
        	
        	return $pagination;
        }
        
        //display plants from db
        public function displayPlantDbEntries($result)
        {
            echo('<table class="table table-bordered"><tr class="info"><th>Image</th><th>Date</th><th>Name</th><th>ScientificName</th>' . 
                    '<th>Category</th><th>Lifecycle</th><th>Soil</th><th>Sun</th><th>Watering</th>' . 
                    '<th>Frost</th><th>SeedPlanting</th><th>PlantingArea</th><th>Update</th><th>Add/View Comments</th></tr>');
                    
            while ($row = mysqli_fetch_array($result))
            {
                echo(' <tr class = "warning"><td><img src="' . $row['Image'] . '" alt="Plant image" />' .
                        '</td><td>' . $row['Date'] .
                        '</td><td>' . $row['Name'] . 
                        '</td><td>' . $row['ScientificName'] .
                        '</td><td>' . $row['Category'] . 
                        '</td><td>' . $row['Lifecycle'] . 
                        '</td><td>' . $row['SoilPreference'] . 
                        '</td><td>' . $row['SunPreference'] . 
                        '</td><td>' . $row['WateringPreference'] . 
                        '</td><td>' . $row['FrostTolerance'] . 
                        '</td><td>' . $row['SeedPlanting'] . 
                        '</td><td>' . $row['PlantingAreaRequired'] . '</td><td>' .
                        '<form action="update_plant.php?id=' . $row['PlantId'] .
                                '" method="post">' . 
                        '<input type="submit" name="Update" value="Update" class="btn-success" /></form></td><td>' .
                        '<form action="comment.php?id=' . $row['PlantId'] .
                                '" method="post">' .
                        '<input type="submit" name="Comment" value="Comment" class="btn-success" /></form></td></tr>');
            }
            
            echo('</table>');
        }
     
        //retrieve plantinfo from db by id and set values
        public function setPlantDbEntriesForUpdate($id)
        {
            require_once('connectvars.php');
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $query = "SELECT * FROM plant_db WHERE PlantId = $id LIMIT 1";
            
            $result = mysqli_query($dbc, $query)
	                or die('Error querying database');

            while ($row = mysqli_fetch_array($result))
            {
                $this->setImage($row['Image']); 
                $this->setPlantName($row['Name']);  
                $this->setScientificName($row['ScientificName']); 
                $this->setCategory($row['Category']);  
                $this->setLifeCycle($row['Lifecycle']);  
                $this->setSoilPreference($row['SoilPreference']);  
                $this->setSunPreference($row['SunPreference']);  
                $this->setWaterPreference($row['WateringPreference']);  
                $this->setFrostTolerance($row['FrostTolerance']);  
                $this->setSeedPlanting($row['SeedPlanting']); 
                $this->setPlantingArea($row['PlantingAreaRequired']);
            }
	                    
	        mysqli_close($dbc);
        }
        
        //update plant database with new info
        public function updatePlantInfo()
        {
            require_once('connectvars.php');
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $query = "UPDATE plant_db SET Date = DEFAULT, Name = '$this->plant_name', 
                    ScientificName = '$this->scientific_name', Category = '$this->category', 
                    Lifecycle = '$this->life_cycle', SoilPreference = '$this->soil_preference', 
                    SunPreference = '$this->sun_preference', WateringPreference = '$this->water_preference', 
                    FrostTolerance = '$this->frost_tolerance', SeedPlanting = '$this->seed_planting', 
                    PlantingAreaRequired = '$this->planting_area', Image = '$this->image' 
                    WHERE PlantId = $this->plant_id ";
            
            mysqli_query($dbc, $query)
	                or die('Error querying database');
	                    
	        mysqli_close($dbc);
        }       
        
        //function to insert comment values into database from form
        public function insertHistoryDbInfo()
        {
            require_once('connectvars.php');
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $query = "INSERT INTO history_db (PlantId, UserId, Comment) 
                    VALUES ('$this->plant_id', '$this->user_id', '$this->comment')";

            mysqli_query($dbc, $query)
	                or die('Error querying database');
	                    
	        mysqli_close($dbc);
        }
        
        //query to retrieve plant related comment results
        public function retrievePlantCommentHistory($plant_id)
        {
            require_once('connectvars.php');
            
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $query = "SELECT * FROM history_db WHERE PlantId = $plant_id";
            
            $result = mysqli_query($dbc, $query)
                    or die('Error querying database');
            
 	        mysqli_close($dbc); 
 	        
 	        return $result;
        }
        
        //put comment query results into a table
        public function displayPlantCommentHistory($result)
        {
            echo('<table class="table table-bordered"><tr class="info"><th>Date</th><th>Comment</th></tr>');
                    
            while ($row = mysqli_fetch_array($result))
            {
                echo(' <tr class = "warning"><td>' . $row['Date'] .
                        '</td><td>' . $row['Comment'] .
                        '</td></tr>');
            }
            
            echo('</table>');
        }
        
    }
?>