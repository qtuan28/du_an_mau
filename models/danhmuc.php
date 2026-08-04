<?php
require_once 'models/db.php';

class DanhMuc
{

    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    // Lấy tất cả danh mục
    public function getAll()
    {

        $sql = "SELECT * FROM CATEGORIES
                ORDER BY category_id ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục
    public function add($name)
    {

        $sql = "INSERT INTO CATEGORIES(name)
                VALUES(:name)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name
        ]);
    }

    // Lấy theo ID
    public function getById($id)
    {

        $sql = "SELECT *
                FROM CATEGORIES
                WHERE category_id=:id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật
    public function update($id, $name)
    {

        $sql = "UPDATE CATEGORIES
              SET name=:name
              WHERE category_id=:id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':id' => $id
        ]);
    }

    // Xóa
    public function delete($id)
    {

        $sql = "DELETE FROM CATEGORIES
              WHERE category_id=:id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    // Tìm kiếm
    public function search($keyword)
    {

        $sql = "SELECT *
              FROM CATEGORIES
              WHERE name LIKE :keyword
              ORDER BY category_id ASC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kiểm tra trùng
    public function checkExists($name)
    {

        $sql = "SELECT *
              FROM CATEGORIES
              WHERE name=:name";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':name' => $name
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
