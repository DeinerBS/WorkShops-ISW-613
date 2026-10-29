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
          <td><?php echo e($user['username']); ?></td>
          <td><?php echo e($user['province_name'] ?? 'Not set'); ?></td>
          <td><?php echo e($user['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>