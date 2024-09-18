<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Welcome!</h1>
                <p class="card-text">You have been invited to create a password for your account.</p>
                <p class="card-text">Click the link below to set your password:</p>
                <a href="{{ $passwordCreationUrl }}" target="_blank" class="btn btn-primary">Create Password</a>
            </div>
        </div>
    </div>
</body>
</html>