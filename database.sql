CREATE DATABASE IF NOT EXISTS college_media;

USE college_media;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    avatar VARCHAR(500),
    is_banned BOOLEAN DEFAULT 0,
    is_admin BOOLEAN DEFAULT 0
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(500),
    category VARCHAR(255) NOT NULL,
    likes INT DEFAULT 0,
    dislikes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS post_reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    reaction_type VARCHAR(10) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    UNIQUE(user_id, post_id)
);

-- Insert a default admin user (password is 'admin_password')
INSERT INTO users (username, email, password, country, avatar, is_admin) VALUES
('admin', 'admin@test.com', 'admin_password', 'USA', 'https://i.pinimg.com/1200x/68/e4/24/68e42428134581259d464896ac826b2b.jpg', 1);

-- Insert a default regular user (password is 'user_password')
INSERT INTO users (username, email, password, country, avatar) VALUES
('testuser', 'test@test.com', 'user_password', 'Canada', 'https://i.pinimg.com/736x/67/e0/f4/67e0f43a5795f412139477c0e85e7dd7.jpg');

-- Insert some posts for different categories
-- Assuming admin has user_id = 1 and testuser has user_id = 2

-- Games Category
INSERT INTO posts (user_id, title, description, image, category) VALUES
(1, 'New RPG Game Released', 'A new epic RPG has just been released. Check out the trailer!', 'https://www.zleague.gg/theportal/wp-content/uploads/2023/12/Lethal-Company-Scary-Monsters.jpg', 'Games'),
(2, 'Top 5 Racing Games of 2025', 'Here are the top 5 racing games you must play this year.', 'https://racinggames.gg/wp-content/uploads/2023/11/Forza-Motorsport-best-starter-car-800x450.jpg', 'Games');

-- Cars Category
INSERT INTO posts (user_id, title, description, image, category) VALUES
(1, 'Review of the new Electric SUV', 'This new electric SUV is a game changer. Read our full review.', 'https://www.topgear.com/sites/default/files/2023/09/1-BMW-iX1.jpg', 'Cars'),
(2, 'Classic Muscle Cars Auction', 'A rare collection of classic muscle cars is up for auction.', 'https://www.motortrend.com/uploads/sites/5/2021/04/1970-Chevrolet-Chevelle-SS-454-LS6-coupe-front-three-quarter.jpg', 'Cars');

-- Movie Category
INSERT INTO posts (user_id, title, description, image, category) VALUES
(1, 'Upcoming Sci-Fi Movie Trailer', 'The trailer for the most anticipated sci-fi movie of the decade is here.', 'https://www.pluggedin.com/wp-content/uploads/2023/07/the-creator-movie-review-1200x688.jpg', 'Movie'),
(2, 'Best Comedies to Watch This Weekend', 'Looking for a laugh? Here are some of the best comedies available now.', 'https://static1.moviewebimages.com/wordpress/wp-content/uploads/2023/02/best-comedy-movies-of-the-2010s-ranked.jpg', 'Movie');

-- Anime Category
INSERT INTO posts (user_id, title, description, image, category) VALUES
(1, 'New Shonen Anime Announcement', 'A new shonen anime from a legendary studio has been announced.', 'https://static1.cbrimages.com/wordpress/wp-content/uploads/2024/02/featured-image-for-a-list-of-the-best-shonen-anime-of-all-time.jpg', 'Anime'),
(2, 'Top 10 Slice of Life Anime', 'Relax and unwind with these top 10 slice of life anime series.', 'https://static1.cbrimages.com/wordpress/wp-content/uploads/2020/04/slice-of-life-anime-skip-and-loafer-horimiya-and-loving-yamada-kun-at-lv999.jpg', 'Anime');