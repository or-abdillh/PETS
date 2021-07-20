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
  
  //Request x times
  //Return as array
  public function reqInterval($count = 1, $endpoint)
  {
    $array = [];
    //Max request 10
    $limit = $count <= 10 ? $count : 10;
    
    for ( $x = 0; $x < $limit; $x++)
    {
      $response = $this->request($endpoint);
      //Push $response to $array
      $array[] = $response;
    }
    
    return $array;
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