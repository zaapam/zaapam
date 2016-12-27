<!DOCTYPE html>
<html>

<head>
    <?= $layout_meta ?>
</head>

<body>
    <!-- Page Content -->
    <div class="container">

        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-4">
                <img class="img-responsive img-rounded" src="http://placehold.it/900x350" alt="">
            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-8">
                <h1><?= $question ?></h1>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        <hr>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 text-center">
                <h2><?= $info['title'] ?></h2>
                <img src="<?= $img_src ?>" class="img-fluid" alt="Responsive image">
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <div class="row" style="padding-top: 20px;">
            <div class="col-md-12 text-center">
                <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Share Facebook</a>
            </div>
        </div>

        <?= $layout_footer ?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="/a/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/a/js/bootstrap.min.js"></script>
</body>

</html>