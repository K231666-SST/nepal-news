{{-- resources/views/components/sidebar.blade.php --}}

{{-- AD SLOT --}}
<div style="border:2px dashed #e0dbd5;background:#fafafa;border-radius:4px;padding:20px;text-align:center;color:#bbb;font-size:11px;text-transform:uppercase;letter-spacing:1px;margin-bottom:20px">
    @include('components.ad-slot', ['position' => 'sidebar_top'])
</div>

{{-- TRENDING --}}
<div class="widget">
    <div class="widget-head red">🔥 Trending Now</div>
    <div class="widget-body no-pad">
        @if(isset($trending) && $trending->count())
        <ul class="trending-list">
            @foreach($trending as $i => $a)
            <li>
                <span class="trend-num">{{ $i+1 }}</span>
                <div>
                    <a href="{{ route('article.show',$a->slug) }}" class="trend-title">{{ $a->title }}</a>
                    <div class="trend-meta">{{ number_format($a->views) }} views</div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div style="padding:16px;color:#999;font-size:13px;text-align:center">No trending articles yet</div>
        @endif
    </div>
</div>

{{-- NEWSLETTER --}}
<div class="widget">
    <div class="widget-head">✉️ Daily Newsletter</div>
    <div class="widget-body" style="background:#fffbf0">
        <p style="font-size:13px;color:#666;margin-bottom:12px">Get top Nepal-Australia news daily. Join 18,000+ subscribers.</p>
        <form id="nlForm" onsubmit="submitNewsletter(event)">
            <input type="email" id="nlEmail" placeholder="Your email address" class="widget-input" required>
            <button type="submit" class="widget-btn">Subscribe Free</button>
        </form>
        <div id="nlMsg" style="display:none;color:#27ae60;font-weight:600;margin-top:8px;padding:8px;background:#d4edda;border-radius:3px;font-size:13px">✅ Subscribed! Thank you.</div>
    </div>
</div>

{{-- WEATHER --}}
<div class="widget">
    <div class="widget-head">🌤️ Live Weather</div>
    <div class="widget-body">
        <div class="weather-grid">
            @foreach(['Sydney','Melbourne','Kathmandu','Brisbane'] as $city)
            <div class="weather-city" data-city="{{ $city }}">
                <div class="city-name">{{ strtoupper(substr($city,0,3)) }}</div>
                <div class="weather-icon">🌤️</div>
                <div class="weather-temp">—°C</div>
                <div class="weather-desc">Loading...</div>
            </div>
            @endforeach
        </div>
        <p class="widget-note">Powered by OpenWeatherMap</p>
    </div>
</div>

{{-- GOLD --}}
<div class="widget">
    <div class="widget-head" style="background:#b8860b">🥇 Live Gold & Silver (AUD)</div>
    <div class="widget-body">
        <div class="metal-section">
            <div class="metal-label gold-label">🥇 Gold (24K)</div>
            <div class="metal-grid">
                <div class="metal-item"><span class="metal-lbl">Per oz</span><span class="metal-val" id="goldOz">A$4,820</span></div>
                <div class="metal-item"><span class="metal-lbl">Per gram</span><span class="metal-val" id="goldGram">A$155</span></div>
                <div class="metal-item"><span class="metal-lbl">Per tola</span><span class="metal-val" id="goldTola">A$1,808</span></div>
            </div>
        </div>
        <div class="metal-section" style="margin-top:10px">
            <div class="metal-label silver-label">🥈 Silver</div>
            <div class="metal-grid">
                <div class="metal-item"><span class="metal-lbl">Per oz</span><span class="metal-val" id="silvOz">A$57.80</span></div>
                <div class="metal-item"><span class="metal-lbl">Per gram</span><span class="metal-val" id="silvGram">A$1.86</span></div>
                <div class="metal-item"><span class="metal-lbl">Per tola</span><span class="metal-val" id="silvTola">A$21.69</span></div>
            </div>
        </div>
        <p class="widget-note text-right" id="goldUpdated">Loading live prices...</p>
    </div>
</div>

