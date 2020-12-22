<?php
class KakaoAPIService
{
    protected $JAVASCRIPT_KEY;
    protected $REST_API_KEY;
    protected $ADMIN_KEY;
    protected $CLIENT_SECRET;
    protected $REDIRECT_URI;
    protected $LOGOUT_REDIRECT_URI;

    public function __construct()
    {   //★ 수정 할 것
        $this->JAVASCRIPT_KEY = "22222222222222222222222222222222"; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->REST_API_KEY   = "44444444444444444444444444444444"; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->ADMIN_KEY      = "77777777777777777777777777777777"; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->CLIENT_SECRET  = "QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ"; // https://developers.kakao.com > 내 애플리케이션 > 제품 설정 > 카카오 로그인 > 보안

        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
        $this->REDIRECT_URI          = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/Your_Redirect_Uri.php");       // 내 애플리케이션 > 제품 설정 > 카카오 로그인
        $this->LOGOUT_REDIRECT_URI   = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/YourLogOut_Redirect_Uri.php"); // 내 애플리케이션 > 제품 설정 > 카카오 로그인 > 고급 > Logout Redirect URI

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getKakaoLoginLink()
    {
        echo ("https://kauth.kakao.com/oauth/authorize?client_id=" . $this->REST_API_KEY . "&redirect_uri=" . $this->REDIRECT_URI . "&response_type=code&state=accessToken");
    }

    public function getAuthorizeLink($scope)
    {
        echo ("https://kauth.kakao.com/oauth/authorize?client_id=" . $this->REST_API_KEY . "&redirect_uri=" . $this->REDIRECT_URI . "&response_type=code&state=accessAgree&scope=" . $scope);
    }

    public function getToken()
    {
        $code = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다.
        $callUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=" . $this->REST_API_KEY . "&redirect_uri=" . $this->REDIRECT_URI . "&code=" . $code . "&client_secret=" . $this->CLIENT_SECRET;
        $response = $this->excuteCurl($callUrl, "POST");
        //Custom 설정 : refreshToken은 2개월 보존되며, 1개월 남았을 때 갱신 가능하므로 세션이 아닌 개별 저장소에 저장하는 것이 좋음
        $_SESSION["refreshToken"] = json_decode($response["response"])->refresh_token;
        return $this->getReturnKey($response, "access_token", "access_token", "accessToken");
    }

    public function setLogOut()
    {
        $callUrl = "https://kapi.kakao.com/v1/user/logout";
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $response = $this->excuteCurl($callUrl, "POST", $headers);
        return $this->getReturnKey($response, "id");
    }

    public function setLogOutForAdmin($id)
    {
        $callUrl = "https://kapi.kakao.com/v1/user/logout";
        $data = 'target_id_type=user_id&target_id=' . $id;
        $headers[] = "Authorization: KakaoAK " . $this->ADMIN_KEY;
        $response = $this->excuteCurl($callUrl, "POST", $headers, $data);
        return $this->getReturnKey($response, "id");
    }

    public function getKakaoWithLogOutLink()
    {
        echo ("https://kauth.kakao.com/oauth/logout?client_id=" . $this->REST_API_KEY . "&logout_redirect_uri=" . $this->LOGOUT_REDIRECT_URI . "&state=logout");
    }

    public function setUnLink()
    {
        $callUrl = "https://kapi.kakao.com/v1/user/unlink";
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $response = $this->excuteCurl($callUrl, "POST", $headers);
        return $this->getReturnKey($response, "id");
    }

    public function setUnLinkForAdmin($id)
    {
        $callUrl = "https://kapi.kakao.com/v1/user/unlink";
        $data = 'target_id_type=user_id&target_id=' . $id;
        $headers[] = "Authorization: KakaoAK " . $this->ADMIN_KEY;
        $response = $this->excuteCurl($callUrl, "POST", $headers, $data);
        return $this->getReturnKey($response, "id");
    }

    public function getAccessTokenInfo()
    {
        $callUrl = "https://kapi.kakao.com/v1/user/access_token_info";
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "id");
    }

    public function setTokenRefresh()
    {
        $callUrl = "https://kauth.kakao.com/oauth/token?grant_type=refresh_token&client_id=" . $this->REST_API_KEY . "&refresh_token=" . $_SESSION["refreshToken"] . "&client_secret=" . $this->CLIENT_SECRET;
        $response = $this->excuteCurl($callUrl, "POST");
        return $this->getReturnKey($response, "access_token", "access_token", "accessToken");
    }

    public function getProfile()
    {
        $callUrl = "https://kapi.kakao.com/v2/user/me";
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $response = $this->excuteCurl($callUrl, "POST", $headers);
        return $this->getReturnKey($response, "id");
    }

    public function setUpdateProfile($nickname)
    {
        $callUrl = "https://kapi.kakao.com/v1/user/update_profile";
        $data = 'properties={"nickname":"'.$nickname.'"}';     
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');        
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $response = $this->excuteCurl($callUrl, "POST", $headers, $data);
        return $this->getReturnKey($response, "id");
    }    

    public function getUserListForAdmin()
    {
        $callUrl = "https://kapi.kakao.com/v1/user/ids";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $headers[] = "Authorization: KakaoAK " . $this->ADMIN_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "elements");
    }    

    public function getAddress($query)
    {
        $callUrl = "https://dapi.kakao.com/v2/local/search/address.json?query=" . urlencode($query);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "meta");
    }

    public function getCoord2regioncode($x, $y)
    {
        $callUrl = "https://dapi.kakao.com/v2/local/geo/coord2regioncode.json?x=" . $x . "&y=" . $y;
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "meta");
    }

    public function getCoord2address($x, $y)
    {
        $callUrl = "https://dapi.kakao.com/v2/local/geo/coord2address.json?x=" . $x . "&y=" . $y;
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "meta");
    }

    public function getTranscoord($x, $y, $input_coord = "WTM", $output_coord = "WGS84")
    {
        $callUrl = "https://dapi.kakao.com/v2/local/geo/transcoord.json?x=" . $x . "&y=" . $y . "&input_coord=" . $input_coord . "&output_coord=" . $output_coord;
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "meta");
    }

    public function getKeywordAddress($query, $x, $y, $radius = 1000)
    {
        $callUrl = "https://dapi.kakao.com/v2/local/search/keyword.json?query=" . urlencode($query) . "&x=" . $x . "&y=" . $y . "&radius=" . $radius;
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "meta");
    }

    public function getCategoryAddress($category_group_code, $x, $y, $radius = 1000)
    {
        $callUrl = "https://dapi.kakao.com/v2/local/search/category.json?category_group_code=" . $category_group_code . "&x=" . $x . "&y=" . $y . "&radius=" . $radius;
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        $response = $this->excuteCurl($callUrl, "GET", $headers);
        return $this->getReturnKey($response, "meta");
    }

    private function getReturnKey($response, $issetKey = "", $getKey = "", $sessionKey = "")
    {
        $return = "";
        if (isset(json_decode($response["response"])->{$issetKey})) {
            if ($getKey == "") {
                $return = $response["response"];
            } else {
                $return = json_decode($response["response"])->{$getKey};
                if ($sessionKey != "") {
                    $_SESSION[$sessionKey] = $return;
                }
            }
        } else {
            return ($response["status_code"]).($response["response"]);
        }
        return $return;
    }

    private function excuteCurl($callUrl, $method, $headers = array(), $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $callUrl);
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_POST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);        
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array(
            "status_code" => $status_code,
            "response" => $response,
        );
    }
}
