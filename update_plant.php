<?php
    $page_title = "Enter Information";
    require_once('header.php');
    require_once('PlantDb.php');
    require_once('connectvars.php');
	require_once('startsession.php');
		
    //check for session logged in or out and give login option or finish page
    if (!isset($_SESSION['user_id'])) 
    {
        echo '<p class="login">Please <a href="login.php" alt="Please log in">Log In</a> to access this page.</p>';
        echo '<p class="login">Please <a href="signup.php" alt="Please sign up">Sign Up</a> to access this page.</p>';
        exit();
    }
    else 
    {
        echo('<p>You are logged in as ' . $_SESSION['username'] . 
            '. <a href="logout.php" alt="Log out of session">Log out</a>.</p>');
    }
    
    //retrieve plant id
    $plant_id = $_GET['id'];
    
    if(!empty($plant_id))
    {
        //set variables with db data to be updated
        $update_plant = new PlantDb();
        
        $update_plant->setPlantDbEntriesForUpdate($plant_id);
        
        $name = $update_plant->getPlantName();
        $scientific_name = $update_plant->getScientificName();
        $category = $update_plant->getCategory();
        $lifecycle = $update_plant->getLifeCycle();
        $frost_tolerance = $update_plant->getFrostTolerance();
        $image_check = $update_plant->getImage();
        $soil = $update_plant->getSoilPreference();
        $sun = $update_plant->getSunPreference();
        $water = $update_plant->getWaterPreference();
        $seed = $update_plant->getSeedPlanting();
        $area = $update_plant->getPlantingArea();
    }
    
    //check for form submission
    if ($_POST['submit'])
    {
        //connect to database
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
        
        //retrive and sanitize form entries
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
        $scientific_name = mysqli_real_escape_string($dbc, trim($_POST['scientific_name']));
        $category = mysqli_real_escape_string($dbc, trim($_POST['category']));
        $lifecycle = mysqli_real_escape_string($dbc, trim($_POST['lifecycle']));
        $frost_tolerance = mysqli_real_escape_string($dbc, trim($_POST['frost']));
        $image = mysqli_real_escape_string($dbc, trim($_FILES['image']['name']));
        $soil = mysqli_real_escape_string($dbc, trim($_POST['soil']));
        $sun = mysqli_real_escape_string($dbc, trim($_POST['sun']));
        $water = mysqli_real_escape_string($dbc, trim($_POST['water']));
        $seed = mysqli_real_escape_string($dbc, trim($_POST['seed']));
        $area = mysqli_real_escape_string($dbc, trim($_POST['area']));
        $image_check = $_POST['imageHolder'];
        $where_id = $_POST['rowId'];        
        
        //image type and size variables - checking image before setting variable
        require_once('imagevars.php');
        $image_type  = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];
        $image_temp = $_FILES['image']['tmp_name'];
        $image_error = $_FILES['file']['error'];
        
        //check form values for entries
        if (!empty($name) && !empty($scientific_name) && !empty($category) &&
                !empty($lifecycle) && !empty($frost_tolerance) &&
                !empty($soil) && !empty($sun) && !empty($water) &&
                !empty($seed) && !empty($area))
        {
            //check for image uploading error
            if (($image_error == 0) && ($image_size < GW_MAXFILESIZE) && (!empty($image)))
            {
                //move the file to upload folder
                if(!empty(GW_UPLOADPATH . $image))
                {
                    //use the original image
                    $target_image = $image_check;
                }
                else
                {
                    $target_image = GW_UPLOADPATH . $image;
                    if (move_uploaded_file($image_temp, $target_image))
                    {
                        echo('<p>Image uploaded ' . $target_image . '</p>');
                    }
                    else
                    {
                        echo('<p>Image Not uploaded</p>');
                    }                    
                }
            }
            else
            {
                //image was not set so use the original 
                $target_image = $image_check;
            }

            //initiate plantdb class
            $plant = new PlantDb();
            
            $plant->setPlantName($name);
            $plant->setScientificName($scientific_name);
            $plant->setCategory($category);
            $plant->setLifeCycle($lifecycle);
            $plant->setFrostTolerance($frost_tolerance);
            $plant->setImage($target_image);
            $plant->setSoilPreference($soil);
            $plant->setSunPreference($sun);
            $plant->setWaterPreference($water);
            $plant->setSeedPlanting($seed);
            $plant->setPlantingArea($area);
            $plant->setPlantId($where_id);
            
            echo($where_id . $image_check);
            $plant->updatePlantInfo();
               
            //reset form entries
            $name = "";
            $scientific_name = "";
            $category = "";
            $lifecycle = "";
            $frost_tolerance = "";
            $image = "";
            $soil = "";
            $sun = "";
            $water = "";
            $seed = "";
            $area = "";
            
            //redirect to page to avoid refresh resubmission *****
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
            header('Location: ' . $home_url);
            exit; 
        }
        else
        {
            echo('<p>Please enter all the information needed:' .
                    'If you are not sure just enter unknown</p>');
        }
    }
    else
    {
        //Not Submitted
    }
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="plant_form" 
        role="form" enctype="multipart/form-data">
        
    <label for="name">Common Name:</label>
    <input type="text" name="name" id="name" value="<?php if (!empty($name)) echo $name; ?>" />
    <br /><br />
        
    <label for="scientific_name">Scientific Name:</label>
    <input type="text" name="scientific_name" id="scientific_name" 
            value="<?php if (!empty($scientific_name)) echo $scientific_name; ?>" />
    <br /><br /> 
    
    <label for="category">Category:</label>
    <select name="category" id="category">
        <option value="vegetable" <?php if (!empty($category) && ($category == 'vegetable'))
                echo('selected="selected"'); ?>>Vegetable</option>
        <option value="fruit" <?php if (!empty($category) && ($category == 'fruit'))
                echo('selected="selected"'); ?>>Fruit</option>
        <option value="herb" <?php if (!empty($category) && ($category == 'herb'))
                echo('selected="selected"'); ?>>Herb</option>
        <option value="grain" <?php if (!empty($category) && ($category == 'grain'))
                echo('selected="selected"'); ?>>Grain</option>
        <option value="repellant" <?php if (!empty($category) && ($category == 'repellant'))
                echo('selected="selected"'); ?>>Pest Repellant</option>
        <option value="ornamental" <?php if (!empty($category) && ($category == 'ornamental'))
                echo('selected="selected"'); ?>>Ornamental</option>
        <option value="other" <?php if (!empty($category) && ($category == 'other'))
                echo('selected="selected"'); ?>>Other</option>
    </select>
    <br /><br />
        
    <label for="lifecycle">Lifecycle:</label>
    <select name="lifecycle" id="lifecycle">
        <option value="annual" <?php if (!empty($lifecycle) && ($lifecycle == 'annual'))
                echo('selected="selected"'); ?>>Annual</option>
        <option value="perennial" <?php if (!empty($lifecycle) && ($lifecycle == 'perennial'))
                echo('selected="selected"'); ?>>Perennial</option>
        <option value="biennial" <?php if (!empty($lifecycle) && ($lifecycle == 'biennial'))
                echo('selected="selected"'); ?>>Biennial</option>
        <option value="unknown" <?php if (!empty($lifecycle) && ($lifecycle == 'unknown'))
                echo('selected="selected"'); ?>>Unknown</option>
    </select>
    <br /><br />

    <label for="frost">Frost Tolerant:</label>
    <select name="frost" id="frost">
        <option value="yes" <?php if (!empty($frost_tolerance) && ($frost_tolerance == 'yes'))
                echo('selected="selected"'); ?>>Yes</option>
        <option value="mild" <?php if (!empty($frost_tolerance) && ($frost_tolerance == 'mild'))
                echo('selected="selected"'); ?>>Mild</option>
        <option value="no" <?php if (!empty($frost_tolerance) && ($frost_tolerance == 'no'))
                echo('selected="selected"'); ?>>No</option>
    </select>
    <br /><br />
    
    <label for="image">Image:</label>
    <input type="file" name="image" id="image" />
    <br />
    
    <input type="hidden" name="imageHolder" id="imageHolder" value="<?php if (!empty($image_check)) echo $image_check; ?>" />
    
    <input type="hidden" name="rowId" id="rowId" 
            value="<?php if (!empty($plant_id)) echo $plant_id; if((empty($plant_id)) && (!empty($where_id))) echo $where_id; ?>" />
    
    <label for="soil">Preferred Soil:</label>
    <input type="text" name="soil" id="soil" value="<?php if (!empty($soil)) echo $soil; ?>" />
    <br /><br />
        
    <label for="sun">Preferred Sun:</label>
    <input type="text" name="sun" id="sun" value="<?php if (!empty($sun)) echo $sun; ?>" />
    <br /><br />

    <label for="water">Preferred Water:</label>
    <input type="text" name="water" id="water" value="<?php if (!empty($water)) echo $water; ?>" />
    <br /><br />
    
    <legend for="seed">Seed Planting:</legend>
    <textarea type="textarea" name="seed" id="seed" class=""
            ><?php if (!empty($seed)) echo $seed; ?></textarea>
    <br /><br />
    
    <legend for="area">Planting Area/Size:</legend>
    <textarea name="area" id="area" class=""
            ><?php if (!empty($area)) echo $area; ?></textarea>
    <br /><br />
    
    <input type="submit" name="submit" class="btn-primary" />
    
</form>

<?php
    require_once('footer.php');
?>