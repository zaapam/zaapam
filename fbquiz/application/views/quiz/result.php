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
            <div class="col-sm-4">
                <img class="img-responsive img-rounded" src="<?= $assets_url ?><?= $question['thumb'] ?>" alt="">
            </div>
            <!-- /.col-md-8 -->
            <div class="col-sm-8">
                <h1><?= $question[$lang] ?></h1>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        <hr>

        <div id="flash" class="row">

        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 text-center">
                <h2><?= $info['title'] ?></h2>
                <img src="<?= $assets_url ?><?= $img_src ?>" class="img-fluid" alt="Responsive image">
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row-->
        <div class="row" style="padding-top: 20px;">
            <div class="col-md-12 text-center">
                <a href="<?= $base_url ?>quiz/?lang=<?= $lang ?>" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Play Other Quiz</a>
                <a id="share-btn" href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Post to Facebook</a>
            </div>
        </div>

        <?= $layout_footer ?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?= $assets_url ?>js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= $assets_url ?>js/bootstrap.min.js"></script>
    <script>
        $( document ).ready(function() {

            $("#share-btn").click(function() {
                link = "<?= $link ?>";
                img = "<?= $picture ?>";
                caption = "<?= $caption ?>";
                title = "<?= $title ?>";

                $("#share-btn").addClass("deactive");
                $("#flash").html("<div class='alert alert-warning text-center'>Posting to Timeline</div>");

                $.post( "<?= $base_url ?>quiz/share/", { lang: "<?= $lang ?>", link: link, pic: img, title: title, caption: caption })
                    .done(function( data ) {
                        $("#flash").html("<div class='alert alert-success text-center'>Posted to Timeline </div>");
                        console.log( "Sent!" );
                    });
            });

            console.log( "ready!" );
        });
    </script>
</body>

</html>