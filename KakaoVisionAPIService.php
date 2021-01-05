<?php
//모듈 수정 원칙
//1. Kakao Response를 가급적 가공 안함
//2. 리턴타입은 Objec, Json, Echo 선택
//3. KakaoAPIService는 API 호출 스펙 정의 
//4. KakaoService는 환경설정과 출력 유틸

require('KakaoService.php');
class KakaoVisionAPIService extends KakaoService
{
    public function __construct($return_type = "")
    {
        parent::__construct($return_type);
    }

    public function faceDetect($image_url)
    {
        $callUrl = "https://dapi.kakao.com/v2/vision/face/detect";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'image_url=' . urlencode($image_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function productDetect($image_url)
    {
        $callUrl = "https://dapi.kakao.com/v2/vision/product/detect";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'image_url=' . urlencode($image_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function adultDetect($image_url)
    {
        $callUrl = "https://dapi.kakao.com/v2/vision/adult/detect";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'image_url=' . urlencode($image_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function thumbnailCrop($image_url)
    {
        $callUrl = "https://dapi.kakao.com/v2/vision/thumbnail/crop";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'image_url=' . urlencode($image_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function multitagGenerate($image_url)
    {
        $callUrl = "https://dapi.kakao.com/v2/vision/multitag/generate";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'image_url=' . urlencode($image_url);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function textOcr($image_full_path)
    {
        $callUrl = "https://dapi.kakao.com/v2/vision/text/ocr";
        $headers = array('Content-Type: multipart/form-data');
        if (function_exists('curl_file_create')) { // php 5.5+
            $cFile = curl_file_create($image_full_path);
        } else { 
            $cFile = '@' . realpath($image_full_path);
        }
        $data = array('image' => $cFile);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }
}
?>