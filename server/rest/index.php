<?php
//Require file init.php
require_once('app/init.php');

//Valid request format
// server/rest/?category=cat

//Catch GET parameter
if ( isset($_GET["category"]) )
{
  $category = $_GET["category"];
  
  switch ($category)
  {
    case "cat" : 
      $Cats = new Cats();
      echo $Cats->getCats();
    break;
    
    case "dog" :
      $Dogs = new Dogs();
      echo $Dogs->getDogs();
    break;
    
    case "fox" :
      $Foxs = new Foxs();
      echo $Foxs->getFoxs();
    break;
    
    default :
      $Rest = new Rest();
      $error = "Invalid parameter, parameter 'category' must be filled with cat, dog, or fox.";
      echo $Rest->badRequest($error);
  }
} else {
  $Rest = new Rest();
  $error = "no parameter is given, parameter 'category' must be filled with cat, dog, or fox.";
  echo $Rest->badRequest($error);
}
?>