document.addEventListener('DOMContentLoaded', function() {

    // Scroll to top
    const btn = document.getElementById('scrollTop');
    if (btn) window.addEventListener('scroll', () => btn.classList.toggle('show', window.scrollY > 400));

    // Category tab filter is handled by animations.js (smooth animated version)

    // Load widgets
    loadWeather();
    loadGold();
    loadCurrency();
    loadHoroscope('aries');
    loadNepaliDate();
});

// ── WEATHER ───────────────────────────────────────────────────
async function loadWeather() {
    const demo = {
        Sydney:    {temp:23,desc:'Partly cloudy',icon:'⛅'},
        Melbourne: {temp:17,desc:'Showers',icon:'🌧️'},
        Kathmandu: {temp:28,desc:'Sunny',icon:'☀️'},
        Brisbane:  {temp:29,desc:'Sunny',icon:'☀️'}
    };
    document.querySelectorAll('.weather-city').forEach(el => {
        const city = el.dataset.city;
        if (demo[city]) {
            el.querySelector('.weather-icon').textContent = demo[city].icon;
            el.querySelector('.weather-temp').textContent = demo[city].temp + '°C';
            el.querySelector('.weather-desc').textContent = demo[city].desc;
        }
        fetch('/api/weather?city=' + city).then(r => r.json()).then(d => {
            if (d.success && d.data) {
                el.querySelector('.weather-icon').textContent = getWeatherEmoji(d.data.icon||'');
                el.querySelector('.weather-temp').textContent = d.data.temp + '°C';
                el.querySelector('.weather-desc').textContent = d.data.desc;
            }
        }).catch(() => {});
    });
}
function getWeatherEmoji(i) {
    if (!i) return '🌤️';
    if (i.startsWith('01')) return '☀️';
    if (i.startsWith('02')) return '⛅';
    if (i.startsWith('03')||i.startsWith('04')) return '☁️';
    if (i.startsWith('09')||i.startsWith('10')) return '🌧️';
    if (i.startsWith('11')) return '⛈️';
    if (i.startsWith('13')) return '❄️';
    return '🌤️';
}

// ── GOLD ──────────────────────────────────────────────────────
async function loadGold() {
    try {
        const d = await fetch('/api/gold').then(r => r.json());
        if (d.success && d.data) {
            const fmt = v => 'A$' + Number(v).toFixed(2);
            setEl('goldOz',fmt(d.data.gold.oz)); setEl('goldGram',fmt(d.data.gold.gram)); setEl('goldTola',fmt(d.data.gold.tola));
            setEl('silvOz',fmt(d.data.silver.oz)); setEl('silvGram',fmt(d.data.silver.gram)); setEl('silvTola',fmt(d.data.silver.tola));
            setEl('goldUpdated','Updated: '+(d.data.updated_at||''));
        }
    } catch(e) {}
}

// ── CURRENCY ──────────────────────────────────────────────────
let currRate = 133.45, currDir = 'AUD_NPR';
async function loadCurrency() {
    updateCurrency();
    try {
        const d = await fetch('/api/currency').then(r => r.json());
        if (d.success && d.data) {
            currRate = d.data.rate;
            setEl('currRate','Rate: 1 AUD = '+currRate+' NPR | '+d.data.updated_at);
        }
    } catch(e) {}
    updateCurrency();
    const input = document.getElementById('currAmount');
    if (input) input.addEventListener('input', updateCurrency);
}
function updateCurrency() {
    const amt = parseFloat(document.getElementById('currAmount')?.value || 100);
    const to = currDir === 'AUD_NPR'
        ? (amt*currRate).toLocaleString('en-AU',{maximumFractionDigits:0})+' NPR 🇳🇵'
        : (amt/currRate).toFixed(2)+' AUD 🇦🇺';
    setEl('currFromLabel', currDir==='AUD_NPR'?'🇦🇺 AUD Amount':'🇳🇵 NPR Amount');
    setEl('currFrom', amt+(currDir==='AUD_NPR'?' AUD 🇦🇺':' NPR 🇳🇵'));
    setEl('currTo', to);
}
function switchCurrency() { currDir = currDir==='AUD_NPR'?'NPR_AUD':'AUD_NPR'; updateCurrency(); }

