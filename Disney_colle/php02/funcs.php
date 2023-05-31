<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//DBConnection
function db_conn(){
    try {
        $db_name = 'dc_db';    //データベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = '';      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = 'localhost'; //DBホスト

        //localhostでなかればさくらに接続する
        if($_SERVER["HTTP_HOST"] != 'localhost'){
            $db_name = '';    //データベース名
            $db_id   = '';      //アカウント名
            $db_pw   = '';      //パスワード：XAMPPはパスワード無しに修正してください。
            $db_host = ''; //DBホスト
            }

        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
    
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect($page){
    header("Location: " .$page);
    exit();
}

?>