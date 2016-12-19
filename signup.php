<?php

    //insert page header
    $page_title = 'Sign Up';
    require_once('header.php');
    require_once('connectvars.php');
    
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);    
    
    if (isset($_POST['submit']))
    {
        //grab profile data from the users POST
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
        
        if (!empty($username) && !empty($password1) && !empty($password2) && 
                ($password1 == $password2)) 
        {
            //verify username is not already taken
            $query = "SELECT * FROM user_db WHERE UserName = '$username'";
            $data = mysqli_query($dbc, $query);
            
            if (mysqli_num_rows($data) == 0)
            {
                //username is unique, so insert the data into database
                $query = "INSERT INTO user_db (UserName, Password)" .
                        "VALUES ('$username', SHA('$password1'))";
                        
                mysqli_query($dbc, $query);
                
                //confirm success with the user
                echo('<p>Your new account has been successfully created. You\'re now ready' . 
                        ' to log in and <a href="login.php">Log In</a></p>');
                        
                mysqli_close($dbc);
                exit();
            }
            else 
            {
                //an account already exists, so display error message
                echo('<p class="error">An account already exists for this username. ' . 
                        'Please use a different one.</p>');
                
                //clear username
                $username = "";
            }
        }
        else
        {
            //user did not enter all required information
            echo('<p class="error">You must enter all of the sign up data, ' . 
                    'including the desired password twice.</p>');
        }
    }
    
    mysqli_close($dbc);
?>

    <p>Please enter your username and desired password to sign up.</p>
    
    <form method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
        
        <fieldset>
            
            <legend>Registration Info</legend>
            
            <label for="username">Username:</label>
            <input type="text" name="username" id="username"
                    value="<?php if (!empty(username)) echo($username); ?>" /><br /><br />
                    
            <label for="password1">Password:</label>
            <input type="password" name="password1" id="password1" /><br /><br />
            
            <label for="password2">Password (retype):</label>
            <input type="password" name="password2" id="password2" /><br /><br />
        </fieldset>
        
        <br />
        <input type="submit" name="submit" value="Sign Up" />
    </form>

<?php
    //insert footer
    require_once('footer.php');
?>