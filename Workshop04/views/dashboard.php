  <div class="container mt-5">
    <h1 class="text-center">Welcome to My Website</h1>
    <p class="text-center">This is a simple homepage created with PHP and Bootstrap.</p>
  </div>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Dashboard</h4>
          </div>
          <div class="card-body">
            <p class="text-center">You are logged in as <strong><?php echo e($username); ?></strong>.</p>
            <a href="<?php echo url('profile'); ?>" class="btn btn-secondary btn-block mb-2">My profile</a>
            <a href="<?php echo url('courses'); ?>" class="btn btn-primary btn-block mb-2">Cursos</a>
            <form action="<?php echo url('auth/logout'); ?>" method="POST">
              <button type="submit" class="btn btn-danger btn-block">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>