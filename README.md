# PM Internship Scheme — AI Recommendation Website

## 📁 File Structure
```
/project
  index.html         ← Home page with Get Started button
  login.html         ← Login / Register page
  form.html          ← User profile form (skills, education, location)
  result.html        ← AI Recommendations (pure HTML/JS, works without PHP)
  result.php         ← AI Recommendations (PHP version, requires XAMPP)
  process.php        ← PHP backend: stores data + API fetch + AI scoring
  style.css          ← Shared stylesheet
  internships.json   ← Fallback internship database (15 companies)
  data.json          ← Auto-created: stores all user form submissions
  recommendations.json ← Auto-created: stores recommendation logs
```

## 🚀 Quick Start (Without PHP - Instant)

Open `index.html` directly in any browser:
1. Click **Get Started** → goes to `login.html`
2. Use **Demo Login** (no registration needed)
3. Fill out the form at `form.html`
4. AI recommendations appear at `result.html`

✅ **This works with just a browser — no server needed!**

---

## 🖥️ Full PHP Backend Setup (XAMPP)

### Step 1: Install XAMPP
Download from: https://www.apachefriends.org/

### Step 2: Place Project Files
Copy the entire `/project` folder to:
```
C:\xampp\htdocs\project\    (Windows)
/opt/lampp/htdocs/project/  (Linux/Mac)
```

### Step 3: Set File Permissions (Linux/Mac only)
```bash
chmod 777 /opt/lampp/htdocs/project/data.json
chmod 777 /opt/lampp/htdocs/project/
```

### Step 4: Start Apache
- Open XAMPP Control Panel
- Click **Start** next to Apache

### Step 5: Open in Browser
```
http://localhost/project/index.html
```

### Step 6: Update form.html for PHP (optional)
In `form.html`, the form action is `result.html` by default (JS mode).
To use PHP backend, change:
```html
<form id="internship-form" method="POST" action="process.php">
```
And remove the JavaScript submit handler `e.preventDefault()` block.

---

## 🔑 Real-Time API Setup (Adzuna)

### Get Free API Key
1. Go to: https://developer.adzuna.com/
2. Register (free) → get App ID and API Key
3. Open `process.php` and replace:
```php
$APP_ID  = 'YOUR_ADZUNA_APP_ID';
$APP_KEY = 'YOUR_ADZUNA_API_KEY';
```

### Alternative APIs
- **Internshala**: https://internshala.com/api (request access)
- **Indeed API**: https://www.indeed.com/publisher
- **RapidAPI Jobs**: https://rapidapi.com/search/jobs

---

## 🤖 AI Scoring Algorithm

```
Score = Skills Match (+2 each, max +10)
      + Interest/Sector Match (+2)
      + City Match (+1)
      + State Match (+1)
      + Remote Preference Bonus (+1)
      + Relocation Willing (+0.5)

Maximum possible score = 15
Top 5 results displayed, sorted by score
```

---

## 🗄️ Data Storage

User submissions saved to `data.json`:
```json
[
  {
    "id": "user_abc123",
    "timestamp": "2025-01-15 14:30:00",
    "name": "Rahul Sharma",
    "skills": ["Python", "Machine Learning"],
    "interest": "Data Science & AI",
    "city": "Bengaluru",
    "state": "Karnataka",
    ...
  }
]
```

---

## 📱 Mobile-Friendly Features
- Responsive grid layouts (CSS Grid + flexbox)
- Large touch targets (min 50px height buttons)
- Simple checkbox skills selector
- Minimal text, icon-heavy UI
- Works on 320px screens

---

## 🔒 Security Notes
- All user input sanitized with `htmlspecialchars()` in PHP
- POST-only endpoint (process.php rejects GET)
- File writes use `LOCK_EX` flag
- Session-based data passing (no URL parameters)
- No eval() or raw SQL used

---

## 📞 Support
PM Internship Scheme | Government of India
Website: https://pminternship.mca.gov.in/
