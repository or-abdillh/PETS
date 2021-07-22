<?php

class Dogs extends Rest {
  
  protected $endpoint;
  protected $dog;
  protected $dogs;
  
  //Method
  //Setter
  public function __construct()
  {
    $this->endpoint = parent::getDogsUrl();
    $response = parent::request($this->endpoint);
    $response = parent::getJSON($response, true);
    
    $this->dog = $response;
  }
  
  //Getter
  public function getDog()
  {
    return $this->dog;
  }
  
  public function getDogs()
  {
    $response = parent::multiReq($this->endpoint);
    $response = $this->modify($response);
    $response = parent::getJSON($response);
    
    $this->dogs = $response;
    
    return $this->dogs;
  }
  
  //Modifikasi JSON
  private function modify($JSON)
  {
    $results = json_decode( json_encode($JSON), true);
    $urls = [];
    
    foreach( $results["results"] as $item )
    {
      $url = ["url" => $item["message"]];
      $urls[] = $url;
    }
    
    return $urls;
  }
}
?>