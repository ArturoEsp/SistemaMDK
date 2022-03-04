<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title-page') ?>&nbsp;-&nbsp;Sistema MDK</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!------------------>

    <!-- Styles CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/css/normalize.css">
    <link rel="stylesheet" href="<?= base_url() ?>/css/index.css">
    <link rel="stylesheet" href="<?= base_url() ?>/css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!---------------->

    <!-- JavaScript Packages -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>/js/methods-help.js"></script>
    <!------------------------->
</head>
<script>
    const base_url = '<?php echo base_url('/'); ?>';
</script>
<body>
    <?= $this->include('layouts/header') ?>
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>
</body>

</html>