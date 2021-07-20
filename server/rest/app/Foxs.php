<?php

class Foxs extends Rest {
  
  protected $endpoint;
  protected $fox;
  protected $foxs;
  
  //Method
  //Setter
  public function __construct()
  {
    $this->endpoint = parent::getFoxsUrl();
    $response = parent::request($this->endpoint);
    $response = parent::getJSON($response, true);
    
    $this->fox = $response;
  }
  
  //Getter
  public function getFox()
  {
    return $this->fox;
  }
  
  public function getFoxs($limit = 1)
  {
    $response = parent::reqInterval($limit, $this->endpoint);
    $response = $this->modify($response);
    $response = parent::getJSON($response);
    
    $this->foxs = $response;
    
    return $this->foxs;
  }
  
  //Modifikasi JSON
  private function modify($JSON)
  {
    $results = json_decode( json_encode($JSON), true);
    $urls = [];
    
    foreach( $results as $item )
    {
      $url = ["url" => $item["image"]];
      $urls[] = $url;
    }
    
    return $urls;
  }
}

?>