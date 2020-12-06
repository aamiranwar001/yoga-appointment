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

    <title>Signup!</title>
  </head>
  <body class="bg"
<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    Signup!
                </div>
                <div class="card-body">
                    <form role="form" action="<?= base_url('register') ?>" method="POST">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="first_name" class="form-control form-control-lg <?= array_key_exists('first_name', $errors) ? 'is-invalid' : '' ?>" placeholder="First Name" value="<?= old('first_name') ?>">
                                    <?php if(array_key_exists('first_name', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="last_name" id="last_name" class="form-control form-control-lg <?= array_key_exists('last_name', $errors) ? 'is-invalid' : '' ?>" placeholder="Last Name" value="<?= old('last_name') ?>">
                                    <?php if(array_key_exists('last_name', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['last_name'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control form-control-lg <?= array_key_exists('email', $errors) ? 'is-invalid' : '' ?>" placeholder="Email Address" value="<?= old('email') ?>">
                            <?php if(array_key_exists('email', $errors)) : ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <input type="text" name="contact_number" class="form-control form-control-lg <?= array_key_exists('contact_number', $errors) ? 'is-invalid' : '' ?>" placeholder="Contact Number" value="<?= old('contact_number') ?>">
                            <?php if(array_key_exists('contact_number', $errors)) : ?>
                                <div class="invalid-feedback"><?= $errors['contact_number'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg <?= array_key_exists('password', $errors) ? 'is-invalid' : '' ?>" placeholder="Password" value="<?= old('password') ?>">
                                    <?php if(array_key_exists('password', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password_confirm" class="form-control form-control-lg <?= array_key_exists('password_confirm', $errors) ? 'is-invalid' : '' ?>" placeholder="Confirm Password" value="<?= old('password_confirm') ?>">
                                    <?php if(array_key_exists('password_confirm', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    
                        <input type="submit" value="Register" class="btn btn-info btn-block">
                
                    </form>
                    <div id="formFooter">
                    Already have account?
                        <a class="underlineHover" href="<?= base_url('login') ?>">Signin</a>
                    </div>
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


