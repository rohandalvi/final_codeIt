<<<<<<< HEAD
<?PHP

	// Author: Shardul Bagade
	// v1.0 Author: Shardul Bagade; Comment: Created file. Contains Download script
	// v1.1 Author: Shardul Bagade; Comment: Run script added
	// v1.2 Author: Shardul Bagade; Comment: Publish code script added
	// v1.3 Author: Tushar Nikam; Comment: Added RUN code for Python, C++ with Arguments
	// import files which are needed
	require_once "../common/utilities.php";
	require_once "../common/variables.php";
	include('../phpseclib/SSH2.php');
	
	session_start();
	
	
	// Author: SB; Comment: script to run programs of specified languages
	if(isset($_POST['submission']) && $_POST['submission'] == "Run")
	{
		$mypass = "Enter Password";
		$result = "xxx";
		
		//echo("Login ");
		$ssh = new NET_SSH2('glados.cs.rit.edu');
		if(!$ssh->login('rsd3565',$mypass))
		{
		
			$result = "Login Failed";
			//echo("Login Failed");
		}
		else
		{
			// run C program
			if(isset($_POST['langhide']) && $_POST[ 'langhide'] == "c")
			{	
				$pieces = explode(",", $_POST['testCase']);
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
					$result = array();
					for($i=0;$i<count($pieces);$i++)
						$result[$i] = $ssh->exec('./main '.$pieces[$i]);
						
					
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
				
				$pieces = explode(",", $_POST['testCase']);
				$result = $ssh->exec('g++ -o main hello.cpp');
				if($result != "")
				{
					//echo "asdf";
					// compilation error occured.
				}
				else
				{
					$result = array();
					for($i=0;$i<count($pieces);$i++)
						$result[$i] = $ssh->exec('./main '.$pieces[$i]);
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
			
				$pieces = explode(",", $_POST['testCase']);
				
				$result =  $ssh->exec('javac hello.java');
				if($result != "")
				{
					echo "222";
					// compilation error occured.
				}
				else
				{
				
					// no compilation error. run the program.
					//$result = $ssh->exec('java hello '.$_POST['testCase']);
					$result = array();
					for($i=0;$i<count($pieces);$i++)
						$result[$i] = $ssh->exec('java hello '.$pieces[$i]);
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'hello.class'); // delete the class file for that program
						//echo $result;
					}
				
				}
			}
			
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "py" ){
				
				$pieces = explode(",", $_POST['testCase']);
				$result = array();
					for($i=0;$i<count($pieces);$i++)
				//	$result = $ssh->exec('python hello.py '.$_POST['testCase']);
						$result[$i] = $ssh->exec('python hello.py '.$pieces[$i]);
			
			}
			
			
		}
	
		// session variable which stores the result to be output
		$_SESSION['coderesult'] = $result;
		
		//unset($_SESSION['coderesult']);
		RedirectToURL(BASE_URL."/codeIt/index.php?pieces0=".$pieces[0]."&pieces1=".$pieces[1]);

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
			
			// if file session not set creat a new file.
			if(!isset($_SESSION['file']))
			{
				do
				{
					// generate name of the file with random string
					$fname = get_random_string("userfile", 8);
					$random_no = str_pad(rand(0,99), 2, "0", STR_PAD_LEFT);
					$myFile = 'user_'.$random_no.'_'.$fname.".txt";
					
				}while(file_exists($myFile));
			
			}
			else // else update the existing file.
			{
				$myFile =  $_SESSION['file'];
				unset($_SESSION['file']);
			}
			
			
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, $a);
			fclose($fh);
		}
		
		RedirectToURL(BASE_URL."/codeIt/index.php?file=".$myFile);
	}
	

	
