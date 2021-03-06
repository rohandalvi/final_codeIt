<!DOCTYPE html>
<?php
    include('handler/functions.php');
    require_once "common/variables.php";
	session_start();
	
	include ("handler/currlang.php"); // get the current language and update the label likewise
	
	
	$pubfilecontent = "";
	unset($pubfilecontent);// unset the session by default
	unset($_SESSION['file']);// unset file session by default
	if(isset($_GET['file']))
	{
		$pubfilecontent = file_get_contents('handler/'.$_GET['file'], true);
		$_SESSION['file'] = $_GET['file']; // set file session
	}
	
	$currCode = "";
	if(isset($_SESSION['code'])) 
	{
		$currCode = $_SESSION['code'];
	}
	if(isset($_GET['classname']) && isset($_GET['lang']) && ($_GET['lang'] == "java") &&!isset($_SESSION['code'])) 
	{
		$currCode = "class ".$_GET['classname']."{\n\tpublic static void main(String args[])\n\t{\n\n\n\t}\n}";
	}
	
	$regex = new functions;

?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CodeIt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- linked files -->
    <!--<script src="http://ajax.aspnetcdn.com/ajax/jshint/r07/jshint.js"></script>-->
	<!--<script src="https://raw.github.com/zaach/jsonlint/79b553fb65c192add9066da64043458981b3972b/lib/jsonlint.js"></script> -->
   
    <link rel="stylesheet" href="css/codemirror.css">
    <link rel="stylesheet" href="codemirror/addon/lint/lint.css">
    <!--Adding the Javscript lint files -->
    
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
            <script type="text/javascript">
            /* for text highlighting*/
            function selectTextareaLine(tarea,lineNum) 
			{
					window.console.log("inside selectTextareaLine "+lineNum);
					lineNum--; 
					var lines = tarea.value.split("\n");

					// calculate start/end
					var startPos = 0; var endPos = tarea.value.length;
					for(var x = 0; x < lines.length; x++) {
					if(x == lineNum) {
					break;
					}
					startPos += (lines[x].length+1);

					}

					var letters = lines[x];

					window.console.log("text is "+letters);
					document.write("\nLine is\n"+letters.fontcolor("red"));
					window.console.log("startpos is "+startPos);
					var endPos = lines[lineNum].length+startPos;
					window.console.log("endpos is "+endPos);
					window.console.log("Line number is "+lineNum);
					// do selection
					// Chrome / Firefox

					if(typeof(tarea.selectionStart) != "undefined") {
					window.console.log("tarea.selectionStart is not undefined so tarea.focus() is called, it is "+tarea.selectionEnd);
					tarea.focus();
					tarea.selectionStart = startPos;
					tarea.selectionEnd = endPos;
					return true;
					}

					// IE
					if (document.selection && document.selection.createRange) {
						window.console.log("this one is for IE");
						tarea.focus();
						tarea.select();
						var range = document.selection.createRange();
						range.collapse(true);
						range.moveEnd("character", endPos);
						range.moveStart("character", startPos);
						range.select();
						window.console.log("Now returning true");
						return true;
					}
					window.console.log("Now returning false");
					return false;
			}
			
			
            var name;
            
            	function setClassName()
            	{
            		 name = prompt("Enter class name: ", "Type your java class name here");
            		
            		window.location.href = "http://localhost/codeIt/index.php?lang=java&&classname="+name;
            	}
            	 
            	function getClassName()
            	{
            		return name;
            	}
            	
            	
            </script>
            
           
	<script type="text/javascript" >
	
         var isLangPaneClicked = false;
		$(document).ready(function() 
		{
			$('#lang_id').hide(); // default behavior is to hide language selection panel
			$('#testcasewrapper').hide(); // default behavior is to hide add test case UI
			$('#stdinwrapper').hide(); // default behavior is to hide add test case UI
			$('#richtext_id').hide(); // default behavior is to hide language selection panel
			editor.display.wrapper.style.height = 400 + "px"; //default height of code textarea
			
			getPreviousCode();
		});
		
		function getPreviousCode()
		{
			var whatever = <?php echo json_encode($currCode); ?>;
			editor.setValue(whatever);
		}
		
		
		
	</script>
	<style>
            .CodeMiror{

                border:1px solid #334;
                width: 00px;
            }
            </style>
	
 </head>
 <body>
       
    <div class="container-fluid">
		
		
	  <div class="row-fluid" style="margin-right:-20px;">
		<div class="row">
			    <div class="navbar" >
					<div class="navbar-inner" style="margin-left:20px; background-image: linear-gradient(to bottom, #333, #333);">
					<!-- Author: Shardul Bagade; Comment: Added href URL. -->
					<a class="brand" style="color: #bbb; text-shadow: none;"
						href=<?php echo BASE_URL."/codeIt/index.php" ?>>CodeIt</a>
					<ul class="nav">
					<li class="active">
						<a style="color: #000; text-shadow: none;"
							href=<?php echo BASE_URL."/codeIt/index.php" ?>>Home</a></li>
					<li><a style="color: #bbb; text-shadow: none;"
							href=<?php echo BASE_URL."/codeIt/tutorials_tips.php" ?>>Tutorials / Tips</a></li>
					<li><a style="color: #bbb; text-shadow: none;"
							href="about.php">About</a></li>
					
					
					</ul>
					
					</div>
				</div>
		</div>
		<?php if(isset($_GET['classname'])) { $string = "handler/download.php?classname=".$_GET['classname'];?>
			<form id="codeform" class="form-horizontal" action="<?= $string; ?>" method="post" style="margin-bottom: 0px; margin-left: 40px;">
				<?php }else { ?>
		<form id="codeform" class="form-horizontal" action="handler/download.php" method="post" style="margin-bottom: 0px; margin-left: 40px;"><?php } ?>
		<div class="span7">
			<div class="row">
			    <div id="lang_anchor" class="navbar" style="margin-bottom:5px; margin-left:-20px;">
					<div class="navbar-inner" style="margin-left:20px;">
					<ul class="nav menu">
					<li class="ListItem">
						<button type="submit" class="btn btn-primary" id="runsubmit" name="submission" value="Run"
							class="" style="margin-left:0px;">
						  <i class="icon-play icon-white"></i> Run
						</button>
					</li>
					<li id="test" class="">
						<button type="image" class="btn btn-primary" id="btnlanguage" name="btnlanguage"
							class="" style="margin-left:20px;">
						  <i class="icon-th-list icon-white" rel="tooltip"></i> Language
						</button>
					</li>
					<li id="test" class="">
						<button type="image" class="btn btn-primary" id="btnnewcode" name="btnnewcode"
							class="" style="margin-left:20px;">
						  <i class="icon-file icon-white" rel="tooltip"></i> New
						</button>
					</li>

					<li id="test" class="">
						<button type="image" class="btn btn-primary" id="btnrichtext" name="btnrichtext" class="" value="Rich Text" 
								rel="tooltip" style="margin-left:20px;"">
						  <i class="icon-edit icon-white"></i> Edit
						</button>

					</li>
					</ul>
					
					<!-- Author: SB; Comment: used pull-right class of bootstrap instead of hardcoding the style of the label -->
					<?php if(isset($_GET['lang'])) {?><ul class="nav pull-right">
					  <li class="">

						<label style="padding: 10px 15px 5px; color: #333; cursor: default;">
						  Current Language :  <?php echo $currLang ?>

						</label>
					  </li>
					</ul><?php } ?>
				</div>
			</div>
			<div id="lang_id" class="row" style="">
			    <div class="navbar" style="margin-bottom:5px; margin-left:20px;	">
					<div class="navbar-inner">
						<ul class="nav">
						  <li><a href=<?php echo BASE_URL."/codeIt/index.php?lang=c" ?>>C</a></li>
						  <li><a href=<?php echo BASE_URL."/codeIt/index.php?lang=cpp" ?>>C++</a></li>
						  <li><a href="#" onClick="setClassName()">Java</a></li>
						  <li><a href=<?php echo BASE_URL."/codeIt/index.php?lang=php" ?>>PHP</a></li>
						  <li><a href=<?php echo BASE_URL."/codeIt/index.php?lang=py" ?>>Python</a></li>
						</ul>
					  </div>
				</div>
			</div>
			

			<div id="richtext_id" class="row" style="">
			    <div class="navbar" style="margin-bottom:5px; margin-left:20px;	">
					<div class="navbar-inner">
						<ul class="nav">
							<li>
							<input type="image" id="undo" class="fa-input" value="Undo" title="Undo"
								style="margin-left:0px; margin-top:2px; height: 30px; weight:20px;" src="img/undo.png">
							</li>
							<li>
							<input type="image" id="redo" class="fa-input" value="Redo" title="Redo"
								style="margin-left:20px; margin-top:2px; height: 30px; weight:20px;" src="img/redo.png">
							</li>
							<li>
							<input type="image" id="print" class="fa-input" value="Print" title="Print code"
								style="margin-left:20px; margin-top:2px; height: 40px; weight:20px;" src="img/print.png">
							</li>
							<li>
							<input type="image" id="clear" class="fa-input" value="Clear" title="Clear code"
								style="margin-left:20px; margin-top:6px; height:30px; weight:20px;" src="img/clear.png">
							</li>
							<li><label style="margin-left:20px; padding: 10px 15px 5px; color: #777777;">Font Size</label></li>
							<li>
							<select id="fontSelect" size="5" id="testList" value="14"
								style="height:25px; width:60px; margin-left:-5px; margin-top:8px; color: #777777;" onChange="doFontChange()">
								
								<option value="14" selected="selected">14</option>
								<option value="6">6</option>
								<option value="8">8</option>	
								<option value="10">10</option>
								<option value="12">12</option> 
								<option value="14">14</option>
								<option value="16">16</option>	
								<option value="18">18</option>
								<option value="20">20</option>									
							</select>​
						</li>
						</ul>
					  </div>
				</div>
			</div>
			
			<script type="text/javascript" >
          
		  
					$('#btnlanguage').click(function(event) {
						event.preventDefault(); // to stop submit
						pinUnpinLangPanel();
					});
					
					$('#btnrichtext').click(function(event) {
						event.preventDefault(); // to stop submit
						pinUnpinRichTextPanel();
					});
					
					$('#undo').click(function(event) {
						event.preventDefault(); // to stop submit
						doUndo();
					});
					
					$('#redo').click(function(event) {
						event.preventDefault(); // to stop submit
						doRedo();
					});
					
					$('#print').click(function(event) {
						event.preventDefault(); // to stop submit
						doPrint();
					});
					
					
					// clear the contents of the code textarea
					$('#clear').click(function(event) {
						event.preventDefault(); // to stop submit
						editor.setValue("");
					});
					
					// new code
					$('#btnnewcode').click(function(event) {
					
						event.preventDefault(); // to stop submit
						var retVal = confirm("Previous code will be lost. Do you want to continue ?");
						if( retVal == true ){
							editor.setValue("");
						}else{
							// do nothing
						}
					});
					
					
					

					
					
					function doFontChange(){  
					 
						// donot delete this commented code. for future reference
						
						//var newFontSize = editor.display.wrapper.style.fontSize + 1;
						//alert(editor.getWrapperElement().style["font-size"]);
						//editor.display.wrapper.style.fontSize = newFontSize + "px";
						//editor.refresh();
						
						editor.display.wrapper.style.fontSize = document.getElementById("fontSelect").value + "px";
						editor.refresh();
					  
					}
					
					
				
					function doPrint(){  
					
							var s = editor.getValue();
							var regExp=/\n/gi;
							s = s.replace(regExp,'<br>');
							pWin = window.open('','pWin','location=yes, menubar=yes, toolbar=yes');
							pWin.document.open();
							pWin.document.write('<html><head></head><body>');
							pWin.document.write(s);
							pWin.document.write('</body></html>');
							pWin.print();
							pWin.document.close();
							pWin.close();
					}
									
			</script>
			


			
                            <input type="hidden" id="classname" name="classname" />
                            <input type="hidden" value=<?php echo $_GET['lang'] ?> name="langhide" />
                            <textarea id ="code" name="code" class="span8"
								style="height:442px; width:100%; max-width:100%; min-width:100%;"><?php if(isset($pubfilecontent)){echo $pubfilecontent;} 
							elseif(isset($_SESSION['code'])){ echo $_SESSION['code']; unset($_SESSION['code']);}
								?></textarea>
								<!--<textarea id ="code1" name="code" class="span8"
								style="height:442px; width:100%; max-width:100%; min-width:100%;">This is demo text area for sample usage</textarea>-->
								
                            <script>
                                <?php if(isset($_GET['lang']) && $_GET['lang'] == 'javascript') {?>
                                var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                       mode: "javascript",
                                       parserfile: "js/javascript.js",	
                                       lineWrapping: true,
                                       textWrapping: true,
                                       autoCloseTags: true,
                                       parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
                                       enterMode: "indent",
                                       lineNumbers: true,
									   autofocus: false,
                                       smartIndent: true,
                                       stylesheet: "css/jscolors.css",
                                       matchBrackets: true,
                                       autoCloseBrackets: true,
                                       styleActiveLine: true,
									   runnable: true,
                                       gutters: ["CodeMirror-lint-markers"],
									   
									   //Author: SB; Comment: commented as download would not work 
                                       //lintWith: CodeMirror.javascriptValidator,
									   
                                       placeholder: "Your code goes here",
                                       highlightSelectionMatches: true
                                       
                                }
                        );
                            <?php } ?>

                                <?php if(isset($_GET['lang']) && $_GET['lang'] == 'py') {?>
                            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            mode: {name: "python",
                            version: 2,
                            singleLineStringErrors: false},
                            lineNumbers: true,
                            indentUnit: 4,
                            tabMode: "shift",
							placeholder: "Your code goes here",
                            matchBrackets: true,
                            autoCloseBrackets: true

                            });
                               <?php }?>

                            <?php if(isset($_GET['lang']) && $_GET['lang'] == 'c') { ?>
                            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                               mode: "text/x-csrc",
                               lineNumbers: true,
                               smartIndent: true,
                               tabMode: "shift",
							   placeholder: "Your code goes here",
                               matchBrackets: true,
                               autoCloseBrackets: true


                            });
                                <?php }?>
                                    
                             <?php if(isset($_GET['lang']) && $_GET['lang'] == 'cpp') { ?>
                            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            lineNumbers: true,
                            matchBrackets: true,
							placeholder: "Your code goes here",
                            mode: "text/x-c++src"
                            });
                              <?php } ?>

                             <?php if($_GET['lang'] == 'java') {?>
                                 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                value:"class", 	
                                lineNumbers: true,
                                matchBrackets: true,
								placeholder: "Your code goes here",
                                mode: "text/x-java",
                                autoCloseBrackets: true

                                });

                                 <?php } ?>

                              <?php if(isset($_GET['lang']) && $_GET['lang'] == 'php') { ?>
                                  
                                  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                   lineNumbers: true,
                                    matchBrackets: true,
                                    mode: "text/x-php",
                                    indentUnit: 4,
                                    indentWithTabs: true,
				    placeholder: "Your code goes here",
                                    enterMode: "keep",
                                    tabMode: "shift",
                                    smartIndent: true

                                  });
                                  <?php } ?>
                                </script>

								
					<?php
					include ("handler/testcases.php"); 
					?>
					<?php
					include ("handler/stdin.php"); 
					?>
				<div class="row" style="margin-top:10px;">
					<div class="navbar" style="margin-bottom:5px;">
						<div class="navbar-inner" style="margin-left:20px;">
						<ul class="nav">
						<!-- Author: Shardul Bagade; Comment: Button for downloading code -->
						<li>
						<button type="submit" id="dwnldsubmit" name="submission" class="btn btn-primary" value="Download"
							class="" style="margin-left:0px;">
						  <i class="icon-download-alt icon-white"></i> Download
						</button>
						</li>
						<li>
						<button type="button" id="btnshowtestcase" name="submission" class="btn btn-primary" value="Add test cases"
							class="" style="margin-left:20px;">
						  <i class="icon-plus icon-white"></i> Add test cases
						</button>
						</li>
						<li>
						<button type="button" id="btnshowstdin" name="submission" class="btn btn-primary" value="Enter stdin"
							class="" style="margin-left:20px;">
						  <i class="icon-plus icon-white"></i> Enter stdin
						</button>
						</li>
						<li>
						<button type="submit" id="btnpublish" name="submission" class="btn btn-primary" value="Publish"
							class="" style="margin-left:20px;">
						  <i class="icon-share icon-white"></i> Publish
						</button>
						</li>
						<script>

						
						
						$("#btnshowtestcase").click(function (event) {
								/// function to show the UI for test cases
								/// hide and show test case UI
								/// change the height of code text area while hiding and showing test case UI
								
								event.preventDefault();
								if(document.getElementById('lang_id').style.visibility == 'visible') // close language panel if open
								{	
									document.getElementById('lang_id').style.visibility = 'hidden';
									$('#lang_id').hide();
								}
								
								if(document.getElementById('richtext_id').style.visibility == 'visible') // close rich text box panel if open
								{								
									document.getElementById('richtext_id').style.visibility = 'hidden';
									$('#richtext_id').hide();
								}
								
								if(document.getElementById('testcasewrapper').style.visibility == 'visible')
								{
									document.getElementById('testcasewrapper').style.visibility = 'hidden';
									$('#testcasewrapper').hide("slow");
									editor.display.wrapper.style.height = 400 + "px";
								}
								else if(document.getElementById('testcasewrapper').style.visibility != 'visible')
								{
									if(document.getElementById('stdinwrapper').style.visibility == 'visible')
									{
										document.getElementById('stdinwrapper').style.visibility = 'hidden';
										$('#stdinwrapper').hide("slow");
									}
									
									editor.display.wrapper.style.height = 290 + "px";
									document.getElementById('testcasewrapper').style.visibility = 'visible';
									$('#testcasewrapper').show("medium");
								}
								
								
							});
							
							
							
							$("#btnshowstdin").click(function (event) {
								
								event.preventDefault();
								if(document.getElementById('lang_id').style.visibility == 'visible') // close language panel if open
								{	
									document.getElementById('lang_id').style.visibility = 'hidden';
									$('#lang_id').hide();
								}
								
								if(document.getElementById('richtext_id').style.visibility == 'visible') // close rich text box panel if open
								{								
									document.getElementById('richtext_id').style.visibility = 'hidden';
									$('#richtext_id').hide();
								}
								
								if(document.getElementById('stdinwrapper').style.visibility == 'visible')
								{
									document.getElementById('stdinwrapper').style.visibility = 'hidden';
									$('#stdinwrapper').hide("slow");
									editor.display.wrapper.style.height = 400 + "px";
								}
								else if(document.getElementById('stdinwrapper').style.visibility != 'visible')
								{
									if(document.getElementById('testcasewrapper').style.visibility == 'visible')
									{
										document.getElementById('testcasewrapper').style.visibility = 'hidden';
										$('#testcasewrapper').hide("slow");
									}
								
									editor.display.wrapper.style.height = 290 + "px";
									document.getElementById('stdinwrapper').style.visibility = 'visible';
									$('#stdinwrapper').show("medium");
								}
								
								
							});
		
		
						</script>
						</ul>
						</div>
					</div>
				</div>
	
		</div>
		</form>
		</div>
		
		<div class="span4">
			<!--Sidebar content-->
			<div class="alert alert-info" style="margin-bottom:10px;">
				Compiler's output here:	
			</div>
			<?php
			if(isset($_SESSION['compilation_error'])) //if a compilation error has occurred in any case
			{
				?><pre><b style="text-align: center;">Compiler thrown Error is:</b>
				
				
				<?php 
				switch($_GET['lang']) //this switch is to check which pattern should be applied to process the regular expression.
				{
					case "java": $pattern = "/\java:\d/i";break;
					case "cpp" : $pattern = "(cpp:[0-9])"; break;
					case "c"   : $pattern = "(c:[0-9])";break;
					case "py"  : $pattern = "/\line \d/i"; break;
							 
				}
				if(preg_match_all($pattern, $_SESSION['compilation_error'],$matches)) //if pattern matches with any part of compilation error, then extract line number.
				{
					$solution = $regex->parseregex($matches); //this function returns the line number into $solution which is also an array.
					 foreach($solution as $sol )
                         {
                             $unique = array_unique($sol); // in cases where same line number is returned multiple times by compiler, our program highlights that line just once
                         }
                         
                            echo "\n".$uni;*/
						 //echo "\nMatch found\n"; //print_r($solution);
                         echo "\nFrom function:\n";
                         foreach($solution as $suba)
                            {
                             foreach($suba as $subarray)
                                {
                                    echo "\nError occurs at Line ".$subarray."\n";
                         ?>
                         <script type="text/javascript">
                                      var tarea = document.getElementById("code");
                                      selectTextareaLine(tarea,<?= $subarray ?>); //this js function prints the line after taking the line number as input.
                                    </script>
                                    <?php }} ?>
                         </pre><?php
			
					unset($_SESSION['compilation_error']);
				}
					
			}
