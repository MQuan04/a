<?php
    function list_banner($id){
        if(empty($id)){
            $sql = "SELECT * FROM banner";
            return pdo_qr($sql);
        }else{
            $sql = "SELECT * FROM banner WHERE id_banner = $id";
            return pdo_qr_one($sql);
        }
    }

    function list_banner_search($trangthai_banner){
        $sql = "SELECT * FROM banner WHERE 1";

        if($trangthai_banner == 1){
            $sql .= " AND trangthai_banner = 1";
        }

        if($trangthai_banner == 2){
            $sql .= " AND trangthai_banner = 2";
        }

        return pdo_qr($sql);
    }

    function delete_banner($id){
        $sql = "SELECT * FROM banner WHERE id_banner = $id";
        $temp = pdo_qr_one($sql);
        delete_img($temp["anh_banner"],"anhsanpham");

        $sql = "DELETE FROM banner WHERE id_banner = $id";
        pdo_exe($sql);
    }

    function delete_banner_sl($arr){
        foreach($arr as $id){
            delete_banner($id);
        }
    }

    function add_banner($anh_banner,$link_banner,$mota_banner,$trangthai_banner){
        $sql = "INSERT INTO banner(anh_banner,link_banner,mota_banner,trangthai_banner) VALUES ('$anh_banner','$link_banner','$mota_banner',$trangthai_banner)";
        pdo_exe($sql);
    }

    function update_banner($id_banner,$anh_banner,$link_banner,$mota_banner,$trangthai_banner){ 
        $sql = "UPDATE banner SET
                anh_banner = '$anh_banner',
                link_banner = '$link_banner',
                mota_banner = '$mota_banner',
                trangthai_banner = '$trangthai_banner'
                WHERE id_banner = $id_banner";
        pdo_exe($sql);
    }

    function turn_banner($id){
        $sql = "UPDATE banner SET trangthai_banner = 
                CASE 
                    WHEN trangthai_banner = 1 THEN 2 
                    WHEN trangthai_banner = 2 THEN 1
                    ELSE trangthai_banner
                END
                WHERE id_banner = $id";
        pdo_exe($sql);
    }

    
?>