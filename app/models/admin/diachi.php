<?php
    function list_shop($id){
        if(empty($id)){
            $sql = "SELECT * FROM shop";
            return pdo_qr($sql);
        }else{
            $sql = "SELECT * FROM shop WHERE id_shop = $id";
            return pdo_qr_one($sql);
        }
    }

    function update_shop($id_shop,$sdt_shop,$email_shop,$diachi_shop,$anh_shop){
        $sql = "UPDATE `shop` SET 
                sdt_shop = '$sdt_shop',
                email_shop = '$email_shop',
                diachi_shop = '$diachi_shop',
                anh_shop = '$anh_shop'
                WHERE id_shop = $id_shop";
        pdo_exe($sql);
    }

?>