
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vascommerse</title>
</head>
<body>
   @auth
        <p>{{ Auth::user()->name }}</p>
   @endauth
    <a href="{{ route('login') }}" class="btn btn-primary">LOGIN</a>
    <a href="{{ route('registerPage') }}" class="btn btn-primary">Register</a>
</body>
</html>
