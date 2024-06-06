<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="/api/login">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
