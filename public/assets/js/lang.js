// Nepal News Australia — Language Switcher
// Translates key UI elements between English and Nepali

const translations = {
    ne: {
        // Navigation
        'Home':          'गृहपृष्ठ',
        'Nepal':         'नेपाल',
        'Australia':     'अष्ट्रेलिया',
        'Community':     'समुदाय',
        'Business':      'व्यापार',
        'Sports':        'खेलकुद',
        'Entertainment': 'मनोरञ्जन',
        'Opinion':       'विचार',
        'Culture':       'संस्कृति',
        'Events':        'कार्यक्रम',
        'Dashboard':     'ड्यासबोर्ड',
        '+ Write':       '+ लेख्नुहोस्',

        // Header
        'Your Bridge Between Nepal & Australia': 'नेपाल र अष्ट्रेलियाबीचको सेतु',
        'Sign In':       'साइन इन',
        'Sign Out':      'साइन आउट',

        // Top bar
        'Sydney, Australia': 'सिड्नी, अष्ट्रेलिया',

        // Breaking
        'Breaking': 'ब्रेकिङ',

        // Sections
        'Latest News':          'ताजा समाचार',
        'Nepal News':           'नेपाल समाचार',
        'Australia News':       'अष्ट्रेलिया समाचार',
        'Opinion & Analysis':   'विचार र विश्लेषण',
        'Community Events':     'सामुदायिक कार्यक्रमहरू',
        'See All →':            'सबै हेर्नुहोस् →',
        'More →':               'थप →',
        'Full Calendar →':      'पूरा क्यालेन्डर →',

        // Category tabs
        'All':  'सबै',

        // Sidebar
        'Trending Now':           'ट्रेन्डिङ',
        'Daily Newsletter':       'दैनिक न्यूजलेटर',
        'Live Weather':           'लाइभ मौसम',
        'Live Gold & Silver (AUD)': 'लाइभ सुन र चाँदी (AUD)',
        'NPR ↔ AUD':              'NPR ↔ AUD',
        'Rashifal — Daily Horoscope': 'राशिफल — दैनिक',
        'Today\'s Date':          'आजको मिति',
        'Follow Us':              'फलो गर्नुहोस्',

        // Weather
        'Loading...':  'लोड हुँदैछ...',
        'Powered by OpenWeatherMap': 'OpenWeatherMap द्वारा',

        // Newsletter
        'Get top Nepal-Australia news in your inbox daily. Join 18,000+ subscribers.':
            'दैनिक शीर्ष नेपाल-अष्ट्रेलिया समाचार पाउनुहोस्। १८,०००+ सदस्यहरूसँग जोडिनुहोस्।',
        'Subscribe Free': 'नि:शुल्क सदस्यता',
        'Your email address': 'तपाईंको इमेल ठेगाना',

        // Currency
        '🇦🇺 AUD Amount': '🇦🇺 AUD रकम',
        '⇅ Switch Direction': '⇅ दिशा बदल्नुहोस्',

        // Footer
        'Australia\'s leading Nepali news platform serving the diaspora across Sydney, Melbourne, Brisbane, Perth and Adelaide.':
            'सिड्नी, मेलबर्न, ब्रिस्बेन, पर्थ र एडिलेडमा नेपाली प्रवासीहरूको लागि अष्ट्रेलियाको प्रमुख नेपाली समाचार मञ्च।',
        'Sections':  'विभागहरू',
        'Services':  'सेवाहरू',
        'Company':   'कम्पनी',
        'Community Events': 'सामुदायिक कार्यक्रम',
        'Newsletter': 'न्यूजलेटर',
        'Advertise':  'विज्ञापन',
        'Submit Story': 'समाचार पठाउनुहोस्',
        'About Us':   'हाम्रोबारे',
        'Contact':    'सम्पर्क',
        'Privacy Policy': 'गोपनीयता नीति',
        'Terms of Use':   'प्रयोग सर्तहरू',

        // Event
        'Free': 'नि:शुल्क',

        // Article
        'Related Articles': 'सम्बन्धित समाचार',
        'Share:': 'सेयर:',
        'Tags:':  'ट्यागहरू:',
        'views':  'पटक हेरियो',
        'min read': 'मिनेट पठन',

        // Search
        'Search news, articles...': 'समाचार खोज्नुहोस्...',

        // Days / months in Nepali
        'Monday':    'सोमवार',
        'Tuesday':   'मंगलवार',
        'Wednesday': 'बुधवार',
        'Thursday':  'बिहीवार',
        'Friday':    'शुक्रवार',
        'Saturday':  'शनिवार',
        'Sunday':    'आइतवार',
    }
};

let currentLang = localStorage.getItem('nna_lang') || 'en';

function initLanguage() {
    updateLangButtons();
    if (currentLang === 'ne') applyNepali();
}

