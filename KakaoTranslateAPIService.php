<?php
//모듈 수정 원칙
//1. Kakao Response를 가급적 가공 안함
//2. 리턴타입은 Objec, Json, Echo 선택
//3. KakaoAPIService는 API 호출 스펙 정의 
//4. KakaoService는 환경설정과 출력 유틸

require('KakaoService.php');
class KakaoTranslateAPIService extends KakaoService
{
    public function __construct($return_type = "")
    {
        parent::__construct($return_type);
    }

    public function translate($src_lang, $target_lang, $query)
    {
        $callUrl = "https://dapi.kakao.com/v2/translation/translate";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'src_lang='.$src_lang.'&target_lang='.$target_lang.'&query='.urlencode($query);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function languageDetect($query)
    {
        $callUrl = "https://dapi.kakao.com/v3/translation/language/detect";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'query='.urlencode($query);
        $headers[] = "Authorization: KakaoAK " . $this->REST_API_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

}
?>