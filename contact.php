<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>	
	<link rel="icon"
		  type="image/png"
		  href="assets/favicon.png">
    <!-- Font selection  -  NOT A FRAMEWORK  -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'> 
	
    <!--  CSS Resets  -  NOT A FRAMEWORK  -->
    <link rel="stylesheet" href="css/resets.css">
    <link rel="stylesheet" href="css/style.css">
	<!-- Load an icon library to show a hamburger menu (bars) on small screens -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-YSS6TJYJXF"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-YSS6TJYJXF');
	</script>
	
    <meta charset="utf-8">
	<meta http-equiv=“Pragma” content=”no-cache”>
	<meta http-equiv=“Expires” content=”-1″>
	<meta http-equiv=“CACHE-CONTROL” content=”NO-CACHE”>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dan Shaw">
</head>
<body>  
<?php

//  define variables and set to empty values
$firstName = $lastName = $orgName = $phoneNum = $email = $comment = $fullName = $submitted = "";
$firstNameErr = $lastNameErr = $orgNameErr = $phoneNumErr = $emailErr = $commentErr = $areErrors = "";

// once the Mail Form is completed successfully, this is the page the user will be redirected to:
$thankYouPage = "thank_you.html";

if  ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstName"])) {
        $firstNameErr = "First name is required";
        $areErrors = TRUE;
    } else {
        $firstName = test_input($_POST["firstName"]);
        // check if firstName only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' .]*$/", ($_POST["firstName"]))) {
            $firstNameErr = "Only letters and whitespace allowed.";
            $areErrors = TRUE;
        }
    }

    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last name is required";
        $areErrors = TRUE;
    } else {
        $lastName = test_input($_POST["lastName"]);
        // check if lastName only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' .-]*$/", ($_POST["lastName"]))) {
            $lastNameErr = "Only letters and whitespace allowed";
            $areErrors = TRUE;
        }
    }

    $fullName = $firstName." ".$lastName;

    if (empty($_POST["orgName"])) {
        $orgName = "";
    } else {
        $orgName = test_input($_POST["orgName"]);
        // check if orgName only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9-' .]*$/", ($_POST["orgName"]))) {
            $orgNameErr = "Only letters and whitespace allowed";
            $areErrors = TRUE;
        }
    }

    if (empty($_POST["phoneNum"])) {
        $phoneNum = "";
    } else {
        $phoneNum = test_input($_POST["phoneNum"]);
        // check if phoneNum only contains numbers, -, .
        if (!preg_match("/(^(\+0?1\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$)/", ($_POST["phoneNum"]))) {
            $phoneNumErr = "Please enter a ten digit phone number";
            $areErrors = TRUE;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $areErrors = TRUE;
    } else {
        $email = test_input($_POST["email"]);
        // check if email address is well-formed
        if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $areErrors = TRUE;
        }
    }

    if (empty($_POST["comment"])) {
        $commentErr = "Reason for contacting is required";
        $areErrors = TRUE;
    } else {
        $comment = test_input($_POST["comment"]);
        // check to see if comment field contains only acceptable items ( whitespace, letters, numbers and: - ' . ! , ; " @ ( )  )
        if (!preg_match("/^[a-zA-Z0-9-' .:\!\,\;\"\@\(\)]*$/", ($_POST["comment"]))) {
            $commentErr = "Only whitespace, letters, numbers and: - ' . ! , ; \" @ ( )";
            $areErrors = TRUE;
        }
    }

    if (!$areErrors ) {
        $toEmail = 'help@ipe-ileaptoolkit.org';
        $emailSubject = 'TEST:  New email from your contant form';
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["Name: {$fullName}\n", "Oganization: {$orgName}\n", "Phone: {$phoneNum}\n", "Email: {$email}\n", "Message:, $comment\n"];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            $submitted = TRUE;
        }
        header("Location: thank_you.html");
        
    } else {
        $allareErrors = $areErrors;
        $redMessage = "<p style='color: red;'>{$allareErrors}: There are errors</p>";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div class="layout-container header">
	<div class="banner">
		<div class="container">
			<div class="logo flex-container flex-column box-logo">
				<img id="logo" src="assets\logo_banner_v3.svg" alt="logo">
			</div>
		</div>
	</div>
	<hr>
	<div class="nav">
		<div class="nav-menu container">
			<div  class="topnav" id="myTopnav">
				<ul class="flex-row">
					<li class="flex-row" id="nav-item-1"><a href="index.html">Home</a></li>
					<li class="flex-row" id="nav-item-2"><a href="doti.html">DOTI</a></li>
					<li class="flex-row" id="nav-item-3"><a href="site_readiness.html">Site Readiness</a></li>
					<li class="flex-row" id="nav-item-4"><a href="student_readiness.html">Student Readiness</a></li>
					<li class="flex-row" id="nav-item-5"><a href="facilitator_training.html">Facilitator Training</a></li>
					<li class="flex-row" id="nav-item-6"><a href="onsite_curriculum.html">Onsite Curriculum</a></li>
					<li class="flex-row" id="nav-item-7"><a href="evaluation.html">Evaluation</a></li>
					<li class="flex-row" id="nav-item-8"><a href="about.html">About</a></li>
					<li class="flex-row" id="nav-item-9"><a class="active" href="contact.php">Contact</a></li>
					<a href="javascript:void(0);" class="icon" onclick="myNavFunction()">
						<i class="fa fa-bars"></i></a>
				</ul>
			</div>
		</div>
	</div>
	<hr>
</div>
<div class="section layout-content">
	<div class="main container">
		<div class="contact-header flex-container">
			<div class="contact-header-text">
				<h1>Thanks for reaching out to us!</h1>
                <h2>Please let us know how we may assist you.</h2>
			</div>
		</div>
		<hr>
		<div class="flex-container contact-form">
			<p class="red">* DENOTES A REQUIRED FIELD</p>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div>
                    <div>
                        <label for="firstName">First Name: <span class="red">*</span><label>
                    </div>
                    <div>
                        <input type="text" name="firstName" value="<?php echo $firstName;?>">
                        <span class="red"> <?php echo $firstNameErr;?></span>
                    </div>
                    <br>
				</div>
				<div>
                    <div>
					    <label for="lastName">Last Name: <span class="red">*</span><label>
                    </div>
                    <div>
                        <input type="text" name="lastName" value="<?php echo $lastName;?>">
                        <span class="red"> <?php echo $lastNameErr;?></span>
                    </div>
                    <br>
				</div>
				<div>
                    <div>
					    <label for="orgName">Organization Name: <label>
                    </div>
                    <div>
                        <input type="text" name="orgName" value="<?php echo $orgName;?>">
					    <span class="red">  <?php echo $orgNameErr;?></span>
                    </div>
                    <br>
				</div>
				<div>
                    <div>
					    <label for="phoneNum">Phone: <label>
                    </div>
                    <div>
				    	<input type="text" name="phoneNum" value="<?php echo $phoneNum;?>">
				    	<span class="red">  <?php echo $phoneNumErr;?></span>                        
                    </div>
                    <br>
				</div>
				<div>
                    <div>                        
					    <label for="email">Email: <span class="red">*</span><label>
                    </div>
                    <div>
					    <input type="text" name="email" value="<?php echo $email;?>">
					    <span class="red"> <?php echo $emailErr;?></span>                        
                    </div>
                    <br>
				</div>
				<div>
                    <div>
				    	<label for="comment">Comment: <span class="red">*</span><label>                        
                    </div>
                    <div>
				    	<textarea name="comment" rows="5" cols="80" value="<?php echo $comment;?>"></textarea>
				    	<span class="red"> <?php echo $commentErr;?></span>                        
                    </div>
                    <br>
				</div>
				<div>	
					<input class="site-button" type="submit" name="submit" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="layout-container"><hr></div>

<div class="layout-container">
	<div class="footer container">
		<div class="footer-logo">
        <img src="assets\ILEAP_logo_tagline.svg" alt="The ILEAP Logo">
		</div>
		<div class="sponsors flex-container">
			<div class="sponsor1">
				<div class="flex-center"><img src="assets\CWRU_logo_stacked.svg" alt="The Case Western Reserve University logo."></div>
			</div>
			<div class="contact-us flex-center">
                <a href="contact.php"><span class="site-button">Contact Us!</span></a>
			</div>
			<div class="sponsor2">
				<div class="flex-center"><img src="assets\Macy_logo.png" alt="The Josiah Macy Jr. Foundation logo."></div>
			</div>
		</div>
		<div class="container">
		<!--	<div class="contact-us flex-center">
				<a href="" target="_blank"><span class="site-button">Contact Us!</span></a>
			</div>	-->
		</div>
	</div>
</div>

<script>

	/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
	function myNavFunction() {
	  var x = document.getElementById("myTopnav");
	  if (x.className === "topnav") {
	    x.className += " responsive";
	  } else {
    	x.className = "topnav";
  	  }
	}

</script>
</body>
</html>
