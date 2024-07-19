<?php
function list_nv($id)
{
    if (empty($id)) {
        $sql = "SELECT nguoi_dung.*, chuc_vu.ten_cv FROM nguoi_dung INNER JOIN chuc_vu ON nguoi_dung.id_cv = chuc_vu.id_cv WHERE nguoi_dung.id_cv IN (1, 2)";
        return pdo_qr($sql);
    } else {
        $sql = "SELECT nguoi_dung.*, chuc_vu.ten_cv FROM nguoi_dung INNER JOIN chuc_vu ON nguoi_dung.id_cv = chuc_vu.id_cv WHERE nguoi_dung.id_nd = " . $id;
        return pdo_qr_one($sql);
    }
}

function list_nv_search($id_cv, $ten_nd)
{
    $sql = "SELECT nguoi_dung.*, chuc_vu.ten_cv FROM nguoi_dung INNER JOIN chuc_vu ON nguoi_dung.id_cv = chuc_vu.id_cv WHERE nguoi_dung.id_cv IN (1,2)";

    if ($id_cv == 1) {
        $sql .= " AND nguoi_dung.id_cv = 1";
    }

    if ($id_cv == 2) {
        $sql .= " AND nguoi_dung.id_cv = 2";
    }

    if ($ten_nd != "") {
        $sql .= " AND nguoi_dung.ten_nd LIKE '%" . $ten_nd . "%'";
    }

    return pdo_qr($sql);
}

function delete_nv($id)
{
    if ($id == $_SESSION["admin"]["id_nd"]) {
        return "
                <script>
                    alert('Không xóa được tài khoản đang đăng nhập');
                    window.location.href = `index.php?act=nv&type=list`;
                </script>
                ";
    } else {
        $sql = "DELETE FROM binh_luan WHERE id_nd = $id";
        pdo_exe($sql);
        $temp = list_nv($id);
        delete_img($temp["anh_nd"], "anhnguoidung");
        $sql = "DELETE FROM nguoi_dung WHERE id_nd = " . $id;
        pdo_exe($sql);
    }
}

function delete_nv_sl($arr)
{
    // kiem tra xem co thuoc mang hay khong
    if (in_array($_SESSION["admin"]["id_nd"], $arr)) {
        return "
                <script>
                    alert('Không xóa được tài khoản đang đăng nhập');
                    window.location.href = `index.php?act=nv&type=list`;
                </script>
                ";
    } else {
        foreach ($arr as $id) {
            delete_nv($id);
        }
    }
}

function add_nv($ten_nd, $anh_nd, $sdt_nd, $ngaysinh_nd, $diachi_nd, $email_nd, $mk_nd, $id_cv)
{
    $sql = "INSERT INTO `nguoi_dung` (`ten_nd`, `anh_nd`, `sdt_nd`, `ngaysinh_nd`, `diachi_nd`, `email_nd`, `mk_nd`, `id_cv`) 
                VALUES ('$ten_nd', '$anh_nd', '$sdt_nd', '$ngaysinh_nd', '$diachi_nd', '$email_nd', '$mk_nd', $id_cv)";
    pdo_exe($sql);
}

function update_nv($id_nd, $ten_nd, $anh_nd, $sdt_nd, $ngaysinh_nd, $diachi_nd, $mk_nd, $id_cv)
{
    $sql = "UPDATE `nguoi_dung` SET 
                `ten_nd` = '$ten_nd',
                `anh_nd` = '$anh_nd',
                `sdt_nd` = '$sdt_nd',
                `ngaysinh_nd` = '$ngaysinh_nd',
                `diachi_nd` = '$diachi_nd',
                `mk_nd` = '$mk_nd',
                `id_cv` = $id_cv
                WHERE `id_nd` = $id_nd";
    pdo_exe($sql);
}

