**CPRO306 — CAPSTONE PROJECT**

**Week 10 — Test Plan & Quality Assurance Report**

_System Testing and Validation_

**Nepal News Australia**

_Bilingual Nepali-Australian Community News Portal_

| **Field** | **Details** |
| --- | --- |
| Team | Team 9 — Skillup Labs WIL Program |
| Unit | CPRO306 Capstone Project — Kent Institute Australia |
| Week | Week 10 — May 2026 |
| Supervisor | Nabin Singh — wil@skilluplabs.com.au |
| Members | Shushil Shah Teli (K231666) · Subash Khatri (K250035) · Sujan Shrestha (K250040) |
| GitHub | https://github.com/K231666-SST/nepal-news |

# **1\. Introduction**

This Test Plan and Quality Assurance Report documents the testing strategy, test cases, and results for Nepal News Australia. Testing was conducted across four phases: unit testing, integration testing, user acceptance testing (UAT), and performance testing. All tests target the functional requirements defined in the SRS (Week 3).

# **2\. Testing Strategy**

## **2.1 Testing Scope**

- Authentication and role-based access control
- Article CRUD operations and publication workflow
- Live API integrations (weather, gold, currency, horoscope)
- Guru AI chatbot responses and context awareness
- Advertisement management and impression/click tracking
- Bilingual language switching
- Responsive design across devices (desktop, tablet, mobile)
- Database integrity and foreign key constraints

## **2.2 Testing Tools**

| **Tool** | **Purpose** |
| --- | --- |
| PHPUnit | Laravel unit and feature tests for controllers and models |
| Laravel Tinker | Manual database queries and model testing |
| Browser DevTools | Responsive design testing at 375px, 768px, 1440px |
| Postman | API endpoint testing for /guru/chat and /api/\* routes |
| XAMPP phpMyAdmin | Database integrity verification |

# **3\. Unit Test Cases**

## **3.1 Authentication Tests**

| **Test ID** | **Test Case** | **Expected Result** | **Status** |
| --- | --- | --- | --- |
| AUTH-01 | Login with valid admin credentials | Redirects to /dashboard | Pass ✅ |
| AUTH-02 | Login with invalid password | Returns validation error message | Pass ✅ |
| AUTH-03 | Access /dashboard as unauthenticated user | Redirects to /login | Pass ✅ |
| AUTH-04 | Access /admin/ads as reader role | Returns 403 Forbidden | Pass ✅ |
| AUTH-05 | Register new user account | Creates user with 'reader' role | Pass ✅ |
| AUTH-06 | Logout clears session | Redirects to homepage | Pass ✅ |

## **3.2 Article Management Tests**

| **Test ID** | **Test Case** | **Expected Result** | **Status** |
| --- | --- | --- | --- |
| ART-01 | Create article as contributor | Article saved with 'draft' status | Pass ✅ |
| ART-02 | Publish article as admin | Status changes to 'published', appears on homepage | Pass ✅ |
| ART-03 | View article increments view count | views column increments by 1 | Pass ✅ |
| ART-04 | Search by keyword returns results | Articles matching keyword displayed | Pass ✅ |
| ART-05 | Delete article as admin | Article removed from database | Pass ✅ |
| ART-06 | Tag article with multiple tags | article_tag pivot records created | Pass ✅ |
| ART-07 | Featured article appears in hero | Homepage hero section shows featured article | Pass ✅ |
| ART-08 | Breaking article appears in ticker | Breaking bar shows article headline | Pass ✅ |

## **3.3 API Widget Tests**

| **Test ID** | **Test Case** | **Expected Result** | **Status** |
| --- | --- | --- | --- |
| API-01 | Weather widget loads for Sydney | Temperature and weather icon displayed | Pass ✅ |
| API-02 | Gold price widget loads | AUD price per gram shown | Pass ✅ |
| API-03 | Currency converter NPR→AUD | Correct converted amount displayed | Pass ✅ |
| API-04 | Horoscope loads for Aries | Daily reading text displayed | Pass ✅ |
| API-05 | Nepali date widget shows BS date | Correct Bikram Sambat date shown | Pass ✅ |
| API-06 | API failure handled gracefully | Widget shows fallback message | Pass ✅ |

