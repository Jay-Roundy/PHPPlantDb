<?php
    $page_title = "Comments";
    require_once('header.php');
    require_once('PlantDb.php');
	require_once('startsession.php');
	require_once('connectvars.php');
	
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
	
	$plant_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    //check for user comment submission
    if ($_POST['submit'])
    {
        //connect to database
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
        
        //set comment/history variables
        $entry = mysqli_real_escape_string($dbc, trim($_POST['comment']));
        $plant_id = mysqli_real_escape_string($dbc, trim($_POST['plantId']));
        
        if (!empty($entry))
        {
            $plant_comment = new PlantDb();
            $plant_comment->setPlantId($plant_id);
            $plant_comment->setUserId($user_id);
            $plant_comment->setComment($entry);
            
            //insert comment into history db
            $plant_comment->insertHistoryDbInfo();
            
            //clear entry but leave plant and user id to show comments 
            $entry='';
            
            echo('<p>Your entry was submitted!</p>');
        }
        else
        {
            echo('<p>You must enter a comment!</p>');    
        }
    }
?>

<form name="comment" id="comment" method="post" role="form"
        class="form-bordered" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                
    <legend for="comment">Enter your comment:</legend>
    <textarea name="comment" id="comment" class="input-xxlarge" rows="3" style="background-color:lightblue"
            value="<?php if (!empty($entry)) echo $entry; ?>" /></textarea><br />

    <input type="hidden" name="plantId" id="plantId" 
            value="<?php if (!empty($plant_id)) echo $plant_id; ?>" />

    <input type="hidden" name="userId" id="userId" 
            value="<?php if (!empty($user_id)) echo $user_id; ?>" />

    <input type="submit" name="submit" id="submit" class="btn-primary" />
</form>

<?php
    
    //show comments for plant from history db
    $comments = new PlantDb();
    
    $comment_result = $comments->retrievePlantCommentHistory($plant_id);
    
    $comments->displayPlantCommentHistory($comment_result);

    require_once('footer.php');
?>