else{ 
				if(isset($_SESSION['coderesult'])) // coderesult is the session variable in which the result of run is returned.
				{
					if(gettype($_SESSION['coderesult'])=="Array") // if it is an array.
					{
						$result_array = array();
						array_push($result_array,$_SESSION['coderesult']); //copying array into new array for better usage.
					

						?>
				<pre><b>Output:</b><br/>
				<?php  
				foreach($result_array as $result) 
						echo "\n".$result;?></pre><?php 
					} 
						else //if $_SESSION is not of type array (it is of type string), then do this.
					{
							?>
				<textarea id="output" readonly="true" style="height:442px; width:100%; max-width:100%; min-width:100%;">
					<?php if($_SESSION['coderesult'] == "Login Failed"){
						echo $_SESSION['coderesult'];}
					else {
					?>
					
					<?php
					echo"\nOutput:\n";
					if(true)
					{
						//if the language selected is python, we need to know if its a normal output or error, the below code is for that.
						//the code not added here.
						$array_result = array();
						$array_result = $_SESSION['coderesult'];
						foreach($array_result as $result)
							echo "\n".$result;
						/*foreach($array_result as $coderesult) //this is required for java since a single string is also being returned like an array here.
						?>
						<pre><?php
						 echo $coderesult; ?>*/
						 ?>
						
					<?php 
					}
					else if(true) //if there is just one result, then it is returned as a string in case of 'c','c++'
					{
						
					echo "\n".$_SESSION['coderesult'];
					} 
					}//end of else
					?>
				</textarea>
				<?php		
				} //end of else
					 ?>
						
			  			
			<?php
			
					unset($_SESSION['coderesult']);
				}
}
			?>
		
		</div>
	</div>
	
	<div id="wrap">
	<!--<div id="main" class="container clear-top">
	<p>Your footer content here</p>
	</div>-->
        <div class ="navbar">
            <div class="pagination pagination-centered">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="tutorials_tips.php">Tutorials/Tips</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>

            </div>


        </div>
	</div>
	
	</div>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
     <!-- codemirror js files -->
    <script src ="js/user/common.js"></script>
    <script src="js/codemirror.js"></script>
    <script src="js/clike.js"></script>
    <script src="js/php.js"></script>
    <script src="js/htmlmixed.js"></script>
    <!--<script src="js/htmlembedded.js"></script>-->
    <script src="codemirror/mode/javascript/javascript.js"></script>
    <script src="codemirror/mode/htmlembedded/htmlembedded.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="codemirror/addon/edit/matchbrackets.js"></script>
    <script src="codemirror/addon/edit/closebrackets.js"></script>
    <script src="codemirror/addon/display/placeholder.js"></script>
    <!-- js for tinymce -->
    <script src="codemirror/addon/lint/json-lint.js"></script>
    <script src="codemirror/addon/lint/javascript-lint.js"></script>
    <script src="codemirror/addon/lint/lint.js"></script>
    
    
    <!-- JS to save file in textarea -->
    
    <script src ="js/python.js"></script>
    <!-- codemirror js scripts -->
    
  </body>
  <style>
	
  </style>
  
  
</html>
