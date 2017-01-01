<!DOCTYPE html>
<html>

<head>
    <?= $layout_meta ?>
</head>

<body>
    <!-- Page Content -->
    <div class="container-fluid">
        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-12">
                <?php for ($i=0 ; $i<count($support_langs) ; $i++) { ?>
                <a href="<?= $base_url ?>quiz/?q=<?= $q ?>&lang=<?= $support_langs[$i] ?>" class="btn btn-circle btn-<?= $btn_colors[$i] ?> pull-right"><?= $support_langs[$i] ?></a>
                <?php } ?>
<!--                <a href="#aboutModal" data-toggle="modal" data-target="#myModal" class="btn btn-circle btn-default pull-right">I</span></a>-->
<!--                <a href="#aboutModal" data-toggle="modal" data-target="#myModal" class="btn btn-circle btn-info pull-right">R</span></a>-->
            </div>

        </div>
        <!-- /.row -->
    <?= $content ?>
    <?= $layout_footer ?>
    </div>

    <!-- jQuery -->
    <script src="<?= $assets_url ?>js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= $assets_url ?>js/bootstrap.min.js"></script>
</body>

</html>