<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/submitlogin" method="POST">
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            email:<input type="email" name="email" placeholder="Email" required>
            password:<input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </div>
    </form>
</body>

</html>

