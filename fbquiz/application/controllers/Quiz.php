<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'libraries/Facebook/autoload.php');

class Quiz extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public $questionLang = array(
        array("AR", "CN", "EN", "JP", "RS"),
        array("AR", "CN", "EN"),
        array("CN", "EN", "JP", "RS"),
    );

    public $langQuestion = array(
        "en" => array('q1', 'q2', 'q3'),
        "ar" => array('q1', 'q2'),
        "cn" => array('q1', 'q2', 'q3'),
        "jp" => array('q1', 'q3'),
        "rs" => array('q1', 'q3'),
    );

    public $buttonClass = array("default", "primary", "success", "info", "warning", "danger");
    private $fb;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');

        session_start();
        $this->fb = $fb = new Facebook\Facebook([
            'app_id' => '746616388822438',
            'app_secret' => '70ee0bddaba5f6daf7e79fadaf6bf530',
            'default_graph_version' => 'v2.2',
        ]);
    }

    private function requireFBLogin($q, $lang) {


//        $helper = $fb->getRedirectLoginHelper();
//
//        $permissions = ['email']; // Optional permissions
//        $loginUrl = $helper->getLoginUrl('https://www.zaapam.com/fbquiz/quiz/1/en/', $permissions);
//        echo $loginUrl;
//        exit();

        $result = array();
        $helper = $this->fb->getCanvasHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            //echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
            //exit;
            $helper = $this->fb->getRedirectLoginHelper();
            $permissions = ['email', 'publish_actions'];
            $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/746616388822438/?q=' . $q . '&lang=' . $lang, $permissions);
            echo "<script>window.top.location = '" . $loginUrl . "'</script>";
            exit();
        } else {
            // Logged in
            $result['signed_request'] = $helper->getSignedRequest();
            $result['access_token'] = $accessToken->getValue();
        }

        return $result;
    }

    function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = "70ee0bddaba5f6daf7e79fadaf6bf530"; // Use your app secret here

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

