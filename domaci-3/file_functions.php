<?php 

    function writeToFile($content, $filename = "database.txt"){
        // file_put_contents(filename, contents);
        $handle = fopen($filename, 'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    function getUsersFromFile($filename = "database.txt"){
        $file_contents = file_get_contents($filename);
        return $file_contents == "" ? [] : json_decode($file_contents, true);
    }

?>