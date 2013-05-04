<!DOCTYPE html>
<?php
    
    require_once "common/variables.php";
	session_start();
	
	//author: SB; comment: set the default language to "C"
	if(!isset($_GET['lang']))
	{
		$_GET['lang'] = "c";
	}
	
	//author: SB; comment: script for publish code functionality
	$pubfilecontent = "";
	unset($pubfilecontent);// unset the variable by default
	if(isset($_GET['file']))
	{
		$pubfilecontent = file_get_contents('handler/'.$_GET['file'], true);
	}
	
	
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
    <script src="codemirror/addon/search/match-highlighter.js"></script>
    <script src="codemirror/addon/selection/active-line.js"></script>
    <script src="codemirror/addon/lint/lint.js"></script>
    <!-- js for tinymce -->

    <script src="tiny_mce/tiny_mce.js"></script>
    
    <!-- JS to save file in textarea -->
    
    <script src ="js/python.js"></script>
    <link rel="stylesheet" href="css/codemirror.css">
    <link rel="stylesheet" href="codemirror/addon/lint/lint.css">
    <!--Adding the Javscript lint files -->
    <script src="codemirror/addon/lint/json-lint.js"></script>
    <script src="codemirror/addon/lint/javascript-lint.js"></script>
    <script src="codemirror/addon/lint/lint.js"></script>
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
            <script type="text/javascript">
				var name;
           
            	function setClassName()
            	{
            		 name = prompt("Enter class name: ", "Type your java class name here");
            		//document.getElementById("classname").value=name;
            		window.location.href = "http://localhost/codeIt/index.php?lang=java&&classname="+name;
            	}
            	 
            	function getClassName()
            	{
            		return name;
            	}
            	
            </script>
            
           
	<script type="text/javascript" >
		$(document).ready(function() 
		{
			$('#lang_id').hide(); // default behavior is to hide language selection panel
			$('#testcasewrapper').hide(); // default behavior is to hide add test case UI
			$('#richtext_id').hide(); // default behavior is to hide language selection panel
		});
		
		// Author: Shardul Bagade; Comment: Removed unwanted functions
		
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
					<div class="navbar-inner" style="margin-left:20px;">
					<!-- Author: Shardul Bagade; Comment: Added href URL. -->
					<a class="brand" href=<?php echo BASE_URL."/codeIt/index.php" ?>>CodeIt</a>
					<ul class="nav">
					<li class="active"><a href=<?php echo BASE_URL."/codeIt/index.php" ?>>Home</a></li>
					<li><a href="#">Tutorials / Tips</a></li>
					<li><a href="about.php">About</a></li>
					
					
					</ul>
					
					</div>
				</div>
		</div>
		
		<form id="codeform" class="form-horizontal" action="handler/download.php" method="post" style="margin-bottom: 0px; margin-left: 40px;">
		<div class="span7">
			<div class="row">
			    <div id="lang_anchor" class="navbar" style="margin-bottom:5px; margin-left:-20px;">
					<div class="navbar-inner" style="margin-left:20px;">
					<ul class="nav menu">
					<li class="active ListItem"><input type="submit" id="runsubmit" name="submission" class="btn fa-input" value="Run"/></li>
					<li id="test" class="">
						<input type="button" id="btnlanguage" name="btnlanguage" class="btn fa-input" value="Languages" 
							onclick="pinUnpinLangPanel()" rel="tooltip" style="margin-left:20px;"/>
					</li>
					<li id="test" class="">
						<input type="button" id="btnrichtext" name="btnrichtext" class="btn fa-input" value="Rich Text" 
							onclick="pinUnpinRichTextPanel()" rel="tooltip" style="margin-left:20px;"/>
					</li>
					</ul>
					
					<!-- Author: SB; Comment: used pull-right class of bootstrap instead of hardcoding the style of the label -->
					<ul class="nav pull-right">
					  <li class="">
						<label style="padding: 10px 15px 5px; color: #777777;">
						  Current Language :  <?php echo $_GET['lang'] ?>
						</label>
					  </li>
					</ul>
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
						  <li><input type="button" id="undo" onClick="doUndo()" class="btn fa-input" value="Undo" style="margin-left:0px;"></li>
						  <li><input type="button" id="redo" onClick="doRedo()" class="btn fa-input" value="Redo" style="margin-left:20px;"></li>
						  <li><input type="button" id="print" onClick="doPrint()" class="btn fa-input" value="Print" style="margin-left:20px;"></li>
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
          
					// Author: Shardul Bagade; Comment: Change font based on selected value
					function doFontChange(){  
					 
						// donot delete this commented code. for future reference
						
						//var newFontSize = editor.display.wrapper.style.fontSize + 1;
						//alert(editor.getWrapperElement().style["font-size"]);
						//editor.display.wrapper.style.fontSize = newFontSize + "px";
						//editor.refresh();
						
						editor.display.wrapper.style.fontSize = document.getElementById("fontSelect").value + "px";
						editor.refresh();
					  
					}
					
					
					// Author: Shardul Bagade; Comment: Print the code
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
			
			<!-- Author: Shardul Bagade; Comment: Call download.php which contains downloading script -->
			<!-- Author: Shardul Bagade; Comment: download script shifted to handler folder -->
			
                            <input type="hidden" id="classname" name="classname" />
                            <input type="hidden" value=<?php echo $_GET['lang'] ?> name="langhide" />
                            <textarea id ="code" name="code" class="span8"
								style="height:442px; width:100%; max-width:100%; min-width:100%;"><?php if(isset($pubfilecontent)){echo $pubfilecontent;} ?></textarea>
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
                            matchBrackets: true
                            });
                               <?php }?>

                            <?php if(isset($_GET['lang']) && $_GET['lang'] == 'c') { ?>
                            var jsEditor = CodeMirror.fromTextArea(document.getElementById("code"), {
                               mode: "javascript",
                               lineNumbers: true,
                               smartIndent: true,
                               tabMode: "shift",
                               matchBrackets: true

                            });
                                <?php }?>
                                    
                             <?php if(isset($_GET['lang']) && $_GET['lang'] == 'cpp') { ?>
                            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            lineNumbers: true,
                            matchBrackets: true,
                            mode: "text/x-c++src"
                            });
                              <?php } ?>

                             <?php if($_GET['lang'] == 'java') {?>
                                 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                value:"class", 	
                                lineNumbers: true,
                                matchBrackets: true,
                                mode: "text/x-java"
                                });
								
								
								
                            <?php } ?>

                              <?php if(isset($_GET['lang']) && $_GET['lang'] == 'php') { ?>
                                  
                                  var phpeditor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                   lineNumbers: true,
                                    matchBrackets: true,
                                    mode: "text/x-php",
                                    indentUnit: 4,
                                    indentWithTabs: true,
                                    enterMode: "keep",
                                    tabMode: "shift"

                                  });
                                  <?php } ?>
                                </script>

								
					<?php
					include ("handler/testcases.php"); 
					?>
				<div class="row" style="margin-top:10px;">
					<div class="navbar" style="margin-bottom:5px;">
						<div class="navbar-inner" style="margin-left:20px;">
						<ul class="nav">
						<!-- Author: Shardul Bagade; Comment: Button for downloading code -->
						<li><input type="submit" id="dwnldsubmit" name="submission" class="btn fa-input" value="Download"></li>
						<li><input type="button" id="btnshowtestcase" class="btn fa-input" value="Add test cases" style="margin-left:20px;"></li>
						<li><input type="submit" id="btnpublish" name="submission" class="btn fa-input" value="Publish" style="margin-left:20px;"></li>
						<script>
							$("#btnshowtestcase").click(function () {
								/// function to show the UI for test cases
								/// hide and show test case UI
								/// change the height of code text area while hiding and showing test case UI
								if(document.getElementById('testcasewrapper').style.visibility == 'visible')
								{
									document.getElementById('testcasewrapper').style.visibility = 'hidden';
									$('#testcasewrapper').hide("slow");
									
									var text = document.getElementById('code');
									text.style.height = '442px';
								}
								else if(document.getElementById('testcasewrapper').style.visibility != 'visible')
								{
									var text = document.getElementById('code');
									text.style.height = '320px';
									
									document.getElementById('testcasewrapper').style.visibility = 'visible';
									$('#testcasewrapper').show("medium");
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
				// Author: SB; Comment: ssh code shifted to download.php
				if(isset($_SESSION['coderesult']))
				{
					$result_array = array();
					$result_array = $_SESSION['coderesult'];
			?>
				<pre><b>Output:</b><br/>
				<?php  foreach($result_array as $result) 
						echo "\n".$result;?></pre>
			  			
			<?php
			
					unset($_SESSION['coderesult']);
				}
			?>
		
		</div>
	</div>
	
	<div id="wrap">
	<!--<div id="main" class="container clear-top">
	<p>Your footer content here</p>
	</div>-->
        <div class ="navbar navbar-fixed-bottom">
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
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <!-- codemirror js scripts -->
    
  </body>
  <style>
	
  </style>
  
  
</html>
