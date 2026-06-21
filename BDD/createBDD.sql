CREATE DATABASE IF NOT EXISTS portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio;

CREATE TABLE IF NOT EXISTS session (
    token VARCHAR(255) PRIMARY KEY,
    expiration_date INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projets (
    projetID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(250),
    contexte TEXT,
    technologies VARCHAR(255),
    role TEXT,
    defis TEXT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projetsvideos (
    videoID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    projetID INT,
    lienVideo VARCHAR(255),
    ordre INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projetsimages (
    imageID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    projetID INT,
    lienImage VARCHAR(255),
    ordre INT DEFAULT 0
) ENGINE=InnoDB;

SET GLOBAL event_scheduler = ON;
DROP EVENT IF EXISTS clean_expired_sessions;

DELIMITER $$
CREATE EVENT clean_expired_sessions
    ON SCHEDULE EVERY 24 HOUR
    STARTS CURRENT_TIMESTAMP DO
    BEGIN
        DELETE FROM session WHERE expiration_date < UNIX_TIMESTAMP();
    END
$$ DELIMITER ;