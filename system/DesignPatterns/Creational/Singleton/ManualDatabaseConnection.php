<?php

namespace System\DesignPatterns\Creational\Singleton;

class ManualDatabaseConnection
{
    private static ?ManualDatabaseConnection $instance = null;
    private \mysqli $connection;

    private function __construct()
    {
        $this->connection = new \mysqli('localhost', 'root', '', 'sms');
        if ($this->connection->connect_error) {
            die('❌ Lỗi kết nối: ' . $this->connection->connect_error);
        }
        log_message('info', '✅ Khởi tạo kết nối đầu tiên đến database.');
    }

    public static function getInstance(): ManualDatabaseConnection
    {
        if (!self::$instance) {
            self::$instance = new ManualDatabaseConnection();
        } else {
            log_message('info', '♻️ Đang sử dụng lại kết nối.');
        }
        return self::$instance;
    }

    public function getConnection(): \mysqli
    {
        return $this->connection;
    }
}