CREATE TABLE user_self_submit_point (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    point VARCHAR(100) NULL,
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