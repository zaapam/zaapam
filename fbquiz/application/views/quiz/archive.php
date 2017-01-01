<!DOCTYPE html>
<html>

<head>
    <?= $layout_meta ?>
</head>

<body>
<!-- Page Content -->
<div class="container-fluid">

    <!-- Page Header -->
    <div class="row">
        <div class="col-sm-6">
            <h1 class="">Funny Quiz
<!--                <small>Secondary Text</small>-->
            </h1>
        </div>
        <div class="col-sm-6">
            <?php for ($i=0 ; $i<count($support_langs) ; $i++) { ?>
                <a href="<?= $base_url ?>quiz/?lang=<?= $support_langs[$i] ?>" class="btn btn-circle btn-<?= $btn_colors[$i] ?> pull-right"><?= $support_langs[$i] ?></a>
            <?php } ?>
            <!--                <a href="#aboutModal" data-toggle="modal" data-target="#myModal" class="btn btn-circle btn-default pull-right">I</span></a>-->
            <!--                <a href="#aboutModal" data-toggle="modal" data-target="#myModal" class="btn btn-circle btn-info pull-right">R</span></a>-->
        </div>
    </div>
    <hr>
    <!-- /.row -->

    <!-- Projects Row -->
    <div class="row">
        <? foreach ($questions as $q) { ?>
        <div class="col-sm-4 portfolio-item">
            <a href="<?= $base_url ?>quiz/?q=<?= $q['id'] ?>&lang=<?= $lang ?>">
                <img class="img-responsive" src="<?= $assets_url ?><?= $q['thumb'] ?>" alt="">
            </a>
            <h3>
                <a href="<?= $base_url ?>quiz/?q=<?= $q['id'] ?>&lang=<?= $lang ?>"><?= $q[$lang] ?></a>
            </h3>
        </div>
        <? } ?>
    </div>
    <!-- /.row -->

    <hr>
    <?= $layout_footer ?>
</div>

<!-- jQuery -->
<script src="/a/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/a/js/bootstrap.min.js"></script>
</body>

</html>