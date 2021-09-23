
<!DOCTYPE html>
<title>Food Restaurant</title>
<body>
	
<p>Dear {{ $details->name }}</p>
<p>Your account has been created <b> {{$details['email']}} </b> on <b style="color:red;"> Food Restaurant </b> , please enter the verification code .</p>

<p>Verification code : <b> {{$details->verifyUser->token}} </b></p>
<p>Thanks</p>

</body>

</html> 