//    public function index($arg1)
//    {
//        echo $arg1;
//        exit();
//
//        $this->load->view('welcome_message');
//    }

    public function index() {

        //print_r($this->load->view('layouts/meta'));
        //exit();

        $q = ($_GET['q']) ? $_GET['q'] : 0;
        $lang = ($_GET['lang']) ? strtolower($_GET['lang']) : 'en';
//        $signed_request = $_POST['signed_request'];
//        $fb_params = $this->parse_signed_request($signed_request);
//        setcookie('access_token', $fb_params['oauth_token'], 0, "/");

        //echo "Hello";
        //print_r($fb_params);
        //exit();

        $token = $this->requireFBLogin($q, $lang);
        setcookie('access_token', $token['access_token'], 0, "/");

        $base_url = $this->config->item('base_url');
        $assets_url = $this->config->item('assets_url');

        if ($q == 0) {
            $langs = $this->questionLang[0];
            $index = array_search($lang, $langs);
            array_splice($langs, $index, 1);

            $questions = array();
            foreach ($this->langQuestion[$lang] as $r) {
                $questions[] = $this->getQuestionInfo($r);
            }

            $data = array(
                "base_url" => $base_url,
                "assets_url" => $assets_url,
                "layout_meta" => $this->load->view('layouts/meta', array("assets_url" => $assets_url), TRUE),
                "layout_footer" => $this->load->view('layouts/footer', array("assets_url" => $assets_url), TRUE),
                "questions" => $questions,
                "lang" => $lang,
                "support_langs" => $langs,
                "btn_colors" => $this->buttonClass,
            );

            $this->load->view('quiz/archive', $data);
        } else {
            $langs = $this->questionLang[$q - 1];
            $index = array_search($lang, $langs);
            array_splice($langs, $index, 1);
            $info = $this->getQuestionInfo("q" . $q);

            $data = array(
                "base_url" => $base_url,
                "assets_url" => $assets_url,
                "layout_meta" => $this->load->view('layouts/meta', array("assets_url" => $assets_url), TRUE),
                "layout_footer" => $this->load->view('layouts/footer', array("assets_url" => $assets_url), TRUE),
                "content" => $this->load->view('quiz/' . $lang . '/q' . $q, array("base_url" => $base_url, "question" => $info), TRUE),
                "q" => $q,
                "lang" => $lang,
                "support_langs" => $langs,
                "btn_colors" => $this->buttonClass,
            );

            $this->load->view('quiz/index', $data);
        }

    }

    public function share() {
        $lang = $_POST['lang'];
        $link = $_POST['link'];
        $picture = $_POST['pic'];
        $caption = $_POST['caption'];
        $title = $_POST['title'];

        /// Publish on Facebook
        $token = $_COOKIE['access_token'];
        $this->fb->sendRequest(
            'POST',
            '/me/feed',
            array(
                'link' => $link,
                'picture' => $picture,
                'name' => $title,
                'caption' => $caption
            ),
            $token
        );

        echo json_encode(
            array(
                "result" => "1"
            )
        );
    }

    public function result($q, $lang) {
        if ($q == 1) {
            $this->renderA1($lang);
        } elseif ($q == 2) {
            $this->renderA2($lang);
        } elseif ($q == 3) {
            $this->renderA3($lang);
        }
    }

    private function renderA1($lang) {
        $q1 = $this->input->post("q1");
        $q2 = $this->input->post("q2");
        $q3 = $this->input->post("q3");
        $q4 = $this->input->post("q4");
        $q5 = $this->input->post("q5");

        $score = $q1 + $q2 + $q3 + $q4 + $q5;

        if ($score <= 5) {
            $img_src = "imgs/r/1/" . $lang . "/1.jpg";
            $info = $this->getResultInfo("q1", $lang, 1);
        } elseif ($score <= 10) {
            $img_src = "imgs/r/1/" . $lang . "/2.jpg";
            $info = $this->getResultInfo("q1", $lang, 2);
        } elseif ($score <= 15) {
            $img_src = "imgs/r/1/" . $lang . "/3.jpg";
            $info = $this->getResultInfo("q1", $lang, 3);
        } elseif ($score <= 20) {
            $img_src = "imgs/r/1/" . $lang . "/4.jpg";
            $info = $this->getResultInfo("q1", $lang, 4);
        } else {
            $img_src = "imgs/r/1/" . $lang . "/5.jpg";
            $info = $this->getResultInfo("q1", $lang, 5);
        }

        $base_url = $this->config->item('base_url');
        $assets_url = $this->config->item('assets_url');

        $data = array(
            'link' => 'https://apps.facebook.com/746616388822438?q=1&lang=' . $lang,
            'picture' => $assets_url . $img_src,
            'caption' => $info['title'],
            'title' => $this->getQuestionInfo("q1")[$lang],
            "base_url" => $base_url,
            "lang" => $lang,
            "assets_url" => $assets_url,
            "question" => $this->getQuestionInfo("q1"),
            "layout_meta" => $this->load->view('layouts/meta', array("assets_url" => $assets_url), TRUE),
            "layout_footer" => $this->load->view('layouts/footer', array("assets_url" => $assets_url), TRUE),
            "img_src" => $img_src,
            "info" => $info,
        );

        $this->load->view('quiz/result', $data);
    }

    private function renderA2($lang) {
        $q1 = $this->input->post("q1");
        $q2 = $this->input->post("q2");
        $q3 = $this->input->post("q3");
        $q4 = $this->input->post("q4");

        $score = $q1 + $q2 + $q3 + $q4;

        if ($score <= 4) {
            $img_src = "imgs/r/2/" . $lang . "/1.jpg";
            $info = $this->getResultInfo("q2", $lang, 1);
        } elseif ($score <= 8) {
            $img_src = "imgs/r/2/" . $lang . "/2.jpg";
            $info = $this->getResultInfo("q2", $lang, 2);
        } elseif ($score <= 12) {
            $img_src = "imgs/r/2/" . $lang . "/3.jpg";
            $info = $this->getResultInfo("q2", $lang, 3);
        } else {
            $img_src = "imgs/r/2/" . $lang . "/4.jpg";
            $info = $this->getResultInfo("q2", $lang, 4);
        }

        $base_url = $this->config->item('base_url');
        $assets_url = $this->config->item('assets_url');

        $data = array(
            'link' => 'https://apps.facebook.com/746616388822438?q=2&lang=' . $lang,
            'picture' => $assets_url . $img_src,
            'caption' => $info['title'],
            'title' => $this->getQuestionInfo("q2")[$lang],
            "base_url" => $base_url,
            "lang" => $lang,
            "assets_url" => $assets_url,
            "question" => $this->getQuestionInfo("q2"),
            "layout_meta" => $this->load->view('layouts/meta', array("assets_url" => $assets_url), TRUE),
            "layout_footer" => $this->load->view('layouts/footer', array("assets_url" => $assets_url), TRUE),
            "img_src" => $img_src,
            "info" => $info,
        );

        $this->load->view('quiz/result', $data);
    }

    private function renderA3($lang) {

        $q1 = $this->input->post("q1");
        $zodiac = $q1 % 12;

        switch ($zodiac) {
            case 1:
                $img_src = "imgs/r/3/" . $lang . "/10.jpg";
                $info = $this->getResultInfo("q3", $lang, 10);
                break;
            case 2:
                $img_src = "imgs/r/3/" . $lang . "/11.jpg";
                $info = $this->getResultInfo("q3", $lang, 11);
                break;
            case 3:
                $img_src = "imgs/r/3/" . $lang . "/12.jpg";
                $info = $this->getResultInfo("q3", $lang, 12);
                break;
            case 4:
                $img_src = "imgs/r/3/" . $lang . "/1.jpg";
                $info = $this->getResultInfo("q3", $lang, 1);
                break;
            case 5:
                $img_src = "imgs/r/3/" . $lang . "/2.jpg";
                $info = $this->getResultInfo("q3", $lang, 2);
                break;
            case 6:
                $img_src = "imgs/r/3/" . $lang . "/3.jpg";
                $info = $this->getResultInfo("q3", $lang, 3);
                break;
            case 7:
                $img_src = "imgs/r/3/" . $lang . "/4.jpg";
                $info = $this->getResultInfo("q3", $lang, 4);
                break;
            case 8:
                $img_src = "imgs/r/3/" . $lang . "/5.jpg";
                $info = $this->getResultInfo("q3", $lang, 5);
                break;
            case 9:
                $img_src = "imgs/r/3/" . $lang . "/6.jpg";
                $info = $this->getResultInfo("q3", $lang, 6);
                break;
            case 10:
                $img_src = "imgs/r/3/" . $lang . "/7.jpg";
                $info = $this->getResultInfo("q3", $lang, 7);
                break;
            case 11:
                $img_src = "imgs/r/3/" . $lang . "/8.jpg";
                $info = $this->getResultInfo("q3", $lang, 8);
                break;

            default:
                $img_src = "imgs/r/3/" . $lang . "/9.jpg";
                $info = $this->getResultInfo("q3", $lang, 9);
        }


        $base_url = $this->config->item('base_url');
        $assets_url = $this->config->item('assets_url');

        /// Publish on Facebook
        /*$token = $_COOKIE['access_token'];
        $this->fb->sendRequest(
            'POST',
            '/me/feed',
            array(
                'link' => 'https://apps.facebook.com/746616388822438?q=3&lang=' . $lang,
                'picture' => $assets_url . $img_src,
                'caption' => $this->getQuestionInfo("q3")[$lang]
            ),
            $token
        );*/

        $data = array(
            'link' => 'https://apps.facebook.com/746616388822438?q=3&lang=' . $lang,
            'picture' => $assets_url . $img_src,
            'caption' => $info['title'],
            'title' => $this->getQuestionInfo("q3")[$lang],
            "base_url" => $base_url,
            "lang" => $lang,
            "assets_url" => $assets_url,
            "question" => $this->getQuestionInfo("q3"),
            "layout_meta" => $this->load->view('layouts/meta', array("assets_url" => $assets_url), TRUE),
            "layout_footer" => $this->load->view('layouts/footer', array("assets_url" => $assets_url), TRUE),
            "img_src" => $img_src,
            "info" => $info,
        );

        $this->load->view('quiz/result', $data);
    }

    private function getQuestionInfo($q) {
        $data = [
            "q1" => [
                "id" => 1,
                "thumb" => "imgs/thumbs/1.jpg",
                "ar" => "يلند اعثر على وجهتك المثالية في تا",
                "cn" => "泰国哪个外府才适合你性格？",
                "en" => "Find your perfect destination in Thailand",
                "jp" => "クイズに答えて、タイ国内であなたにぴったりの観光先を探しましょう。",
                "rs" => "Найдите своё идеальное место в Таиланде ",
            ],
            "q2" => [
                "id" => 2,
                "thumb" => "imgs/thumbs/2.jpg",
                "ar" => "ماهو طبقك التا يلندي المفضل ؟",
                "cn" => "那道菜属于你的性格？",
                "en" => "What Thai dish are you?",
            ],
            "q3" => [
                "id" => 3,
                "thumb" => "imgs/thumbs/3.jpg",
                "cn" => "你的属相在泰该去哪座寺庙拜佛？",
                "en" => "Where is the right Temple for you to take a visit too…",
                "jp" => "あなたにとって訪れるべき寺院は・・・",
                "rs" => "Где же находится Ваш храм для посещения... ",
            ],
        ];

        return $data[$q];
    }

    private function getResultInfo($q, $lang, $a) {
        $data = [
            "q1" => [
                "ar" => [
                    "a1" => [
                        "title" => "بانكوك – أكثر المدن إثارة . الثمافة ، الحضارة وحياة المدن الصاخبة كلها في مكان واحد مثير."
                    ],
                    "a2" => [
                        "title" => "فاتيا – الأقرب للشواطئ ، الإستمتاع بالحياة اليلية والترفيه عن النفس..",
                    ],
                    "a3" => [
                        "title" => "فوكيت – هنا الماء حياة بكاملها ... حيث الغوص والإبحار والشواطئ الجميلة .... إقامة جميلة لك..",
                    ],
                    "a4" => [
                        "title" => "سموي – الكثير من الأنشطة في الهواء الطلق والمكان الأنسب للاحتفال تحت ضوء القمر المتكامل.",
                    ],
                    "a5" => [
                        "title" => "شيانغ ماي – حيث جمال الطبيعة الخلابة والاجواء الرائعة, الحياة التقليدية والتارخٌ العريق بإنتظارك.  ",
                    ],
                ],
                "cn" => [
                    "a1" => [
                        "title" => "曼谷 – 失眠之城，不管是悠久文化、都会生活、豪华时尚、逛街购物都有不缺，应有尽有，作为最具有生活力之地。"
                    ],
                    "a2" => [
                        "title" => "芭提亚-  总所周知，闻名世界，白天游玩海滩夜里乐享无数夜店酒吧，保证能够让你玩得更嗨更疯狂。"
                    ],
                    "a3" => [
                        "title" => "普吉岛-  蓝海青天，处处美景，无论是潜水、帆船、日光浴或户外运动都等你来体验体验！"
                    ],
                    "a4" => [
                        "title" => "苏梅岛 -  碧绿海水、白细沙滩是你不可拒绝的美丽。如果多重极限运动还不狗嗨，那满月派对可能会满足你的需求！"
                    ],
                    "a5" => [
                        "title" => "清迈-  自然之美、天气清爽、骑象赏花、，清迈是绝对从来没让你后悔的选择。"
                    ],
                ],
                "en" => [
                    "a1" => [
                        "title" => "Bangkok – The most exciting city. Culture, urbanity & big city life all rolled into one exciting place"
                    ],
                    "a2" => [
                        "title" => "Pattaya – Get close to the beach, enjoy the nightlife & just enjoy yourself"
                    ],
                    "a3" => [
                        "title" => "Phuket – Water is life here…Diving, Sailing and beach…a beautiful setting for you"
                    ],
                    "a4" => [
                        "title" => "Samui – Plenty of outdoor activities & the place to get down with the famous Full Moon party!"
                    ],
                    "a5" => [
                        "title" => "Chiangmai – the beauty of nature, wonderful weather, traditions & history just waiting for you"
                    ],
                ],
                "jp" => [
                    "a1" => [
                        "title" => "バンコク－最もエキサイティングな街。カルチャーや都会的で洗練されたスポットが集中する場所。"
                    ],
                    "a2" => [
                        "title" => "パタヤ－海沿いの街なので、ビーチへすぐにＧｏ！ナイトライフも満喫。"
                    ],
                    "a3" => [
                        "title" => "プーケット－マリンスポーツ天国・・・ダイビング、セイリング、海水浴など何でもチャレンジ。"
                    ],
                    "a4" => [
                        "title" => "サムイ－アウトドアでのアクティビティが充実。有名なフルムーンパーティーで盛り上がって！"
                    ],
                    "a5" => [
                        "title" => "チェンマイ－美しい自然、過ごしやすい気候、伝統的、歴史的な名所の数々に癒されて。"
                    ],
                ],
                "rs" => [
                    "a1" => [
                        "title" => "Бангкок - поистине самый удивительный город. Культура, традиции и бурная городская жизнь в одном флаконе "
                    ],
                    "a2" => [
                        "title" => "Паттайя - будьте ближе к пляжу, наслаждайтесь ночной жизнью и просто получайте удовольствие "
                    ],
                    "a3" => [
                        "title" => "Пхукет - Сдесь вода - это жизнь... Дайвинг, яхты и пляж - прекрасный набор условий только для вас "
                    ],
                    "a4" => [
                        "title" => "Самуй - разнообразный активный отдых и знаменитая вечеринка Фул Мун! "
                    ],
                    "a5" => [
                        "title" => "Чиангмай - красота природы, замечательная погода, традиции и история ждут вас"
                    ],
                ],
            ],
            "q2" => [
                "ar" => [
                    "a1" => [
                        "title" => "مرقة الكاري بالدجاج والخبز – اللذة – قطع الدجاج المغمسة بالتوابل وحليب جوز الهند .هذا ما تبحث عنه.                                                                                                                       "
                    ],
                    "a2" => [
                        "title" => "فاد تاي – سهل التحضير – تحب أكلات الشوارع ونمط الحياة المريح. طبق المكرونة اللذ يذٌة والسوشي المقلي معا، هذا بالضبط ما سوف يرضيك.                                                                                   "
                    ],
                    "a3" => [
                        "title" => "أرز بالمانجو – لطيف – شخصيتك لطيفة ومناسبة مع هذا الطبق تماما ... رومانسي ورقيق ومحبوبٌ بين الناس.                                                                                                            "
                    ],
                    "a4" => [
                        "title" => "سلطة البابا يا {سوم تام} – عنيف – ما هو الخيار الأفضل من كل هذه الحرارة والتوابل في هذا الطبق التا يلندي المشهور.                                                                                                      "
                    ],
                ],
                "cn" => [
                    "a1" => [
                        "title" => "印度煎饼和咖喱鸡汤  – 优雅和保守派！嫩鸡腿放在浓郁咖哩汤加椰奶，绝对精制的做法表现你的高贵气质和优雅。"
                    ],
                    "a2" => [
                        "title" => "泰式炒米粉 -  随和、潇洒！你性格是自由自在，非常适合泰国街边小摊的各种当地美食和我行我素的生活方式。 特色米粉和甜酸酱一起炒，这才是你真正的美味。"
                    ],
                    "a3" => [
                        "title" => "芒果和糯米- 温柔文雅、彬彬有礼，你的温和非要属于这种泰国甜品不可，味道甜咸不腻收到大家的欢迎。"
                    ],
                    "a4" => [
                        "title" => "泰式沙拉 (泰式凉拌青木瓜沙拉) – 猛烈、冲动，你是个火辣组！ 喜欢挑战自己和别人。泰式沙拉的辣味可能不比你多，放更多辣椒看看谁会赢的！"
                    ],
                ],
                "en" => [
                    "a1" => [
                        "title" => "Chicken Curry and Roti – TASTEFUL - Indulge in spices combined with tender chicken & coconut milk. This is what you’re looking for"
                    ],
                    "a2" => [
                        "title" => "Pad Thai – EASY-GOING – You’re in love with street food & a cosy lifestyle. Tasty flat noodles & sauce fried together, this is exactly what will satisfy you."
                    ],
                    "a3" => [
                        "title" => "Mango Sticky Rice – GENTLE – Your gentle personality fits this dish perfectly…sweet, soft & loved by everyone"
                    ],
                    "a4" => [
                        "title" => "Papaya Salad (Som Tam) – FIERCE – You’re on fire baby! What would be a better choice than taking all spices & chilli with this famous Thai dish!"
                    ],
                ],
            ],
            "q3" => [
                "cn" => [
                    "a1" => [
                        "title" => "位于清迈的Wat Phra That Sri Chomthong 寺，寺庙装饰表现泰国北部的兰纳文化，同时提供沉思培训班。"
                    ],
                    "a2" => [
                        "title" => "南邦府的Wat Phra That Lampang Luang 寺在主殿具有神奇的倒头佛图反映出来，称呼奇迹，值得去体验一下！"
                    ],
                    "a3" => [
                        "title" => "位于北部帕府的Wat Phra That Cho Hae寺历史非常悠久，另外庙里的佛塔还供有佛主之骨，信佛者必要去一次！"
                    ],
                    "a4" => [
                        "title" => "南府的Wat Pra That Chae Haeng寺建于素可泰王朝时代，庙里保留着佛主的骨节到现在。"
                    ],
                    "a5" => [
                        "title" => "位于清迈府的Wat Pra Singh 寺，您可在此庙尊拜泰国最重要佛像之一的 Sihing 佛像。"
                    ],
                    "a6" => [
                        "title" => "清迈府的Wat Chet Yod寺是以印度Mahabodhi Vihar寺的风格来模仿而建立，寺庙风格独特不凡。"
                    ],
                    "a7" => [
                        "title" => "属马的应该去拜一下达府的Wat Phra Borommathat寺。庙里模仿缅甸艺术的佛塔而建立，风格优雅精致，美妙无比。"
                    ],
                    "a8" => [
                        "title" => "属羊的可能最容易去尊拜，位于清迈府的  Wat Phra That Doi Suthep 寺已经著称于世为兰娜文化中心之地。此庙位于山上美景绝对。"
                    ],
                    "a9" => [
                        "title" => "在位于泰国东北部的那空帕农府的Wat Phra That Phanom 寺，您可看到泰国和老挝艺术风格的交融，属猴的真有眼福啊！"
                    ],
                    "a10" => [
                        "title" => "Wat Phra That Hariphunchai 寺位于清迈府，在此寺您可欣赏独特装饰的佛塔。小心佛塔的金色亮光刺到你的眼哦。"
                    ],
                    "a11" => [
                        "title" => "佛经说Chula Manee 塔位于天堂，所以只有亡者才去尊拜，而泰国人借用此信仰在清迈建立了Chula Manee 佛塔，为了让我们可在人间去参拜。"
                    ],
                    "a12" => [
                        "title" => "Wat Phra That Doitung 是位于泰国最北边的清莱府。两座小型塔虽然不壮观伟大，但是精致美丽。参拜者还可以欣赏山上的美景。"
                    ],
                ],
                "en" => [
                    "a1" => [
                        "title" => "Wat Phra That Sri Chomthong in Chiang Mai. With Lanna style architecture & meditation classes throughout the year. "
                    ],
                    "a2" => [
                        "title" => "Wat Phra That Lampang Luang in Lampang. Explore the upside-down vision of a Buddha image. "
                    ],
                    "a3" => [
                        "title" => "Wat Phra That Cho Hae in Prae. Buddha relics are housed inside the pagoda base."
                    ],
                    "a4" => [
                        "title" => "Wat Pra That Chae Haeng in Nan. A sanctuary containing Buddha relics from the Sukhothai Era."
                    ],
                    "a5" => [
                        "title" => "Wat Pra Singh in Chiang Mai. You can find the  Sihing Buddha image, a very important Buddha image of Thailand."
                    ],
                    "a6" => [
                        "title" => "Wat Chet Yod in Chiang Mai. The pagoda was inspired by the Mahabodhi Vihar Temple in Bodh Gaya, India where Lord Buddha found enlightened."
                    ],
                    "a7" => [
                        "title" => "Wat Phra Borommathat in Tak. A replica of Myanmar’s Shwedagon pagoda. "
                    ],
                    "a8" => [
                        "title" => "Wat Phra That Doi Suthep in Chiang Mai. Known as the soul of the Lanna people throughout time."
                    ],
                    "a9" => [
                        "title" => "Wat Phra That Phanom in Nakhon Phanom. See the Thai-Lao style pagoda. "
                    ],
                    "a10" => [
                        "title" => "Wat Phra That Hariphunchai in Chiang Mai. Discover the unique design of the pagoda. "
                    ],
                    "a11" => [
                        "title" => "Wat Ket Karam in Chiang Mai. where Worship Phra That Chula Manee & see some antiques inside the museum. "
                    ],
                    "a12" => [
                        "title" => "Wat Phra That Doitung in Chiang Rai. Enjoy two small beautiful pagodas."
                    ],

                ],
                "jp" => [
                    "a1" => [
                        "title" => "チェンマイのワット・プラタ－ト・シー・チョムトーン。ランナー様式の寺院では、年中、建築や瞑想の講座が開催されています。"
                    ],
                    "a2" => [
                        "title" => "ランパーンのワット・プラタート・ランパーン・ルアン。パゴダ（仏塔）を逆さまに見るという趣向が面白い寺院。"
                    ],
                    "a3" => [
                        "title" => "プレーのワット・プラタート・チョー・ヘー。パゴダ内に仏陀が鎮座しています。"
                    ],
                    "a4" => [
                        "title" => "ナーンのワット・プラタ－ト・チョー・ヘーン。スコータイ時代の仏像があり、神聖な雰囲気。"
                    ],
                    "a5" => [
                        "title" => "チェンマイのワット・プラシン。タイで最も重要な仏像の一つ、プラシン仏が納められています。"
                    ],
                    "a6" => [
                        "title" => "チェンマイのワット・チェット・ヨ－ド。パゴダは、仏陀が悟りを開いたと言われるインドのブッダガヤにあるマハーボディ寺院がモデルとなっています。"
                    ],
                    "a7" => [
                        "title" => "タークのワット・プラーボロマタート。ミャンマーのシェダゴン・パゴダを模した寺院。"
                    ],
                    "a8" => [
                        "title" => "チェンマイのワット・プラータート・ドイステープ。ランナー時代の人々の魂とも言うべき神聖な場所。"
                    ],
                    "a9" => [
                        "title" => "ナコンパトムのワット・プラータート・パノム。タイとラオスの様式が融合したパゴダ。"
                    ],
                    "a10" => [
                        "title" => "チェンマイのワット・プラータート・ハリプンチャイ。ユニークなデザインが特徴のパゴダ。"
                    ],
                    "a11" => [
                        "title" => "チェンマイのワット・ケット・カラム。プラタートチュラマニーを拝み、美術館の歴史的遺産物を鑑賞しましょう。"
                    ],
                    "a12" => [
                        "title" => "チェンライのワット・プラタート・ドイトゥン。２つの小さく美しいパゴダが並びます。"
                    ],
                ],
                "rs" => [
                    "a1" => [
                        "title" => "Храм Пра Тат Си Чом Тонг в Чиангмае. Архитектура в стиле \"Ланна\", а также занятия медитацией на протяжении всего года. "
                    ],
                    "a2" => [
                        "title" => "Храм Пра Тат Лампанг Луанг в Лампанге. Откройте для себя иное представление об изображении Будды. "
                    ],
                    "a3" => [
                        "title" => "Храм Пра Тат Чо Хэ в провинции Прэ. В пагоде храма хранятся реликвии Будды. "
                    ],
                    "a4" => [
                        "title" => "Храм Пра Тат Чэ Хэнг в провинции Нан. Священное место, где хранятся реликвии Будды периода Сукхотай. "
                    ],
                    "a5" => [
                        "title" => "Храм Пра Сингх в Чиангмае. Вы сможете увидеть изображение Будды Сихин, очень значимый образ Будды в Таиланде. "
                    ],
                    "a6" => [
                        "title" => "Храм Чет Йот в Чиангмае. Пагода, возведена в стиле индийского храма Махабодхи в Бодх-Гая, где Будда получил просветление. "
                    ],
                    "a7" => [
                        "title" => "Храм Пра Бороматхат в провинции Так. Точная копия пагоды Шведагон в Мьянме. "
                    ],
                    "a8" => [
                        "title" => "Храм Пра Тат Дой Сутеп в Чиангмае. На протяжении долгого времени являлся душой народа Ланна. "
                    ],
                    "a9" => [
                        "title" => "Храм Пра Тат Паном в городе Накхон Пханом. Пагода выполнена в смешанном тайско-лаосском стиле. "
                    ],
                    "a10" => [
                        "title" => "Храм Пра Тат Харипунчай в Чиангмае. Откройте для себя уникальную архитектуру пагоды. "
                    ],
                    "a11" => [
                        "title" => "Храм Кет Карам в Чиангмае, где почитается пагода Чула Мани. Также, можно посмотреть на множество старинных вещей в музее."
                    ],
                    "a12" => [
                        "title" => "Храм Пра Тат Дой Тунг в Чианграе. Воспользуйтесь возможностью увидеть две небольшие красивые пагоды"
                    ],

                ],
            ]
        ];

        return $data[$q][$lang]["a" . $a];
    }
}
