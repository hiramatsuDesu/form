<?php
session_start();
?>

<!doctype html>

<html lang="en">

<head>
    <!--Required meta tags-->
    <meta charset = "utf-8">
    <title>Register</title>
</head>

<body>


<!--
    Make appropriate provisions and checks to prevent hacker attacks to thescript.
I added here some code for the captcha
-->
<?php
function text_str(){
    $str="abcdefghijklmnopqrxyz1234567890!)(/&%$#+-*.,;[]{}-_";
    $code="";
    for($i=0; $i<7; $i++){
        $code.=$str[rand(0, 51)];
    }
    return $code;
}

$_SESSION['captcha'] = text_str();

?>


<div class="container">

<h3>Sign Up</h3>

<form method="POST" action="form.php" name="form" enctype="multipart/formdata">

<!--name-->
<label for="name">First Name *</label></br>
<input type="text" name="name" minlength="3" maxlength="100" required /></br>

<!--lastname-->
<label for="lastname">Last Name *</label></br>
<input type="text" name="lastname" minlenght="3" maxlength="100" required /> </br>

<!--email will be the primary key for my data base-->
<label for="email">E-mail Address *</label></br>
<input type="email" name="email" title="It needs an E-mail valid" placeholder="your_email@example.com" required /><br>

<!--first password-->
<label for="password1">Password *<label></br>
<input type="password" name="pass1" minglength="6" maxlength="20" required /></br>

<!--second password in the bottom i will compare them-->
<label for="password2">Confirm Password *<label></br>
<input type="password" name="pass2" minglength="6" maxlength="20" required /></br>

<!--first address-->
<label for="address1">Address *</label></br>
<input type="text" name="address1" maxlength="150" required /></br>

<!--second address here I specify there is not necesary it's optional-->
<label for="address2">Address Complement</label></br>
<input type="text" name="address2" title="Optional"> Optional </br>

<!--thrid address here I specify there is no necesary it's optional-->
<label for="address3">Address Complement</label></br>
<input type="text" name="address3" title="Optional"> Optional </br>

<!--town-->
<label for="town">Town/City * </label></br>
<input type="text" name="town" required /> </br>

<!--I called "region" to avoid the confusion with country and county-->
<label for="region">County/Region * </label></br>
<input type="text" name="region" required /> </br>

<!--country-->
<label for="country">Country * </label></br>
<input type="text" name="country" required /> </br>


<!--this select has options like A, B or C or Other because I dont know the context but it can be changed-->
<label for="heard">Where heard... * </label></br>
<select name="heard" onchange="if(this.value=='Other') document.getElementById('other_heard').disabled = false" >
    <option value="a" selected >A</option>
    <option value="b">B</option>
    <option value="c">C</option>
    <option value="Other">Other</option>
</select>
<!--this will be available in the case option "other" be selected and the user will can write his response-->
<input type="text" name="other_option" id="other_heard" placeholder="Where did you heard about us..." disabled="disabled" required>
</br>

<!--the user will not be able to register unless this option is checked-->
<label for="terms"><input type="checkbox" name="terms" required />Accept Terms and Conditions * </label></br>


<h4>I am not a robot</h4>
<label>Plis resolve the captcha</label></br>

<!--here the user must resolve the captcha this provides more security to the site and prevents attacks from spam robots-->
<img src="captcha.php"></br>
<input type="text" name="code_captcha" required>Required</br>

<input type="submit" value="enviar"></br>

<p>All the items with (*) must be completed to continue</p>


<!--here in the bottom is the php code-->
<?php


//if post do this...
if($_POST){

    //if the passwords are the same do this
    if($_POST['pass1'] ==  $_POST['pass2'])
    {
        //I assign the variables from the form with the method POST
        $name_register=$_POST['name'];
        $last_name = $_POST['lastname'];
        $email_register = $_POST['email'];
        $pass_one = password_hash($_POST['pass1'], PASSWORD_DEFAULT, array('cost=>4'));
        $address_one = $_POST['address1'];
        $address_two = $_POST['address2'];
        $address_three = $_POST['address3'];
        $town_register = $_POST['town'];
        $region_register = $_POST['region'];
        $country_register = $_POST['country'];
        $selectOption = $_POST['heard'];
        $otherOption = $_POST['other_option'];

        //I made the connect with my data base in the local host
        $bd=mysqli_connect("localhost", "root", "", "practica")or exit("
        Error");

        //I check that there is no other user with the same email 
        $check_email=mysqli_query($bd, "SELECT email FROM register WHERE email ='$email_register' ");

        //if there is not another user with the same email I inser the dates at the table register in my data base 
        if($check_email){
            mysqli_query($bd, "INSERT INTO register VALUES('$name_register', '$last_name', '$email_register', '$pass_one', '$address_one', '$address_two', '$address_three', '$town_register', '$region_register', '$country_register', '$selectOption', '$otherOption')");

            //once the regitration is finish then the user is redirected to another page:"success.php"
            header("Location: success.php");
           
        }else{
            //If it is another user with the same email I warn at the user that must change his email 
            echo "Please change your email";
        }



    }
    else{
        // if the passwrord are not the same then the user is warned
        echo "The password are not same";
    }
}
?>


</form>

</div>

</body>

</html>