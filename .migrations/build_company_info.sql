CREATE TABLE `harvey_huang` (
    `id` BIGINT(20) NOT NULL COMMENT '系統編號',
    `name` VARCHAR(50) NOT NULL COMMENT '公司名稱',
    `founded_date` DATETIME NOT NULL COMMENT '公司成立日期',
    `contact` VARCHAR(50) NOT NULL COMMENT '公司聯絡窗口(人)',
    `email` VARCHAR(30) NOT NULL COMMENT '公司信箱',
    `scale` ENUM('big','medium','small') NOT NULL COMMENT '公司規模',
    `ndustry_id` BIGINT NOT NULL COMMENT '行業別編號 ndustry_info.id',
    `create_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '建立日期',
    `update_at` DATETIME NOT NULL COMMENT '更新日期',
    `delete_at` DATETIME NOT NULL COMMENT '刪除日期',
    `rec_status` ENUM('0','1') NOT NULL DEFAULT '1' COMMENT '資料狀態 0:無效 1:有效',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;