## **3.4 Guru AI Chatbot Tests**

| **Test ID** | **Test Case** | **Expected Result** | **Status** |
| --- | --- | --- | --- |
| GURU-01 | Open chatbot with 🧿 button | Chat window opens with greeting message | Pass ✅ |
| GURU-02 | Send 'Summarise this article' | Guru responds with article summary | Pass ✅ |
| GURU-03 | Send 'Translate hello to Nepali' | Guru responds: नमस्ते | Pass ✅ |
| GURU-04 | Send message in Nepali | Guru responds in Nepali | Pass ✅ |
| GURU-05 | Quick action buttons work | Pre-filled message sent on click | Pass ✅ |
| GURU-06 | Enter key submits message | Same as clicking send button | Pass ✅ |

## **3.5 Advertisement Tests**

| **Test ID** | **Test Case** | **Expected Result** | **Status** |
| --- | --- | --- | --- |
| AD-01 | Active ad displays on homepage | Ad image shown in sidebar_top position | Pass ✅ |
| AD-02 | Inactive ad not shown | Ad with is_active=false not rendered | Pass ✅ |
| AD-03 | Impression counter increments | impressions+1 on each page load | Pass ✅ |
| AD-04 | Click counter increments | clicks+1 on ad click via async fetch | Pass ✅ |
| AD-05 | Create new image ad | Ad saved and displayed immediately | Pass ✅ |

# **4\. Integration Tests**

| **Test ID** | **Integration Test** | **Expected Result** | **Status** |
| --- | --- | --- | --- |
| INT-01 | Homepage loads all data sources | Featured, breaking, latest, events all populated | Pass ✅ |
| INT-02 | Article page shows related content | Tags, author, sidebar widgets all load | Pass ✅ |
| INT-03 | Newsletter subscription saves to DB | Email stored in subscribers table | Pass ✅ |
| INT-04 | Language switch persists across pages | Session maintains language preference | Pass ✅ |
| INT-05 | Guru receives page context | Guru answers questions about current article | Pass ✅ |
| INT-06 | Pagination works on category page | Correct articles shown per page | Pass ✅ |

# **5\. Responsiveness Tests**

| **Viewport** | **Test** | **Result** |
| --- | --- | --- |
| 1440px (Desktop) | Full layout: sidebar visible, 3-col grid, full nav | Pass ✅ |
| 1024px (Laptop) | 2-col grid, sidebar visible, full nav | Pass ✅ |
| 768px (Tablet) | Single col, sidebar hidden, nav visible | Pass ✅ |
| 375px (Mobile) | Hamburger menu, single col, hero shows main only | Pass ✅ |
| 320px (Small mobile) | No horizontal scroll, readable text | Pass ✅ |

# **6\. Known Issues**

| **Issue ID** | **Description** | **Severity** | **Status** |
| --- | --- | --- | --- |
| BUG-01 | Render.com deployment intermittently restarts | Medium | In Progress |
| BUG-02 | Nepali date widget uses approximate BS/AD conversion | Low | Accepted |
| BUG-03 | Groq API rate limit on heavy usage | Low | Monitored |

# **7\. Test Summary**

| **Category** | **Total Tests** | **Passed** | **Failed** | **Pass Rate** |
| --- | --- | --- | --- | --- |
| Authentication | 6   | 6   | 0   | 100% |
| Article Management | 8   | 8   | 0   | 100% |
| API Widgets | 6   | 6   | 0   | 100% |
| Guru AI | 6   | 6   | 0   | 100% |
| Advertisements | 5   | 5   | 0   | 100% |
| Integration | 6   | 6   | 0   | 100% |
| Responsiveness | 5   | 5   | 0   | 100% |
| TOTAL | 42  | 42  | 0   | 100% |

# **8\. References**

Kent Beck (2002) Test Driven Development: By Example. Boston: Addison-Wesley.

PHPUnit (2024) PHPUnit Manual. Available at: https://phpunit.de/documentation.html

Sommerville, I. (2016) Software Engineering. 10th edn. Harlow: Pearson.

Laravel (2024) Testing — Laravel Documentation. Available at: https://laravel.com/docs/testing