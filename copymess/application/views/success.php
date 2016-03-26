<link rel="stylesheet" href="<?php echo base_url("css/bootstrap.min.css"); ?>">
<div class="alert alert-success">
    The Account Has Created Successfully. Please Check Your Mail<br/>
    <a href="<?php echo base_url(); ?>">Login Page</a>
</div>

<?php
function sendMail() {
// multiple recipients
    $to  = 'jaidul26@gmail.com'; // note the comma

// subject
    $subject = 'Birthday Reminders for August';

// message
    $message = '
	<html>
	<head>
	  <title>Birthday Reminders for August</title>
	</head>
	<body>
	  <p>Here are the birthdays upcoming in August!</p>
	  <table>
	    <tr>
	      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
	    </tr>
	    <tr>
	      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
	    </tr>
	    <tr>
	      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
	    </tr>
	  </table>
	</body>
	</html>
	';

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
    $headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
    $headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
    $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

    // Mail it
    return mail($to, $subject, $message, $headers);
}

if(sendMail()) {
    echo 'Mail sent';
} else {
    echo 'OOPS!!';
}
?>