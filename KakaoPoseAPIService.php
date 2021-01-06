<?php
//모듈 수정 원칙
//1. Kakao Response를 가급적 가공 안함
//2. 리턴타입은 Objec, Json, Echo 선택
//3. KakaoAPIService는 API 호출 스펙 정의 
//4. KakaoService는 환경설정과 출력 유틸

require('KakaoService.php');
class KakaoPoseAPIService extends KakaoService
{
    public function __construct($return_type = "")
    {
        parent::__construct($return_type);
    }

    public function pose($image_url)
    {
        $callUrl = "https://cv-api.kakaobrain.com/pose";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'image_url=' . urlencode($image_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function poseJob($video_url)
    {
        $callUrl = "https://cv-api.kakaobrain.com/pose/job";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'video_url=' . urlencode($video_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function poseResult($id)
    {
        $callUrl = "https://cv-api.kakaobrain.com/pose/job/".$id;
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers);
    }
}
?>