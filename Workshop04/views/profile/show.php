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
              <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?php echo e(profilePictureUrl($user['profile_picture'])); ?>" alt="Profile picture" class="rounded-circle img-thumbnail" style="width: 128px; height: 128px; object-fit: cover;">
              <?php else: ?>
                <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width: 128px; height: 128px; font-size: 48px;"><?php echo e(mb_strtoupper(mb_substr($user['username'], 0, 1))); ?></div>
              <?php endif; ?>
            </div>
            <dl class="row">
              <dt class="col-sm-4">Username</dt>
              <dd class="col-sm-8"><?php echo e($user['username']); ?></dd>
              <dt class="col-sm-4">Province</dt>
              <dd class="col-sm-8"><?php echo e($user['province_name'] ?? 'Not set'); ?></dd>
            </dl>
            <hr>
            <h5>Update your data</h5>
            <form action="<?php echo url('profile/update'); ?>" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" maxlength="50" value="<?php echo e($user['username']); ?>" required>
              </div>
              <div class="form-group">
                <label for="province_id">Province</label>
                <select class="form-control" id="province_id" name="province_id" required>
                  <option value="" disabled <?php echo $user['province_id'] === null ? 'selected' : ''; ?>>Select a province</option>
                  <?php foreach ($provinces as $province): ?>
                    <option value="<?php echo (int) $province['id']; ?>" <?php echo (int) $province['id'] === $user['province_id'] ? 'selected' : ''; ?>><?php echo e($province['name']); ?></option>
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
            <a href="<?php echo url('dashboard'); ?>" class="btn btn-link btn-block">Back to dashboard</a>
          </div>
        </div>
      </div>
    </div>
  </div>