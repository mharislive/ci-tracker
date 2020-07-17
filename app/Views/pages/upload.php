<?php
$session = session();
$message = "";
if ($session->getFlashdata('db_message')) {
    $message = $session->getFlashdata('db_message');
}
?>

<div class="container">

    <?= $message; ?>

    <form action="/upload" method="post" enctype="multipart/form-data">
        <!-- <label class="p-4 d-block btn btn-light">
             Upload a CSV file
             <input type="file" name="file" id="file" class="d-none">
         </label>-->


        <div class="form-group">
            <h3 class="mb-3">Upload CSV file</h3>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file">
                    <label class="custom-file-label" for="file">Choose file</label>
                </div>
            </div>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>

</div>