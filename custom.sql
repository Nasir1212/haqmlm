CREATE TABLE user_self_submit_point (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    point VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE count_total_submitted_points (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    point TEXT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE transactions 
ADD COLUMN admin_recollect_date DATETIME NULL;

ALTER TABLE user_self_submit_point 
ADD COLUMN is_admin_point_collect TINYINT DEFAULT 0;

ALTER TABLE user_self_submit_point
ADD COLUMN admin_recollect_date DATETIME NULL;

ALTER TABLE dealers
ADD COLUMN country VARCHAR(250) NULL;


ALTER TABLE balance_transfer_records 
ADD COLUMN after_blance VARCHAR(250) NULL, 
ADD COLUMN prev_blance VARCHAR(250) NULL;


ALTER TABLE `point_sale_histories`
MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE balance_transfer_records 
ADD COLUMN sender_after_blance VARCHAR(250) NULL, 
ADD COLUMN sender_before_blance VARCHAR(250) NULL;

ALTER TABLE settings 
ADD COLUMN regular_tsp VARCHAR(250) NULL, 
ADD COLUMN irregular_tsp VARCHAR(250) NULL,
ADD COLUMN non_working_auto VARCHAR(250) NULL;

ALTER TABLE settings 
ADD COLUMN pension_withdraw_amount VARCHAR(250) NULL, 
ADD COLUMN lock_point VARCHAR(250) NULL;


ALTER TABLE users ADD COLUMN pension_balance VARCHAR(250) NULL;


ALTER TABLE withdraws 
ADD COLUMN payment_r_ac_qr VARCHAR(255) NULL AFTER payment_r_ac;


ALTER TABLE point_submit_histories 
ADD COLUMN remark_type VARCHAR(255) NULL AFTER point;

ALTER TABLE point_sale_histories 
ADD COLUMN remark_type VARCHAR(255) NULL AFTER point;