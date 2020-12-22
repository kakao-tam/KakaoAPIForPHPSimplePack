<?php
require('KakaoAPIService.php');
$KakaoAPIService = new KakaoAPIService();
?>
<!doctype html>
<html lang="kr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <base href="/" />
    <link rel="manifest" href="/manifest.json">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/static/css/2.86aa6515.chunk.css" rel="stylesheet">
    <link href="/static/css/main.a583af82.chunk.css" rel="stylesheet">
    <!--highlight.js cdn-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/highlight.min.js"></script>
    <!--bootstrapcdn-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>PHP Simple Pack</title>
</head>

<body>
    <header>
        <nav class="navbar-expand-sm navbar-toggleable-sm ng-white border-bottom box-shadow mb-3 navbar navbar-light">
            <div class="container"><a class="navbar-brand" href="/"><img src="/img/icon/googsu.png" class="logo" alt="logo">Kakao API Test</a>
                <h1>PHP Simple Pack</h1>
            </div>
        </nav>
    </header>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
                <h3>사용방법</h3>
                * PHP Simple Pack : <a href="https://github.com/kakao-tam/KakaoAPIForPHPSimplePack">[Github]</a> <a href="https://kakao-tam.tistory.com/23">[Blog]</a>
                <pre><code class="php"> * KakaoAPIService.php 수정
