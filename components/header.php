<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beauty Store - <?php echo $pageTitle; ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="assets/images/favicon_io/site.webmanifest">
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/nav.css" />
    <link rel="stylesheet" href="assets/css/footer.css" /> <?php if (isset($additionalCss)) {
                                                                foreach ($additionalCss as $css) { ?>
            <link rel="stylesheet" href="<?php echo $css; ?>" />
    <?php }
                                                            } ?>
    <!-- Cart JS -->
    <script defer src="assets/js/cart.js"></script>
</head>

<body>