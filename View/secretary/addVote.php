<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Vote</title>
</head>
<body>
    <form action="/submit_vote" method="post">
        <label for="id">ID:</label><br>
        <input type="number" id="id" name="id" required><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" maxlength="64" required><br>
        <label for="startdate">Start Date:</label><br>
        <input type="datetime-local" id="startdate" name="startdate" required><br>
        <label for="enddate">End Date:</label><br>
        <input type="datetime-local" id="enddate" name="enddate" required><br>
        <label for="question">Question:</label><br>
        <input type="text" id="question" name="question" maxlength="256" required><br>
        <label for="answers_id">Answers ID:</label><br>
        <input type="number" id="answers_id" name="answers_id" required><br>
        <label for="quorum_id">Quorum ID:</label><br>
        <input type="number" id="quorum_id" name="quorum_id" required><br>
        <label for="vote_type_id">Vote Type ID:</label><br>
        <input type="number" id="vote_type_id" name="vote_type_id" required><br>
        <label for="majority_id">Majority ID:</label><br>
        <input type="number" id="majority_id" name="majority_id" required><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>