<!DOCTYPE html>
<html>
<head>
  <title>WFUXX</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
<body>
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">WFUXX</a>
</nav>


<div class="container">
<hr>
<form method="post" action="wfuxx.php">
<div class="form-group input-group input-group-sm mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-sm">target</span>
  </div>
  <input type="text" class="form-control" value="https://go.sony.com" name="target" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
 </div>



<div class="form-group input-group input-group-sm mb-3">
  
  <select class="custom-select" id="inputGroupSelect01" name="tool">
    <option selected>Choose tools</option>
<option value="ffuf">ffuf</option>
<option value="gobuster">gobuster</option>

</select>
</div>

<div class="form-group input-group input-group-sm mb-3">
  
  <select class="custom-select" id="inputGroupSelect01" name="list">
    <option selected>Choose Wordlist</option>
<option value="./var/www/html/lists/large-files.txt">/lists/large-files.txt</option>
<option value="./var/www/html/lists/medium-files.txt">/lists/medium-files.txt</option>
<option value="./var/www/html/lists/quickhits-2000.txt">/lists/quickhits-2000.txt</option>
<option value="./var/www/html/lists/large-dir.txt">/lists/large-dir.txt</option>
<option value="./var/www/html/lists/subdomain-prefixes.txt">/lists/subdomain-prefixes.txt</option>
<option value="./var/www/html/lists/nmap-1000.txt">/lists/nmap-1000.txt</option>
<option value="./var/www/html/lists/medium-words.txt">/lists/medium-words.txt</option>
<option value="./var/www/html/lists/ffuf.txt">/lists/ffuf.txt</option>
<option value="./var/www/html/lists/large-words.txt">/lists/large-words.txt</option>
<option value="./var/www/html/lists/test.txt">/lists/test.txt</option>
<option value="./var/www/html/lists/medium-dir.txt">/lists/medium-dir.txt</option>
  </select>
</div>
<div class="form-group input-group input-group-sm mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-sm">Theads</span>
  </div>
  <input type="text" class="form-control" name="thread" aria-label="Small" value="100" aria-describedby="inputGroup-sizing-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-sm">Extension</span>
  </div>
  <input type="text" class="form-control" name="ext" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
</div>
<div class="form-group input-group input-group-sm mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-sm">filters</span>
  </div>
  <input type="text" class="form-control" name="filter" value="200,301,302,403" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
 </div>
 <div class="form-group input-group input-group-sm mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-sm">exclude</span>
  </div>
  <input type="text" class="form-control" name="exclude" value="400,404" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
 </div>
 

      <input type="checkbox" aria-label="Checkbox for following text input" name="wildcard">&nbsp;Wildcard <br><br>

<div class="form-group input-group input-group-sm mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-sm">password</span>
  </div>
  <input type="text" class="form-control" value="weakpass" name="zing" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
 </div>
<button type="button" class="btn btn-success" onclick="document.forms[0].submit()">Run</button>
</form>

<hr>
 <div class="input-group-text container" style="overflow-x:scroll">
    <?php
error_reporting(0);

if(isset($_REQUEST['zing']) && $_REQUEST['zing']=='m4d') {
    
extract($_REQUEST);
$n=explode('/',$target)[2].".txt";
if(isset($target) && $tool=='ffuf'){
    //ffuf code

 while (@ ob_end_flush()); // end all output buffers if any

 $cmd = 'ffuf -s -w '.$list.' -u '.$target.'/FUZZ -recursion-depth 2 -of html -o '.$target.'.html';
$cmd = $cmd.' -t '.$thread.'';

if(isset($exclude)){
  $cmd = $cmd." -fc ".$exclude;
}
if(isset($filter)){
  $cmd = $cmd." -mc ".$filter;
}

if(isset($ext) && $ext !=  ''){
  $cmd = $cmd." -e ".$ext;
}
echo "<script>alert('$cmd')</script>";
$proc = popen($cmd, 'r');
//$proc='';

echo '<center><pre>';
while (!feof($proc))
{
    echo fread($proc, 4096);
    @ flush();
}
echo '</pre></center>';
}



if(isset($target) && $tool == 'gobuster'){
  //gobuster code
  while (@ ob_end_flush()); // end all output buffers if any

$cmd = 'gobuster dir -u';
$cmd = $cmd.' '.$target.' -w '.$list.' -t '.$thread.' -z';

if(isset($wildcard)){
  $cmd = $cmd.' --wildcard';
}
if(isset($exclude)){
  $cmd = $cmd." -b ".$exclude;
}
if(isset($filter)){
  $cmd = $cmd." -s ".$filter;
}

if(isset($ext) && $ext !=  ''){
  $cmd = $cmd." -x ".$ext;
}
$proc = popen($cmd, 'r');
//$proc='';

echo '<center><pre>';
while (!feof($proc))
{
    echo fread($proc, 4096);
    @ flush();
}
echo '</pre></center>';
}
}

?>

    </div>
</div>

</body>
</html>
