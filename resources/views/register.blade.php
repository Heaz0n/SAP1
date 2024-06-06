<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form method="POST" action="/api/register">
        @csrf
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="birthday">Birthday:</label>
        <input type="date" name="birthday" id="birthday">
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
