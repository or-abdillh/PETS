<?php
//Require file init.php
require_once('app/init.php');

//Valid request format
// server/rest/?category=cats&limit=5

//Catch GET parameter
if ( isset($_GET["category"]) )
{
  $category = $_GET["category"];
  
  //If limit not defined
  if ( !isset($_GET["limit"]) )
  {
    $Rest = new Rest();
    $error = "Invalid limitter, zero is given";
    echo $Rest->badRequest($error);
    die;
  }
  
  $limit = intval( $_GET["limit"] );
  
  switch ($category)
  {
    case "cats" : 
      $Cats = new Cats();
      echo $Cats->getCats($limit);
    break;
    
    case "dogs" :
      $Dogs = new Dogs();
      echo $Dogs->getDogs($limit);
    break;
    
    case "foxs" :
      $Foxs = new Foxs();
      echo $Foxs->getFoxs($limit);
    break;
    
    default :
      $Rest = new Rest();
      $error = "Invalid parameter, parameter 'category' must be filled with cats, dogs, or foxs.";
      echo $Rest->badRequest($error);
  }
} else {
  $Rest = new Rest();
  $error = "no parameter is given, parameter 'category' must be filled with cats, dogs, or foxs.";
  echo $Rest->badRequest($error);
}
?>