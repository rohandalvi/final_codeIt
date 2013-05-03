<?PHP

	// Author: Shardul Bagade
	// v1.0 Author: Shardul Bagade; Comment: Created file. Contains Download script
	// v1.1 Author: Shardul Bagade; Comment: Run script added
	// v1.2 Author: Shardul Bagade; Comment: Publish code script added
	// v1.3 Author: Tushar Nikam; Comment: Added RUN code for Python, C++ with Arguments
	// import files which are needed
	require_once "..//common/utilities.php";
	require_once "..//common/variables.php";
	include('ssh_connection.php');
	
	session_start();
	
	
	// Author: SB; Comment: script to run programs of specified languages
	if(isset($_POST['submission']) && $_POST['submission'] == "Run")
	{
		$mypass = "Password Goes Here";
		$result = "xxx";
		//echo("Login ");
		$ssh = new NET_SSH2('glados.cs.rit.edu');
		if(!$ssh->login('tln8399',$mypass))
		{
		
			$result = "Login Failed";
			//echo("Login Failed");
		}
		else
		{
			// run C program
			if(isset($_POST['langhide']) && $_POST[ 'langhide'] == "c")
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
					//if(isset($_POST['testCase1'])){
						
						//$result = $ssh->exec('./main '.'testCase1.value');
					//}
					//else{
						$result = $ssh->exec('./main '.$_POST['testCase']);
					//}	
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'main'); // delete the exe file for that program
						//echo $result;
					}
					//echo $_SERVER['DOCUMENT_ROOT'];
					
					
				}
			}
			
			//run C++ Program
			if(isset($_POST['langhide']) && $_POST['langhide'] == "cpp"){
			
				$result = $ssh->exec('g++ -o main hello.cpp');
				if($result != "")
				{
					//echo "asdf";
					// compilation error occured.
				}
				else
				{
					$result = $ssh->exec('./main '.$_POST['testCase']);
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'main'); // delete the exe file for that program
						//echo $result;
					}
				}
			}
			
			// run Java program
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "java")
			{
				//echo $_POST['testCase'];
				echo "1111";
				$result =  $ssh->exec('javac hello.java');
				if($result != "")
				{
					echo "222";
					// compilation error occured.
				}
				else
				{
				
					// no compilation error. run the program.
					$result = $ssh->exec('java hello '.$_POST['testCase']);
					
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'hello.class'); // delete the class file for that program
						//echo $result;
					}
				
				}
			}
			
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "py" ){
				
				$result = $ssh->exec('python hello.py');
				
			
			}
			
			
		}
	
		// session variable which stores the result to be output
		$_SESSION['coderesult'] = $result;
		//unset($_SESSION['coderesult']);
		RedirectToURL(BASE_URL."/codeIt/index.php");

	}
	else if(isset($_POST['submission']) && $_POST['submission'] == "Download")
	{
	
	
		// Author: SB; Comment: changed $GET to $POST for getting the file extension.
		if(isset($_POST['code'])) { //only do file operations when appropriate
			$a = $_POST['code'];
			
			// Author: SB; Comment: generate name of the file with random string
			
			$fname = get_random_string("possible", 4);
			$myFile = $fname.".txt";
			
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
	else if(isset($_POST['submission']) && $_POST['submission'] == "Publish")// script to publish code
	{
		if(isset($_POST['code'])) {
			$a = $_POST['code'];
			
			$count = 0;
			do
			{
				// generate name of the file with random string
				$fname = get_random_string("userfile", 8);
				$random_no = str_pad(rand(0,99), 2, "0", STR_PAD_LEFT);
				$myFile = 'user_'.$random_no.'_'.$fname.".txt";
				
			}while(file_exists($myFile));
			
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, $a);
			fclose($fh);
		}
		
		RedirectToURL(BASE_URL."/codeIt/index.php?file=".$myFile);
	}
	

	
?>