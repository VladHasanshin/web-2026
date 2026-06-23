USE blog;

CREATE TABLE user (
    id INT UNSIGNED AUTO_INCREMENT,
    user_name CHAR(50) NOT NULL,
    avatar_path VARCHAR(255) DEFAULT './img/default_avatar.jpg',
    PRIMARY KEY (id)
);

CREATE TABLE post (
    id INT UNSIGNED AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    post_text TEXT NOT NULL,
    likes_count INT DEFAULT 0,
    post_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);