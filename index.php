<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('upload_max_filesize', '500000M');
ini_set('post_max_size', 0);
ini_set('max_input_time', '-1');


   phpinfo();
exit();
function chunked_copy($from, $to) {
    # 1 meg at a time, you can adjust this.
    $buffer_size = 500; 
    $ret = 0;
    $fin = fopen($from, "rb");
    $fout = fopen($to, "w");
    while(!feof($fin)) {
        $ret += fwrite($fout, fread($fin, $buffer_size));
    }
    fclose($fin);
    fclose($fout);
    return true; # return number of bytes written
}

if (!empty($_POST)) {

    $file_url = $_POST['url'];
    $title = $_POST['title'];
    $split = $_POST['split'];
    
    $newfile = './upload/' . $title;
    //$newfiles = './split/' . $title;
    
    //exec('wget '.$file_url. '-O '.$newfiles);

    if ( chunked_copy($file_url, $newfile) ) {
    	echo "Copy success!";
    }else{
    	echo "Copy failed.";
    }
    
    
    exec('split -b '.$split.'m -d -a 3 upload/' . $title.' split/' . $title . '.');
    
}

include 'index.phtml';
echo '<br />';
include 'upload.php';
?>