// ── HOROSCOPE ─────────────────────────────────────────────────
let currentSign = 'aries';

const ZODIAC = {
    aries:       {emoji:'♈',name:'Aries',       dates:'Mar 21 – Apr 19',stars:'★★★★☆',num:7, color:'Red',     stone:'Diamond',  element:'🔥',eName:'Fire'},
    taurus:      {emoji:'♉',name:'Taurus',       dates:'Apr 20 – May 20',stars:'★★★☆☆',num:6, color:'Green',   stone:'Emerald',  element:'🌍',eName:'Earth'},
    gemini:      {emoji:'♊',name:'Gemini',       dates:'May 21 – Jun 20',stars:'★★★★★',num:3, color:'Yellow',  stone:'Agate',    element:'💨',eName:'Air'},
    cancer:      {emoji:'♋',name:'Cancer',       dates:'Jun 21 – Jul 22',stars:'★★★☆☆',num:2, color:'Silver',  stone:'Pearl',    element:'💧',eName:'Water'},
    leo:         {emoji:'♌',name:'Leo',          dates:'Jul 23 – Aug 22',stars:'★★★★★',num:1, color:'Gold',    stone:'Ruby',     element:'🔥',eName:'Fire'},
    virgo:       {emoji:'♍',name:'Virgo',        dates:'Aug 23 – Sep 22',stars:'★★★★☆',num:5, color:'Navy',    stone:'Sapphire', element:'🌍',eName:'Earth'},
    libra:       {emoji:'♎',name:'Libra',        dates:'Sep 23 – Oct 22',stars:'★★★★☆',num:6, color:'Blue',    stone:'Opal',     element:'💨',eName:'Air'},
    scorpio:     {emoji:'♏',name:'Scorpio',      dates:'Oct 23 – Nov 21',stars:'★★★☆☆',num:9, color:'Black',   stone:'Topaz',    element:'💧',eName:'Water'},
    sagittarius: {emoji:'♐',name:'Sagittarius',  dates:'Nov 22 – Dec 21',stars:'★★★★☆',num:3, color:'Purple',  stone:'Turquoise',element:'🔥',eName:'Fire'},
    capricorn:   {emoji:'♑',name:'Capricorn',    dates:'Dec 22 – Jan 19',stars:'★★★★☆',num:8, color:'Brown',   stone:'Garnet',   element:'🌍',eName:'Earth'},
    aquarius:    {emoji:'♒',name:'Aquarius',     dates:'Jan 20 – Feb 18',stars:'★★★★★',num:4, color:'Teal',    stone:'Amethyst', element:'💨',eName:'Air'},
    pisces:      {emoji:'♓',name:'Pisces',       dates:'Feb 19 – Mar 20',stars:'★★★☆☆',num:7, color:'Sea Green',stone:'Aquamarine',element:'💧',eName:'Water'},
};

