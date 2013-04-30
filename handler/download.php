<?PHP

	// Author: Shardul Bagade
	// Comment: Created file. Contains Download script
	
	// import utilities file
	require_once "..//common/utilities.php";
	
	// Author: SB; Comment: changed $GET to $POST for getting the file extension.
	if(isset($_POST['code'])) { //only do file operations when appropriate
        $a = $_POST['code'];
		
		// Author: SB; Comment: generate name of the file with random string
		$fname = get_random_string("possible", 4);
		$myFile = $fname.".txt";
		
		//$myFile = "t.txt";
		
		// Author: SB; Comment: file extension functionality added
		if(isset($_POST['langhide']))
		{
			$myFile = $fname.".".$_POST['langhide'];
		}
		else
		{
			$_POST['langhide'] = "txt";
		}	
        
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $a);
        fclose($fh);
    }
	
	
	
	//download.php
	//content type
	header('Content-type: text/plain');
	$filename = $fname.".".$_POST['langhide'];
	//open/save dialog box
	header('Content-Disposition: attachment; filename='.$filename);
	//read from server and write to buffer
	readfile($fname.".".$_POST['langhide']);

	
?>