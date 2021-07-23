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
  
  //Request 8 pets
  public function multiReq($endpoint)
  {
    
    $ch1 = curl_init($endpoint);
    $ch2 = curl_init($endpoint);
    $ch3 = curl_init($endpoint);
    $ch4 = curl_init($endpoint);
    $ch5 = curl_init($endpoint);
    $ch6 = curl_init($endpoint);
    $ch7 = curl_init($endpoint);
    $ch8 = curl_init($endpoint);
    $ch9 = curl_init($endpoint);
    $ch10 = curl_init($endpoint);
    
    //Setopt
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch5, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch6, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch7, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch8, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch9, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch10, CURLOPT_RETURNTRANSFER, true);
    
    //create the multiple cURL handle
    $mh = curl_multi_init();
    
    //add the two handles
    curl_multi_add_handle($mh,$ch1);
    curl_multi_add_handle($mh,$ch2);
    curl_multi_add_handle($mh,$ch3);
    curl_multi_add_handle($mh,$ch4);
    curl_multi_add_handle($mh,$ch5);
    curl_multi_add_handle($mh,$ch6);
    curl_multi_add_handle($mh,$ch7);
    curl_multi_add_handle($mh, $ch8);
    curl_multi_add_handle($mh, $ch9);
    curl_multi_add_handle($mh, $ch10);
    
    
    //execute the multi handle
    do {
        $status = curl_multi_exec($mh, $active);
        if ($active) {
            curl_multi_select($mh);
        }
    } while ($active && $status == CURLM_OK);
    
    //close the handles
    curl_multi_remove_handle($mh, $ch1);
    curl_multi_remove_handle($mh, $ch2);
    curl_multi_remove_handle($mh, $ch3);
    curl_multi_remove_handle($mh, $ch4);
    curl_multi_remove_handle($mh, $ch5);
    curl_multi_remove_handle($mh, $ch6);
    curl_multi_remove_handle($mh, $ch7);
    curl_multi_remove_handle($mh, $ch8);
    curl_multi_remove_handle($mh, $ch9);
    curl_multi_remove_handle($mh, $ch10);
    curl_multi_close($mh);
    
    // all of our requests are done, we can now access the results
    $results = [ 
      json_decode( curl_multi_getcontent($ch1), true),
      json_decode( curl_multi_getcontent($ch2), true),
      json_decode( curl_multi_getcontent($ch3), true),
      json_decode( curl_multi_getcontent($ch4), true),
      json_decode( curl_multi_getcontent($ch5), true),
      json_decode( curl_multi_getcontent($ch6), true),
      json_decode( curl_multi_getcontent($ch7), true),
      json_decode( curl_multi_getcontent($ch8), true),
      json_decode( curl_multi_getcontent($ch9), true),
      json_decode( curl_multi_getcontent($ch10), true)
    ];
    
    $results = ["results" => $results];
    // output results
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