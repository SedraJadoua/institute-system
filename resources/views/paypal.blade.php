<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Form</title>
</head>
<body>
    <form action="{{ route('charge') }}" method="post">
        @csrf
        <div>
            <label for="amount">Amount:</label>
            <input type="float" id="amount" name="amount" required>
        </div>
        <div>
            <input id="course_teacher_id" name="course_teacher_id"
             value="9c7d0ad0-a43d-4e83-a8ae-90b59d92522a">
        </div>
        <div>
            <input  id="student_id" name="student_id" 
            value="9c7d0ad1-41f5-4e98-a337-5f427dcc64ae">
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
