<?php
    
    function list_km($id){
        if(empty($id)){
            $sql = "SELECT * FROM khuyen_mai";
            return pdo_qr($sql);
        }else{
            $sql = "SELECT * FROM khuyen_mai WHERE id_km = $id";
            return pdo_qr_one($sql);
        }
    }

    function list_km_search($trangthai_km){
        $sql = "SELECT * FROM khuyen_mai WHERE 1";

        if($trangthai_km == 1){
            $sql .= " AND trangthai_km = 1";
        }

        if($trangthai_km == 2){
            $sql .= " AND trangthai_km = 2";
        }

        return pdo_qr($sql);
    }

    function add_km($ma_km,$phantram_km,$ngaybd_km,$ngaykt_km){
        $sql = "INSERT INTO khuyen_mai(ma_km,phantram_km,ngaybd_km,ngaykt_km) VALUES ('$ma_km',$phantram_km,'$ngaybd_km','$ngaykt_km')";
        pdo_exe($sql);
    }

    function delete_km($id){
        $sql = "DELETE FROM khuyen_mai WHERE id_km = $id";
        pdo_exe($sql);
    }

    function delete_km_sl($arr){
        foreach($arr as $id){
            delete_km($id);
        }
    }

    function update_km($id_km,$ma_km,$phantram_km,$ngaybd_km,$ngaykt_km){
        $sql = "UPDATE khuyen_mai SET
                ma_km ='$ma_km',
                phantram_km = '$phantram_km',
                ngaybd_km = '$ngaybd_km',
                ngaykt_km = '$ngaykt_km'
                WHERE id_km = $id_km ";
        pdo_exe($sql);
    }

    function validation_makm($ma_km){
        if($ma_km == 0){
            return " * Mã khuyến mãi không hợp lệ";
        }elseif(empty($ma_km)){
            return " * Mã khuyến mãi không được bỏ trống";
        }elseif(preg_match("/[ ]/", $ma_km)){
            return " * Mã khuyến mãi không được chứa dấu cách";
        }elseif(strlen($ma_km) < 8 || strlen($ma_km)> 50){
            return " * Độ dài không hợp lệ";
        }

        $sql = "SELECT ma_km FROM khuyen_mai";
        foreach(pdo_qr($sql) as $temp){
            if($temp["ma_km"] == $ma_km){
                return " * Mã khuyến mãi đã tồn tại";
            }
        }
    }

    function validation_makm_update($ma_km,$id){
        if($ma_km == 0){
            return " * Mã khuyến mãi không hợp lệ";
        }elseif(empty($ma_km)){
            return " * Mã khuyến mãi không được bỏ trống";
        }elseif(preg_match("/[ ]/", $ma_km)){
            return " * Mã khuyến mãi không được chứa dấu cách";
        }elseif(strlen($ma_km) < 8 || strlen($ma_km)> 50){
            return " * Độ dài không hợp lệ";
        }

        $sql = "SELECT ma_km FROM khuyen_mai WHERE id_km <> $id";
        foreach(pdo_qr($sql) as $temp){
            if($temp["ma_km"] == $ma_km){
                return " * Mã khuyến mãi đã tồn tại";
            }
        }
    }

 
?>