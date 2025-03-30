
# Purrfect

### Features:
  - A pet adoption website where users match with adoptable pets.
  - Users can create an account, log in, and save pets to their favorites.
  - Users can click an "Adopt" icon to be redirected to a pet's adoption link.
  - The website features a playful, lighthearted theme.

### Future Features:
- Integration of APIs and web scrapers to automatically populate the pet database.
- Collaboration with animal shelters to get more accurate pet details and images.
- Ability for users to host fundraisers to help with clinic expenses.

---

## Getting Started

Follow the steps below to get the project up and running locally using **XAMPP**.

### Prerequisites
- **XAMPP** installed on your system.
- A basic understanding of  **JavaScript**.

### Installation

1. Clone this repository to your local machine:

2. Install **XAMPP** (if you don't have it installed already). You can download it from [here](https://www.apachefriends.org/index.html).

3. Put this folder in the `htdocs` folder in XAMPP

4. Start **XAMPP** and launch the **Apache** and **MySQL** server to run the web app.

5. Configure the **MySQL** server with the following commands:
```SQL
-- Create the database
CREATE DATABASE IF NOT EXISTS purrfect_db;
USE purrfect_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Pets table with an adoption link and added_by user ID
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age VARCHAR(20) NOT NULL,
    breed VARCHAR(100) NOT NULL,
    personality TEXT NOT NULL,
    bio TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,         -- now holds an image URL
    adoption_link VARCHAR(255) NOT NULL,
    added_by INT,
    FOREIGN KEY (added_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Favorites table
CREATE TABLE IF NOT EXISTS favorites (
    user_id INT,
    pet_id INT,
    PRIMARY KEY (user_id, pet_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);

```

### Usage

- To add pets, log in to the website and use the **Add Pet** feature. Ensure you upload an image and fill in the required information like breed, age, and personality.
- Swipe through pets, and save your favorites by clicking the **heart** icon.
- Once you are ready to adopt, click the **Adopt** button to be redirected to the pet's adoption link (currently a placeholder).

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
