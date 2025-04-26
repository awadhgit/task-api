
# Task Management REST API (Core PHP)



## Features

- User Registration
- User Login (returns token)
- Create, Read, Update, Delete (CRUD) Tasks
- Token-based authentication (No sessions)
- Secure PDO prepared statements



## Database Structure

### Users Table
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tasks Table
```sql
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  status ENUM('pending', 'completed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## API Endpoints

### Authentication

| Method | Endpoint | Description |
|:------:|:--------:|:-----------:|
| POST | `/api/register` | Register a new user |
| POST | `/api/login` | Login and receive a token |

### Task Management (Requires Bearer Token)

| Method | Endpoint | Description |
|:------:|:--------:|:-----------:|
| GET | `/api/tasks` | Get all tasks |
| POST | `/api/tasks` | Create a new task |
| GET | `/api/tasks/{id}` | Get a specific task |
| PUT | `/api/tasks/{id}` | Update a task |
| DELETE | `/api/tasks/{id}` | Delete a task |



