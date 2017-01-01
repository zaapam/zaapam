<!-- Heading Row -->
<div class="row">
    <div class="col-sm-4">
        <img class="img-responsive img-rounded" src="<?= $assets_url ?><?= $question['thumb'] ?>" alt="">
    </div>
    <!-- /.col-md-8 -->
    <div class="col-sm-8">
        <h1>Find your perfect destination in Thailand</h1>
    </div>
    <!-- /.col-md-4 -->
</div>
<!-- /.row -->

<hr>

<!-- Content Row -->
<form action="<?= $base_url ?>quiz/result/1/en/" method="post">
    <div class="row">
        <div class="col-md-12">
            <h2>1. What would be the first thing you’d want to eat once you landed?</h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_1" value="1" />
                    <label for="q1_1">Traditional Thai Food</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_2" value="2" />
                    <label for="q1_2">Fresh Seafood</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_3" value="3" />
                    <label for="q1_3">Street Food</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_4" value="4" />
                    <label for="q1_4">Som Tam</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q1" id="q1_5" value="5" />
                    <label for="q1_5">Fine Dining</label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>2. How do you prefer to travel around?</h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_1" value="1" />
                    <label for="q2_1">Walking</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_2" value="2" />
                    <label for="q2_2">Tuk Tuk</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_3" value="3" />
                    <label for="q2_3">Boat</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_4" value="4" />
                    <label for="q2_4">Elephant</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q2" id="q2_5" value="5" />
                    <label for="q2_5">Limousine</label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>3. What would you really like to do with your time here?</h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_1" value="1" />
                    <label for="q3_1">Partying at a nightclub</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_2" value="2" />
                    <label for="q3_2">Visiting temples & palaces</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_3" value="3" />
                    <label for="q3_3">Watching a cabaret show</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_4" value="4" />
                    <label for="q3_4">Relaxing at a local coffee shop</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q3" id="q3_5" value="5" />
                    <label for="q3_5">Diving</label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>4. Your favourite spot for shopping?</h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_1" value="1" />
                    <label for="q4_1">Night Market</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_2" value="2" />
                    <label for="q4_2">Floating Market</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_3" value="3" />
                    <label for="q4_3">Luxury Mall</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_4" value="4" />
                    <label for="q4_4">Vintage Store</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q4" id="q4_5" value="5" />
                    <label for="q4_5">Online</label>
                </div>
            </div>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <h2>5. Where would you like to stay?</h2>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_1" value="1" />
                    <label for="q5_1">Temple</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_2" value="2" />
                    <label for="q5_2">At a random camp</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_3" value="3" />
                    <label for="q5_3">5-star Hotel</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_4" value="4" />
                    <label for="q5_4">Bungalow</label>
                </div>
                <div class="funkyradio-success">
                    <input type="radio" name="q5" id="q5_5" value="5" />
                    <label for="q5_5">Friend’s place</label>
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