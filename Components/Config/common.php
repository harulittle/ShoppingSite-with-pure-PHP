<?php 
    session_start();
   

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(!hash_equals($_SESSION['_token'],$_POST['_token'])){
            echo "invalid request for csrf attack";
            die(); //some error template should  show
        }else{
            unset($_SESSION['_token']);
        }
    }
    /* this code should place below 
    check post request code because 
    after unset session we need another token session for other post request */
    if (empty($_SESSION['_token'])) {
        if (function_exists('random_bytes')) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        } else {
            $_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

        /**
     * Escapes HTML for output
     *
     */

    function escape($html) {
        return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
    }

    // diedump function 
    function dd($data){
        echo "<pre>";
        die(var_dump($data));
    }

    // pagination reusable function
    function pagination($recordsPerPage,$tableName,$pdo){
        // pagination
       // check pageno exist or not
       if(isset($_GET['pageno'])) 
       {
         $pageno=$_GET['pageno'];
       }
       else{
         $pageno=1;
       }
       $offset=($pageno-1)*$recordsPerPage;
       $stmt=$pdo->prepare("select * from $tableName limit $offset,$recordsPerPage");
       $stmt->execute();
       $datas=$stmt->fetchAll(PDO::FETCH_OBJ);
       // total pages
       $statement=$pdo->prepare("select count(*) from $tableName");
       $statement->execute();
       $result=$statement->fetch();
       $totaldatas=$result[0];
       $totalPages=ceil($totaldatas/$recordsPerPage);
       return [$pageno,$datas,$totalPages];
   }
?>