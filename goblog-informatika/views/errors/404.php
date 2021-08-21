<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />

    <?php if(isset($title)): ?>
        <title><?=$title?> | <?= $site_title; ?> Admin Panel</title>
        <?php else: ?>
            <title><?= $site_title; ?></title>
        <?php endif; ?>

        <meta name="keywords" content="<?= $site_keywords; ?>">
        <meta name="description" content="<?= $site_description; ?>">
        <meta name="author" content="<?= $site_author; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <meta property="og:locale" content="id_ID" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?= $url; ?>" />
        <meta property="og:site_name" content="<?= $site_name;?>" />
        <meta property="og:image" content="<?= base_url('assets/images/'.$site_favicon); ?>" />
        <meta property="og:image:secure_url" content="<?= base_url('assets/images/'.$site_favicon); ?>" />
        <meta property="og:image:width" content="560" />
        <meta property="og:image:height" content="315" />

        <link rel="shortcut icon" href="<?= base_url('assets/images/'.$site_favicon) ?>" type="image/x-icon" />
        <link rel="apple-touch-icon" href="<?= base_url('assets/images/'.$site_favicon) ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/error-404.css') ?>" />
    <link href="./assets/images/favicon.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body style="margin: 20vh;">
    <div class="container">
        <img class="ops" src="<?= base_url('assets/images/404.svg') ?>" />
        <br />
        <h3>Halaman yang Anda cari tidak ditemukan.
            <br /> Bisa jadi karena url tersebut salah atau tidak tersedia.</h3>
        <br />
        <a class="buton" href="javascript:history.back()">Kembali</a>
    </div>
</body>

</html>
