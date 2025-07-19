-- Insert an admin user with username 'admin' and password 'admin123'
INSERT INTO users (username, password, is_admin) VALUES (
    'admin',
    '$2y$10$e0NRzQ6q6vQ6Q6Q6Q6Q6QO6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6', -- password hash for 'admin123'
    1
);
