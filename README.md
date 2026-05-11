# Nepal News Australia 🇳🇵🇦🇺

A full-stack news web application built for the Nepali-Australian diaspora community.

## Project Information
- **Course:** CPRO306 — Capstone Project
- **Institution:** Kent Institute Australia
- **Team:** Team 9 — Skillup Labs WIL
- **Supervisor:** Nabin Singh

## Team Members
| Name | Student ID | Role |
|------|-----------|------|
| Shushil Shah Teli | K231666 | Tech Lead & Backend Developer |
| Subash Khatri | K250035 | QA Engineer & DevOps |
| Sujan Shrestha | K250040 | Product Manager & Frontend |

## Tech Stack
- **Backend:** Laravel 13.7, PHP 8.5
- **Frontend:** Laravel Blade, Custom CSS
- **Database:** MySQL
- **APIs:** OpenWeatherMap, ExchangeRate, Horoscope API

## Features
- 📰 News articles across 8 categories
- 🌤️ Live weather, 💱 Currency converter, ⭐ Rashifal
- 👥 Role-based auth (Admin, Editor, Contributor, Reader)
- 📢 Advertisement management system
- 🌐 Bilingual English/Nepali support
- 📱 Mobile responsive design

## Installation
```bash
git clone https://github.com/K231666-SST/nepal-news.git
cd nepal-news
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Demo Credentials
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@nepalnews.com.au | password |
| Editor | editor@nepalnews.com.au | password |
| Contributor | contributor@nepalnews.com.au | password |

## License
MIT — Kent Institute Australia — CPRO306 Capstone 2026
