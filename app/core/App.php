<?php

/**
 * app/core/App.php
 * 
 * File này chứa các hàm cốt lõi của ứng dụng
 * Load config và các thiết lập cơ bản
 * 
 * CÁCH SỬ DỤNG:
 * require_once dirname(__DIR__) . '/core/App.php';
 * App::init();
 */

class App
{
    /**
     * Khởi tạo ứng dụng - Load config và các thiết lập cơ bản
     * Chỉ cần gọi một lần ở đầu mỗi file
     */
    public static function init()
    {
        // Chỉ load config một lần
        if (!defined('BASE_URL')) {
            require_once dirname(dirname(__FILE__)) . '/config/config.php';
        }
    }

    /**
     * Lấy đường dẫn đầy đủ của file
     * @param string $path - Đường dẫn tương đối
     * @return string - Đường dẫn đầy đủ
     */
    public static function path($path)
    {
        self::init();
        return ROOT_PATH . '/' . ltrim($path, '/');
    }

    /**
     * Lấy URL đầy đủ
     * @param string $path - Đường dẫn tương đối
     * @return string - URL đầy đủ
     */
    public static function url($path = '')
    {
        self::init();
        return BASE_URL . '/' . ltrim($path, '/');
    }
}
