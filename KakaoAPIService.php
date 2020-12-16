<?php
class KakaoAPIService {  

    protected $REST_API_KEY;
    protected $REDIRECT_URI;

    public function __construct()
    {
        $this->REST_API_KEY = "4408b5bb51bdf4c89879e933556a21e8";
        $this->REDIRECT_URI = urlencode("http://".$_SERVER['HTTP_HOST']."/PHPSimplePack.php");
    }

    public function getKakaoLoginLink(){
        echo("https://kauth.kakao.com/oauth/authorize?client_id=".$this->REST_API_KEY."&redirect_uri=".$this->REDIRECT_URI."&response_type=code");
    }

}
?>