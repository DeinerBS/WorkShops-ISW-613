<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="navId">
    <li class="nav-item">
      <a href="/pages/dashboard.php" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item">
      <a href="/pages/profile.php" class="nav-link">Profile</a>
    </li>
    <li class="nav-item">
      <a href="/users.php" class="nav-link active">Users</a>
    </li>
    <li class="nav-item">
      <form action="/actions/logout.php" method="POST" class="m-0">
        <button type="submit" class="nav-link btn btn-link">Logout</button>
      </form>
    </li>
  </ul>
