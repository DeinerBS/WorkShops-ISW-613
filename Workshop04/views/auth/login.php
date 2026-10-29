  <div class="container mt-5">
    <h1 class="text-center">Welcome to My Website</h1>
    <p class="text-center">This is a simple homepage created with PHP and Bootstrap.</p>
  </div>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Login</h4>
          </div>
          <div class="card-body">
            <?php renderAlert(); ?>
            <form action="<?php echo url('auth/authenticate'); ?>" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo e($rememberedUsername); ?>" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" <?php echo $rememberedUsername !== '' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="remember_me">Remember me</label>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <p class="text-center mt-3 mb-0">Don't have an account? <a href="<?php echo url('auth/register'); ?>">Sign up</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>