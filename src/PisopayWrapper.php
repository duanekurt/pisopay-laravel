<?php

namespace Savants\PisopayWrapper;
use Http;
class PisopayWrapper
{

  // Credentials
  protected $user;
  protected $password;
  protected $xgateway;

  // App
  public $checkoutUrl = '';
  public $checkoutStatus = '';

  public function __construct(){
    $this->user  = config('pisopay.user');
    $this->password  = config('pisopay.password');
    $this->xgateway  = config('pisopay.xgatewayauth');
  }

  public function generateSession(){
    $response = Http::withHeaders([
      'X-Gateway-Auth' => $this->xgateway,
      'Content-Type' => 'application/json',
      'Authorization' => 'Basic '.base64_encode($this->user.':'.$this->password),
      ])->get('https://api.pisopay.com.ph/checkout/1.0/login');
      if($response->json()['responseCode'] == 0){
        $session =  $response->json()['data']['sessionId'];
        return $session;
      }else{
        dump($response->json());
        die();
      }

    }

    public function checkout($data = array()){
      $payload = [
        'customerName' => $data['customerName'],
        'customerEmail' => $data['customerEmail'],
        'customerPhone' => $data['customerPhone'],
        'amount' => $data['amount'],
        'traceNo' => $data['traceNo'],
        'details' => $data['details'],
        'merchantCallbackURL' => $data['merchantCallbackURL'],
        'callbackUrl' => $data['callbackUrl'],
      ];

      $response = Http::withHeaders([
        'X-Gateway-Auth' => $this->xgateway,
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.$this->generateSession()
        ])->post('https://api.pisopay.com.ph/checkout/1.0/payment/commit',$payload);

        if ($response->json()['responseCode'] == 0) {
          $this->checkoutStatus = 'success';
          $this->checkoutUrl = $response->json()['data']['checkoutUrl'];
        }else{
          $this->checkoutStatus = 'failed';
          dump($response->json());
          die();
        }
        return $this->checkoutStatus;

      }

      public function getCheckoutUrl(){
        return $this->checkoutUrl;
      }

      public function traceTransaction($trace_no){
        if (empty($trace_no)) {
          dump('Trace # is required');
          die();
        }
        $response = Http::withHeaders([
          'X-Gateway-Auth' => $this->xgateway,
          'Content-Type' => 'application/json',
          'Authorization' => 'Bearer '.$this->generateSession()
        ])->post('https://api.pisopay.com.ph/checkout/1.0/payment/inquiry',$trace_no);

        if ($response->json()['responseCode'] == 0) {
          return $response->json()['data'];
        }
      }

}
