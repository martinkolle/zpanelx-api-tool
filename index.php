<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ZpanelX API</title>
<style type="text/css">
body{background-color: #0C1021;-webkit-transition: background-color 0.5s ease-out;-moz-transition: background-color 0.5s ease-out;-ms-transition: background-color 0.5s ease-out;-o-transition: background-color 0.5s ease-out;transition: background-color 0.5s ease-out;margin:25px;font: 16px/20px Consolas,"Andale Mono WT","Andale Mono","Lucida Console","Lucida Sans Typewriter","DejaVu Sans Mono","Bitstream Vera Sans Mono","Liberation Mono","Nimbus Mono L",Monaco,"Courier New",Courier,monospace;}
h2{color:#FF6400;}
.welcome, .code{color: #08F;color: rgba(0, 136, 255, .9);white-space: pre;margin: 0;position: relative;z-index: 1;display: inline;}
.php_start, .php_end{color:#FF6400;}
.variable{color: #08F;color: rgba(0, 136, 255, .9)!important;}
.class{color:#A70;}
.new,.function{color:#A70;}
.equal, .arrow, .end, .comma{color:#8DA6CE;}
input, textarea{background:#0C1021;color:#61CE3C;border:0!important;font: 16px/20px Consolas,"Andale Mono WT","Andale Mono","Lucida Console","Lucida Sans Typewriter","DejaVu Sans Mono","Bitstream Vera Sans Mono","Liberation Mono","Nimbus Mono L",Monaco,"Courier New",Courier,monospace;cursor:text;}
input[name=name]{min-width:150px;width:auto;}
input[name=module]{width:150px;}
input[name=function]{width:150px;}
input[name=api]{width:200px;}
input[name=user]{width:100px;}
input[name=pass]{width:100px;}
textarea{width:300px;height:150px;}
textarea.small{width:80%;height:200px;}
/*.small{font-size:12px;}*/
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
<form action="index.php" method="post">
<div class="code">
<span class="php_start">&lt;?php</span>
	<span class="variable">$xmws</span> <span class="equal">=</span> <span class="new">new xmwsclient()</span><span class="end">;</span>
	<span class="variable">$xmws</span><span class="arrow">-></span><span class="function">InitRequest(</span><input name="panel" type="text" value="<?php echo ($_POST['panel']) ? $_POST['panel'] : 'http://zpanel.domain.dk'; ?>" /><span class="comma">,</span><input name="module" type="text" value="<?php echo ($_POST['module']) ? $_POST['module'] : 'Module name'; ?>" /></span><span class="comma">,</span> <input name="function" type="text" value="<?php echo ($_POST['function']) ? $_POST['function'] : 'Webservice function'; ?>"/><span class="comma">,</span> <input name="api" type="text" value="<?php echo ($_POST['api']) ? $_POST['api'] : 'API code'; ?>" /><span class="comma">,</span><input name="user" type="text" value="<?php echo ($_POST['user']) ? $_POST['user'] : 'Username'; ?>" /><span class="comma">,</span><input name="pass" type="text" value="<?php echo ($_POST['pass']) ? $_POST['pass'] : 'Password'; ?>" /><span class="function">)</span><span class="end">;</span>
	<span class="variable" style="vertical-align:top">$xmws</span><span class="arrow" style="vertical-align:top">-></span><span class="function" style="vertical-align:top">SetRequestData(</span></span><textarea name="data"><?php echo ($_POST['data']) ? $_POST['data'] : 'XML data'; ?></textarea><span class="function">)</span><spn class="end">;</span>
<span class="php_end">?&gt;</span><br />
<input type="submit" value="Run code..." name="submit"/>
</div>
</form>
<?php
require 'xmwsclient.class.php';

/** 
 *  @link http://gdatatips.blogspot.dk/2008/11/xml-php-pretty-printer.html
 */
function xml_pretty($xml, $html_output=false) {
    $xml_obj = new SimpleXMLElement($xml);
    $level = 4;
    $indent = 0; // current indentation level
    $pretty = array();
    // get an array containing each XML element
    $xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));
    // shift off opening XML tag if present
    if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {
      $pretty[] = array_shift($xml);
    }
    foreach ($xml as $el) {
      if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
          // opening tag, increase indent
          $pretty[] = str_repeat(' ', $indent) . $el;
          $indent += $level;
      } else {
        if (preg_match('/^<\/.+>$/', $el)) {            
          $indent -= $level;  // closing tag, decrease indent
        }
        if ($indent < 0) {
          $indent += $level;
        }
        $pretty[] = str_repeat(' ', $indent) . $el;
      }
    }   
    $xml = implode("\n", $pretty);   
    return ($html_output) ? htmlentities($xml) : $xml;
}

/**
 * @link http://www.php.net/manual/en/function.highlight-string.php#84661
*/
function xml_highlight($s)
{        
    $s = htmlspecialchars($s);
    $s = preg_replace("#&lt;([/]*?)(.*)([\s]*?)&gt;#sU",
        "<font style=\"color: #08F;color: rgba(0, 136, 255, .9)!important;\">&lt;\\1\\2\\3&gt;</font>",$s);
    $s = preg_replace("#&lt;([\?])(.*)([\?])&gt;#sU",
        "<font color=\"#FF6400\">&lt;\\1\\2\\3&gt;</font>",$s);
    $s = preg_replace("#&lt;([^\s\?/=])(.*)([\[\s/]|&gt;)#iU",
        "&lt;<font color=\"#A70\">\\1\\2</font>\\3",$s);
    $s = preg_replace("#&lt;([/])([^\s]*?)([\s\]]*?)&gt;#iU",
        "&lt;\\1<font color=\"#A70\">\\2</font>\\3&gt;",$s);
    $s = preg_replace("#([^\s]*?)\=(&quot;|')(.*)(&quot;|')#isU",
        "<font color=\"#8DA6CE\">\\1</font>=<font color=\"#FF00FF\">\\2\\3\\4</font>",$s);
    $s = preg_replace("#&lt;(.*)(\[)(.*)(\])&gt;#isU",
        "&lt;\\1<font color=\"#8DA6CE\">\\2\\3\\4</font>&gt;",$s);
    return $s;
}
		
if($_POST['submit']){

	$xmws = new xmwsclient();
	$xmws->InitRequest($_POST['panel'], $_POST['module'], $_POST['function'], $_POST['api'],$_POST['user'],$_POST['pass']);
	$xmws->SetRequestData($_POST['data']);

	$build_request   = $xmws->Request($xmws->BuildRequest());
	$response_array  = $xmws->XMLDataToArray($xmws->Request($xmws->BuildRequest()), 0);
?>
<div class="boxs" style="width:100%;">
	<h2>Your request</h2>
	<div class="small code">
		<code>
<?php echo xml_highlight(xml_pretty(stripslashes($xmws->BuildRequest()))); ?>
		</code>
	</div>
	
	<h2>Return request</h2>
	<p style="color: #08F;color: rgba(0, 136, 255, .9);">If there is any errors they will be here. (xml)</p>
	<div class="small code">
       <code>
<?php echo xml_highlight(xml_pretty(stripslashes(trim($build_request)))); ?>
        </code>
	</div>
</div>
	<br />
	<h2>Return request</h2>
	<p style="color: #08F;color: rgba(0, 136, 255, .9);">PHP array</p>
	<pre class="small">
<?php print_r($response_array); ?>
	</pre>

<?php }//end post ?>
</body>
</html>