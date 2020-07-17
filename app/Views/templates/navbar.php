<?php
$session = session();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <a href="/" class="navbar-brand">Tracker</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto"></ul>

        <div class="btn-group navbar-nav">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                Account
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <!--<a href="/profile" class="dropdown-item" type="button">Profile</a>-->
                <?php if ($session->role === 'admin'): ?>
                    <a href="/upload" class="dropdown-item" type="button">Upload</a>
                <?php endif; ?>
                <a href="/logout" class="dropdown-item" type="button">Logout</a>
            </div>
        </div>
    </div>
</nav>