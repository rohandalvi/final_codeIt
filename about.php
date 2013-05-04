<!DOCTYPE HTML>

<?php
    
    require_once "common/variables.php";
	
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>About CodeIt</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/bootstrap.css" rel="stylesheet">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script type="text/javascript" src="js/bootstrap-collapse.js"></script>
    </head>
    <body>
	
	<div class="row-fluid" >
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
        <div class="row-fluid" style="margin-top: 60px;">
            <div class="row-fluid">
                <div class="span2">
                
                </div>
                <div class="span8">
                    <div class="well">
                        <p class="text-info" style="font-size:200%; text-align:center">About CodeIt</p>
                        
                            <div class="row-fluid"><br />  
                        </div>
                        <div class="row-fluid"><br />
                            <p><blockquote>CodeIt  is  an  online  compiler/interpreter,  wherein  users  can  execute  programs. We
                            to   provide  a  large  gamut  of  languages  for  users  to   choose  from.  CodeIt  can  be  thought  as  a
                            pastebin  where  users  can  just  paste  the  code  they  want  or  even  write  a  code  themselves.</blockquote><br />
                            <blockquote>

                                CodeIt  will  be  developed  in  PHP,  HTML,  CSS  and  JavaScript.  We  have  chosen  these
                                technologies  as,  though,  HTML  has  some  limitations  when   it  comes  to  layout,  CSS  and
                                JavaScript  could  be used  to provide  a  rich  GUI.  Also  we  will  be  using  basic  features of them so
                                that it could be supported by all browsers.
                            </blockquote>
                             <div id="myCollapsibleExample"><a href="#demo" data-toggle="collapse" style="margin-left:15px;">How CodeIt works ?</a></div>
                               <div id="demo" class="collapse" style="margin-left:15px;">
                                   <br /> Users  has  to  select  the  language  of  his  choice.  Then  he  can  either  paste  the  program  or  even
                                        write  a  program  in   the  editor  itself.  After  user  are  confident,   they  can  click  the  execute button.
                                        CodeIt  will  then  run  the  program on  its  server  and  output  the  results/errors
                                        users to see.
                               </div>

                            <br /><div id="myCollapsibleExample"><a href="#demo1" data-toggle="collapse" style="margin-left:15px;">Programming Languages Support</a></div>
                           <div id="demo1" class="collapse" style="margin-left:15px;">
                               <br /><ol>
                                   <li>C</li><li>C++</li><li>Javascript</li><li>PHP</li>
                               </ol>
                           </div>

                            <br /><div id="myCollapsibleExample"><a href="#features" data-toggle="collapse" style="margin-left:15px;">Features Provided: </a></div>
                               <div id="features" class="collapse" style="margin-left:15px;">
                                   <br /> <ol>
                                       <li>

                                           Responsive Editor to write programs.
                                       </li>
                                       <li>Output results/errors just besides the code.</li>
                                       <li>Syntax Highlighting.</li>
                                       <li>Tips and Tutorials.</li>
                                       <li>Run Test Cases.</li>
                                       <li>Provide line highlighting when error occurs.</li>

                                   </ol>
                               </div>

                        </p>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
        <div class ="navbar ">
            <div class="pagination pagination-centered">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="tutorials_tips.php">Tutorials/Tips</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>

            </div>

        </div>
        <!--<div class="row">
   <div class="span4">
      <div class="well">sdfijoidfisdonsdfiosdnfosdi</div>
   </div>
   <div class="span4">
      <div class="well">sdfijoidfisdonsdfiosdnfosdi</div>
   </div>
   <div class="span4">
      <div class="well">sdfijoidfisdonsdfiosdnfosdi</div>
   </div>
</div>
<div class="row">
   <div class="span4">
      <div class="well">sdfijoidfisdonsdfiosdnfosdi</div>
   </div>
   <div class="span4">
      <div class="well">sdfijoidfisdonsdfiosdnfosdi</div>
   </div>
   <div class="span4">
      <div class="well">sdfijoidfisdonsdfiosdnfosdi</div>
   </div>
</div>-->
    </body>
</html>