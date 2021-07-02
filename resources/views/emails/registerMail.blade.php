<!DOCTYPE html>
<html>

<head>
    <title>Fotget password Confirmation</title>
</head>

<body>
    <p>You are registering an account under the name {{ $username }}</p>
    <p>To finish, please click on this link to verify: <a href="{{ $verificationURL }}">Verify link</a></p>
    <hr>
    <p>If you did not do this action, please ignore this email.</p>
</body>

</html>