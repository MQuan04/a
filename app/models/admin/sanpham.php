<?php




function add_sp($id_dm, $ten_sp, $mota_sp, $anh_sp, $gia_sp, $trangthai1_sp)
{
    $ngaynhap_sp = date("Y-m-d");
    $sql = "INSERT INTO san_pham(id_dm,ten_sp,mota_sp,ngaynhap_sp,anh_sp,gia_sp,trangthai1_sp,trangthai2_sp,trangthai3_sp)
                VALUES (?,?,?,?,?,?,?,?,?)";
    pdo_exe($sql, $id_dm, $ten_sp, $mota_sp, $ngaynhap_sp, $anh_sp, $gia_sp, $trangthai1_sp, 2, 2);
}

// CẬP NHẬT TRẠNG THÁI 2 SẢN PHẨM bằng 1 lênh sql khi ta lấy danh sachs sản phẩm Tương tự cách ta làm banner
function list_sp($id)
{
    if (empty($id)) {
        $sql = "SELECT * FROM san_pham";
        return pdo_qr($sql);
    } else {
        $sql = "SELECT * FROM san_pham WHERE id_sp = $id";
        return pdo_qr_one($sql);
    }
}

function list_sp_search($id_dm,$sp){
    // 2 cai trong 
    $sql = "SELECT * FROM san_pham WHERE 1";

    // neu co $sp
    if($sp !=""){
        $sql .= " AND ten_sp LIKE '%" .$sp. "%'";
    }

    // neu co danh muc
    if($id_dm != ""){
        $sql .= " AND id_dm = $id_dm";
    }

    return pdo_qr($sql);

}

function delete_sp($id_sp)
{
    if (list_sp($id_sp)["trangthai3_sp"] == 2) {
        // xoa bien the
        $sql = "DELETE FROM bien_the WHERE id_sp = $id_sp";
        pdo_exe($sql);
        // xoa hinh anh
        $listanh = hinh_anh($id_sp, "");
        foreach ($listanh as $temp) {
            if ($temp["anh_ha"] != "anhmacdinh.jpg") {
                delete_img($temp["anh_ha"], "anhsanpham");
            }
        }

        $sql = "DELETE FROM hinh_anh WHERE id_sp = $id_sp";
        pdo_exe($sql);

        $sql = "DELETE FROM binh_luan WHERE id_sp = $id_sp";
        pdo_exe($sql);

        // xóa sản phẩm
        $listsp = list_sp($id_sp);
        delete_img($listsp["anh_sp"], "anhsanpham");
        $sql = "DELETE FROM san_pham WHERE id_sp = $id_sp";
        pdo_exe($sql);
    } else {
        return "
                    <script>
                        alert('Không xóa được sản phẩm đang có trong đơn hàng');
                        window.location.href = `index.php?act=sp&type=list`;
                    </script>
                ";
    }
}

// =======================UPDATE=======================================
// CAP NHAT LAI TRANG THAI SAN PHAM KHI DOI DANH MUC 
// =====================================================================

function update_sp($id_sp, $id_dm, $ten_sp, $mota_sp, $anh_sp, $gia_sp)
{
    if ($_SESSION["admin"]["id_cv"] == 1) {

        $ngaynhap_sp = date("Y-m-d");
        $sql = "UPDATE san_pham 
                    SET id_dm = ?,
                        ten_sp = ?,
                        mota_sp = ?,
                        ngaynhap_sp = ?,
                        anh_sp = ?,
                        gia_sp = ?
                        WHERE id_sp = ?";
        pdo_exe($sql, $id_dm, $ten_sp, $mota_sp, $ngaynhap_sp, $anh_sp, $gia_sp, $id_sp);

        $sql = "UPDATE san_pham
                INNER JOIN danh_muc ON san_pham.id_dm = danh_muc.id_dm
                SET san_pham.trangthai1_sp = 
                CASE 
                WHEN danh_muc.trangthai_dm = 1 THEN 1
                ELSE 2
                END";
        pdo_exe($sql);
    } else {
        die();
    }
}

function validation_ten_sp($name)
{
    $name = trim($name);

    if (!empty(validation_name($name))) {
        return validation_name($name);
    }

    $sql = "SELECT ten_sp FROM san_pham";
    foreach (pdo_qr($sql) as $temp) {
        if ($name == $temp["ten_sp"]) {
            return " * Sản phẩm đã tồn tại";
        }
    }
}

function validation_ten_sp_update($name, $id)
{
    $name = trim($name);

    if (!empty(validation_name($name))) {
        return validation_name($name);
    }

    $sql = "SELECT ten_sp FROM san_pham WHERE id_sp <> $id";
    foreach (pdo_qr($sql) as $temp) {
        if ($name == $temp["ten_sp"]) {
            return " * Sản phẩm đã tồn tại";
        }
    }
}

