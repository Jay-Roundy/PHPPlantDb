<?php
    require_once('connectvars.php');

    // Start the session
    session_start();

    // Clear the error message
    $error_msg = "";

    // If the user isn't logged in, try to log them in
    if (!isset($_SESSION['user_id'])) 
    {
        if (isset($_POST['submit'])) 
        {
            // Connect to the database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Grab the user-entered log-in data
            $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

            //check for a name and password and query the user db
            if (!empty($user_username) && !empty($user_password)) 
            {
                $query = "SELECT UserId, UserName FROM user_db " . 
                " WHERE UserName = '$user_password' AND Password = SHA('$user_password')";
            
                $data = mysqli_query($dbc, $query);
            
                mysqli_close($dbc);
                
                if (mysqli_num_rows($data) == 1) 
                {
                    //set session and cookies, the redirect to admin page
                    $row = mysqli_fetch_array($data);
                    $_SESSION['user_id'] = $row['UserId'];
                    $_SESSION['username'] = $row['UserName'];
                    setcookie('user_id', $row['UserId'], time() + (60 * 60 * 24 * 30));        // expires in 30 days
                    setcookie('username', $row['UserName'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
                    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                    header('Location: ' . $home_url);
                }
                else
                {
                    // The username/password are incorrect so set an error message
                    $error_msg = 'Sorry, you must enter a valid username and password to log in.';
                }
            }
            else 
            {
                // The username/password weren't entered so set an error message
                $error_msg = 'Sorry, you must enter your username and password to log in.';
            }
        }
    }
?>

<?php
    
    //insert page header
    require_once('header.php');
    
    // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
    if (empty($_SESSION['user_id'])) 
    {
        echo '<p class="error">' . $error_msg . '</p>';
?>

    <form method="post" class="form form-bordered" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
        <fieldset>
    
            <legend class="text-info">Log In</legend>
            
            <div class="form-group">
                <label for="username" class="text-primary">Username:</label>
                <input type="text" name="username" id="username" class="btn-info"
                        value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
            </div>
            
            <div class="form-group">
                <label for="password" class="text-primary">Password:</label>
                <input type="password" name="password" id="password" class="btn-info"/>
            </div>
        </fieldset>
        
        <input type="submit" value="Log In" name="submit" class="btn-primary" />
    </form>

<?php
    }
    else 
    {
        // Confirm the successful log-in
        echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
    }
?>

<?php
    //insert footer
    require_once('footer.php');
?>