<?php
require_once "config.php";

$email = $name = $subject = "";
$message = $query = "";
$email_err = $name_err = $subject_err = $message_err = $query_err = "";

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
        $email = trim($_POST['email']);
    }
    
    
    //check for name
    if(empty(trim($_POST['name']))){
        $name_err = "Name cannot be blank";
    }
    elseif(!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $name_err = "Only letters and white space allowed in the Full Name";
    }
    else{
        $name = trim($_POST['name']);
    }
    
    //check for subject
    if(empty(trim($_POST['subject']))){
        $subject_err = "DOB cannot be blank";
    }
    else{
        $subject = trim($_POST['subject']);
    }
    
    //check for message
    if(empty(trim($_POST['message']))){
        $message_err = "message cannot be blank";
    }
    else{
        $message = trim($_POST['message']);
    }

    //check for query
    if(empty(trim($_POST['query']))){
        $query_err = "query cannot be blank";
    }
    else{
        $query = trim($_POST['query']);
    }
    
    // If there were no errors, go ahead and insert into the database
    if(empty($email_err) && empty($name_err) && empty($subject_err) && empty($message_err) && empty($query_err))
    {
        $sql = "INSERT INTO contactus (email, name, subject, message, query) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, "sssss", $param_email, $param_name, $param_subject, $param_message, $param_query);
            
            // Set these parameters
            $param_email = $email;
            $param_name = $name;
            $param_subject = $subject;
            $param_message = $message;
            $param_query = $query;
            
            
            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                echo "Your query has been submitted, Thank You for contacting us!";
            }
            else{
                echo "Something went wrong... Please try again!";
            }
            //     mysqli_stmt_close($stmt);
            // }
            // else{
                //     echo "Prepare statement error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
        
        elseif(!empty($email_err)){
            echo '<div class="errormsg">'.$email_err.'</div>';//Display the error message
        }
        elseif(!empty($name_err)){
            echo '<div class="errormsg">'.$name_err.'</div>';//Display the error message
        }
        elseif(!empty($subject_err)){
            echo '<div class="errormsg">'.$subject_err.'</div>';//Display the error message
        }
        elseif(!empty($message_err)){
            echo '<div class="errormsg">'.$message_err.'</div>';//Display the error message
        }
        elseif(!empty($query_err)){
            echo '<div class="errormsg">'.$query_err.'</div>';//Display the error message
        }
        else{
            echo '<div class="errormsg"> " Something is wrong, Please fill in all the details " </div>';//Display the error message
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
    <div class="contactus-div">
        <!-- <h3>Contact Us:</h3>
        <hr> -->
        <div class="logo"></div>
            <div class="title">Learning</div>
            <div class="sub-title">Made easy</div>
        <form action="" method="post">
        <div class="fields">
            <div class="form-row">
                <div class="form-group col-md-6">
                <div class="email_c">
                    <input type="text" class="form-control" name="email" id="fullname" placeholder="    E-mail">
                </div>
                </div>
                <div class="form-group col-md-6">
                <div class="fullname">
                    <input type="text" class="form-control" name ="name" id="name" placeholder="    Full Name">
                </div>
                </div>
            </div>
            <div class="form-group">
            <div class="subject">
                <input type="text" class="form-control" id="subject" name ="subject" placeholder="    Subject">
            </div>
            </div>
            <div class="form-group">
            <div class="message">
                <input type="text" class="form-control" id="message" name ="message" placeholder="    Message">
            </div>
            </div>
            <div class="form-group">
            <div class="query">
                <input type="text" class="form-control" id="query" name ="query" placeholder="    Query">
            </div>
            </div>
            <button type="submit" class="button signin-button">Submit</button>
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

