# Week 12 — Final Project Deliverable
## Nepal News Australia
**CPRO306 Capstone Project | Team 9 | Kent Institute Australia**

| Detail | Information |
|--------|-------------|
| Project Name | Nepal News Australia |
| Course | CPRO306 — Capstone Project |
| Institution | Kent Institute Australia |
| WIL Program | Skillup Labs |
| Supervisor | Nabin Singh — wil@skilluplabs.com.au |
| Live URL | https://nepal-news.onrender.com |
| GitHub | https://github.com/K231666-SST/nepal-news |
| Submission Week | Week 12 |

---

## Team Members

| Name | Student ID | Role |
|------|-----------|------|
| Shushil Shah Teli | K231666 | Tech Lead & Backend Developer |
| Subash Khatri | K250035 | QA Engineer & DevOps Engineer |
| Sujan Shrestha | K250040 | Product Manager & Frontend Developer |

---

## 1. Project Summary

Nepal News Australia is a full-stack bilingual news web application built for the Nepali-Australian diaspora community. The platform delivers current news across 8 categories, live financial and weather data, community events, and an AI-powered assistant named Guru.

The project was developed over 12 weeks using the Laravel 13 MVC framework, PHP 8.2, and SQLite database, deployed on Render.com using Docker containerisation.

---

## 2. Final Feature List

### 2.1 Core Features Completed

| Feature | Status | Description |
|---------|--------|-------------|
| News Articles (CRUD) | ✅ Complete | Create, read, update, delete across 8 categories |
| Role-Based Authentication | ✅ Complete | Admin, Editor, Contributor, Reader roles |
| User Registration & Login | ✅ Complete | Laravel Breeze authentication |
| Article Search & Filter | ✅ Complete | Search by keyword, filter by category and tag |
| Community Events | ✅ Complete | Submit, approve, and display events |
| Newsletter Subscription | ✅ Complete | Email capture with database storage |
| Advertisement Management | ✅ Complete | 6 ad positions, admin-only management |
| Bilingual Support | ✅ Complete | English and Nepali language switcher |
| Responsive Design | ✅ Complete | Mobile, tablet, desktop — hamburger menu |
| Nepali Date Widget | ✅ Complete | Bikram Sambat calendar with Hamro Patro link |

### 2.2 Live API Integrations

| API | Provider | Feature |
|-----|----------|---------|
| Weather API | OpenWeatherMap | Live weather for Sydney, Melbourne, Brisbane, Kathmandu |
| Metal Price API | MetalPriceAPI | Live gold and silver prices in AUD |
| Currency API | ExchangeRate-API | Live NPR to AUD conversion |
| Horoscope API | Horoscope App API | Daily Rashifal for all 12 zodiac signs |

### 2.3 AI Integration

| Component | Detail |
|-----------|--------|
| Assistant Name | Guru |
| Provider | Groq Cloud |
| Model | llama-3.1-8b-instant |
| Features | Article summarisation, English-Nepali translation, Q&A |
| Controller | app/Http/Controllers/GuruController.php |
| View Component | resources/views/components/guru-chat.blade.php |

---

## 3. Technology Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend Framework | Laravel | 13.7.0 |
| Programming Language | PHP | 8.2.31 |
| Database | SQLite | 3.x |
| Web Server | Apache | 2.4.67 |
| Frontend | Laravel Blade + Custom CSS | — |
| Containerisation | Docker | Latest |
| Hosting | Render.com | Free tier |
| Version Control | GitHub | — |
| AI API | Groq (llama-3.1-8b-instant) | Latest |

---

## 4. Project Architecture

```
nepal-news/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php        # Homepage logic
│   │   ├── ArticleController.php     # Article CRUD
│   │   ├── EventController.php       # Events management
│   │   ├── DashboardController.php   # Admin dashboard
│   │   ├── ApiController.php         # Live API widgets
│   │   ├── GuruController.php        # AI chatbot
│   │   └── AdvertisementController.php
│   └── Models/
│       ├── Article.php
│       ├── User.php
│       ├── Event.php
│       └── Advertisement.php
├── database/migrations/              # 5 migration files
├── resources/views/                  # Blade templates
├── public/assets/                    # CSS, JS, images
├── routes/web.php                    # All URL routes
├── Dockerfile                        # Docker configuration
├── start.sh                          # Production startup script
└── docs/                             # All project documentation
```

---

## 5. Database Schema

| Table | Purpose | Key Fields |
|-------|---------|-----------|
| users | User accounts and roles | id, name, email, role, password |
| articles | News articles | id, title, slug, content, category, status, author_id |
| tags | Article tags | id, name, slug |
| article_tag | Pivot table | article_id, tag_id |
| events | Community events | id, title, date, location, is_approved |
| advertisements | Ad management | id, title, position, type, image_url, is_active |
| subscribers | Newsletter emails | id, email, created_at |
| comments | Article comments | id, article_id, user_id, content |

---

## 6. Deployment

### 6.1 Production Environment

| Item | Detail |
|------|--------|
| Platform | Render.com (Docker) |
| Database | SQLite (bundled in container) |
| Live URL | https://nepal-news.onrender.com |
| Auto-deploy | Yes — triggers on every GitHub push to main |

### 6.2 Local Development

```bash
git clone https://github.com/K231666-SST/nepal-news.git
cd nepal-news
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --port=8080
```

### 6.3 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@nepalnews.com.au | admin123 |
| Editor | editor@nepalnews.com.au | admin123 |
| Contributor | contributor@nepalnews.com.au | admin123 |
| Reader | reader@nepalnews.com.au | admin123 |

---

## 7. Testing Summary

| Category | Tests Run | Passed | Failed |
|----------|-----------|--------|--------|
| Authentication | 6 | 6 | 0 |
| Article CRUD | 8 | 8 | 0 |
| Role-Based Access | 6 | 6 | 0 |
| Live API Widgets | 5 | 5 | 0 |
| Guru AI Chatbot | 4 | 4 | 0 |
| Newsletter | 3 | 3 | 0 |
| Responsiveness | 6 | 6 | 0 |
| W3C Validation | 7 pages | 7 | 0 |
| **Total** | **45** | **45** | **0** |

---

## 8. Individual Contributions

| Team Member | Contribution % | Key Work |
|-------------|---------------|---------|
| Shushil Shah Teli (K231666) | 40% | Laravel backend, all controllers, database design, API integration, Docker deployment |
| Subash Khatri (K250035) | 30% | QA testing, DevOps, Render deployment, CI/CD, test documentation |
| Sujan Shrestha (K250040) | 30% | Frontend Blade templates, CSS design, UI/UX, all project documentation |

---

## 9. Lessons Learned

- Laravel MVC architecture significantly accelerated development by separating concerns clearly
- SQLite is suitable for small-scale production deployment when MySQL is unavailable
- Docker containerisation ensured consistent behaviour between local and production environments
- Free hosting platforms (Render.com) have cold-start delays that must be communicated to users
- Groq API provided a reliable and completely free alternative to OpenAI for AI integration

---

## 10. References

- Laravel Documentation. (2024). *Laravel 13.x Documentation*. https://laravel.com/docs
- Groq Cloud. (2024). *Groq API Documentation*. https://console.groq.com/docs
- Render. (2024). *Render Documentation — Docker Deploys*. https://render.com/docs
- OpenWeatherMap. (2024). *Current Weather Data API*. https://openweathermap.org/api
- W3C. (2024). *Markup Validation Service*. https://validator.w3.org
- Pressman, R. S. & Maxim, B. R. (2020). *Software Engineering: A Practitioner's Approach* (9th ed.). McGraw-Hill.