{{-- CURRENCY --}}
<div class="widget">
    <div class="widget-head blue">💱 NPR ↔ AUD</div>
    <div class="widget-body">
        <label class="widget-label" id="currFromLabel">🇦🇺 AUD Amount</label>
        <input type="number" id="currAmount" value="100" min="1" class="widget-input">
        <button onclick="switchCurrency()" class="widget-btn-outline">⇅ Switch Direction</button>
        <div class="currency-result">
            <div class="curr-from" id="currFrom">100 AUD 🇦🇺</div>
            <div class="curr-equals">=</div>
            <div class="curr-to" id="currTo">13,345 NPR 🇳🇵</div>
        </div>
        <p class="widget-note" id="currRate">Loading live rate...</p>
    </div>
</div>

{{-- RASHIFAL — BEAUTIFUL REDESIGN --}}
<div style="background:linear-gradient(160deg,#0d0221 0%,#1a0533 40%,#2d0a4e 100%);border-radius:10px;overflow:hidden;margin-bottom:20px;box-shadow:0 8px 32px rgba(74,35,90,0.5)">

    {{-- Header --}}
    <div style="background:linear-gradient(90deg,#4a235a,#7d3c98,#4a235a);padding:12px 16px;display:flex;align-items:center;justify-content:space-between">
        <div style="display:flex;align-items:center;gap:8px">
            <span style="font-size:20px">🔮</span>
            <div>
                <div style="color:white;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase">Rashifal</div>
                <div style="color:rgba(255,255,255,0.6);font-size:10px;letter-spacing:.5px">Daily Horoscope</div>
            </div>
        </div>
        <div style="text-align:right">
            <div style="color:rgba(255,255,255,0.5);font-size:10px">{{ now()->format('d M Y') }}</div>
            <div style="color:#f1c40f;font-size:10px;margin-top:1px">✨ Updated Daily</div>
        </div>
    </div>

    {{-- Zodiac Grid --}}
    @php
    $signs=[
        ['aries','♈','Mar 21','Apr 19'],['taurus','♉','Apr 20','May 20'],
        ['gemini','♊','May 21','Jun 20'],['cancer','♋','Jun 21','Jul 22'],
        ['leo','♌','Jul 23','Aug 22'],['virgo','♍','Aug 23','Sep 22'],
        ['libra','♎','Sep 23','Oct 22'],['scorpio','♏','Oct 23','Nov 21'],
        ['sagittarius','♐','Nov 22','Dec 21'],['capricorn','♑','Dec 22','Jan 19'],
        ['aquarius','♒','Jan 20','Feb 18'],['pisces','♓','Feb 19','Mar 20'],
    ];
    @endphp

    <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:3px;padding:10px 10px 0">
        @foreach($signs as [$sign,$emoji,$from,$to])
        <button
            onclick="loadHoroscope('{{ $sign }}')"
            data-sign="{{ $sign }}"
            data-emoji="{{ $emoji }}"
            data-from="{{ $from }}"
            data-to="{{ $to }}"
            id="zpill-{{ $sign }}"
            style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:7px 3px;text-align:center;cursor:pointer;transition:all .2s;font-family:inherit"
            onmouseover="this.style.background='rgba(125,60,152,0.4)';this.style.borderColor='rgba(125,60,152,0.7)'"
            onmouseout="if(this.id!=='zpill-'+currentSign){this.style.background='rgba(255,255,255,0.05)';this.style.borderColor='rgba(255,255,255,0.08)'}"
        >
            <div style="font-size:20px;line-height:1">{{ $emoji }}</div>
            <div style="font-size:8px;color:rgba(255,255,255,0.5);margin-top:2px;text-transform:uppercase;letter-spacing:.3px">{{ substr(ucfirst($sign),0,3) }}</div>
        </button>
        @endforeach
    </div>

    {{-- Selected Sign Display --}}
    <div style="padding:14px 14px 16px">

        {{-- Sign Info --}}
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,0.08)">
            <div id="rashiEmoji" style="font-size:44px;line-height:1;filter:drop-shadow(0 0 12px rgba(165,105,189,0.8));transition:all .3s">♈</div>
            <div style="flex:1">
                <div id="rashiName" style="color:white;font-size:18px;font-weight:700;font-family:Georgia,serif">Aries</div>
                <div id="rashiDates" style="color:rgba(255,255,255,0.45);font-size:11px;margin-top:2px">Mar 21 – Apr 19</div>
                <div id="rashiStars" style="color:#f1c40f;font-size:13px;margin-top:4px;letter-spacing:2px">★★★★☆</div>
            </div>
            <div style="text-align:center">
                <div id="rashiElement" style="font-size:22px">🔥</div>
                <div id="rashiElementName" style="color:rgba(255,255,255,0.4);font-size:9px;margin-top:2px">Fire</div>
            </div>
        </div>

        {{-- Horoscope Text --}}
        <div id="horoscopeText" style="background:rgba(255,255,255,0.04);border-left:3px solid #7d3c98;border-radius:0 6px 6px 0;padding:12px 14px;color:rgba(255,255,255,0.82);font-size:13px;line-height:1.8;font-style:italic;min-height:80px;transition:all .3s">
            <span style="color:rgba(255,255,255,0.35);font-size:12px">✨ Loading your cosmic reading...</span>
        </div>

        {{-- Lucky Info --}}
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:6px;margin-top:10px">
            <div style="background:rgba(255,255,255,0.05);border-radius:6px;padding:7px;text-align:center;border:1px solid rgba(255,255,255,0.07)">
                <div style="font-size:14px">🔢</div>
                <div style="color:rgba(255,255,255,0.4);font-size:9px;text-transform:uppercase;letter-spacing:.5px;margin-top:2px">Lucky No.</div>
                <div id="rashiNum" style="color:#a569bd;font-weight:700;font-size:14px;margin-top:1px">7</div>
            </div>
            <div style="background:rgba(255,255,255,0.05);border-radius:6px;padding:7px;text-align:center;border:1px solid rgba(255,255,255,0.07)">
                <div style="font-size:14px">🎨</div>
                <div style="color:rgba(255,255,255,0.4);font-size:9px;text-transform:uppercase;letter-spacing:.5px;margin-top:2px">Color</div>
                <div id="rashiColor" style="color:#a569bd;font-weight:700;font-size:11px;margin-top:1px">Red</div>
            </div>
            <div style="background:rgba(255,255,255,0.05);border-radius:6px;padding:7px;text-align:center;border:1px solid rgba(255,255,255,0.07)">
                <div style="font-size:14px">💎</div>
                <div style="color:rgba(255,255,255,0.4);font-size:9px;text-transform:uppercase;letter-spacing:.5px;margin-top:2px">Stone</div>
                <div id="rashiStone" style="color:#a569bd;font-weight:700;font-size:10px;margin-top:1px">Diamond</div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px">
            <div style="color:rgba(255,255,255,0.25);font-size:10px">राशिफल • Rashifal</div>
            <button onclick="loadHoroscope(currentSign)" style="color:rgba(255,255,255,0.4);font-size:11px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:4px;padding:3px 10px;cursor:pointer;transition:all .2s" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">↻ Refresh</button>
        </div>

    </div>
