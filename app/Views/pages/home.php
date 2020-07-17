<?php
$validation = \Config\Services::validation();
$err = ['search' => ''];

if ($validation->getError('search')) {
    $err['search'] = "<div class='text-danger'>{$validation->getError('search')}</div>";
}

if (!isset($search)) {
    $search = "";
}
?>
<div class="container">

    <form action="/" method="post" class="mb-5">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter phone number" name="search"
                   value="<?= $search; ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
        <?= $err['search']; ?>
    </form>


    <?php if (isset($result)): ?>
        <?php if (count($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Email</th>
                        <th scope="col">Note</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['address'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['note'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <h3>No data found.</h3>
        <?php endif; ?>

    <?php endif; ?>

</div>
