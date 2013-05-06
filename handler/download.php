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
	$mypass = "itsmyL1fe";
	
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
		if(!$ssh->login('scb8803',$mypass) || !$sftp->login('scb8803',$mypass))
		{
			$result = "Login Failed";
			//echo("Login Failed");
		}
		else
		{
		
			$isTestCaseSet = False;
			$isStdInSet = False;
			
			$pieces = "";
			if(!empty($_POST['testCase']))
			{
				$isTestCaseSet = True;
				$pieces = explode(",", $_POST['testCase']);
			}
			
			if(!empty($_POST['stdin']))
			{
				$isStdInSet = True;
				$pieces = explode(",", $_POST['stdin']);
			}
				
			// run C program
			if(isset($_POST['langhide']) && $_POST[ 'langhide'] == "c")
			{
				
				
				
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
					unset($_SESSION['compilation_error']);
					$result = array();
					//echo "111";
					if($isTestCaseSet != True && $isStdInSet != True)
					{
						
						$result[0] = $ssh->exec('./main');
						
						//echo $result;
					}
					else if($isTestCaseSet != True && $isStdInSet == True)
					{
						
						for($i=0;$i<count($pieces);$i++)
						{
							//echo "sss";
							file_put_contents('input.txt', $pieces[$i]);
							$result[$i] = $ssh->exec('./main < input.txt');
						}
						//echo $result[0];
					}
					
					else if($isTestCaseSet == True && $isStdInSet != True)
					{
						for($i=0;$i<count($pieces);$i++)
						{
							
							$result[$i] = $ssh->exec('./main '.$pieces[$i]);
						}
						
					}	
					
					
					
					unlink($_SERVER['DOCUMENT_ROOT'].'main'); // delete the exe file for that program
						
				}
			}
			
			//run C++ Program
			if(isset($_POST['langhide']) && $_POST['langhide'] == "cpp")
			{
				
				
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
					// no compilation error. run the program.
					unset($_SESSION['compilation_error']);
					
					$result = array();
					if($isTestCaseSet != True && $isStdInSet != True)
					{
						$result[0] = $ssh->exec('./main');
					}
					else if($isTestCaseSet != True && $isStdInSet == True)
					{
						for($i=0;$i<count($pieces);$i++)
						{
							file_put_contents('input.txt', $pieces[$i]);
							$result[$i] = $ssh->exec('./main < input.txt');
						}
						
					}
					else if($isTestCaseSet == True && $isStdInSet != True)
					{
						for($i=0;$i<count($pieces);$i++)
						{
							$result[$i] = $ssh->exec('./main '.$pieces[$i]);
						}
						
					}
					
					
					unlink($_SERVER['DOCUMENT_ROOT'].'main'); // delete the exe file for that program
				}
			}
			
			// run Java program
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "java")
			{
				
				
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
					RedirectToURL(BASE_URL."/codeIt/index.php?&lang=".$_POST['langhide']."&classname=".$_GET['classname']);
					//echo "222";
					// compilation error occured.
				}
				else
				{
				
					// no compilation error. run the program.
					unset($_SESSION['compilation_error']);
					
					$result = array();
					if($isTestCaseSet != True && $isStdInSet != True)
					{
						$result[0] = $ssh->exec('java hello');
					}
					else if($isTestCaseSet != True && $isStdInSet == True)
					{
						
						for($i=0;$i<count($pieces);$i++)
						{
							file_put_contents('input.txt', $pieces[$i]);
							$result[$i] = $ssh->exec('java hello < input.txt');
						}
						
					}
					else if($isTestCaseSet == True && $isStdInSet != True)
					{
						
						for($i=0;$i<count($pieces);$i++)
						{
							$result[$i] = $ssh->exec('java hello '.$pieces[$i]);
						}
						
					}
					
					unlink($_SERVER['DOCUMENT_ROOT'].'hello.class'); // delete the class file for that program
				
				}
			}
			
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "py" )
			{
				
				$File = "hello.py";
				$handle = fopen($File,'w');
				
				$data = $_POST['code']."\n\n";
				fwrite($handle,$data);
				fclose($handle);
				$mode = "NET_SFTP_LOCAL_FILE";
				$sftp->put("hello.py",$data,$mode);
				
				
				$result = array();
				if($isTestCaseSet != True && $isStdInSet != True)
				{
					$result[0] = $ssh->exec('python hello.py');
				}
				else if($isTestCaseSet != True && $isStdInSet == True)
				{
					
					for($i=0;$i<count($pieces);$i++)
					{
						file_put_contents('input.txt', $pieces[$i]);
						$result[$i] = $ssh->exec('java hello < input.txt');
					}
					
				}
				else if($isTestCaseSet == True && $isStdInSet != True)
				{
					for($i=0;$i<count($pieces);$i++)
					{
						$result[$i] = $ssh->exec('python hello.py '.$pieces[$i]);
					}
					
				}
					
				unlink($_SERVER['DOCUMENT_ROOT'].'hello.class'); // delete the class file for that program
				
				
			}
			// run PHP program
			else if(isset($_POST['langhide']) && $_POST['langhide'] == "php")
			{
				$File = $_SERVER['DOCUMENT_ROOT']."/codeIt/hello.php";
				$handle = fopen($File,'w');
				
				$data = $_POST['code']."\n\n";
				fwrite($handle,$data);
				fclose($handle);
				//$mode = "NET_SFTP_LOCAL_FILE";
				//$sftp->put("hello.php",$data,$mode);
				
				$result = array();
				
				if($isTestCaseSet != True && $isStdInSet != True)
				{
					$result[0] = file_get_contents(BASE_URL."/codeIt/hello.php");
				}
				/*else if($isTestCaseSet != True && $isStdInSet == True)
				{
					
					for($i=0;$i<count($pieces);$i++)
					{
						file_put_contents('input.txt', $pieces[$i]);
						$result[$i] = $ssh->exec('java hello < input.txt');
					}
					
				}
				else if($isTestCaseSet == True && $isStdInSet != True)
				{
					echo $pieces[0];
					for($i=0;$i<count($pieces);$i++)
					{
						$result[$i] = file_get_contents(BASE_URL."/codeIt/hello.php ".$pieces[$i]);
					}
					
				}*/
				
				
				unlink($_SERVER['DOCUMENT_ROOT'].'/codeIt/hello.php'); // delete the file after execution
			}
		}
	
		// session variable which stores the result to be output
		$_SESSION['coderesult'] = $result;
		
		
		//echo $_SESSION['coderesult'];
		//unset($_SESSION['coderesult']);
		RedirectToURL(BASE_URL."/codeIt/index.php?lang=".$_POST['langhide']."&classname=".$_GET['classname']);

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
	


?>