<!-- Heading Row -->
<div class="row">
    <div class="col-sm-4">
        <img class="img-responsive img-rounded" src="<?= $assets_url ?><?= $question['thumb'] ?>" alt="">
    </div>
    <!-- /.col-md-8 -->
    <div class="col-sm-8">
        <h1>Найдите своё идеальное место в Таиланде </h1>
    </div>
    <!-- /.col-md-4 -->
</div>
<!-- /.row -->

<hr>

<!-- Content Row -->
<form action="<?= $base_url ?>quiz/result/1/rs/" method="post">
    <div class="row">
        <div class="col-md-12">
            <h2>1. Чтобы из еды вы хотели попробовать первым?</h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_1" />
                    <label for="q1_1">Традиционная тайская кухня </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_2" />
                    <label for="q1_2">Морепродукты </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_3" />
                    <label for="q1_3">Уличная кухня </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_4" />
                    <label for="q1_4">Салат из папайи (Сом Там) </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_5" />
                    <label for="q1_5">Дорогая изысканная кухня </label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>2. Как вы предпочитаете передвигаться? </h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_1" />
                    <label for="q2_1">Пешком </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_2" />
                    <label for="q2_2">На тук-туке </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_3" />
                    <label for="q2_3">На лодке </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_4" />
                    <label for="q2_4">На слоне </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_5" />
                    <label for="q2_5">На лимузине </label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>3. На что бы вы потратили большую часть времени? </h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_1" />
                    <label for="q3_1">На бары и ночные клубы </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_2" />
                    <label for="q3_2">На посещение храмов </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_3" />
                    <label for="q3_3">На кабаре </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_4" />
                    <label for="q3_4">На отдых в местной кофейне </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_5" />
                    <label for="q3_5">На дайвинг</label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>4. Ваше любимое место для шопинга? </h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_1" />
                    <label for="q4_1">Рынок выходного дня (Ночной рынок) </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_2" />
                    <label for="q4_2">Плавучий рынок </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_3" />
                    <label for="q4_3">Торговый центр </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_4" />
                    <label for="q4_4">Винтажный магазин </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_5" />
                    <label for="q4_5">Онлайн-магазин </label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>5. Где бы вы хотели остановиться? </h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_1" />
                    <label for="q5_1">В храме </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_2" />
                    <label for="q5_2">В лагере </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_3" />
                    <label for="q5_3">В пятизвездочном отеле </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_4" />
                    <label for="q5_4">В небольшом доме с верандой </label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_5" />
                    <label for="q5_5">У друга </label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12 text-center">
            <input type="submit" class="btn btn-info" value="Submit Answers">
        </div>
    </div>
</form>