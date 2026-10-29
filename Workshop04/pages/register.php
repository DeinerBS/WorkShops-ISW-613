<?php
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/provinces.php';
require_once __DIR__ . '/../utils/messages.php';

$provinces = getProvinces($conn);
?>
<?php require_once 'common/header.php'; ?>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Sign up</h4>
          </div>
          <div class="card-body">
            <?php renderAlert(); ?>
            <form action="/actions/register.php" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" maxlength="50" required>
              </div>
              <div class="form-group">
                <label for="province_id">Province</label>
                <select class="form-control" id="province_id" name="province_id" required>
                  <option value="" disabled selected>Select a province</option>
                  <?php foreach ($provinces as $province): ?>
                    <option value="<?php echo (int) $province['id']; ?>"><?php echo htmlspecialchars($province['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Create account</button>
            </form>
            <p class="text-center mt-3 mb-0">Already have an account? <a href="/index.php">Log in</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'common/footer.php'; ?>
