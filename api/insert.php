<?php 
include 'connect.php';
if(isset($_GET['id'])){
        $kegiatan = isset($_GET['kegiatan']) ? $_GET['kegiatan'] : '';
        $id = mysqli_real_escape_string($conn,$_GET['id']);
        $pernahMasuk=getActivity($conn,$id,$kegiatan);
        $sql="SELECT tiket.id,tiket.id_pic,tiket.order_id,pic.nama,pic.email from tiket
         -- inner join activity on tiket.id =  activity.id_tiket
         inner join pic on tiket.id_pic = pic.id 
         where tiket.id= '$id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $totalTiket=mysqli_num_rows($query);
        // echo $sql;

        $data=[];

        if($totalTiket>0){
            if($pernahMasuk){
                // print_r();
               array_push($data,[
                'id'        => $id,
                 'nama'    => $row['nama'], 
                 // 'kegiatan'    => $row['kegiatan'], 
                 // 'waktu'         => $row['waktu'], 
                 'status' =>"Sudah Pernah Masuk",
               ]);

                 $json_pretty =  json_encode($data, JSON_PRETTY_PRINT );
                 header('Content-Type: application/json');  
                 echo($json_pretty);

            }else{

            
            
            $query = mysqli_query($conn, $sql);
            if ($query->num_rows > 0) {
                echo "ada data";
                $row = mysqli_fetch_assoc($query);
               array_push($data,[
                'id'        => $id,
                 'nama'    => $row['nama'], 
                 // 'kegiatan'    => $row['kegiatan'],
                 // 'waktu'         => $row['waktu'], 
                 'status' =>"Sukses Mendata",
               ]);
        
             $json_pretty =  json_encode($data, JSON_PRETTY_PRINT );
             header('Content-Type: application/json');  
             echo($json_pretty);
            } else {
                echo "tidak ada data";
            $id_tiket       = htmlspecialchars($_POST['id_tiket']);
            $waktu          = htmlspecialchars($_POST['waktu']);
            $userscanner    = htmlspecialchars($_POST['userscanner']);
            $kegiatan       = htmlspecialchars($_POST['kegiatan']);
                 $query1         = mysqli_query($conn, "INSERT INTO activity (id_tiket, waktu, userscanner, kegiatan) VALUES ( '$id_tiket', '$waktu', '$userscanner','$kegiatan') ");
            }     
        }
        }else{
$query = mysqli_query($conn, $sql);
            array_push($data,[
                'id'        => $id,
                 'nama'    => $row['nama'], 
                 // 'waktu'         => $row['waktu'], 
                 'status' =>"Tiket Tidak Ditemukan",
               ]);
         
             $json_pretty =  json_encode($data, JSON_PRETTY_PRINT );
             header('Content-Type: application/json');  
             echo($json_pretty);
        }
        
    }
    
    
    mysqli_close($conn);


    function getActivity($conn,$idTiket,$activity){
        $result=0;
        $sql="Select * from activity where id_tiket='$idTiket' and kegiatan='$activity'";
        $getResult=mysqli_query($conn,$sql);
        $totalRow=mysqli_num_rows($getResult);
        // echo "totalRow:".$totalRow;
        if($totalRow>0){
            $result=1;
        }
        return $result;
    }
 ?>