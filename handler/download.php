<?PHP

	// Author: Shardul Bagade
	// Comment: Created file. Contains Download and Run program script
	
	// import utilities file
	require_once "..//common/utilities.php";
	require_once "..//common/variables.php";
	include('ssh_connection.php');
	session_start();
	
	
	// Author: SB; Comment: script to run programs of specified languages
	if(isset($_POST['submission']) && $_POST['submission'] == "Run")
	{
		$mypass = "pwd";
		$result = "xxx";
		//echo("Login ");
		$ssh = new NET_SSH2('glados.cs.rit.edu');
		if(!$ssh->login('scb8803',$mypass))
		{
		
			$result = "Login Failed";
			//echo("Login Failed");
		}
		else
		{
			// run C program
			if(isset($_POST['langhide']) && $_POST['langhide'] == "c")
			{
				$result =  $ssh->exec('gcc -o main hello.c');
				if($result != "")
				{
					//echo "asdf";
					// compilation error occured.
				}
				else
				{
					// no compilation error. run the program.
				
					$result = $ssh->exec('./main');
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'main'); // delete the exe file for that program
						//echo $result;
					}
					//echo $_SERVER['DOCUMENT_ROOT'];
					
					
				}
			}
			
			// run Java program
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "java")
			{
				echo "1111";
				$result =  $ssh->exec('javac HelloWorld.java');
				if($result != "")
				{
					echo "222";
					// compilation error occured.
				}
				else
				{
					// no compilation error. run the program.
					$result = $ssh->exec('java HelloWorld');
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'HelloWorld.class'); // delete the class file for that program
						//echo $result;
					}
				
				}
			}
			
			
		}
	
		// session variable which stores the result to be output
		$_SESSION['coderesult'] = $result;
		//unset($_SESSION['coderesult']);
		RedirectToURL(BASE_URL."/codeIt/index.php");

	}
	else if(isset($_POST['submission']) && $_POST['submission'] == "Download") // download script starts here.
	{
	
	
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
		
	}

	
?>