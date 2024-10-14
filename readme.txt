Creating a JWT (JSON Web Token) Authentication and Authorization system in PHP using MySQL requires proper design for modularity and maintainability. Below is a guide based on the Repository Pattern and Dependency Injection, following clean API principles.

#Components Overview:
    Database Setup: MySQL table for storing users.
    Models: Handle database operations.
    Controllers: Process API requests.
    JWT Helper: Generates and validates JWT tokens.
    Middleware: Authenticates users via JWT.
    API Routes: Defines the API endpoints.

Database:: jwt-corephp


1. Database Setup (MySQL)

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Use bcrypt for storing passwords securely.



2. Project Structure
/jwt-api/
│
├── /config/
│   └── Database.php         # DB connection setup
│
├── /controllers/
│   ├── AuthController.php   # Login/Register logic
│   └── UserController.php   # User-specific APIs
│
├── /models/
│   └── UserModel.php        # User queries
│
├── /middlewares/
│   └── JWTMiddleware.php    # JWT validation logic
│
├── /helpers/
│   └── JWT.php              # JWT creation/validation
│
└── /public/
    └── index.php            # API entry point


3. Config: Database Connection
/config/Database.php

4. User Model: Handling User Data
/models/UserModel.php

5. JWT Helper: Token Generation & Validation
/helpers/JWT.php

    -   Install the firebase/php-jwt library using:
            composer require firebase/php-jwt

6. Auth Controller: Handling Authentication
/controllers/AuthController.php

7. JWT Middleware: Authorization Check
/middlewares/JWTMiddleware.php

8. User Controller: Protected API Endpoint
/controllers/UserController.php

9. API Routes (Entry Point)
/public/index.php

10. Test the API
    Register:
        curl -X POST http://localhost/register -d '{"username": "test", "password": "123456"}'
    Login:
        curl -X POST http://localhost/login -d '{"username": "test", "password": "123456"}'
    Access Profile (Protected):
        curl -H "Authorization: Bearer <TOKEN>" http://localhost/profile



11. Rewrite Apache/Nginx Config for Clean URLs
    Ensure your web server configuration supports URL rewriting (so /register is processed through index.php). Below is the .htaccess file for Apache.
    /public/.htaccess

    Explanation:
        Any request like /register or /profile will now be internally routed to index.php.
        If the request matches an existing file or directory, it will serve those directly.
