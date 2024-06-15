<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route ('payment')}}" method="POST">
        @csrf
        <input  type="text" name="amount" value="1000">
        <input  type="text" name="course_id" value="9c497121-8194-405e-ba86-44f6c0409ada">
        <input  type="text" name="teacher_id" value="9c497121-7ff2-44c5-8b44-082f3e2cd8e2">
        <button type="submit">
            click me
        </button>
    </form>
</body>
</html>