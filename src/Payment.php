<?php

/**
 * Class Moneytigo Payment
 * v 1.0.1 - 2021-06-15
 *
 */

namespace moneytigo;

class Payment {

  public $customer;


  public function __construct( $params ) {

    $this->apiuri = "https://payment.moneytigo.com";
    $this->merchantkey = $params[ 'MerchantKey' ];
    $this->secretkey = $params[ 'SecretKey' ];
    $this->client = new\ GuzzleHttp\ Client();
  }

  /**
   * Function to generate a Universal Unique ID (UUID)
   *
   * @return string - a UUID
   */

  private function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }

  /**
   * Do a Get http query
   *
   * @param $url
   * @return mixed|\Psr\Http\Message\ResponseInterface
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  private function get( $url, $generateHeaders = true ) {
    $method = 'GET';
    if ( $generateHeaders == true ) {
      $this->generateHeaders( $method );
    }
    $response = $this->client->request( $method, $url, [ 'headers' => $this->headers ] );
    return $response;
  }
  /**
   * Do a Raw Post of a JSON content
   *
   * @param $url
   * @param bool $body
   * @return mixed|\Psr\Http\Message\ResponseInterface
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  private function postJson( $url, $body = false ) {
    $method = 'POST';
    $this->generateHeaders( $method, $body );
    $response = $this->client->request( $method, $url, [ 'headers' => $this->headers, 'json' => $body ] );
    return $response;
  }

  /**
   * Do a urlencoded form POST
   *
   * @param $url
   * @param bool $postParameters
   * @return mixed|\Psr\Http\Message\ResponseInterface
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  private function postForm( $url, $postParameters = false ) {
    $response = $this->client->request( 'POST', $url, [ 'headers' => $this->headers, 'form_params' => $postParameters ] );
    return $response;
  }
	
	 public function startProcess($body) :array
    {
		$responses = $this->postForm($this->apiuri."/init_transactions/", $body); 
		print_r($responses);	  
	 echo "julien";
	 }

}