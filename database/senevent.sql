-- Base de données SenEvent
CREATE DATABASE IF NOT EXISTS senevent
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE senevent;

-- Table des utilisateurs (avec role : 'admin' ou 'user')
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des événements (avec image et categorie)
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    description TEXT,
    date_event DATE NOT NULL,
    lieu VARCHAR(150) NOT NULL,
    categorie VARCHAR(50) NOT NULL DEFAULT 'Autre',
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des réservations
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Compte administrateur par defaut
-- Email : admin@senevent.sn   /   Mot de passe : admin123
INSERT INTO users (nom, email, password, role) VALUES
('Administrateur', 'admin@senevent.sn',
 '$2y$10$WiiKDK2PjP9xUsaACrPRUOJzDVklL9Ff5BznxrYu7DjTxKEY.Xjgi', 'admin');

-- Quelques événements de test (avec categorie et image)
INSERT INTO events (titre, description, date_event, lieu, categorie, image) VALUES
('Concert Youssou Ndour', 'Grand concert au Grand Theatre national', '2026-08-15', 'Dakar', 'Concert', 'concert.jpg'),
('Forum Tech Dakar', 'Rencontre des developpeurs et startups', '2026-09-10', 'Diamniadio', 'Forum', 'forum.jpg'),
('Salon de l''Emploi', 'Rencontre entreprises et jeunes diplomes', '2026-10-05', 'Dakar', 'Salon', 'salon.jpg');
