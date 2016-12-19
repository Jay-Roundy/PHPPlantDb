<?php
    $page_title = "Main Page";
    require_once('header.php');
    require_once('startsession.php');
    require_once('PlantDb.php');
		
    //check for session logged in or out and give login option or finish page
    if (!isset($_SESSION['user_id'])) 
    {
        echo '<p class="login">Please <a href="login.php" alt="Please log in">Log In</a>.</p>';
    }
    else 
    {
        echo('<p>You are logged in as ' . $_SESSION['username'] . 
                '. <a href="logout.php" alt="Log out of session">Log out</a>.</p>');
    }
    
    /* display plant database entries with pagination */
    $tbl_name="plant_db";		//your table name
    
    // How many adjacent pages should be shown on each side?
    $adjacents = 1;
    
    /* Setup vars for query. */
    $targetpage = "index.php"; 	//your file name  (the name of this file)
    $limit = 1; 								//how many items to show per page
    $page = $_GET['page'];
    if($page) 
    	$start = ($page - 1) * $limit; 			//first item to display on this page
    else
    	$start = 0;								//if no page var is given, set start to 0

    //retrieve the number of records in db
    $plants = new PlantDb(); //declare class object
    $total_pages = $plants->countPlantDbEntries($tbl_name); //get total number of pages from db
    
    //run query to retrieve the result set with pagination start and limit conditions and table name
    $result = $plants->retrievePlantDbEntries($start, $limit, $tbl_name);
    
	//Setup page vars for display. 
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
    
    //set pagination
	$pagination = $plants->setPagination($lastpage, $targetpage, $prev, $adjacents, $page, $lpm1, $next);
	
	//display db table
	$plants->displayPlantDbEntries($result);
	
	//display pagination
	echo($pagination);
?>
    
<?php    
    require_once('footer.php');
?>