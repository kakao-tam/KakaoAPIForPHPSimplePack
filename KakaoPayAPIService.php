<?php
//모듈 수정 원칙
//1. Kakao Response를 가급적 가공 안함
//2. 리턴타입은 Objec, Json, Echo 선택
//3. KakaoAPIService는 API 호출 스펙 정의 
//4. KakaoService는 환경설정과 출력 유틸

require('KakaoService.php');
class KakaoAPIService extends KakaoService
{
    private $PAY_CID;
    private $approval_url;
    private $fail_url;
    private $cancel_url;

    public function __construct($return_type="")
    {
        parent::__construct($return_type);
        $this->PAY_CID = "TC0ONETIME";

        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
        $this->approval_url = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/approval_url.php"); 
        $this->fail_url = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/fail_url.php"); 
        $this->cancel_url = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/cancel_url.php"); 
    }

    //단건 결제
    public function paymentReady($partner_order_id, $partner_user_id, $item_name, $quantity, $total_amount, $vat_amount, $tax_free_amount)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/ready";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&partner_order_id='.$partner_order_id;
        $data += '&partner_user_id='.$partner_user_id;
        $data += '&item_name='.urlencode($item_name);
        $data += '&quantity='.$quantity;
        $data += '&total_amount='.$total_amount;
        $data += '&vat_amount='.$vat_amount;
        $data += '&tax_free_amount='.$tax_free_amount;
        $data += '&approval_url='.urlencode($this->approval_url);
        $data += '&fail_url='.urlencode($this->fail_url);
        $data += '&cancel_url='.urlencode($this->cancel_url);

        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function paymentApprove($partner_order_id, $partner_user_id, $tid, $pg_token)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/approve";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&partner_order_id='.$partner_order_id;
        $data += '&partner_user_id='.$partner_user_id;
        $data += '&tid='.$tid;
        $data += '&pg_token='.$pg_token;

        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    //첫 결제 후, 정기 결제 세팅
    public function paymentSubscription($sid, $partner_order_id, $partner_user_id, $item_name, $quantity, $total_amount, $tax_free_amount)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/subscription";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&sid='.$sid;
        $data += '&partner_order_id='.$partner_order_id;
        $data += '&partner_user_id='.$partner_user_id;
        $data += '&item_name='.urlencode($item_name);
        $data += '&quantity='.$quantity;
        $data += '&total_amount='.$total_amount;
        $data += '&tax_free_amount='.$tax_free_amount;

        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }

    public function paymentSubscriptionInactive($sid)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/subscription/inactive";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&sid='.$sid;
        
        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }    

    public function paymentSubscriptionStatus($sid)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/subscription/status";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&sid='.$sid;
        
        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }        

    //주문 목록
    public function paymentOrder($partner_order_id, $partner_user_id, $tid, $pg_token)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/order";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&tid='.$tid;

        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }    

    //취소
    public function paymentCancel($tid, $cancel_amount, $cancel_tax_free_amount, $cancel_vat_amount, $cancel_available_amount)
    {
        $callUrl = "https://kapi.kakao.com/v1/payment/ready";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'cid='.$this->PAY_CID;
        $data += '&tid='.$tid;
        $data += '&cancel_amount='.$cancel_amount;
        $data += '&cancel_tax_free_amount='.$cancel_tax_free_amount;
        $data += '&cancel_vat_amount='.$cancel_vat_amount;
        $data += '&cancel_available_amount='.$cancel_available_amount;

        $headers[] = "Authorization: KakaoAK ".$this->ADMIN_KEY;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }    
}
?>