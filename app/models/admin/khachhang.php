<?php
    function list_kh($id){
        if(empty($id)){
            $sql = "SELECT * FROM nguoi_dung INNER JOIN chuc_vu ON chuc_vu.id_cv = nguoi_dung.id_cv WHERE nguoi_dung.id_cv = 3";
            return pdo_qr($sql);
        }else{
            $sql = "SELECT * FROM nguoi_dung INNER JOIN chuc_vu ON chuc_vu.id_cv = nguoi_dung.id_cv WHERE nguoi_dung.id_nd = $id";
            return pdo_qr_one($sql);  
        }
    }

    function add_kh($ten_nd,$anh_nd,$sdt_nd,$ngaysinh_nd,$diachi_nd,$email_nd,$mk_nd){
        $sql = "INSERT INTO nguoi_dung(ten_nd,anh_nd,sdt_nd,ngaysinh_nd,diachi_nd,email_nd,mk_nd,id_cv) VALUES ('$ten_nd','$anh_nd','$sdt_nd','$ngaysinh_nd','$diachi_nd','$email_nd','$mk_nd',3)";
        pdo_exe($sql);
    }

    function update_kh($id_nd,$ten_nd,$anh_nd,$sdt_nd,$ngaysinh_nd,$diachi_nd,$mk_nd){   
        $sql = "UPDATE `nguoi_dung` SET 
            `ten_nd` = '$ten_nd',
            `anh_nd` = '$anh_nd',
            `sdt_nd` = '$sdt_nd',
            `ngaysinh_nd` = '$ngaysinh_nd',
            `diachi_nd` = '$diachi_nd',
            `mk_nd` = '$mk_nd'
            WHERE `id_nd` = $id_nd";

        pdo_exe($sql);
    }

    function delete_kh($id){
        $sql = "DELETE FROM binh_luan WHERE id_nd = $id";
        pdo_exe($sql);
        $temp = list_kh($id);
        delete_img($temp["anh_nd"],"anhnguoidung");
        $sql = "DELETE FROM nguoi_dung WHERE id_nd = " . $id;
        pdo_exe($sql);
       
    }

    function delete_kh_sl($arr){
        foreach($arr as $id){
            delete_kh($id);
        }
    }
?>