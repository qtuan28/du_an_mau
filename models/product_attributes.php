<?php
require_once 'models/db.php';

class ProductAttributes {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
        $this->checkAndMigrate();
    }

    private function checkAndMigrate() {
        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS PRODUCT_ATTRIBUTES (
                attr_id    INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                attr_name  VARCHAR(100) NOT NULL,
                sort_order INT DEFAULT 0,
                FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $this->db->exec("CREATE TABLE IF NOT EXISTS PRODUCT_ATTRIBUTE_VALUES (
                value_id   INT AUTO_INCREMENT PRIMARY KEY,
                attr_id    INT NOT NULL,
                value_text VARCHAR(100) NOT NULL,
                quantity   INT DEFAULT 0,
                FOREIGN KEY (attr_id) REFERENCES PRODUCT_ATTRIBUTES(attr_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } catch (Exception $e) {}
    }

    public function getByProductId($productId) {
        $attrs = [];
        $stmtAttr = $this->db->prepare(
            "SELECT * FROM PRODUCT_ATTRIBUTES WHERE product_id = :pid ORDER BY sort_order ASC, attr_id ASC"
        );
        $stmtAttr->execute([':pid' => (int)$productId]);
        $attrRows = $stmtAttr->fetchAll(PDO::FETCH_ASSOC);
        foreach ($attrRows as $attr) {
            $stmtVal = $this->db->prepare(
                "SELECT * FROM PRODUCT_ATTRIBUTE_VALUES WHERE attr_id = :aid ORDER BY value_id ASC"
            );
            $stmtVal->execute([':aid' => (int)$attr['attr_id']]);
            $attr['values'] = $stmtVal->fetchAll(PDO::FETCH_ASSOC);
            $attrs[] = $attr;
        }
        return $attrs;
    }

    public function saveAttributes($productId, $attrsData) {
        $stmtDel = $this->db->prepare("DELETE FROM PRODUCT_ATTRIBUTES WHERE product_id = :pid");
        $stmtDel->execute([':pid' => (int)$productId]);
        if (empty($attrsData)) return;
        $stmtAttr = $this->db->prepare(
            "INSERT INTO PRODUCT_ATTRIBUTES (product_id, attr_name, sort_order) VALUES (:pid, :name, :sort)"
        );
        $stmtVal = $this->db->prepare(
            "INSERT INTO PRODUCT_ATTRIBUTE_VALUES (attr_id, value_text, quantity) VALUES (:aid, :val, :qty)"
        );
        foreach ($attrsData as $order => $attr) {
            $name = trim($attr['name'] ?? '');
            if ($name === '') continue;
            $stmtAttr->execute([':pid' => (int)$productId, ':name' => $name, ':sort' => $order]);
            $attrId = $this->db->lastInsertId();
            $values = $attr['values'] ?? [];
            $qtys   = $attr['qtys']   ?? [];
            foreach ($values as $i => $val) {
                $valText = trim($val);
                if ($valText === '') continue;
                $qty = isset($qtys[$i]) ? (int)$qtys[$i] : 0;
                $stmtVal->execute([':aid' => $attrId, ':val' => $valText, ':qty' => $qty]);
            }
        }
    }

    public function deleteByProductId($productId) {
        $stmt = $this->db->prepare("DELETE FROM PRODUCT_ATTRIBUTES WHERE product_id = :pid");
        return $stmt->execute([':pid' => (int)$productId]);
    }
}