const FALLBACK = {
    aries:       'A powerful surge of energy drives you forward today. Mars, your ruling planet, amplifies your courage and determination. Take bold action on a goal you have been hesitating on — the cosmic timing is in your favour.',
    taurus:      'Venus blesses your financial affairs and personal relationships today. A patient investment of time or resources begins to show returns. Your natural appreciation for beauty leads to a moment of genuine pleasure.',
    gemini:      'Mercury sharpens your already quick mind today. Words flow effortlessly — whether in writing, conversation, or creative expression. A chance meeting sparks ideas that could reshape your path in exciting ways.',
    cancer:      'The Moon, your guardian, bathes your intuition in silver light. Trust the feelings that arise without explanation — they carry important messages. Family connections strengthen and bring comfort to the soul.',
    leo:         'The Sun, your ruler, fills you with golden confidence today. Leadership opportunities arise naturally — step forward without hesitation. Your warmth and generosity inspire loyalty from those around you.',
    virgo:       'Mercury brings analytical clarity to every challenge you face today. Details that others overlook become the key to solving a complex problem. Your methodical approach earns quiet but genuine admiration.',
    libra:       'Venus, your ruling planet, harmonises your social world beautifully today. A relationship reaches new depth and understanding. Creative endeavours flourish when pursued with your natural elegance and grace.',
    scorpio:     'Pluto deepens your perceptive powers significantly today. Hidden truths surface, giving you insights others simply cannot access. Transformation is underway — trust the process even when it feels uncomfortable.',
    sagittarius: 'Jupiter, your generous ruler, expands your horizons in surprising directions today. An unexpected opportunity for travel, learning, or philosophical discovery arrives. Your optimism is contagious and attracts good fortune.',
    capricorn:   'Saturn rewards your consistent discipline with measurable progress today. Career ambitions move forward steadily — recognition is closer than it appears. Long-term planning made now will yield significant dividends.',
    aquarius:    'Uranus sparks brilliant flashes of innovation in your mind today. A solution you have been seeking arrives in an unexpected moment of clarity. Your unique perspective is exactly what your community needs right now.',
    pisces:      'Neptune heightens your spiritual sensitivity and creative imagination today. Dreams and waking life feel beautifully interconnected. Artistic expression becomes a powerful channel for emotions that words cannot contain.',
};

async function loadHoroscope(sign) {
    currentSign = sign;

    // Update all pill buttons
    document.querySelectorAll('[id^="zpill-"]').forEach(b => {
        const isActive = b.id === 'zpill-' + sign;
        b.style.background = isActive ? 'linear-gradient(135deg,#7d3c98,#4a235a)' : 'rgba(255,255,255,0.05)';
        b.style.borderColor = isActive ? '#a569bd' : 'rgba(255,255,255,0.08)';
        b.style.boxShadow   = isActive ? '0 2px 10px rgba(125,60,152,0.5)' : 'none';
        b.style.transform   = isActive ? 'translateY(-1px)' : 'translateY(0)';
    });

    const z = ZODIAC[sign];
    if (z) {
        setEl('rashiEmoji',       z.emoji);
        setEl('rashiName',        z.name);
        setEl('rashiDates',       z.dates);
        setEl('rashiStars',       z.stars);
        setEl('rashiNum',         z.num);
        setEl('rashiColor',       z.color);
        setEl('rashiStone',       z.stone);
        setEl('rashiElement',     z.element);
        setEl('rashiElementName', z.eName);
    }

    setEl('horoscopeText', '<span style="color:rgba(255,255,255,0.35);font-size:12px;font-style:italic">✨ Reading the stars for ' + (z?.name||sign) + '...</span>');

    try {
        const d = await fetch('/api/horoscope?sign=' + sign).then(r => r.json());
        if (d.success && d.data && d.data.horoscope) {
            setEl('horoscopeText', d.data.horoscope);
        } else {
            setEl('horoscopeText', FALLBACK[sign] || 'The stars shine on you today.');
        }
    } catch(e) {
        setEl('horoscopeText', FALLBACK[sign] || 'The cosmos aligns in your favour today.');
    }
}

// ── NEPALI DATE ───────────────────────────────────────────────
async function loadNepaliDate() {
    try {
        const d = await fetch('/api/nepali-date').then(r => r.json());
        if (d.success && d.data) {
            setEl('bsYear',  d.data.bs_year);
            setEl('bsMonth', d.data.bs_month);
        }
    } catch(e) {}
}

// ── NEWSLETTER ────────────────────────────────────────────────
function submitNewsletter(e) {
    e.preventDefault();
    document.getElementById('nlForm').style.display = 'none';
    document.getElementById('nlMsg').style.display  = 'block';
}

// ── UTIL ──────────────────────────────────────────────────────
function setEl(id, html) {
    const el = document.getElementById(id);
    if (el) el.innerHTML = html;
}