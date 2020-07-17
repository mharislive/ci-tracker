<?php
$validation = \Config\Services::validation();
$session = session();
$err = ['username' => '', 'password' => '', 'db_message' => ''];
if($session->getFlashdata('db_message')) {
    $err['db_message'] = "<div class='p-2 mb-2 bg-danger text-white'>{$session->getFlashdata('db_message')}</div>";
}

if ($validation->getError('username')) {
    $err['username'] = "<div class='text-danger'>{$validation->getError('username')}</div>";
}

if ($validation->getError('password')) {
    $err['password'] = "<div class='text-danger'>{$validation->getError('password')}</div>";
}

if (!isset($username)) {
    $username = "";
}
if (!isset($password)) {
    $password = "";
}
?>

<div class="center">
    <div class="card entry-form">
        <h5 class="card-header">Login</h5>
        <div class="card-body">
            <form method="post" action="/login">

                <?= csrf_field() ?>

                <?= $err['db_message']; ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" autocomplete="off" id="username" name="username"
                           value="<?= $username ?>">
                    <?= $err['username']; ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>">
                    <?= $err['password']; ?>
                </div>

                <div class="form-group d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Login</button>

                    <a href="/register">Go to register</a>
                </div>
            </form>
        </div>
    </div>
</div>