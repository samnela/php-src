--TEST--
Test file function : variation - various absolute and relative paths
--CREDITS--
Dave Kelsey <d_kelsey@uk.ibm.com>
--FILE--
<?php
/* Prototype  : array file(string filename [, int flags[, resource context]])
 * Description: Read entire file into an array 
 * Source code: ext/standard/file.c
 * Alias to functions:
 */

echo "*** Testing file() : variation ***\n";
$mainDir = "fileVar8.dir";
$subDir = "fileVar8Sub";
$absMainDir = dirname(__FILE__)."/".$mainDir;
mkdir($absMainDir);
$absSubDir = $absMainDir."/".$subDir;
mkdir($absSubDir);

$old_dir_path = getcwd();
chdir(dirname(__FILE__));

$allDirs = array(
  // absolute paths
  "$absSubDir/",
  "$absSubDir/../".$subDir,
  "$absSubDir//.././".$subDir,
  "$absSubDir/../../".$mainDir."/./".$subDir,
  "$absSubDir/..///".$subDir."//..//../".$subDir,
  "$absSubDir/BADDIR",

  // relative paths
  $mainDir."/".$subDir,
  $mainDir."//".$subDir, 
   $mainDir."///".$subDir, 
  "./".$mainDir."/../".$mainDir."/".$subDir,
  "BADDIR",

);

$filename = 'FileGetContentsVar7.tmp';
$absFile = $absSubDir.'/'.$filename;
$h = fopen($absFile,"w");
fwrite($h, "contents read");
fclose($h);

for($i = 0; $i<count($allDirs); $i++) {
  $j = $i+1;
  $dir = $allDirs[$i];
  echo "\n-- Iteration $j --\n";
  var_dump(file($dir."/".$filename));
}

unlink($absFile);
chdir($old_dir_path);
rmdir($absSubDir);
rmdir($absMainDir);

echo "\n*** Done ***\n";
?>
--EXPECTF--
*** Testing file() : variation ***

-- Iteration 1 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 2 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 3 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 4 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 5 --

Warning: file(%sfileVar8.dir/fileVar8Sub/..///fileVar8Sub//..//../fileVar8Sub/FileGetContentsVar7.tmp): failed to open stream: No such file or directory in %s on line %d
bool(false)

-- Iteration 6 --

Warning: file(%sfileVar8.dir/fileVar8Sub/BADDIR/FileGetContentsVar7.tmp): failed to open stream: No such file or directory in %s on line %d
bool(false)

-- Iteration 7 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 8 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 9 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 10 --
array(1) {
  [0]=>
  string(13) "contents read"
}

-- Iteration 11 --

Warning: file(BADDIR/FileGetContentsVar7.tmp): failed to open stream: No such file or directory in %s on line %d
bool(false)

*** Done ***