=======
<?PHP

	// Author: Shardul Bagade
	// v1.0 Author: Shardul Bagade; Comment: Created file. Contains Download script
	// v1.1 Author: Shardul Bagade; Comment: Run script added
	// v1.2 Author: Shardul Bagade; Comment: Publish code script added
	// v1.3 Author: Tushar Nikam; Comment: Added RUN code for Python, C++ with Arguments
	// import files which are needed
	require_once "../common/utilities.php";
	require_once "../common/variables.php";
	include('../phpseclib/SSH2.php');
	include('../phpseclib/Net/SFTP.php');
	//creating an SFTP session.
	$mypass = "pwd";
	
	// if(!$sftp->login('rsd3565',$mypass))
	// {
		// exit('Login Failed');
	// }
	session_start();
	if(isset($_POST['code'])) $_SESSION['code'] = $_POST['code'];
	
	// Author: SB; Comment: script to run programs of specified languages
	if(isset($_POST['submission']) && $_POST['submission'] == "Run")
	{
		//$mypass = "pwd";
		$result = "xxx";
		$sftp = new NET_SFTP('glados.cs.rit.edu');
		//echo("Login ");
		$ssh = new NET_SSH2('glados.cs.rit.edu');
		if(!$ssh->login('rsd3565',$mypass) || !$sftp->login('rsd3565',$mypass))
		{
		
			$result = "Login Failed";
			//echo("Login Failed");
		}
		else
		{
			// run C program
			if(isset($_POST['langhide']) && $_POST[ 'langhide'] == "c")
			{
				if(isset($_POST['testCase']))	
				$pieces = explode(",", $_POST['testCase']);
				
				
				$File = "hello.c";
				$handle = fopen($File, 'w');
				
				$data = $_POST['code']."\n\n";
				fwrite($handle, $data);
				fclose($handle);
				
				$mode = "NET_SFTP_LOCAL_FILE";
				$sftp->put("hello.c",$data,$mode);
				
				$result =  $ssh->exec('gcc -o main hello.c');
				
				if($result != "")
				{
					$_SESSION['compilation_error']=$result;
					RedirectToURL(BASE_URL."/codeIt/index.php?&lang=".$_POST['langhide']);
					//echo "asdf";
					// compilation error occured.
				}
				else
				{
					if($_POST['testCase']){
					$result = array();
					for($i=0;$i<count($pieces);$i++)
						$result[$i] = $ssh->exec('./main '.$pieces[$i]);}
					else
						{
							$result = $ssh->exec('./main');
						}
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
				if(isset($_POST['testCase']))
				$pieces = explode(",", $_POST['testCase']);
				//Adding text fromt textarea to file, preparing for file writing
				$File = $_GET['classname'].".cpp";
				$handle = fopen($File,'w');
				
				$data = $_POST['code']."\n\n";
				fwrite($handle,$data);
				fclose($handle);
				$mode = "NET_SFTP_LOCAL_FILE";
				$sftp->put("hello.cpp",$data,$mode);
				
				$result = $ssh->exec('g++ -o main hello.cpp');
				if($result != "")
				{
					$_SESSION['compilation_error']=$result;
					RedirectToURL(BASE_URL."/codeIt/index.php?&lang=".$_POST['langhide']);
					//echo "asdf";
					// compilation error occured.
				}
				else
				{
					if(isset($_POST['testCase'])){
					$result = array();
					for($i=0;$i<count($pieces);$i++)
						$result[$i] = $ssh->exec('./main '.$pieces[$i]);}
					else {
						$result = $ssh->exec('./main');
					}
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
				if(isset($_POST['testCase']))
				$pieces = explode(",", $_POST['testCase']);
				//Adding text fromt textarea to file, preparing for file writing
				$File = $_GET['classname'].".java";
				$handle = fopen($File,'w');
				
				$data = $_POST['code']."\n\n
				public class hello
				{\n
					\tpublic static void main(String args[])\n
					{\n
					
						".$_GET['classname'].".main(args);\n
					}\n
					
				}\n
				
				";
				fwrite($handle,$data);
				fclose($handle);
				$mode = "NET_SFTP_LOCAL_FILE";
				$sftp->put("hello.java",$data,$mode);
				//ending file write procedure
				$result =  $ssh->exec('javac hello.java');
				if($result != "")
				{
					$_SESSION['compilation_error']=$result;
					RedirectToURL(BASE_URL."/codeIt/index.php?&lang=".$_POST['langhide']);
					//echo "222";
					// compilation error occured.
				}
				else
				{
				
					// no compilation error. run the program.
					//$result = $ssh->exec('java hello '.$_POST['testCase']);
					if(isset($_POST['testCase'])){
					$result = array();
					for($i=0;$i<count($pieces);$i++)
						$result[$i] = $ssh->exec('java hello '.$pieces[$i]);}
					else{
						$result = $ssh->exec('java hello');
						
					}
					if(count($result)>0)
					{
						// run successful
						unlink($_SERVER['DOCUMENT_ROOT'].'hello.class'); // delete the class file for that program
						//echo $result;
					}
				
				}
			}
			
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "py" )
			{
				if(isset($_POST['testCase']))	{
				$pieces = explode(",", $_POST['testCase']);
					$_SESSION['testCase'] = $_POST['testCase'];
				}
				$File = "hello.py";
				$handle = fopen($File,'w');
				
				$data = $_POST['code']."\n\n";
				fwrite($handle,$data);
				fclose($handle);
				$mode = "NET_SFTP_LOCAL_FILE";
				$sftp->put("hello.py",$data,$mode);
				
				if(isset($_POST['testCase']))
				{
					$result = array();
					for($i=0;$i<count($pieces);$i++)
							$result[$i] = $ssh->exec('python hello.py '.$pieces[$i]);
				}
				else
					{
						$result = $ssh->exec('python hello.py');
					}
			
			}
		}
	
		// session variable which stores the result to be output
		$_SESSION['coderesult'] = $result;
		
		//unset($_SESSION['coderesult']);
		RedirectToURL(BASE_URL."/codeIt/index.php?lang=".$_POST['langhide']."&classname=".$_GET['classname']."&pieces0=".$pieces[0]."&pieces1=".$pieces[1]);

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
	

	
>>>>>>> All changes from my functionality
?>