public function __construct()
{   //★ 수정 할 것
    $this->JAVASCRIPT_KEY = "22222222222222222222222222222222";
    $this->REST_API_KEY   = "44444444444444444444444444444444";
    $this->CLIENT_SECRET  = "QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ";
    $this->REDIRECT_URI = urlencode("http://".$_SERVER['HTTP_HOST']."/PHPSimplePack.php");
...             </code></pre>
                <pre><code class="php"> * API 사용하려고 하는 곳에 선언
&lt;?php
require('KakaoAPIService.php');
$KakaoAPIService = new KakaoAPIService();
?&gt;                   </code></pre>
                <h3>끝.</h3>
                <p>
                    * 아래 유형별 API를 한줄 호출하여 사용 <br />
                </p>
            </li>
        </ul>
    </div>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
                <h4>카카오 로그인 - 로그인 링크 가져오기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP">
                        <p></p>
                        <a href="<?= $KakaoAPIService->getKakaoLoginLink() ?>"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                        <p></p>
                        <pre><code class="php"> * 로그인 페이지의 로그인 버튼 or 이미지에 링크를 설정합니다.
&lt;a href="&lt;?= $KakaoAPIService->getKakaoLoginLink() ?&gt;"&gt;
    &lt;img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /&gt;
&lt;/a&gt;              </code></pre>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <h4>카카오 로그인 - 로그인 콜백 처리</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP1">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP1">
                        <p></p>
                        <pre><code class="php"> * 위의 로그인을 실행하면, 설정된 CallBack Page에서 결과를 확인 할 수 있습니다.
&lt;?= $KakaoAPIService->getToken() ?&gt; //토큰 조회
&lt;?= $KakaoAPIService->getProfile() ?&gt; //프로필 조회</code></pre>
                        <div id="Response1" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getToken() ?>
                        </div>
                        <div id="Response2" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getProfile() ?>
                        </div>
                        <p></p>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로그인 - 추가 항목 동의 받기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP">
                        <p></p>
                        <a href="<?= $KakaoAPIService->getAuthorizeLink("talk_message,plusfriends") ?>">추가 항목 동의 받기</a>
                        <p></p>
                        <pre><code class="php"> //필수 동의가 아닌 사용중 동의가 필요할때 
&lt;a href="&lt;?= $KakaoAPIService->getAuthorizeLink("talk_message,plusfriends") ?&gt;"&gt;추가 항목 동의 받기&lt;/a&gt;              </code></pre>
                    </div>
                </div>
            </li>         
            <li class="list-group-item">
                <h4>카카오 로그인 - 로그아웃</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP1">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP1">
                        <p></p>
                        <pre><code class="php"> 
&lt;?= $KakaoAPIService->setLogOut() ?&gt; //로그아웃
&lt;?= $KakaoAPIService->setLogOutForAdmin(1515035367) ?&gt; //Admin로그아웃</code></pre>
                        <div id="Response1" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            {"id":1515035367}
                        </div>
                        <div id="Response2" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            {"id":1515035367}
                        </div>
                        <p></p>
                    </div>
                </div>
            </li>            
            <li class="list-group-item">
                <h4>카카오 로그인 - 카카오계정과 함께 로그아웃</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP1">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP1">
                        <p></p>
                        <a href="<?= $KakaoAPIService->getKakaoWithLogOutLink() ?>">카카오계정과 함께 로그아웃</a>
                        <pre><code class="php"> * 로그인 페이지의 로그인 버튼 or 이미지에 링크를 설정합니다.
&lt;a href="&lt;?= $KakaoAPIService->getKakaoWithLogOutLink() ?&gt;"&gt;카카오계정과 함께 로그아웃&lt;/a&gt;              </code></pre>
                    </div>
                </div>
            </li>                 
            <li class="list-group-item">
                <h4>카카오 로그인 - 연결 끊기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP1">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP1">
                        <p></p>
                        <pre><code class="php"> 
&lt;?= $KakaoAPIService->setUnLink() ?&gt; //연결 끊기
&lt;?= $KakaoAPIService->setUnLinkForAdmin(1515035367) ?&gt; //Admin연결 끊기</code></pre>
                        <div id="Response1" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                        {"id":1515035367}
                        </div>
                        <div id="Response2" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                        {"id":1515035367}
                        </div>
                        <p></p>
                    </div>
                </div>
            </li>  
            <li class="list-group-item">
                <h4>카카오 로그인 - 토큰 갱신하기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP1">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP1">
                        <p></p>
                        <pre><code class="php"> 
&lt;?= $KakaoAPIService->setTokenRefresh() ?&gt; //토큰 갱신하기</code></pre>
                        <div id="Response1" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                        9RjyTpQUBKZ6w1wCGXYvfULyH0ljPfc8fU2OqwopyWAAAAF2iU5m4Q
                        </div>
                        <p></p>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로그인 - 사용자 정보 저장하기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP1">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP1">
                        <p></p>
                        <pre><code class="php"> 
&lt;?= $KakaoAPIService->setUpdateProfile('test API name') ?&gt; //사용자 정보 저장하기</code></pre>
                        <div id="Response1" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                        {"id":1515035367}
                        </div>
                        <p></p>
                    </div>
                </div>
            </li>            
            <li class="list-group-item">
                <h4>카카오 로컬 - 주소 조회</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP2">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP2">
                        <p></p>
                        <pre><code class="php">//주소 조회
&lt;?= $KakaoAPIService->getAddress("전북 삼성동 100") ?&gt;</code></pre>
                        <p></p>
                        <div id="Response3" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getAddress("전북 삼성동 100") ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로컬 - 좌표로 행정구역정보 받기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP2">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP2">
                        <p></p>
                        <pre><code class="php">//좌표로 행정구역정보 받기
&lt;?= $KakaoAPIService->getCoord2regioncode(127.1086228, 37.4012191) ?&gt;</code></pre>
                        <p></p>
                        <div id="Response3" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getCoord2regioncode(127.1086228, 37.4012191) ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로컬 - 좌표로 주소 변환하기</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP2">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP2">
                        <p></p>
                        <pre><code class="php">//좌표로 주소 변환하기
&lt;?= $KakaoAPIService->getCoord2address(127.1086228, 37.4012191) ?&gt;
                        </code></pre>
                        <p></p>
                        <div id="Response3" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getCoord2address(127.1086228, 37.4012191) ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로컬 - 좌표계 변환</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP2">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP2">
                        <p></p>
                        <pre><code class="php">//좌표계 변환
&lt;?= $KakaoAPIService->getTranscoord(127.1086228, 37.4012191) ?&gt;</code></pre>
                        <p></p>
                        <div id="Response3" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getTranscoord(127.1086228, 37.4012191) ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로컬 - 키워드로 장소 검색</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP2">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP2">
                        <p></p>
                        <pre><code class="php">//키워드로 장소 검색
&lt;?= $KakaoAPIService->getKeywordAddress("카카오프렌즈", 127.1086228, 37.4012191) ?&gt;</code></pre>
                        <p></p>
                        <div id="Response3" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getKeywordAddress("카카오프렌즈", 127.1086228, 37.4012191) ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h4>카카오 로컬 - 카테고리로 장소 검색</h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PHP2">PHP</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="PHP2">
                        <p></p>
                        <pre><code class="php">//카테고리로 장소 검색
&lt;?= $KakaoAPIService->getCategoryAddress("PM9", 127.1086228, 37.4012191, 100) ?&gt;</code></pre>
                        <p></p>
                        <div id="Response3" class="alert alert-primary" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            <?= $KakaoAPIService->getCategoryAddress("PM9", 127.1086228, 37.4012191, 100) ?>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
</body>

</html>
