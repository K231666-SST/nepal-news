**CPRO306 — CAPSTONE PROJECT**

**Week 8 — Development Progress Report**

_Full-Stack Implementation Update_

**Nepal News Australia**

_Bilingual Nepali-Australian Community News Portal_

| **Field** | **Details** |
| --- | --- |
| Team | Team 9 — Skillup Labs WIL Program |
| Unit | CPRO306 Capstone Project — Kent Institute Australia |
| Week | Week 8 — May 2026 |
| Supervisor | Nabin Singh — wil@skilluplabs.com.au |
| Members | Shushil Shah Teli (K231666) · Subash Khatri (K250035) · Sujan Shrestha (K250040) |
| GitHub | https://github.com/K231666-SST/nepal-news |

# **1\. Executive Summary**

By the end of Week 8, Nepal News Australia has achieved full functional completeness across all core modules. The Laravel 13.7 application is running locally at http://localhost:8080, with all 15 functional requirements from the SRS implemented and verified. This report documents the features built, code implemented, and progress made during the Week 7-8 development sprint.

# **2\. Features Completed This Sprint**

## **2.1 Authentication and Role Management**

- Laravel Breeze authentication with 4 user roles: Admin, Editor, Contributor, Reader
- Role-based middleware protecting /dashboard, /articles/create, /admin/ads routes
- Animated login page with circular logo and spinning gradient ring
- Session management with remember-me functionality

## **2.2 Article Management System**

- Full CRUD operations: create, read, update, delete articles
- Publication workflow: Draft → Pending → Published → Archived
- Featured article and breaking news flagging for homepage hero
- View counter incrementing on each article visit
- Image URL support for article featured images
- Many-to-many tag relationships via article_tag pivot table

## **2.3 Homepage and Content Discovery**

- Hero section: 60/40 grid showing featured article + 2 sub-articles
- Breaking news ticker with animated scroll and gold label
- Latest News 3-column card grid with category badges
- Category tabs filtering articles (All, Nepal, Australia, Community, Business)
- Opinion section with 2-column grid and author avatars
- Community Events section with date box widgets

## **2.4 Live API Widgets (Sidebar)**

| **Widget** | **API Used** | **Data Shown** | **Status** |
| --- | --- | --- | --- |
| Weather | OpenWeatherMap | Temperature + conditions for SYD, MEL, KTM, BRI | Live ✅ |
| Gold Prices | MetalPriceAPI | Gold + silver prices in AUD per gram | Live ✅ |
| Currency Converter | ExchangeRate-API | NPR to AUD live rate + custom converter | Live ✅ |
| Rashifal | Horoscope App API | Daily horoscope for 12 Nepali zodiac signs | Live ✅ |
| Nepali Date | Custom BS/AD | Bikram Sambat + Gregorian dual date | Live ✅ |

## **2.5 Advertisement Management**

- 6 ad positions: sidebar_top, sidebar_middle, sidebar_bottom, header_banner, article_inline, homepage_banner
- 3 ad types: image (URL), HTML code injection, text-only
- Impression tracking: increments on every page load
- Click tracking: increments via async POST request
- Active/inactive toggle for campaign management

## **2.6 Bilingual Language Support**

- Session-based language switcher (English / नेपाली)
- Translated navigation labels, UI text, and widget headings
- Language preference persists across page navigation

## **2.7 Guru AI Assistant (Week 8 Addition)**

- Floating chatbot widget accessible from all pages (bottom-left 🧿 button)
- Powered by Groq API with Llama 3.1 8B Instant model (free tier)
- Features: article summarisation, English/Nepali translation, Nepal news Q&A
- Typing animation with bouncing dots, quick-action buttons, session chat history
- Auto-reads current page article title/summary as context for smarter responses

# **3\. Technical Implementation**

## **3.1 Controller Code — HomeController**

The HomeController aggregates all data required for the homepage in a single index() method, using Eloquent eager loading to minimise database queries:

public function index() { $featured = Article::published()->featured()->latest()->first(); $breaking = Article::published()->breaking()->latest()->take(5)->get(); $latest = Article::published()->latest()->take(6)->get(); $opinion = Article::published()->where('category','opinion')->latest()->take(4)->get(); $events = Event::upcoming()->take(3)->get(); return view('pages.home', compact('featured','breaking','latest','opinion','events')); }

## **3.2 Article Model Relationships**

class Article extends Model { public function author() { return $this->belongsTo(User::class, 'author_id'); } public function tags() { return $this->belongsToMany(Tag::class); } public function comments(){ return $this->hasMany(Comment::class); } public function scopePublished($q) { return $q->where('status','published'); } public function scopeFeatured($q) { return $q->where('is_featured', true); } public function scopeBreaking($q) { return $q->where('is_breaking', true); } }

# **4\. GitHub Activity Summary**

| **Team Member** | **Key Commits This Sprint** | **Files Changed** |
| --- | --- | --- |
| Shushil Shah Teli (K231666) | GuruController, ApiController, Advertisement system, deployment config | 15+ files |
| Subash Khatri (K250035) | GitHub cleanup, QA testing, Docker/Render configuration, README | 10+ files |
| Sujan Shrestha (K250040) | CSS system, Blade templates, hamburger menu, breaking bar fix | 12+ files |

# **5\. Issues Resolved**

| **Issue** | **Resolution** |
| --- | --- |
| Hero section not full width on desktop | Added .hero-section .container { max-width: 100% } CSS override |
| Hamburger menu not showing on mobile | Fixed conflicting CSS display:none rules, added proper @media queries |
| Breaking ticker text invisible | Added explicit white color override and display:block for all screen sizes |
| Advertisement sidebar_top redirecting | Removed nepalnewsaustralia.com.au from ad link_url via tinker |
| Render deployment Host empty | Fixed heredoc variable expansion in start.sh using ENVEOF marker |
| Groq API replacing OpenAI (quota exceeded) | Switched to Groq free API with llama-3.1-8b-instant model |

# **6\. Next Steps — Week 9**

- Complete and submit Mid-Project Deliverables report (Task 4)
- Add screenshots to report — database, UI pages, GitHub evidence
- Generate ERD from MySQL Workbench for documentation
- Stabilise Render.com deployment with Railway MySQL
- Begin formal unit and integration testing preparation

# **7\. References**

Laravel (2024) Laravel 11.x Documentation. Available at: https://laravel.com/docs

Groq (2024) Groq API Documentation. Available at: https://console.groq.com/docs

Pressman, R.S. and Maxim, B.R. (2014) Software Engineering: A Practitioner's Approach. 8th edn. McGraw-Hill.