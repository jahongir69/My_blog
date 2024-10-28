<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Tasdiqlash</title>
</head>
<body>
    <h1>Assalomu alaykum, {{ $user_name }}!</h1>
    <p>Emailingizni tasdiqlash uchun quyidagi havolani bosing:</p>
    <p>
        <a href="{{ $link }}">Emailni tasdiqlash</a>
    </p>
    <p>Agar havola ishlamasa, quyidagi URL manzilini brauzeringizga nusxalab joylashtiring:</p>
    <p>{{ $link }}</p>
</body>
</html>
