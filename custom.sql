CREATE TABLE user_self_submit_point (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    point VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
