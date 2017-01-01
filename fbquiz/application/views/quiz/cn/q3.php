<!-- Heading Row -->
<div class="row">
    <div class="col-sm-4">
        <img class="img-responsive img-rounded" src="<?= $assets_url ?><?= $question['thumb'] ?>" alt="">
    </div>
    <!-- /.col-md-8 -->
    <div class="col-sm-8">
        <h1>Where is the right Temple for you to take a visit too…</h1>
    </div>
    <!-- /.col-md-4 -->
</div>
<!-- /.row -->

<hr>

<!-- Content Row -->
<form action="<?= $base_url ?>quiz/result/3/cn/" method="post">
    <div class="row">
        <div class="col-md-12">

        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12 text-center">
            <input type="submit" class="btn btn-info btn-lg" value="See your result">
        </div>
    </div>
</form>