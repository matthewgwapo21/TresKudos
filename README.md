# 🍽️ TresKudos — Community Recipe Database

A full-featured community recipe platform where users can discover, share, and organize recipes. Built with Laravel 12 and deployed on Railway.

🌐 **Live Site**: [treskudos.up.railway.app](https://treskudos.up.railway.app)

---

## ✨ Features

### For Users
- 🔐 Register & login (email or Google OAuth)
- 🍳 Browse and search recipes by category and total time
- ➕ Submit your own recipes with photos
- ✏️ Edit and delete your own recipes
- ❤️ Favorite / bookmark recipes
- ⭐ Rate and review recipes (1-5 stars)
- 💬 Comment on recipes
- 📅 Weekly meal planner (Breakfast, Lunch, Dinner slots)
- 🛒 Auto-generated shopping list from meal plan
- 👤 User profile with bio and avatar

### For Admins
- 📊 Dashboard with site statistics
- 👥 View and manage all users (promote/demote admins)
- 🗂️ Manage categories (add, edit, delete)
- 🗑️ Delete any recipe

### API
- REST API with Laravel Sanctum authentication
- JSON endpoints for recipes, categories, login, register

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2) |
| Database | MySQL (Railway) |
| Frontend | Blade Templates + Tailwind CSS |
| Image Storage | Cloudinary |
| Authentication | Laravel Auth + Google OAuth (Socialite) |
| API Auth | Laravel Sanctum |
| Deployment | Railway |
| Version Control | GitHub |

---

## 📸 Screenshots

> Landing Page, Recipe Browse, Recipe Detail, Meal Planner, Admin Dashboard

---

## 🚀 Local Setup

### Requirements
- PHP 8.2+
- Composer
- MySQL (via XAMPP/phpMyAdmin)
- Git

### Steps
```bash
# Clone the repo
git clone https://github.com/matthewgwapo21/TresKudos.git
cd TresKudos

# Install dependencies
composer install

# Set up environment
copy .env.example .env
php artisan key:generate

# Configure your .env
DB_DATABASE=TresKudos
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seeders
php artisan migrate
php artisan db:seed --class=CategorySeeder

# Link storage
php artisan storage:link

# Start the server
php artisan serve
```

Then open `http://127.0.0.1:8000` in your browser.

---

## 🔑 Environment Variables
```env
APP_NAME=TresKudos
APP_ENV=local
APP_KEY=
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=TresKudos
DB_USERNAME=root
DB_PASSWORD=

CLOUDINARY_CLOUD_NAME=
CLOUDINARY_API_KEY=
CLOUDINARY_API_SECRET=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT=http://127.0.0.1:8000/auth/google/callback
```

---

## 📡 API Endpoints

### Public
| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/register` | Register a new user |
| POST | `/api/login` | Login and get token |
| GET | `/api/recipes` | Get all recipes |
| GET | `/api/recipes/{id}` | Get single recipe |
| GET | `/api/categories` | Get all categories |

### Protected (Bearer Token required)
| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/me` | Get current user |
| POST | `/api/recipes` | Create a recipe |
| DELETE | `/api/recipes/{id}` | Delete a recipe |
| POST | `/api/logout` | Logout |

---

## 👨‍💻 Developer

**Adrian Matthew Cortes**
- GitHub: [@matthewgwapo21](https://github.com/matthewgwapo21)

---

## 📄 License

This project is for educational purposes — 3rd Year BSIT, 2nd Semester 2025-2026.
