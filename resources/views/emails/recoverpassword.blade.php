<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recover Password</title>
</head>
<body>
    <h1>Recover Your Password</h1>

    <p>Click on this link to recover your password:</p>
    <a href="{{ config('app.url', 'localhost') }}/newpassword/{{ $token }}">Recover Your Password</a>
    <p>If this isn't you, you can ignore this email.</p>
</body>
</html>
