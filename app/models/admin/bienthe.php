<?php

// bien the
// do đã cập nhật trjang thái 2 ở list danh mục nên khi thêm sửa xóa size thì k cần trigger để cập nhật nữa


function soluong_bt($id)
{
    $sql = "SELECT SUM(soluong_bt) AS soluong_sp FROM bien_the WHERE id_sp = $id ORDER by id_sp";

    if (empty(pdo_qr_one($sql)["soluong_sp"])) {
        return 0;
    } else {
        return pdo_qr_one($sql)["soluong_sp"];
    }
}

function list_bt($idsp, $idbt)
{
    if (empty($idbt)) {
        $sql = "SELECT * FROM bien_the WHERE id_sp = $idsp ORDER BY size_bt ASC";
        return pdo_qr($sql);
    } else {
        $sql = "SELECT * FROM bien_the WHERE id_sp = $idsp AND id_bt = $idbt";
        return pdo_qr_one($sql);
    }
}

function add_bt($id, $size_bt, $soluong_bt)
{
    $sql = "INSERT INTO bien_the(id_sp,size_bt,soluong_bt) VALUES ($id,$size_bt,$soluong_bt)";
    pdo_exe($sql);
}

function update_bt($idsp, $idbt, $size_bt, $soluong_bt)
{
    $sql = "UPDATE bien_the SET
                `size_bt` = '$size_bt',
                `soluong_bt` = '$soluong_bt'
                WHERE `id_bt` = '$idbt' AND `id_sp` = '$idsp'";
    pdo_exe($sql);
}

function validation_size($id, $size_bt)
{

    if (empty($size_bt)) {
        return " * Size không được bỏ trống";
    } elseif ($size_bt <= 0) {
        return " * Size không được âm";
    }

    $sql = "SELECT size_bt FROM bien_the WHERE id_sp = $id";
    foreach (pdo_qr($sql) as $temp) {
        if ($size_bt == $temp["size_bt"]) {
            return " * Size đã tổn tại";
        }
    }
}

function validation_size_update($id, $size_bt, $id_bt)
{
    if (empty($size_bt)) {
        return " * Size không được bỏ trống";
    } elseif ($size_bt <= 0) {
        return " * Size không được âm";
    }

    $sql = "SELECT size_bt FROM bien_the WHERE id_sp = $id AND id_bt <> $id_bt";
    foreach (pdo_qr($sql) as $temp) {
        if ($size_bt == $temp["size_bt"]) {
            return " * Size đã tổn tại";
        }
    }
}

function delete_bt($idsp, $idbt)
{
    $sql = "DELETE FROM bien_the WHERE id_bt = $idbt AND id_sp = $idsp";
    pdo_exe($sql);
}

function hinh_anh($idsp, $idha)
{
    if (empty($idha)) {
        $sql = "SELECT * FROM hinh_anh WHERE id_sp = $idsp";
        return pdo_qr($sql);
    } else {
        $sql = "SELECT * FROM hinh_anh WHERE id_sp = $idsp AND id_ha = $idha";
        return pdo_qr_one($sql);
    }
}

function update_ha($idsp, $idha, $anh_ha)
{
    $sql = "UPDATE hinh_anh SET
            anh_ha = '$anh_ha'
            WHERE id_ha = $idha
            AND id_sp = $idsp";
    pdo_exe($sql);
}

