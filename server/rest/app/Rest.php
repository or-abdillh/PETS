<?php

//Parent Class
class Rest {
  
  //Endpoint URL
  protected $catsUrl = 'https://api.thecatapi.com/v1/images/search?has_breeds=0';
  protected $dogsUrl = 'https://dog.ceo/api/breeds/image/random';
  protected $foxsUrl = 'https://randomfox.ca/floof/';
  
  //Getter
  public function getCatsUrl()
  {
    return $this->catsUrl;
  }
  
  public function getDogsUrl()
  {
    return $this->dogsUrl;
  }
  
  public function getFoxsUrl()
  {
    return $this->foxsUrl;
  }
  
  //Method
  public function request($endpoint)
  {
    // create curl resource
    $curl = curl_init();
    
    // set url
    curl_setopt($curl, CURLOPT_URL, $endpoint);
    
    //Return as string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    //$response contains the output string
    $response = curl_exec($curl);
    
    // close curl resource to free up system resources
    curl_close($curl);
    
    //Convert string to Array Assoc
    $response = json_decode($response, true);
    
    //Return response
    return $response;
  }
  
  //Convert Array Assoc to JSON format
  //Formating response
  public function getJSON($array, $minified = false)
  {
    if ( $minified ) return json_encode($array);
    
    $code = is_null($array) ? 404 : 200;
    $message = $code == 200 ? 'success' : 'not found';
    $length = $code == 200 ? count($array) : 0;
    $category = $_GET["category"];
    
    $JSON = [
      'code' => $code,
      'message' => $message,
      'category' => $category,
      'length' => $length,
      'results' => $array
      ];
      
    return json_encode($JSON);
  }
  
  //Request 10 times
  public function multiReq($endpoint)
  {
    //Make curl_init
    // ch == Curl Http
    $ch_1 = $ch_2 = $ch_3 = $ch_4 = $ch_5 = $ch_6 = $ch_7 = $ch_8 = $ch_9 = $ch_10 = curl_init();
    $vars = [$ch_1, $ch_2, $ch_3, $ch_4, $ch_5, $ch_6, $ch_7, $ch_8, $ch_9, $ch_10];
    
    //Make options
    foreach ($vars as $var)
    {
      curl_setopt($var, CURLOPT_URL, $endpoint);
      curl_setopt($var, CURLOPT_RETURNTRANSFER, true);
    }
    
    //init multi_init
    $mh = curl_multi_init();
    
    //Add multi_handle
    foreach ($vars as $var)
    {
      curl_multi_add_handle($mh, $var);
    }
    
    //Execute multi handle
    do 
    {
      $status = curl_multi_exec($mh, $active);
      
      if ($active)
      {
        curl_multi_select($mh);
      }
    } while ( $active && $status == CURLM_OK);
    
    //Close multi handles
    foreach ($vars as $var)
    {
      curl_multi_remove_handle($mh, $var);
    }
    curl_multi_close($mh);
    
    //Get results
    $results = [];
    foreach ($vars as $var)
    {
      $results[] = json_decode( curl_multi_getcontent($var), true );
    }
    
    $results = ["results" => $results];
    
    //Output
    return $results;
  }
  
  //Response for bad request
  public function badRequest($description)
  {
    $JSON = [
      "code" => 400,
      "message" => "bad request",
      "description" => $description
      ];
      
    echo json_encode($JSON);
  }
}
?>