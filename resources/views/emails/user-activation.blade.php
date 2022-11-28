<!DOCTYPE html>
<html>
<head>
    <title>User Activation</title>
</head>
<body>
    <h1>Hai {{$mailData['name']}},</h1>
    <p>Since you have registered to the system</p>
    <p>Here is your credentials for you to continue Login : </p>
    <p>Username : <b>{{$mailData['username']}}</b></p>    
    <p>Password : <b>{{$mailData['password']}}</b></p>   
    <p>Thank you</p>
    <p>Admin</p>
</body>
</html>