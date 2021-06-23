<!DOCTYPE html>
<html>

<head>
    <title>Register Account Confirmation</title>
</head>

<body>
    <p>We receive a request to retreive email in the account: {{ $username }}</p>
    <p>To finish, please click on this link to verify: <a href="{{ $verificationURL }}">Verify link</a></p>
    <hr>
    <p>If you did not do this action, please ignore this mail.</p>
</body>

</html>