<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ZpanelX API</title>
<style type="text/css">
body{
background-color: #0C1021;
-webkit-transition: background-color 0.5s ease-out;
-moz-transition: background-color 0.5s ease-out;
-ms-transition: background-color 0.5s ease-out;
-o-transition: background-color 0.5s ease-out;
transition: background-color 0.5s ease-out;
margin:25px;
font: 16px/20px Consolas,"Andale Mono WT","Andale Mono","Lucida Console","Lucida Sans Typewriter","DejaVu Sans Mono","Bitstream Vera Sans Mono","Liberation Mono","Nimbus Mono L",Monaco,"Courier New",Courier,monospace;
}
h2{color:#FF6400;}
.welcome,.code{
color: #08F;
color: rgba(0, 136, 255, .9);
white-space: pre;
margin: 0;
position: relative;
z-index: 1;
display: inline;
}

.php_start, .php_end{color:#FF6400;}
.variable{color: #08F;color: rgba(0, 136, 255, .9)!important;}
.class{color:#A70;}
.new,.function{color:#A70;}
.equal, .arrow, .end, .comma{color:#8DA6CE;}

input, textarea{background:#0C1021;color:#61CE3C;border:0!important;font: 16px/20px Consolas,"Andale Mono WT","Andale Mono","Lucida Console","Lucida Sans Typewriter","DejaVu Sans Mono","Bitstream Vera Sans Mono","Liberation Mono","Nimbus Mono L",Monaco,"Courier New",Courier,monospace;cursor:text;
}
input[name=name]{min-width:150px;width:auto;}
input[name=module]{width:150px;}
input[name=function]{width:150px;}
input[name=api]{width:200px;}
input[name=user]{width:100px;}
input[name=pass]{width:100px;}
textarea{width:300px;height:150px;}
textarea.small{width:80%;height:200px;}

.small{font-size:12px;}
code,pre{color:#61CE3C;}
</style>
</head>
<body>
<div class="welcome">
/* -------------------------------------------------------------
    ZpanelX, API testing
    =====================================================

    With this script is it easy to test your API features,
    and get rid of the errors you never have made. Simple
    enter your api informations and get everything back
    in one request.

    Design proadly stolen from css3please.com (great tool)

------------------------------------------------------------- */
</div>
<form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="post">
<div class="code">
<span class="php_start">&lt;?php</span>
	<span class="variable">$xmws</span> <span class="equal">=</span> <span class="new">new xmwsclient()</span><span class="end">;</span>
	<span class="variable">$xmws</span><span class="arrow">-></span><span class="function">InitRequest(</span><input name="panel" type="text" value="<?php echo ($_POST['panel']) ? $_POST['panel'] : 'http://zpanelx.domain.com'; ?>" /><span class="comma">,</span><input name="module" type="text" value="<?php echo ($_POST['module']) ? $_POST['module'] : 'Module_name'; ?>" /></span><span class="comma">,</span> <input name="function" type="text" value="<?php echo ($_POST['function']) ? $_POST['function'] : 'Webservice function'; ?>"/><span class="comma">,</span> <input name="api" type="text" value="<?php echo ($_POST['api']) ? $_POST['api'] : 'API code'; ?>" /><span class="comma">,</span><input name="user" type="text" value="<?php echo ($_POST['user']) ? $_POST['user'] : 'Username'; ?>" /><span class="comma">,</span><input name="pass" type="text" value="<?php echo ($_POST['pass']) ? $_POST['pass'] : 'Password'; ?>" /><span class="function">)</span><span class="end">;</span>
	<span class="variable" style="vertical-align:top">$xmws</span><span class="arrow" style="vertical-align:top">-></span><span class="function" style="vertical-align:top">SetRequestData(</span></span><textarea name="data"><?php echo ($_POST['data']) ? $_POST['data'] : 'Request xml data'; ?></textarea><span class="function">)</span><spn class="end">;</span>
<span class="php_end">?&gt;</span>
<input type="submit" value="Run code..." name="submit"/>
</div>
</form>


<?php
require 'xmwsclient.class.php';

if($_POST['submit']){

	setcookie("api_zpanelx", $_POST['api'], time() + 9600);

	$xmws = new xmwsclient();
	$xmws->InitRequest($_POST['panel'], $_POST['module'], $_POST['function'], $_POST['api'],$_POST['user'],$_POST['pass']);
	$xmws->SetRequestData($_POST['data']);

	$build_request = $xmws->Request($xmws->BuildRequest());
	$response_array = $xmws->XMLDataToArray($xmws->Request($xmws->BuildRequest()), 0);

	echo "<h2>Your request</h2>";
	echo "<div class=\"small code\"><code>";
	print_r(htmlspecialchars(trim($xmws->BuildRequest())));
	echo "</code></div><br />";


	echo "<h2>Return request</h2><p style=\"color: #08F;color: rgba(0, 136, 255, .9);\">If there is any errors they will be shown here. (xml)</p><div class=\"small code\"><code>";
	print_r(htmlspecialchars(trim($build_request)));
	echo "</code></div><br />";

	echo "<h2>Return request</h2><p style=\"color: #08F;color: rgba(0, 136, 255, .9);\">Shown as array</p><pre class=\"small\">";
	print_r($response_array);
	echo "</pre>";

}
?>
</body>
</html>
