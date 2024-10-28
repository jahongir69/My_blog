<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notify</title>
</head>
<body>
   @foreach ($notify as $n)
   <p1>{{$n->data['message']}}</p1>
   @endforeach
</body>
</html>