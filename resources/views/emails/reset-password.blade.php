<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Hai {{$mailData['name']}},</h1>
    <p>Since you have reset password request,</p>
    <p>Here is your new password for you to continue Login : </p>
    <p>Username : {{$mailData['username']}}</p>    
    <p>Password : <b>{{$mailData['password']}}</b></p>   
    <p>Thank you</p>
    <p>Admin</p>
</body>
</html>