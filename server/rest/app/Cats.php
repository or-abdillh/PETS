<?php

class Cats extends Rest {
  
  protected $endpoint;
  protected $cat;
  protected $cats;
  
  //Construct
  //Request data 
  public function __construct()
  {
    $this->endpoint = parent::getCatsUrl();
    $response = parent::request($this->endpoint);
    $response = parent::getJSON($response);
    
    $this->cat = $response;
  }
  
  //Getter
  //Return as a singgle
  public function getCat()
  {
    return $this->cat;
  }
  
  //Setter and Getter
  //Return many response
  public function getCats()
  {
    $response = parent::multiReq($this->endpoint);
    $response = $this->modify($response);
    $response = parent::getJSON($response);
    $this->cats = $response;
    
    return $this->cats;
  }
  
  //Modify results JSON
  private function modify($array)
  {
    $urls = [];
    
    foreach ($array["results"] as $item)
    {
      $url = ["url" => $item["file"]];
      $urls[] = $url;
    }
    
    return $urls;
  }
}

?>