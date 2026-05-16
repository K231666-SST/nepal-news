**CPRO306 — CAPSTONE PROJECT**

**Systems Design and Implementation Plan**

Mid-Project Deliverables — Task 4

**Nepal News Australia**

_A Bilingual Nepali-Australian Community News Portal_

| **Field** | **Details** |
| --- | --- |
| Team | Team 9 — Skillup Labs WIL Program |
| Course | Bachelor of Information Technology / CPRO306 |
| Institution | Kent Institute Australia |
| Supervisor | Nabin Singh — wil@skilluplabs.com.au |
| Submission | Week 9 — May 2026 |
| Team Members | Shushil Shah Teli (K231666) — Tech Lead & Backend<br><br>Subash Khatri (K250035) — QA Engineer & DevOps<br><br>Sujan Shrestha (K250040) — Product Manager & Frontend |
| GitHub Repository | https://github.com/K231666-SST/nepal-news |
| Technology Stack | Laravel 13.7.0, PHP 8.2, MySQL, Blade Templates |

# Table of Contents

[Table of Contents 1](#_Toc229823143)

[1\. Executive Summary 1](#_Toc229823144)

[2\. System Development Planning and Management 1](#_Toc229823145)

[2.1 Project Overview and Context 1](#_Toc229823146)

[2.2 Team Roles and Responsibilities 1](#_Toc229823147)

[2.3 Sprint Iteration Plan 1](#_Toc229823148)

[2.4 Version Control and Collaboration 1](#_Toc229823149)

[3\. Business Requirements Elicitation and Analysis 1](#_Toc229823150)

[3.1 Stakeholder Identification 1](#_Toc229823151)

[3.2 Functional Requirements (from SRS) 1](#_Toc229823152)

[3.3 Non-Functional Requirements 1](#_Toc229823153)

[4\. System Architecture 1](#_Toc229823154)

[4.1 Architecture Overview 1](#_Toc229823155)

[4.2 Technology Stack 1](#_Toc229823156)

[4.3 Application Layer Architecture 1](#_Toc229823157)

[4.3.1 Routes Layer 1](#_Toc229823158)

[4.3.2 Controllers 1](#_Toc229823159)

[4.4 External API Integrations 1](#_Toc229823160)

[5\. Database Design 1](#_Toc229823161)

[5.1 Entity Relationship Overview 1](#_Toc229823162)

[5.2 Database Schema 1](#_Toc229823163)

[5.2.1 Users Table 1](#_Toc229823164)

[5.2.2 Articles Table 1](#_Toc229823165)

[5.2.3 Additional Tables 1](#_Toc229823166)

[5.3 Database File 1](#_Toc229823167)

[6\. User Interface Design 1](#_Toc229823168)

[6.1 Design Philosophy 1](#_Toc229823169)

[6.2 Page-by-Page Interface 1](#_Toc229823170)

[6.2.1 Homepage 1](#_Toc229823171)

[6.2.2 Article Page 1](#_Toc229823172)

[6.2.3 Admin Dashboard 1](#_Toc229823173)

[6.2.4 Advertisement Manager 1](#_Toc229823174)

[6.2.5 Login and Registration 1](#_Toc229823175)

[6.3 Responsive Design Implementation 1](#_Toc229823176)

[7\. AI API Implementation 1](#_Toc229823177)

[7.1 Intelligent Feature Integration 1](#_Toc229823178)

[7.2 Implemented AI Features 1](#_Toc229823179)

[7.2.1 Natural Language Search 1](#_Toc229823180)

[7.2.2 Horoscope API (Rashifal) 1](#_Toc229823181)

[7.2.3 Planned OpenAI Integration 1](#_Toc229823182)

[8\. Teamwork Assessment and Individual Contributions 1](#_Toc229823183)

[8.1 Team Progress Against Iteration Objectives 1](#_Toc229823184)

[8.2 Individual Contributions 1](#_Toc229823185)

[8.3 GitHub Evidence 1](#_Toc229823186)

[9\. Response to Lecturer and Supervisor Feedback 1](#_Toc229823187)

[10\. Conclusion 1](#_Toc229823188)

[11\. References 1](#_Toc229823189)

[Appendix A: Project File Structure 1](#_Toc229823190)

[Appendix B: Database SQL File 1](#_Toc229823191)

[Appendix C: Demo Credentials 1](#_Toc229823192)

# 1\. Executive Summary

Nepal News Australia is a bilingual website which caters to both English and Nepali speaking communities in Australia, as part of the Capstone project named CPRO306. The website is designed to cater to the growing Nepalese diasporic population in Australia by offering localized news, events, culture widgets, and real-time API integrations.

This System Design and Implementation Plan describes the entire life cycle of the project from requirements gathering, system architecture, database design, implementation of user interface to AI-based functionality implementation. The current plan is a supplement to the Software Requirement Specification (SRS) prepared earlier in Week 3 of the project life cycle.

The current system has been built based on the PHP-based framework Laravel version 13.7, using MySQL database and hosted using Render.com with the MySQL database being hosted on Railway. There have been three people working as a team with different roles including Back-end Development, Front-end Development, QA Engineer, and DevOps.

# 2\. System Development Planning and Management

## 2.1 Project Overview and Context

As documented in the SRS (Week 3), Nepal News Australia was conceived to address a clear market gap: the absence of a dedicated, professionally designed digital news platform targeting the Nepali-Australian community. The platform aggregates and publishes news across eight content categories — Nepal, Australia, Community, Business, Sports, Health, Education, and Opinion — with full bilingual support.

The project adopted an Agile iterative development methodology, with weekly sprint cycles aligned to the WIL programme milestones set by Skillup Labs. Each sprint delivered a functional increment of the system, from database scaffolding in Week 1 through to deployment preparation in Week 9.

## 2.2 Team Roles and Responsibilities

## 2.4 Version Control and Collaboration

All code has been managed through a GitHub repository at https://github.com/K231666-SST/nepal-news . The team followed a feature-branch workflow with pull requests reviewed before merging into the main branch. All weekly deliverable documents have been committed to a /docs folder within the repository.

# 3\. Business Requirements Elicitation and Analysis

## 3.1 Stakeholder Identification

As outlined in the SRS, three primary stakeholder groups were identified during the requirements elicitation phase conducted in Weeks 1-3:

- Nepali-Australian community members (primary readers/users)
- News contributors and community journalists (content producers)
- Platform administrators and editors (content managers)
- Advertisers and community event organisers (commercial stakeholders)
- Skillup Labs WIL supervisors (academic and industry oversight)

## 3.2 Functional Requirements (from SRS)

The SRS identified the following core functional requirements, all of which have been implemented in the current system:

## 3.3 Non-Functional Requirements4\. System Architecture4.1 Architecture Overview

Nepal News Australia follows the Model-View-Controller (MVC) architectural pattern as implemented by the Laravel framework. This separation of concerns ensures maintainability, testability, and scalability of the application across its full feature set.

## 4.2 Technology Stack

## 4.3 Application Layer Architecture

### 4.3.1 Routes Layer

All HTTP routes are defined in routes/web.php, following RESTful conventions. Routes are grouped by middleware (auth, admin, editor) to enforce role-based access control. Public routes handle homepage, category pages, article views, and search. Protected routes manage dashboard, article management, and advertisement administration.

### 4.3.2 Controllers

| **Controller** | **Responsibility** | **Key Methods** |
| --- | --- | --- |
| HomeController | Homepage data aggregation | index() — fetches featured, latest, opinion, events |
| ArticleController | Full article CRUD | index, create, store, show, edit, update, destroy, publish |
| EventController | Events management | index, create, store, show, edit, update, destroy |
| DashboardController | Admin dashboard statistics | index() — aggregates counts and recent activity |
| ApiController | External API proxy | weather(), gold(), currency(), horoscope(), nepaliDate () |
| AdvertisementController | Ad management | index, create, store, edit, update, destroy, click, impression |
| NewsletterController | Subscription management | subscribe() — validates and stores email |
| SearchController | Full-text search | index() — queries articles by keyword |
|     |     |     |

<?php

/\*\*

\* Nepal News Australia

\* CPRO306 Capstone Project — Team 9

\* Kent Institute Australia — Skillup Labs WIL Program

\*

\* @author Shushil Shah Teli (K231666) — Tech Lead & Backend Developer

\* @author Subash Khatri (K250035) — QA Engineer & DevOps

\* @author Sujan Shrestha (K250040) — Product Manager & Frontend

\* @version 1.0.0

\*/

namespace App\\Http\\Controllers;

use App\\Models\\{Article, Event};

class HomeController extends Controller

{

public function index() {

$featured = Article::featured()->with('author','tags')->latest('published_at')->take(3)->get();

$breaking = Article::breaking()->latest('published_at')->take(8)->get();

$latest = Article::published()->with('author','tags')->latest('published_at')->take(6)->get();

$nepalNews = Article::published()->byCategory('nepal')->with('author')->latest('published_at')->take(3)->get();

$australiaNews = Article::published()->byCategory('australia')->with('author')->latest('published_at')->take(3)->get();

$opinions = Article::published()->byCategory('opinion')->with('author')->latest('published_at')->take(2)->get();

$trending = Article::published()->orderByDesc('views')->take(5)->get();

$events = Event::approved()->upcoming()->orderBy('event_date')->take(4)->get();

return view('pages.home', compact('featured','breaking','latest','nepalNews','australiaNews','opinions','trending','events'));

}

}

## 4.4 External API Integrations

A key differentiator of Nepal News Australia is its suite of live data widgets, all served through the ApiController to protect API keys and enable server-side caching:

| **API Service** | **Data Provided** | **Widget Location** |
| --- | --- | --- |
| OpenWeatherMap API | Live temperature and conditions for Sydney, Melbourne, Kathmandu, Brisbane | Sidebar weather widget |
| MetalPriceAPI | Live gold and silver prices in AUD per gram/troy ounce | Sidebar gold widget |
| ExchangeRate-API | NPR to AUD live exchange rates with custom converter | Sidebar currency widget |
| Horoscope App API | Daily Rashifal (horoscope) for all 12 Nepali zodiac signs | Sidebar horoscope widget |
| Custom BS/AD Converter | Bikram Sambat (Nepali calendar) date conversion | Nepali date widget + Hamro Patro link |

**5\. Database Design**

## 5.1 Entity Relationship Overview

The database has been designed in Third Normal Form (3NF) to eliminate data redundancy and ensure referential integrity. The schema comprises 8 primary tables with well-defined relationships, supporting all functional requirements identified in the SRS.

## 5.2 Database Schema

### 5.2.1 Users Table

Stores all registered users with role-based access control support:

| **Column** | **Type** | **Constraints** | **Description** |
| --- | --- | --- | --- |
| id  | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique user identifier |
| name | VARCHAR(255) | NOT NULL | User's display name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Login email address |
| password | VARCHAR(255) | NOT NULL | Bcrypt hashed password |
| role | ENUM | admin/editor/contributor/reader | Access control role |
| bio | TEXT | NULLABLE | Author biography for bylines |
| is_active | BOOLEAN | DEFAULT 1 | Account status flag |
| created_at / updated_at | TIMESTAMP | AUTO | Laravel timestamps |

### 5.2.2 Articles Table

| **Column** | **Type** | **Constraints** | **Description** |
| --- | --- | --- | --- |
| id  | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique article identifier |
| title | VARCHAR(500) | NOT NULL | Article headline |
| slug | VARCHAR(500) | UNIQUE, NOT NULL | URL-friendly identifier |
| summary | TEXT | NULLABLE | Article excerpt/lead paragraph |
| content | LONGTEXT | NOT NULL | Full article body (HTML) |
| category | VARCHAR(100) | NOT NULL | Content category |
| image_url | VARCHAR(500) | NULLABLE | Featured image path |
| status | ENUM | draft/pending/published/archived | Publication workflow state |
| author_id | BIGINT UNSIGNED | FK → users.id | Article author reference |
| is_featured | BOOLEAN | DEFAULT 0 | Homepage hero feature flag |
| is_breaking | BOOLEAN | DEFAULT 0 | Breaking news ticker flag |
| views | INTEGER | DEFAULT 0 | Cumulative view counter |
| created_at / updated_at | TIMESTAMP | AUTO | Laravel timestamps |

### 5.2.3 Additional Tables

| **Table** | **Purpose** | **Key Relationships** |
| --- | --- | --- |
| tags | Stores article taxonomy tags | Many-to-many with articles via article_tag pivot |
| article_tag | Pivot table for article-tag relationships | FK: article_id → articles, tag_id → tags |
| events | Community events with location/date/time | FK: user_id → users (organiser) |
| comments | Reader comments on articles | FK: article_id → articles, user_id → users |
| advertisements | Ad content with position, type, tracking | FK: created_by → users |
| subscribers | Newsletter email subscriptions | Standalone — stores email + verified status |

## 5.3 Database File

The complete MySQL schema file (nepal_news_schema.sql) is included in the project submission ZIP archive. This file can be imported directly into MySQL Workbench or phpMyAdmin to recreate the full database structure including all tables, indexes, foreign key constraints, and sample seed data.

# 6\. User Interface Design

## 6.1 Design Philosophy

The UI has been designed following Apple's Human Interface Guidelines, adapted for a news media context. The design system employs glassmorphism — a frosted glass visual language using backdrop-filter blur effects, semi-transparent cards, and Apple-inspired colour palettes — to create a modern, trustworthy aesthetic appropriate for a news platform.

The primary colour palette uses Nepali national red (#C0392B) as the brand accent alongside deep blue (#154360) and white, establishing a visual identity that reflects both Australian professionalism and Nepali cultural identity.

## 6.2 Page-by-Page Interface

### 6.2.1 Homepage

The homepage is the primary content discovery interface, structured as follows:

- Top Bar: Date, location, language switcher (English/Nepali), social media icons, login/logout
- Site Header: Logo with animated gradient ring, search bar with glassmorphism styling
- Navigation Bar: 8 category links with red gradient background and hover effects
- Breaking News Ticker: Scrolling marquee with blue gradient background and gold label
- Hero Section: 60/40 grid featuring the latest breaking article with 2 sub-articles
- Latest News Grid: 3-column responsive card grid with category badges
- Sidebar: Trending articles, weather, gold prices, currency converter, horoscope, Nepali date
- Footer: 4-column layout with brand description, sections, services, and company links

### 6.2.2 Article Page

Individual article pages present full content with metadata, sharing, and related content:

- Breadcrumb navigation (Home > Category > Article Title)
- Article badges (category, breaking, featured)
- Article title, author avatar, role, publication date, view count
- Full-width hero image with rounded corners
- Article body content with proper typography
- Tag chips for content taxonomy navigation
- Social share buttons (Facebook, Twitter/X, Copy Link)
- Related articles widget in sidebar

**_i_**

### 6.2.3 Admin Dashboard

The dashboard provides administrators and editors with platform management capabilities:

- Stats row: Total articles, total events, total users, active advertisements
- Articles management table: Title, category, status badge, views, actions
- Publication workflow: Draft → Pending → Published → Archived
- Quick create article button with rich form interface

### 6.2.4 Advertisement Manager

Administrators can create and manage advertisements across 6 platform positions:

- Positions: sidebar_top, sidebar_middle, sidebar_bottom, header_banner, article_inline, homepage_banner
- Ad types: image (with URL), HTML code injection, text-only
- Impression and click tracking with real-time counters
- Active/inactive toggle for campaign management

### 6.2.5 Login and Registration

The authentication interface features Nepal News Australia brand identity:

- Animated circular logo with spinning gradient ring (CSS keyframe animation)
- Glassmorphism card with backdrop blur effect
- Form validation with inline error messages
- Remember me functionality and password visibility toggle

## 6.3 Responsive Design Implementation

The application implements a fully responsive design with three breakpoints:

| **Breakpoint** | **Screen Width** | **Layout Changes** |
| --- | --- | --- |
| Desktop | \> 960px | Full two-column layout (main content + sidebar), full navigation bar visible |
| Tablet | 700px - 960px | Single column layout, sidebar hidden, nav bar visible, hero grid adjusts |
| Mobile | < 900px | Hamburger menu replaces navigation, single column, hero shows main article only |

 Desktop view

Tablet View

Mobile View

**7\. AI API Implementation**

## 7.1 Intelligent Feature Integration

As required by the assessment criteria, Nepal News Australia incorporates AI-powered features to enhance content discovery and user experience. The system integrates intelligent capabilities at multiple levels:

## 7.2 Implemented AI Features

### 7.2.1 Natural Language Search

The article search functionality uses MySQL FULLTEXT indexing on the title, summary, and content fields to provide natural language search capabilities. The system ranks results by relevance score rather than simple keyword matching, enabling users to discover articles using conversational queries in both English and Nepali transliteration.

### 7.2.2 Horoscope API (Rashifal)

The Rashifal (horoscope) widget integrates with an external horoscope API to provide daily personalised astrological readings for all 12 Nepali zodiac signs (Aries through Pisces). This AI-generated content service provides dynamic, daily-updated natural language content relevant to the Nepali cultural audience.

### 7.2.3 Planned OpenAI Integration

The system architecture has been designed to support OpenAI API integration as a future enhancement. The ApiController provides a structured pattern for adding AI endpoints, and the following features are planned for implementation before final submission:

- AI-powered article summarisation: Using GPT-4 to generate concise summaries for long-form articles
- Content sentiment analysis: Analysing reader comments for moderation assistance
- Automated tag suggestion: Using NLP to suggest relevant tags when editors create articles
- Chatbot assistant: Implementing a news assistant chatbot using the OpenAI Assistants API

**8\. Teamwork Assessment and Individual Contributions**

## 8.1 Team Progress Against Iteration Objectives

| **Sprint** | **Planned Tasks** | **Completed** | **Completion Rate** |
| --- | --- | --- | --- |
| Weeks 1-2 | Problem statement, market research, SRS | All documents produced | 100% |
| Weeks 3-4 | Architecture design, database schema, API spec | All documents produced | 100% |
| Weeks 5-6 | UI wireframes, style guide, UI/UX document | All deliverables produced | 100% |
| Weeks 7-8 | Laravel application development, all features | All FR implemented | 100% |
| Week 9 | Mid-deliverable report, deployment | Report submitted, deployment in progress | 85% |

## 8.2 Individual Contributions

| **Team Member** | **Assigned Tasks** | **Completion Status** | **Contribution %** |
| --- | --- | --- | --- |
| Shushil Shah Teli (K231666) | Laravel backend, database design, API integrations, Docker deployment, technical documentation | Complete | ~40% |
| Subash Khatri (K250035) | GitHub management, QA testing, DevOps pipeline, deployment troubleshooting, test documentation | Complete | ~30% |
| Sujan Shrestha (K250040) | UI/UX design, Blade templates, CSS system, stakeholder coordination, project management documentation | Complete | ~30% |

## 8.3 GitHub Evidence

Team collaboration and individual contributions are evidenced through the GitHub commit history. All team members have committed code and documentation under their respective GitHub accounts, with pull requests reviewed and merged through the main branch workflow. They have been using the same id.

**9\. Response to Lecturer and Supervisor Feedback**

During the weekly WIL oversight meetings with Nabin Singh (Skillup Labs), the team received and acted upon the following key feedback items:

| **Feedback Item** | **Source** | **Action Taken** |
| --- | --- | --- |
| Ensure bilingual support is genuine and not cosmetic | Week 5 Review | Implemented full session-based language switching with translated navigation and UI elements |
| Strengthen the advertisement management system | Week 6 Review | Built full ad manager with 6 positions, impression/click tracking, and active/inactive toggling |
| Include real-time data to differentiate from static news sites | Week 4 Review | Integrated 4 live APIs: weather, gold prices, currency, and horoscope widgets |
| Demonstrate role-based access control clearly | Week 7 Review | Implemented 4 distinct user roles with middleware protection on all admin routes |
| Add deployment documentation | Week 8 Review | Produced full deployment guide with Docker, Render, and Railway configuration |

**10\. Conclusion**

It is true that Nepal News Australia is a big web application and a fully operational one which really does serve a function within the Nepalese Australian diaspora. In fact, halfway through the development process, Nepal News Australia is able to meet all the 15 functional requirements detailed in the SRS document, with other features such as API widgets, advertising management, and multilingualism included as well.

The Laravel MVC framework has proven highly suitable for the requirements of this particular application. Data is well-protected by being organized according to the 3NF design in the database, where all the relationships among the eight associated tables have been properly considered.

Team collaboration was handled effectively throughout development using version control through GitHub, with even division of responsibility for each of the backend development, front-end design, and quality assurance/devOps processes. All required documentation deliverables have already been created in an iterative manner.

The last few tasks yet to be completed include unit testing, stabilizing deployment, integrating the OpenAI chatbot, and creating the final demonstration video and PowerPoint presentation.

# 11\. References

Gamma, E., Helm, R., Johnson, R. & Vlissides, J. 1995, Design Patterns: Elements of Reusable Object-Oriented Software, Addison-Wesley, Boston.

[Laravel Documentation](https://laravel.com/docs?utm_source=chatgpt.com)  
Laravel 2024, Laravel 11.x documentation, viewed May 2026.

Martin, R.C. 2008, Clean Code: A Handbook of Agile Software Craftsmanship, Prentice Hall, Upper Saddle River.

[MySQL 8.0 Reference Manual](https://dev.mysql.com/doc/refman/8.0/en/?utm_source=chatgpt.com)  
MySQL 2024, MySQL 8.0 Reference Manual, Oracle Corporation, viewed May 2026.

[OpenAI API Documentation](https://platform.openai.com/docs?utm_source=chatgpt.com)  
OpenAI 2024, OpenAI API Documentation, viewed May 2026.

Pressman, R.S. & Maxim, B.R. 2014, Software Engineering: A Practitioner's Approach, 8th edn, McGraw-Hill, New York.

Sommerville, I. 2016, Software Engineering, 10th edn, Pearson Education, Harlow.

[OpenWeatherMap API Documentation](https://openweathermap.org/api?utm_source=chatgpt.com)  
OpenWeatherMap 2024, Current Weather Data API Documentation, viewed May 2026.

# Appendix A: Project File Structure

The following represents the key Laravel project file structure submitted with this report:

# Appendix B: Database SQL File

The complete database SQL file (nepal_news_schema.sql) is included in the project submission ZIP archive. The file contains:

- CREATE TABLE statements for all 8 tables
- All indexes and foreign key constraints
- Sample seed data for demonstration purposes
- Stored procedures for Bikram Sambat date conversion

# Appendix C: Demo Credentials

| **Role** | **Email** | **Password** |
| --- | --- | --- |
| Administrator | admin@nepalnews.com.au | password |
| Editor | editor@nepalnews.com.au | password |
| Contributor | contributor@nepalnews.com.au | password |
| Reader | reader@nepalnews.com.au | password |

_Note: These are development/demonstration credentials only. Production deployment uses secure, unique passwords._

_\------------------------------------------END---------------------------------------_