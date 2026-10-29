<?php
  require_once __DIR__ . '/utils/auth.php';

  // The users list is only reachable with a valid, active session
  requireLogin();

  require_once __DIR__ . '/utils/database.php';
  require_once __DIR__ . '/utils/users.php';

  $users = getUsers($conn);
?>
 <?php require('inc/header.php') ?>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="display-4">Users</h1>
      <p class="lead">Users list</p>
      <hr class="my-4">
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Province</th>
          <th>Created at</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td scope="row"><?php echo (int) $user['id']; ?></td>
          <td><?php echo htmlspecialchars($user['username']); ?></td>
          <td><?php echo htmlspecialchars($user['province_name'] ?? 'Not set'); ?></td>
          <td><?php echo htmlspecialchars($user['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php require('inc/footer.php') ?>
