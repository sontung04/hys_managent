<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
</head>
<body>
    <h2>Create</h2>
    <a href="#">Back</a>
    <form action="{{Route('calendar.store1')}}" method="post">
        @csrf
        <label for="Name">
            Title:
            <input type="text" name="title">
        </label><br><br>
        <label for="Description">
            Description:
            <input type="text" name="description">
        </label><br><br>
        <label for="Starttime">
            Starttime:
            <input type="datetime-local" name="starttime">
        </label><br><br>
        <label for="Endtime">
            Status:
            <input type="datetime-local" name="endtime">
        </label><br><br>
        <label for="Address">
            Address:
            <input type="text" name="address">
        </label><br><br>
        <label for="Formality">
            Formality:
            <input type="text" name="formality">
        </label><br><br>
        <label for="Area">
            Area:
            <input type="text" name="area">
        </label><br><br>
        <label for="Group_id">
            Group_id:
            <input type="text" name="group_id">
        </label><br><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>