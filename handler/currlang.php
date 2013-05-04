<?PHP

	// Author: Shardul Bagade
	// Comment: Created file. Contains script for adding test cases of user programs
	
	$currLang = "";
	
	//author: SB; comment: set the default language to "C"
	if(!isset($_GET['lang']))
	{
		$_GET['lang'] = "c";
		$currLang = "C";
	}
	else
	{
		if($_GET['lang'] == "c")
		{
			$currLang = "C";
		}
		else if($_GET['lang'] == "cpp")
		{
			$currLang = "C++";
		}
		else if($_GET['lang'] == "java")
		{
			$currLang = "Java";
		}
		else if($_GET['lang'] == "php")
		{
			$currLang = "PHP";
		}
		else if($_GET['lang'] == "py")
		{
			$currLang = "Python";
		}
			
	}
	
	
	
?>
