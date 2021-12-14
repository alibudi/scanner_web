<?php 
 include 'connect.php';

    if(isset($_GET['id'])){
            
        $id = mysqli_real_escape_string($conn,$_GET['id']);
        $data = [];
        $query = mysqli_query($conn, "SELECT * from tenan where id = '$id'");
     
         while( $row = mysqli_fetch_assoc($query)){
           array_push($data,[
            'id'        => $row['id'],
             'random_code'    => $row['random_code'], 
             'code_tenan'         => $row['code_tenan'], 
             'status' => "Berhasil",
           ]);
        } 
     
         $json_pretty =  json_encode($data, JSON_PRETTY_PRINT );
         header('Content-Type: application/json');  
         echo($json_pretty);
        
    }
    else{
        $data = [];
       $query = mysqli_query($conn, "SELECT * from redeem limit 10");
        while( $row = mysqli_fetch_assoc($query)){
           array_push($data,[
            'id'        => $row['id'],
             'nominal'    => $row['nominal'], 
             'tgl'         => $row['tgl_pengajuan'], 
             'status' => $row['status'],
           ]);
        }
     
        $json_pretty =  json_encode($data, JSON_PRETTY_PRINT );
        header('Content-Type: application/json');   
        echo($json_pretty);  
    }
    mysqli_close($conn);
?>