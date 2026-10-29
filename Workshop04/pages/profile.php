<?php
require_once __DIR__ . '/../utils/auth.php';

// The profile is only reachable with a valid, active session
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/provinces.php';
require_once __DIR__ . '/../utils/messages.php';
require_once __DIR__ . '/../utils/profile_pictures.php';

$provinces = getProvinces($conn);
?>
<?php require_once 'common/header.php'; ?>
<body>
  <?php require_once __DIR__ . '/common/nav.php'; ?> 
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Profile</h4>
          </div>
          <div class="card-body">
            <?php renderAlert(); ?>
            <div class="text-center mb-3">
              <?php if (!empty($_SESSION['profile_picture'])): ?>
                <img src="<?php echo htmlspecialchars(profilePictureUrl($_SESSION['profile_picture']), ENT_QUOTES, 'UTF-8'); ?>" alt="Profile picture" class="rounded-circle img-thumbnail" style="width: 128px; height: 128px; object-fit: cover;">
              <?php else: ?>
                <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width: 128px; height: 128px; font-size: 48px;"><?php echo htmlspecialchars(mb_strtoupper(mb_substr($_SESSION['username'], 0, 1))); ?></div>
              <?php endif; ?>
            </div>
            <dl class="row">
              <dt class="col-sm-4">Username</dt>
              <dd class="col-sm-8"><?php echo htmlspecialchars($_SESSION['username']); ?></dd>
              <dt class="col-sm-4">Province</dt>
              <dd class="col-sm-8"><?php echo htmlspecialchars($_SESSION['province_name'] ?? 'Not set'); ?></dd>
            </dl>
            <hr>
            <h5>Update your data</h5>
            <form action="/actions/update_profile.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" maxlength="50" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="province_id">Province</label>
                <select class="form-control" id="province_id" name="province_id" required>
                  <option value="" disabled <?php echo $_SESSION['province_id'] === null ? 'selected' : ''; ?>>Select a province</option>
                  <?php foreach ($provinces as $province): ?>
                    <option value="<?php echo (int) $province['id']; ?>" <?php echo (int) $province['id'] === $_SESSION['province_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($province['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="profile_picture">Profile picture</label>
                <input type="file" class="form-control-file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/gif,image/webp">
                <small class="form-text text-muted">Optional. JPG, PNG, GIF or WEBP, up to 2 MB. Leave empty to keep your current picture.</small>
              </div>
              <p class="text-muted small mb-2">Leave the password fields empty to keep your current password.</p>
              <div class="form-group">
                <label for="current_password">Current password</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
              </div>
              <div class="form-group">
                <label for="new_password">New password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" minlength="8">
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm new password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Save changes</button>
            </form>
            <a href="/pages/dashboard.php" class="btn btn-link btn-block">Back to dashboard</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'common/footer.php'; ?>
