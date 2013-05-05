<?php
class functions
{
	function parseregex($array)
	{
	$regex = array();
        foreach($array as $subarr)
        {
          $regex[] = implode(':',$subarr);
         }
        
	 $string_to_be_parsed =  implode(',',$regex);
         
        $pattern = "/\\d/i";
        if(preg_match_all($pattern, $string_to_be_parsed,$match))
        {
            
            
            return $match;
        }
        //the code below converts the line number to string and then returns.
         //   $int = filter_var($string_to_be_parsed,FILTER_SANITIZE_NUMBER_INT);
           // return $int;
	}
}

?>