function switchLang(lang) {
    currentLang = lang;
    localStorage.setItem('nna_lang', lang);
    updateLangButtons();
    if (lang === 'ne') {
        applyNepali();
    } else {
        location.reload(); // Reload to restore English
    }
}

function updateLangButtons() {
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.lang === currentLang);
    });
}

function applyNepali() {
    const t = translations.ne;

    // Translate all text nodes matching our dictionary
    translateElements(t);

    // Add Nepali font style
    document.body.style.fontFamily = "'Noto Sans Devanagari', 'Mukta', Arial, sans-serif";

    // Translate nav links specifically
    document.querySelectorAll('.nav-inner a').forEach(a => {
        const txt = a.textContent.trim();
        if (t[txt]) a.textContent = t[txt];
    });

    // Translate section titles
    document.querySelectorAll('.section-title').forEach(el => {
        const txt = el.textContent.trim();
        if (t[txt]) el.textContent = t[txt];
    });

    // Translate widget heads
    document.querySelectorAll('.widget-head').forEach(el => {
        const txt = el.textContent.trim();
        if (t[txt]) el.textContent = t[txt];
    });

    // Translate footer headings
    document.querySelectorAll('.footer-col h4').forEach(el => {
        const txt = el.textContent.trim();
        if (t[txt]) el.textContent = t[txt];
    });

    // Translate buttons
    document.querySelectorAll('button, .btn-primary, .btn-secondary').forEach(el => {
        const txt = el.textContent.trim();
        if (t[txt]) el.textContent = t[txt];
    });

    // Translate placeholder text
    const searchInput = document.querySelector('.header-search input');
    if (searchInput) searchInput.placeholder = t['Search news, articles...'] || searchInput.placeholder;

    const nlInput = document.getElementById('nlEmail');
    if (nlInput) nlInput.placeholder = t['Your email address'] || nlInput.placeholder;

    // Translate see-all links
    document.querySelectorAll('.see-all').forEach(el => {
        const txt = el.textContent.trim();
        if (t[txt]) el.textContent = t[txt];
    });

    // Translate logo subtitle
    const logoSub = document.querySelector('.logo-text p');
    if (logoSub && t[logoSub.textContent.trim()]) {
        logoSub.textContent = t[logoSub.textContent.trim()];
    }

    // Translate footer brand text
    const brandP = document.querySelector('.footer-brand p');
    if (brandP && t[brandP.textContent.trim()]) {
        brandP.textContent = t[brandP.textContent.trim()];
    }

    // Translate cat tabs
    document.querySelectorAll('.cat-tab').forEach(el => {
        const txt = el.textContent.trim();
        if (t[txt]) el.textContent = t[txt];
    });

    // Convert date in top bar to Nepali numerals
    const topDate = document.querySelector('.top-left span:first-child');
    if (topDate) {
        const now = new Date();
        const nepaliDays = ['आइतवार','सोमवार','मंगलवार','बुधवार','बिहीवार','शुक्रवार','शनिवार'];
        const nepaliMonths = ['जनवरी','फेब्रुअरी','मार्च','अप्रिल','मे','जुन','जुलाई','अगस्ट','सेप्टेम्बर','अक्टोबर','नोभेम्बर','डिसेम्बर'];
        topDate.textContent = '📅 ' + nepaliDays[now.getDay()] + ', ' + toNepaliNumerals(now.getDate()) + ' ' + nepaliMonths[now.getMonth()] + ' ' + toNepaliNumerals(now.getFullYear());
    }

    const topCity = document.querySelector('.top-left span:last-child');
    if (topCity) topCity.textContent = '📍 ' + (t['Sydney, Australia'] || 'सिड्नी, अष्ट्रेलिया');
}

function translateElements(t) {
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
    const nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);
    nodes.forEach(node => {
        const trimmed = node.textContent.trim();
        if (t[trimmed] && node.parentElement && !['SCRIPT','STYLE','INPUT','TEXTAREA'].includes(node.parentElement.tagName)) {
            node.textContent = node.textContent.replace(trimmed, t[trimmed]);
        }
    });
}

function toNepaliNumerals(num) {
    const nepali = ['०','१','२','३','४','५','६','७','८','९'];
    return String(num).split('').map(d => /\d/.test(d) ? nepali[parseInt(d)] : d).join('');
}

// Load Noto Sans Devanagari font for Nepali
function loadNepaliFont() {
    if (!document.getElementById('nepali-font')) {
        const link = document.createElement('link');
        link.id   = 'nepali-font';
        link.rel  = 'stylesheet';
        link.href = 'https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600;700&display=swap';
        document.head.appendChild(link);
    }
}

// Init on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    loadNepaliFont();

    // Wire up language buttons
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchLang(this.dataset.lang);
        });
    });

    initLanguage();
});
