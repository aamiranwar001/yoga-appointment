<?php
    $errors = [];
    if (session()->has('errors'))
    {
        $errors = session('errors');
    }
?>
<!doctype html>
<html lang="en" >
  <head>
      <style>
      
      </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url('css/views/register.css') ?>" >
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" >

    <title>Sign in!</title>
  </head>
  <body class="bg"
  <div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    Sign in!
                </div>
                <div class="card-body">
                <form role="form" action="<?= base_url('login') ?>" method="POST">
            
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control form-control-lg <?= array_key_exists('email', $errors) ? 'is-invalid' : '' ?>" placeholder="Email Address" value="<?= old('email') ?>">
                <?php if(array_key_exists('email', $errors)) : ?>
                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                <?php endif ?>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control form-control-lg <?= array_key_exists('password', $errors) ? 'is-invalid' : '' ?>" placeholder="Password" value="<?= old('password') ?>">
                <?php if(array_key_exists('password', $errors)) : ?>
                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                <?php endif ?>
            </div>
        
            
            <input type="submit" value="Login" class="btn btn-info btn-block">
        
        </form>
                </div>
            </div>
        
        </div>
    </div>
</div>

    <script src="<?= base_url('js/jquery-3.5.1.slim.min.js') ?>" > </script>
    <script src="<?= base_url('js/popper.min.js') ?>" ></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    
  </body>
</html>