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

    <title>New Appointment</title>
  </head>
  <body class="bgAppointment"
<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    Create Appointment!
                </div>
                <div class="card-body">
                    <form role="form" action="<?= base_url('createAppointment') ?>" method="POST">
                    <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">    
                                <div class="form-group">
                                    <input type="text" name="title" id="title" class="form-control form-control-lg <?= array_key_exists('title', $errors) ? 'is-invalid' : '' ?>" placeholder="Title" value="<?= old('title') ?>">
                                    <?php if(array_key_exists('title', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['title'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">    
                                <div class="form-group">
                                    <select name="tutor_id" id="tutor_id" class="form-control form-control-lg <?= array_key_exists('tutor_id', $errors) ? 'is-invalid' : '' ?>">
                                            <option value="1" selected>Ahmad</option>
                                            <option value="2">Aamir</option>
                                            <option value="3">Raza</option>
                                    </select>
                                    <?php if(array_key_exists('tutor_id', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['tutor_id'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <textarea rows="3" maxlength="512" name="description" id="description" 
                            class="form-control form-control-lg <?= array_key_exists('description', $errors) ? 'is-invalid' : '' ?>" 
                            placeholder="Write description..." value="<?= old('description') ?>"></textarea>

                            <?php if(array_key_exists('description', $errors)) : ?>
                                <div class="invalid-feedback"><?= $errors['description'] ?></div>
                            <?php endif ?>
                        </div>
            

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="date" name="date" id="date" class="form-control form-control-lg <?= array_key_exists('date', $errors) ? 'is-invalid' : '' ?>" placeholder="mm/dd/yyyy" value="<?= old('date') ?>">
                                    <?php if(array_key_exists('date', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['date'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <select name="time_slot" id="time_slot" class="form-control form-control-lg <?= array_key_exists('time_slot', $errors) ? 'is-invalid' : '' ?>">
                                        <option value="1" selected>09:00am-10:00am</option>
                                        <option value="2">10:00am-11:00am</option>
                                        <option value="3">11:00am-12:00pm</option>
                                        <option value="4">12:00pm-01:00pm</option>
                                        <option value="5">01:00pm-02:00pm</option>
                                        <option value="6">02:00pm-03:00pm</option>
                                        <option value="7">03:00pm-04:00pm</option>
                                        <option value="8">04:00pm-05:00pm</option>
                                        <option value="9">05:00pm-06:00pm</option>
                                        <option value="10">06:00pm-07:00pm</option>
                                        <option value="11">07:00pm-08:00pm</option>
                                        <option value="12">08:00pm-09:00pm</option>
                                    </select>
                                    <?php if(array_key_exists('time_slot', $errors)) : ?>
                                        <div class="invalid-feedback"><?= $errors['time_slot'] ?></div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        
                    
                        <input type="submit" value="Book" class="btn btn-info btn-block">
                
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


