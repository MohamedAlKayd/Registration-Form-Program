/*
Mohamed Mahmoud
*/

<html>
<body>
<?php

/*
Variables used in the program
*/
$mistake = "
<b>There is a mistake in your registration form, please fix it and submit again</b> <br/><br/>
Possible mistakes: <br/><br/>
Possible Error 1: First name section left empty <br/>
Possible Error 2: First name has characters other than letters and white spaces <br/>
Possible Error 3: Last name section left empty <br/>
Possible Error 4: Last name has characters other than letters and white spaces <br/>
Possible Error 5: Email address section left empty <br/>
Possible Error 6: Email address not a valid email address <br/>
Possible Error 7: Phone number section left empty <br/>
Possible Error 8: Book section left empty <br/>
Possible Error 9: Operating system section left empty <br/><br/>

<b>Your Mistake:</b> 
";
$error = ''; 
$firstname = '';
$lastname = '';
$email = '';
$phone = '';
$book = '';
$os = '';

/* 
 Function to clean the text
 Removes whitespace from left and right sides of the string
 Removes backslashes from the string
 Converts predefined characters to html entities
 Will return a cleaned string
*/

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

/*
Check if the condition variable is set or not
*/

if(isset($_POST["submit"]))
{

/* 
First Name
Error 1: First name section left empty
Error 2: First name has characters other than letters and white spaces
*/

 if(empty($_POST["firstname"]))
 {
  $error .= '<p><label class="text-danger">Please enter your First Name</label></p>';
 }
 else
 {
  $firstname = clean_text($_POST["firstname"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$firstname))
  {
   $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
  }
 }

/* 
Last Name
Error 3: Last name section left empty
Error 4: Last name has characters other than letters and white spaces
*/

 if(empty($_POST["lastname"]))
 {
  $error .= '<p><label class="text-danger">Please enter your last name</label></p>';
 }
 else
 {
    $lastname = clean_text($_POST["lastname"]);
    if(!preg_match("/^[a-zA-Z ]*$/",$lastname))
    {
      $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
    }
   }
 
/* 
Email Address
Error 5: Email address section left empty
Error 6: Email address not a valid email address
*/

 if(empty($_POST["email"]))
 {
  $error .= '<p><label class="text-danger">Please enter your email</label></p>';
 }
 else
 {
    $email = clean_text($_POST["email"]);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
     $error .= '<p><label class="text-danger">Invalid email format</label></p>';
    }
 }

 /* 
 Phone number 
 Error 7: Phone number section left empty
 */

 if(empty($_POST["phone"]))
 {
  $error .= '<p><label class="text-danger">Please enter your phone number</label></p>';
 }
 else
 {
  $phone = clean_text($_POST["phone"]);
 }

 /*
 Book
Error 8: Book section left empty
 */

 if($_POST["book"]=="----------------------------------------------------------")
 {
  $error .= '<p><label class="text-danger">Please choose a book you are interested in</label></p>';
 }
 else
 {
  $book = clean_text($_POST["book"]);
 }

 /*
 Operating System
Error 9: Operating system section left empty
 */

 if(empty($_POST["operatingsystem"]))
 {
  $error .= '<p><label class="text-danger">Please choose an operating system</label></p>';
 }
 else
 {
  $os = clean_text($_POST["operatingsystem"]);
 }

 /*
 If there are no Errors
 Open the CSV file and append the new registration to the end of the file
 */

if($error == '')
 {
  $file_open = fopen("mini4.csv", "a");
  $no_rows = count(file("mini4.csv"));
  
  if($no_rows > 1)
  {
   $no_rows = ($no_rows - 1) + 1;
  }

/* 
First Name
Last Name
Email Address
Phone Number
Book
Operating System
*/

  fwrite($file_open, $firstname);
  fwrite($file_open, ", ");
  fwrite($file_open, $lastname);
  fwrite($file_open, ", ");
  fwrite($file_open, $email);
  fwrite($file_open, ", ");
  fwrite($file_open, $phone);
  fwrite($file_open, ", ");
  fwrite($file_open, $book);
  fwrite($file_open, ", ");
  fwrite($file_open, $os);
  fwrite($file_open, "\r\n");

/* 
Reset all the variables 
Close the CSV File
Display the current contents of the CSV File on the screen
*/

  $error = '<label class="text-success">Thank you for filling the registration form</label>';
  $firstname = '';
  $lastname = '';
  $email = '';
  $phone = '';
  $book = '';
  $os = '';

  fclose($file_open);

  $fileread=fopen("mini4.csv", "r");
  while(1){
   if(feof($fileread)){
      return;
   }   
   echo fgets($fileread); 
   echo "<br/>";
  }
  fclose($fileread);
 }

/*
Show user their error
*/

else
 {
    echo $mistake;
    echo "<br/>";
    echo $error;
 }
}

/* 
End of the Program
*/

?>
</body>
</html>
