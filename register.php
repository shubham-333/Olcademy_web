<?php
require_once "config.php";

$email = $password = $confirm_password = "";
$fullname = $gender = $dob = "";
$email_err = $password_err = $confirm_password_err = $fullname_err = $gender_err = $dob_err ="";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = trim($_POST['email']);
    // Check if email is empty
    if(empty(trim($_POST['email']))){
        $email_err = "Email cannot be blank";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        // Return Error - Invalid Email
        $email_err = "The email you have entered is invalid, please try again.";
    }
    else{
        $sql = "SELECT id FROM user_data WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set the value of param email
            $param_email = trim($_POST['email']);
            
            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_err = "This email is already registered"; 
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
    
    
    
    
    // Check for password
    if(empty(trim($_POST['password']))){
        $password_err = "Password cannot be blank";
        
    }
    elseif(strlen(trim($_POST['password'])) < 5){
        $password_err = "Password cannot be less than 5 characters";
    }
    else{
        $password = trim($_POST['password']);
    }
    
    // Check for confirm password field
    if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
        $password_err = "Passwords should match";
    }
    
    //check for fullname
    if(empty(trim($_POST['fullname']))){
        $fullname_err = "Full Name cannot be blank";
    }
    elseif(!preg_match("/^[a-zA-Z-' ]*$/",$fullname)) {
        $fullname_err = "Only letters and white space allowed in the Full Name";
    }
    else{
        $fullname = trim($_POST['fullname']);
    }
    
    //check for dob
    if(empty(trim($_POST['dob']))){
        $dob_err = "DOB cannot be blank";
    }
    else{
        $dob = trim($_POST['dob']);
    }
    
    //check for dob
    if(empty(trim($_POST['gender']))){
        $gender_err = "gender cannot be blank";
    }
    else{
        $gender = trim($_POST['gender']);
    }
    
    // If there were no errors, go ahead and insert into the database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($dob_err) && empty($gender_err))
    {
        $sql = "INSERT INTO user_data (fullname, email, password, dob, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, "sssss", $param_fullname, $param_email, $param_password, $param_dob, $param_gender);
            
            // Set these parameters
            $param_fullname = $fullname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_dob = $dob;
            $param_gender = $gender;
            
            
            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else{
                echo "Something went wrong... cannot redirect!";
            }
            //     mysqli_stmt_close($stmt);
            // }
            // else{
                //     echo "Prepare statement error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
        
        elseif(!empty($fullname_err)){
            echo '<div class="errormsg">'.$fullname_err.'</div>';//Display the error message
        }
        elseif(!empty($password_err)){
            echo '<div class="errormsg">'.$password_err.'</div>';//Display the error message
        }
        elseif(!empty($confirm_password_err)){
            echo '<div class="errormsg">'.$confirm_password_err.'</div>';//Display the error message
        }
        elseif(!empty($email_err)){
            echo '<div class="errormsg">'.$email_err.'</div>';//Display the error message
        }
        elseif(!empty($dob_err)){
            echo '<div class="errormsg">'.$dob_err.'</div>';//Display the error message
        }
        elseif(!empty($gender_err)){
            echo '<div class="errormsg">'.$gender_err.'</div>';//Display the error message
        }
        else{
            echo '<div class="errormsg"> " Something is wrong, Please check the info you have entered " </div>';//Display the error message
        }
        mysqli_close($conn);
    }
    
    ?>
    
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<!-- google fonts Lato -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

<title>Olcademy</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="home.html"><img src="img/logo.png" alt="Olcademy" width="200" height="45"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="home.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contactus.php">Contact Us</a>
            </li>
            
            
            
        </ul>
    </div>
</nav>


<div class="login-inner">  
    <div class="registration-div">
        <div class="logo"></div>
        <div class="title">Learning</div>
        <div class="sub-title">Made easy</div>
        <form action="" method="post">
        <div class="fields_r">
            <div class="form-group">
            <!-- <label for="fullname">Full Name</label> -->
            <div class="fullname">
                <svg class="svg-icon" viewBox="0 0 20 20">
					<path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
				</svg>
                <input type="text" name="fullname" id="fullname" placeholder="Full Name">
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
            <!-- <label for="inputPassword4">Password</label> -->
                <div class="password_r">
                    
                    <input type="password" name ="password" id="inputPassword4" placeholder="   Password">
                </div>
            </div>
            
            <div class="form-group col-md-6">
            <!-- <label for="inputPassword4">Confirm Password</label> -->
                <div class="password_r">
                    <input type="password" name ="confirm_password" id="inputPassword" placeholder="   Confirm Password">
                </div>
            </div>
            </div>
            <div class="form-group">
                <!-- <label for="email">E-mail</label> -->
            <div class="email_r">
                <svg class="svg-icon" viewBox="0 0 20 20">
					<path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
				</svg>
                <input type="text" id="email" name ="email" placeholder="E-mail">
            </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6" >
                    <label for="dob">Date of Birth</label>
                <div class="dob">
                    <!-- <label for="dob">Date of Birth</label> -->
                    <input type="date" class="form-control" id="dob" name ="dob" placeholder="  dd/mm/yy">
                </div>
                </div>
                <div class="form-group col-md-6" >
                    <label for="gender">Gender</label>
                <div class="gender">
                    
                    <select id="gender" class="form-control" name = "gender">
                        <option selected>Choose..</option>
                        <option>Female</option>
                        <option>Male</option>
                        <option>Others</option>
                    </select>
                </div>
                </div>
            </div>
            <button type="submit" class="button signin-button">Register</button>
        </div>
        </form>
    </div>   
</div>
    <!-- JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>