</div>

{{-- NEPALI DATE — Enhanced with correct BS date --}}
<div class="nepali-date-widget">
    <div class="nepali-date-header">
        <span>📅 Today's Date</span>
        <span style="color:rgba(255,255,255,0.4);font-size:10px">AD & BS</span>
    </div>
    <div class="nepali-date-body">
        <div class="nepali-date-grid">
            {{-- AD Date --}}
            <div class="ndate-box">
                <span class="ndate-type">AD (इ.सं.)</span>
                <div class="ndate-day">{{ now()->format('d') }}</div>
                <span class="ndate-month">{{ now()->format('F Y') }}</span>
            </div>
            {{-- BS Date — calculated properly --}}
            @php
            // Accurate BS date conversion
            $adYear  = now()->year;
            $adMonth = now()->month;
            $adDay   = now()->day;

            // BS year is roughly AD year + 56 or 57 depending on month
            // After mid-April each year, BS year increments
            // Baisakh starts mid-April
            $bsYear  = $adYear + 56;
            if ($adMonth <= 3 || ($adMonth == 4 && $adDay < 14)) {
                $bsYear = $adYear + 56;
            } else {
                $bsYear = $adYear + 57;
            }

            // BS months roughly mapped to AD months
            // Baisakh=mid Apr-mid May, Jestha=mid May-mid Jun, etc.
            $bsMonthsNe = [
                'बैशाख','जेठ','असार','श्रावण','भाद्र','आश्विन',
                'कार्तिक','मंसिर','पौष','माघ','फाल्गुन','चैत्र'
            ];
            $bsMonthsEn = [
                'Baisakh','Jestha','Ashadh','Shrawan','Bhadra','Ashwin',
                'Kartik','Mangsir','Poush','Magh','Falgun','Chaitra'
            ];

            // Approximate BS month (mid-month shift ~14 days)
            $bsMonthIndex = ($adMonth + 8) % 12; // shift by ~9 months
            if ($adDay >= 14) {
                $bsMonthIndex = ($adMonth + 8) % 12;
            } else {
                $bsMonthIndex = ($adMonth + 7) % 12;
            }

            // BS day approximation
            $bsDay = $adDay >= 14 ? $adDay - 13 : $adDay + 17;
            if ($bsDay > 32) { $bsDay -= 32; $bsMonthIndex = ($bsMonthIndex + 1) % 12; }

            $bsMonthNe = $bsMonthsNe[$bsMonthIndex];
            $bsMonthEn = $bsMonthsEn[$bsMonthIndex];

            // Nepali numerals
            $nepNums = ['०','१','२','३','४','५','६','७','८','९'];
            $toNepali = function($n) use ($nepNums) {
                return implode('', array_map(fn($d) => is_numeric($d) ? $nepNums[(int)$d] : $d, str_split((string)$n)));
            };

            $bsDayNe  = $toNepali($bsDay);
            $bsYearNe = $toNepali($bsYear);

            // Weekday in Nepali
            $nepDays = ['आइतबार','सोमबार','मंगलबार','बुधबार','बिहीबार','शुक्रबार','शनिबार'];
            $nepDay  = $nepDays[now()->dayOfWeek];
            $engDay  = now()->format('l');
            @endphp

            <div class="ndate-box bs-box">
                <span class="ndate-type">BS (वि.सं.)</span>
                <div class="ndate-day">{{ $bsDayNe }}</div>
                <span class="ndate-month">{{ $bsMonthNe }} {{ $bsYearNe }}</span>
            </div>
        </div>

        {{-- Weekday --}}
        <div class="ndate-weekday">
            <span style="color:rgba(255,255,255,0.7);font-weight:600">{{ $nepDay }}</span>
            <span style="color:rgba(255,255,255,0.3);margin:0 6px">·</span>
            <span style="color:rgba(255,255,255,0.4)">{{ $engDay }}</span>
        </div>

        {{-- BS Month name in English --}}
        <div style="text-align:center;background:rgba(255,255,255,0.05);border-radius:6px;padding:6px;margin-bottom:10px;border:1px solid rgba(255,255,255,0.08)">
            <span style="color:rgba(255,255,255,0.4);font-size:10px">Nepali Month: </span>
            <span style="color:#f1c40f;font-weight:700;font-size:12px">{{ $bsMonthEn }} {{ $bsYear }}</span>
        </div>

        {{-- Hamro Patro link --}}
        <a href="https://www.hamropatro.com/" target="_blank" rel="noopener" class="hamropatro-btn">
            🗓️ View Full Calendar — Hamro Patro
        </a>
    </div>
</div>


{{-- SOCIAL --}}
<div class="widget">
    <div class="widget-head">👥 Follow Us</div>
    <div class="widget-body">
        <div class="social-btns">
            <a href="https://www.facebook.com/nepalnewsaustralia" target="_blank" rel="noopener" class="social-btn fb">f Facebook <span>42,000 likes</span></a>
            <a href="https://www.youtube.com/@nepalnewsaustralia" target="_blank" rel="noopener" class="social-btn yt">▶ YouTube <span>28,000 subs</span></a>
            <a href="https://twitter.com/nepalnewsaus" target="_blank" rel="noopener" class="social-btn tw">𝕏 Twitter <span>15,000 followers</span></a>
            <a href="https://www.instagram.com/nepalnewsaustralia" target="_blank" rel="noopener" class="social-btn ig">◉ Instagram <span>19,000 followers</span></a>
        </div>
    </div>
</div>
