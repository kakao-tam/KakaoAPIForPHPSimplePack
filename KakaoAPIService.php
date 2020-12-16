<?php
class KakaoAPIService {  

    protected $REST_API_KEY;
    protected $REDIRECT_URI;
    protected $CLIENT_SECRET;

    public function __construct()
    {   //★ 수정 할 것
        $this->REST_API_KEY = "4408b5bb51bdf4c89879e933556a21e8";
        $this->CLIENT_SECRET = "QZhr9itOs0mxVRDxIvuOfOLzjZMc5q1U";
        $this->REDIRECT_URI = urlencode("http://".$_SERVER['HTTP_HOST']."/PHPSimplePack.php");

        session_start();
    }

    public function getKakaoLoginLink(){
        echo("https://kauth.kakao.com/oauth/authorize?client_id=".$this->REST_API_KEY."&redirect_uri=".$this->REDIRECT_URI."&response_type=code");
    }

    public function getToken(){
        $code = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다.
        $callUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$this->REST_API_KEY."&redirect_uri=".$this->REDIRECT_URI."&code=".$code."&client_secret=".$this->CLIENT_SECRET;
        $response = KakaoAPIService::excuteCurl($callUrl, "POST");

        if( isset( json_decode($response["response"])->access_token )){               
            $_SESSION["accessToken"] = json_decode($response["response"])->access_token;
        }
        else{
            echo($response["status_code"]);
            echo($response["response"]);
        }
        return $_SESSION["accessToken"];
    }

    public function getProfile(){       
        $callUrl = "https://kapi.kakao.com/v2/user/me";

        $headers = array();
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $response = KakaoAPIService::excuteCurl($callUrl, "POST", $headers);

        $return = "";
        if( isset( json_decode($response["response"])->id )){               
            $return = $response["response"];
        }
        else{
            echo($response["status_code"]);
            echo($response["response"]);
        }
        return $return;        
    }

    private function excuteCurl($callUrl, $method, $headers = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $callUrl);
        if($method == "POST"){
            curl_setopt($ch, CURLOPT_POST, true);
        }
        else{
            curl_setopt($ch, CURLOPT_POST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array(
            "status_code" => $status_code,
            "response" => $response,
        );     
    }
}
?>
