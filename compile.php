<?php

function renaming($data, $check, $except)
{
    return ($data == $check) ? $except : $data;
}

function param($param, $default = "")
{
    return (isset($_REQUEST[$param])) ? $_REQUEST[$param] : $default;
}

function create_file($folder, $filename, $content)
{
    $file = $folder . "/";
    $file .= substr(md5(mt_rand()), 0, 7);
    $file .= $filename;
    $create_file = fopen($file, "w");
    fwrite($create_file, $content);
    fclose($create_file);

    return $file;
}

function delete_file($filename)
{
    if (file_exists($filename)) {
        unlink($filename);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $language = strtolower(param("language"));
    $code = param("code");

    if ($language == "php") {
        $file = create_file("temp", ".php", $code);
        echo shell_exec("php $file 2>&1");
        delete_file($file);
    } else if ($language == "python") {
        $file = create_file("temp", ".py", $code);
        echo shell_exec("python $file 2>&1");
        delete_file($file);
    } else if ($language == "node") {
        $file = create_file("temp", ".js", $code);
        echo shell_exec("node $file 2>&1");
        delete_file($file);
    } else if ($language == "c") {
        $output =  substr(md5(mt_rand()), 0, 7) . ".exe";
        $file = create_file("temp", ".c", $code);
        shell_exec("gcc $file -o $output");
        echo shell_exec(__DIR__ . "//$output");
        delete_file($file);
    } else if ($language == "cpp") {
        $output =  substr(md5(mt_rand()), 0, 7) . ".exe";
        $file = create_file("temp", ".cpp", $code);
        shell_exec("g++ $file -o $output");
        echo shell_exec(__DIR__ . "//$output");
        delete_file($file);
    } else if ($language == "cs") {
        $output =  substr(md5(mt_rand()), 0, 7) . ".exe";
        $file = create_file("temp", ".cs", $code);
        shell_exec("csc $file -o $output");
        echo shell_exec(__DIR__ . "//$output");
        delete_file($file);
    } else if ($language == "json") {
        echo "<pre>";
        echo json_decode(json_encode($code), true);
        echo "</pre>";
    }
} else {
    echo "Invalid request.";
}
