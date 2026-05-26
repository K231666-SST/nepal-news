<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Advertisement;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── CREATE USERS ─────────────────────────────────────
        $admin = User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@nepalnews.com.au',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'bio'       => 'Platform administrator for Nepal News Australia.',
            'is_active' => true,
        ]);

        $editor = User::create([
            'name'      => 'Bikash Thapa',
            'email'     => 'editor@nepalnews.com.au',
            'password'  => Hash::make('editor123'),
            'role'      => 'editor',
            'bio'       => 'Senior editor covering Nepal politics and Australia affairs.',
            'is_active' => true,
        ]);

        $contributor = User::create([
            'name'      => 'Priya Adhikari',
            'email'     => 'contributor@nepalnews.com.au',
            'password'  => Hash::make('contributor123'),
            'role'      => 'contributor',
            'bio'       => 'Community reporter based in Melbourne.',
            'is_active' => true,
        ]);

        $reader = User::create([
            'name'      => 'Rajan Sharma',
            'email'     => 'reader@nepalnews.com.au',
            'password'  => Hash::make('reader123'),
            'role'      => 'reader',
            'bio'       => 'Regular reader from Sydney.',
            'is_active' => true,
        ]);

        $contributor2 = User::create([
            'name'      => 'Suman Gurung',
            'email'     => 'suman@nepalnews.com.au',
            'password'  => Hash::make('suman123'),
            'role'      => 'contributor',
            'bio'       => 'Sports journalist and community organiser based in Brisbane.',
            'is_active' => true,
        ]);

        // ── CREATE TAGS ──────────────────────────────────────
        $tagData = [
            'Nepal', 'Australia', 'Education', 'Migration', 'Community',
            'Business', 'Sports', 'Culture', 'Politics', 'Economy',
            'Cricket', 'Sydney', 'Melbourne', 'Brisbane', 'Festival',
            'Visa', 'Health', 'Technology', 'Climate', 'Dashain',
            'Perth', 'Adelaide', 'Canberra', 'Tourism', 'Food',
            'Women', 'Youth', 'Scholarship', 'Remittance', 'Himalaya',
            'Kathmandu', 'Arts', 'Music', 'Religion', 'Environment',
        ];
        $tags = [];
        foreach ($tagData as $name) {
            $tags[$name] = Tag::create(['name' => $name, 'slug' => Str::slug($name)]);
        }

        // ── CREATE ARTICLES ──────────────────────────────────
        // Pexels CDN images: free to embed, no key needed for display
        $articles = [

            // ─── ARTICLE 1 ───────────────────────────────────
            [
                'title'          => 'Nepal and Australia Sign Historic Education Partnership Worth $500 Million',
                'summary'        => 'Prime ministers of both nations gathered in Canberra to finalise a landmark deal covering universities, scholarships, and research collaboration.',
                'content'        => '<p>In a historic summit held at Parliament House in Canberra, the Prime Ministers of Nepal and Australia signed a comprehensive education partnership agreement worth $500 million, marking a new era in bilateral relations between the two nations.</p><p>The agreement covers a wide range of areas including university partnerships, scholarship programs, and joint research initiatives. Under the deal, over 5,000 Nepali students will receive full scholarships to study at Australian universities over the next decade.</p><p>Speaking at the signing ceremony, the Australian Prime Minister emphasised the importance of people-to-people connections between the two countries. "This partnership is not just about education — it is about building bridges between our communities and investing in the future leaders of both nations," he said.</p><p>The Nepali Prime Minister welcomed the agreement, noting that it would help address the brain drain issue Nepal has been facing for decades. "Our talented young people will now have the opportunity to receive world-class education and return home with the skills to transform Nepal," he said.</p><p>The partnership also includes provisions for joint research in areas such as clean energy, sustainable agriculture, and disaster management — all critical priorities for Nepal given its vulnerability to natural disasters and climate change.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/995765/pexels-photo-995765.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => true,
                'is_breaking'    => true,
                'views'          => 4821,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Australia', 'Education', 'Scholarship'],
                'published_at'   => now()->subHours(2),
            ],

            // ─── ARTICLE 2 ───────────────────────────────────
            [
                'title'          => "Nepal's GDP Growth Hits 6.8 Percent — Highest in a Decade",
                'summary'        => 'The International Monetary Fund credits remittances from abroad and the growing IT sector as key drivers of Nepal\'s economic resurgence.',
                'content'        => '<p>The International Monetary Fund has confirmed that Nepal achieved 6.8% GDP growth in the 2025-26 fiscal year, the highest recorded growth rate in a decade. The achievement comes despite global economic headwinds and marks a significant milestone in Nepal\'s post-pandemic recovery.</p><p>Remittances from Nepalese workers abroad, which account for approximately 26% of the national GDP, continued to be the primary driver of economic growth. Australia emerged as one of the top five source countries for remittances, reflecting the growing Nepali diaspora in cities like Sydney, Melbourne, and Brisbane.</p><p>The IT sector has also emerged as a significant contributor, with exports of software services growing by 45% year-on-year. Several Nepali tech startups have secured international contracts, and the government\'s IT park initiative in Kathmandu has attracted over 200 companies.</p><p>Tourism, which had been severely impacted by the COVID-19 pandemic, also showed strong recovery with over 1.2 million international visitors in 2025-26, surpassing pre-pandemic levels for the first time.</p>',
                'category'       => 'nepal',
                'featured_image' => 'https://images.pexels.com/photos/3889742/pexels-photo-3889742.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => true,
                'is_breaking'    => false,
                'views'          => 3267,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Economy', 'Remittance', 'Technology'],
                'published_at'   => now()->subHours(5),
            ],

            // ─── ARTICLE 3 ───────────────────────────────────
            [
                'title'          => 'Sydney Welcomes Record 12,000 Nepali Migrants in First Quarter of 2026',
                'summary'        => 'New immigration data reveals unprecedented growth in the Nepali-Australian population, driven by skilled worker visas and family reunification programs.',
                'content'        => '<p>New data released by the Australian Bureau of Statistics reveals that over 12,000 Nepalese-born migrants settled in Sydney during the first quarter of 2026 alone, making it the highest quarterly migration figure on record from Nepal to Australia.</p><p>The surge is primarily driven by the skilled worker visa program, with nursing, aged care, IT, and construction emerging as the top occupational categories. The federal government\'s regional migration incentives have also encouraged a significant number of Nepali migrants to settle in outer Sydney suburbs and regional New South Wales.</p><p>The Nepalese-Australian community now numbers over 130,000 across the country, with Sydney (42%), Melbourne (31%), Brisbane (12%), Perth (8%), and Adelaide (7%) being the primary settlement cities.</p><p>Community organisations such as the Non-Resident Nepali Association of Australia (NRNA Australia) have welcomed the growth but called for better support services for new arrivals. "We need more Nepali-speaking settlement workers, legal aid services, and mental health support," said NRNA Australia president.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/2193300/pexels-photo-2193300.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 2914,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Australia', 'Migration', 'Sydney'],
                'published_at'   => now()->subHours(8),
            ],

            // ─── ARTICLE 4 ───────────────────────────────────
            [
                'title'          => 'Melbourne Nepali Community Hosts Largest Ever Dashain Festival',
                'summary'        => 'Over 5,000 community members attended the two-day celebration at Federation Square, featuring cultural performances, traditional food, and Tika ceremonies.',
                'content'        => '<p>Melbourne\'s vibrant Nepali community came together in record numbers for the annual Dashain festival at Federation Square, with over 5,000 attendees over two days making it the largest Dashain celebration in Australian history.</p><p>The event, organised by the Nepalese Community of Victoria (NCV), featured traditional cultural performances including dance, music, and theatrical presentations showcasing Nepal\'s rich cultural heritage. A dedicated food court offered authentic Nepali cuisine including sel roti, momo, dhido, and gundruk.</p><p>The highlight of the festival was the traditional Tika ceremony on the tenth day of Dashain, where elders blessed younger family and community members with a mixture of yogurt, rice, and red tika powder while offering them jamara (sacred barley grass).</p><p>"Dashain is more than just a festival — it is a reminder of who we are and where we come from. Celebrating it here in Melbourne, thousands of kilometres from home, makes it even more meaningful," said festival director Sunita Karmacharya.</p><p>The festival also featured a marketplace with Nepali handicrafts, artwork, and cultural products, providing a platform for Nepali artisans and small businesses in the community.</p>',
                'category'       => 'community',
                'featured_image' => 'https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => true,
                'is_breaking'    => false,
                'views'          => 5102,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Community', 'Dashain', 'Melbourne', 'Festival', 'Culture'],
                'published_at'   => now()->subDay(),
            ],

            // ─── ARTICLE 5 ───────────────────────────────────
            [
                'title'          => 'Nepali Cricket Team Qualifies for 2027 ODI World Cup',
                'summary'        => 'Nepal secured their spot in the 2027 ICC Cricket World Cup after a thrilling five-wicket victory over the UAE in the qualification tournament in Namibia.',
                'content'        => '<p>Nepal\'s national cricket team has made history by qualifying for the 2027 ICC Cricket World Cup, their first-ever appearance at the sport\'s premier 50-over tournament. The team secured their spot with a thrilling five-wicket victory over the United Arab Emirates in the final qualifying match played in Windhoek, Namibia.</p><p>Captain Rohit Paudel, who hit an unbeaten 87 runs off 94 balls in the chase, dedicated the victory to all Nepali cricket fans around the world. "This is a historic moment for Nepal cricket. We have been working towards this for years, and today we have achieved it," he said.</p><p>The Nepali-Australian community celebrated the historic qualification with spontaneous gatherings in Sydney, Melbourne, and Brisbane. The Nepal Australia Cricket Association announced plans for a special charity match between Nepal and an Australian XI to celebrate the qualification.</p><p>Nepal will face cricket powerhouses including India, Pakistan, Australia, and England in the group stage of the World Cup to be held in South Africa and Zimbabwe.</p>',
                'category'       => 'sports',
                'featured_image' => 'https://images.pexels.com/photos/3621104/pexels-photo-3621104.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => true,
                'views'          => 7638,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Sports', 'Cricket', 'Nepal'],
                'published_at'   => now()->subDays(2),
            ],

            // ─── ARTICLE 6 ───────────────────────────────────
            [
                'title'          => 'Nepali Women\'s Association Launches Free Legal Aid Service in Brisbane',
                'summary'        => 'The newly launched service provides free legal consultations for visa issues, workplace rights, and domestic matters to Nepali community members across Queensland.',
                'content'        => '<p>The Nepali Women\'s Association of Queensland launched a groundbreaking free legal aid service in Brisbane this week, providing access to legal consultations for Nepali community members across Queensland who cannot afford private legal services.</p><p>The service, which is funded through a combination of government grants and community donations, will offer advice on immigration and visa matters, workplace rights and employment disputes, family law and domestic violence, tenancy and housing issues, and general consumer rights.</p><p>Registered migration agents and volunteer lawyers will be available for consultations every Saturday at the Nepali Community Centre in Fortitude Valley, Brisbane. Nepali-speaking interpreters will be available for all sessions.</p><p>"Many Nepali migrants are not aware of their rights or are too afraid to seek help due to language barriers or concerns about their visa status. This service aims to change that," said association president Mina Gurung.</p>',
                'category'       => 'community',
                'featured_image' => 'https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1893,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Community', 'Brisbane', 'Visa', 'Women'],
                'published_at'   => now()->subDays(3),
            ],

            // ─── ARTICLE 7 ───────────────────────────────────
            [
                'title'          => 'Australia Announces New Visa Pathways for Nepali Skilled Workers',
                'summary'        => 'The Australian government has announced expanded visa pathways specifically targeting skilled workers from Nepal in nursing, aged care, IT, and construction sectors.',
                'content'        => '<p>The Australian government has announced a significant expansion of visa pathways for skilled workers from Nepal, in response to critical shortages in key industries including nursing, aged care, information technology, and construction.</p><p>The new measures include a dedicated fast-track processing system for Nepali applicants in critical shortage occupations, an increase in the annual quota for Nepali workers under the Skilled Worker Program, streamlined skills recognition for Nepali qualifications, and a new regional sponsorship pathway specifically for Nepali workers willing to settle in regional and rural Australia.</p><p>Immigration Minister Tony Burke said the measures reflect Australia\'s commitment to filling critical workforce gaps while supporting legal migration pathways. "Nepal has a highly skilled and hardworking workforce, and we want to welcome more Nepali professionals to contribute to Australia\'s economy and communities," he said.</p><p>The changes are expected to take effect from 1 July 2026 and will apply to Subclass 482 (Temporary Skill Shortage), 186 (Employer Nomination Scheme), and 189 (Skilled Independent) visa subclasses.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/4050291/pexels-photo-4050291.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 2341,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Australia', 'Visa', 'Migration'],
                'published_at'   => now()->subDays(4),
            ],

            // ─── ARTICLE 8 ───────────────────────────────────
            [
                'title'          => 'UNESCO Adds Patan Durbar Square to Expanded World Heritage Protection',
                'summary'        => 'The medieval city of Patan\'s historic Durbar Square complex receives expanded protections following renewed conservation efforts by Nepali authorities.',
                'content'        => '<p>UNESCO has announced expanded World Heritage protections for Patan Durbar Square, the medieval city complex located in the Kathmandu Valley, following a successful conservation effort by the Nepali government and international preservation organisations.</p><p>The expansion covers newly documented temples, courtyards, and traditional Newari architecture that were previously outside the protected boundary. The decision was made at the UNESCO World Heritage Committee meeting in New Delhi.</p><p>Patan, also known as Lalitpur, is one of the three ancient cities in the Kathmandu Valley and contains some of the finest examples of traditional Newari architecture in the world. The Durbar Square houses over 136 courtyards and 55 major temples.</p><p>The Nepali-Australian community has expressed pride at the recognition, with cultural organisations planning special events to raise awareness about Nepal\'s rich cultural heritage among the diaspora.</p>',
                'category'       => 'culture',
                'featured_image' => 'https://images.pexels.com/photos/2901209/pexels-photo-2901209.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1654,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Culture', 'Nepal', 'Kathmandu'],
                'published_at'   => now()->subDays(5),
            ],

            // ─── ARTICLE 9 ───────────────────────────────────
            [
                'title'          => 'Opinion: Nepal\'s Federal System Is Maturing — Slowly But Surely',
                'summary'        => 'Seven years into federalism, Nepal\'s provinces are beginning to demonstrate fiscal independence and policy innovation that seemed impossible in 2017.',
                'content'        => '<p>When Nepal adopted its new constitution in 2015 and transitioned to a federal democratic republic with three tiers of government — federal, provincial, and local — the sceptics were many. The logistics of dividing a historically centralised state into seven provinces, 753 municipalities, and over 6,000 ward offices seemed overwhelming.</p><p>Seven years on, the picture is more nuanced than either the optimists or pessimists predicted. Yes, federalism has been messy, expensive, and at times chaotic. But there are also genuine signs of progress that deserve recognition.</p><p>Provincial governments in Bagmati and Gandaki are now designing their own health and education policies, with measurably different outcomes from the federal baseline. Karnali Province, historically the most marginalised, has implemented innovative social protection programs that have reduced extreme poverty.</p><p>Local governments have been particularly active, with hundreds of municipalities now running their own agricultural extension services, building local roads, and managing primary schools in ways that simply did not happen under the old unitary system.</p>',
                'category'       => 'opinion',
                'featured_image' => 'https://images.pexels.com/photos/1550337/pexels-photo-1550337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 987,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Politics'],
                'published_at'   => now()->subDays(6),
            ],

            // ─── ARTICLE 10 ──────────────────────────────────
            [
                'title'          => 'New Student Visa Rules Favour Nepali Applicants With Regional University Offers',
                'summary'        => 'Changes to the student visa framework prioritise regional campus placements, opening new opportunities for thousands of Nepali students annually.',
                'content'        => '<p>The Australian government has announced significant changes to its student visa framework that will particularly benefit Nepali students who accept offers from regional university campuses and vocational training colleges.</p><p>Under the new rules, Nepali students accepting offers from universities in regional areas (outside Sydney, Melbourne, and Brisbane) will receive priority processing, reduced visa fees, and access to the Regional Graduate Visa — a pathway to permanent residency after just two years of work in regional Australia.</p><p>The changes are expected to benefit up to 15,000 Nepali students annually and will help address workforce shortages in regional Australia while providing Nepali graduates with a clearer pathway to permanent residency.</p><p>Universities in Canberra, Adelaide, Perth, Darwin, and Townsville have already reported a spike in enquiries from prospective Nepali students since the announcement.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/1205651/pexels-photo-1205651.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1432,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Australia', 'Education', 'Visa', 'Scholarship'],
                'published_at'   => now()->subDays(7),
            ],

            // ─── ARTICLE 11 ──────────────────────────────────
            [
                'title'          => 'Nepali Climbers Set New Everest Speed Record During Spring Season',
                'summary'        => 'A team of six Sherpa climbers summited Mount Everest in under 25 hours from Base Camp, smashing the previous speed record by nearly two hours.',
                'content'        => '<p>A team of six elite Sherpa climbers from Nepal has shattered the Mount Everest speed ascent record, reaching the 8,849-metre summit from Base Camp in just 24 hours and 17 minutes — nearly two hours faster than the previous record set in 2022.</p><p>The team, led by veteran mountaineer Nirmal "Nims" Purja\'s protégé Dawa Tenzin Sherpa, made the rapid ascent using a revolutionary acclimatisation protocol developed in partnership with Kathmandu\'s High Altitude Medical Research Centre. The team carried minimal gear and used pre-fixed ropes installed during the season\'s regular expedition traffic.</p><p>"We trained for three years for this. Every breath at altitude, every simulated climb at the HARC facility — it was all for this moment," said Dawa Tenzin after the record was confirmed.</p><p>The feat has been celebrated across Nepal and the Nepali diaspora in Australia, with Sherpa community associations in Sydney and Melbourne hosting celebration events. Nepal\'s Tourism Board noted that the record would further boost Nepal\'s profile as the world\'s premier mountaineering destination.</p><p>The 2026 spring season on Everest has been one of the most successful on record, with over 600 climbers reaching the summit amid unusually stable weather conditions in May.</p>',
                'category'       => 'sports',
                'featured_image' => 'https://images.pexels.com/photos/2804111/pexels-photo-2804111.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => true,
                'is_breaking'    => false,
                'views'          => 6420,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Sports', 'Tourism', 'Himalaya'],
                'published_at'   => now()->subDays(8),
            ],

            // ─── ARTICLE 12 ──────────────────────────────────
            [
                'title'          => 'Hundreds of Nepali Nurses Recruited Under New Australian Health Workforce Agreement',
                'summary'        => 'A new bilateral health workforce agreement will bring 800 Nepali nurses to Australian hospitals over the next two years, addressing critical staffing shortages.',
                'content'        => '<p>Under a groundbreaking new bilateral health workforce agreement signed between Australia and Nepal, 800 qualified Nepali nurses will be recruited to work in Australian public hospitals over the next two years, targeting urgent staffing shortages in aged care, rural hospitals, and metropolitan intensive care units.</p><p>The agreement, brokered by the Australian Department of Health and the Nepal Nursing Council, includes a recognition of qualifications framework that will allow Nepali nurses to be registered with the Australian Health Practitioner Regulation Agency (AHPRA) within 60 days of arrival — compared to the current wait of up to 12 months.</p><p>Participating Nepali nurses will receive a bridging support package including airfare, temporary housing, language support, and a cultural orientation program. After two years of service, they will be eligible to apply for permanent residency under the health worker skilled migration stream.</p><p>"Nepal has some of the world\'s most dedicated and skilled nurses. This agreement is a win for Australian healthcare and a meaningful career opportunity for Nepali health professionals," said Health Minister Mark Butler.</p><p>The Nepali Nurses Association of Australia, which currently represents over 4,000 Nepali-born nurses working in Australia, welcomed the agreement and offered mentoring support to incoming nurses.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/3938022/pexels-photo-3938022.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 3108,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Australia', 'Health', 'Migration', 'Women'],
                'published_at'   => now()->subDays(9),
            ],

            // ─── ARTICLE 13 ──────────────────────────────────
            [
                'title'          => 'Nepal Tourism Breaks All Records as 1.5 Million Visitors Arrive in 2025-26',
                'summary'        => 'Nepal\'s tourism sector has fully recovered from the COVID-19 slump, with visitor numbers exceeding pre-pandemic peaks by over 25 percent.',
                'content'        => '<p>Nepal\'s Ministry of Tourism has confirmed that the 2025-26 fiscal year saw a record 1.5 million international visitors to Nepal — a 25% increase over the previous peak year of 2019 — as the sector continues its dramatic post-pandemic recovery.</p><p>Trekking remains the dominant draw, with the Annapurna Circuit, Everest Base Camp, and Langtang Valley routes all reporting near-capacity booking through the spring and autumn seasons. New trekking routes opened by the Nepal Tourism Board in the far-western Humla and Dolpo regions are also gaining popularity.</p><p>Australian visitors were the sixth largest group of international tourists, with over 48,000 Australians visiting Nepal in 2025-26. Many are Nepali-Australians making return visits, but the proportion of first-time Australian trekkers is also growing rapidly.</p><p>"Nepal offers something truly unique — raw natural beauty, ancient culture, and the warmth of its people. We are committed to sustainable tourism that benefits local communities and protects our environment," said Tourism Minister Rekha Sharma.</p><p>The government has announced plans to build new mountain airports in Tsum Valley and Upper Mustang to improve access to remote trekking regions, with funding from the Asian Development Bank.</p>',
                'category'       => 'nepal',
                'featured_image' => 'https://images.pexels.com/photos/2070485/pexels-photo-2070485.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 2876,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Nepal', 'Tourism', 'Himalaya', 'Economy'],
                'published_at'   => now()->subDays(10),
            ],

            // ─── ARTICLE 14 ──────────────────────────────────
            [
                'title'          => 'Authentic Nepali Restaurant "Himalayan Kitchen" Opens in Melbourne\'s CBD',
                'summary'        => 'Melbourne\'s food scene gains a new gem as award-winning Nepali chef Binod Baral brings authentic mountain cuisine to the heart of the city.',
                'content'        => '<p>Melbourne\'s celebrated food scene has welcomed a new addition with the opening of Himalayan Kitchen, an upscale Nepali restaurant in Flinders Lane, CBD, helmed by award-winning chef Binod Baral who previously worked in Kathmandu\'s Dwarika\'s Hotel and London\'s Tamarind restaurant.</p><p>The menu at Himalayan Kitchen is a masterclass in Nepal\'s diverse regional cuisines, featuring dishes from the Himalayan highlands — including yak cheese, buckwheat bread, and butter tea — alongside the spiced complexity of Madhesi cuisine from Nepal\'s southern Terai region.</p><p>Signature dishes include slow-cooked Newari khasi ko masu (goat curry), handmade bamboo shoot momos with wild mushroom filling, and the show-stopping thakali thali with a rotating selection of seasonal preparations.</p><p>"Nepali food is largely unknown outside the community, which is a shame because it is incredibly complex and diverse. I want Melburnians to discover what Nepali cuisine really is — not just momo and chow mein," said Chef Baral.</p><p>Himalayan Kitchen is open Tuesday through Sunday and has already secured bookings months in advance following rave reviews from Melbourne food critics, who have called it "a revelation" and "unmissable."</p>',
                'category'       => 'community',
                'featured_image' => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 4211,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Community', 'Melbourne', 'Food', 'Culture'],
                'published_at'   => now()->subDays(11),
            ],

            // ─── ARTICLE 15 ──────────────────────────────────
            [
                'title'          => 'Nepal-Australia Business Forum Seals $120 Million in New Investment Deals',
                'summary'        => 'The third annual Nepal-Australia Business Forum in Sydney produced 14 signed MoUs, with Australian investors targeting Nepal\'s hydropower, IT, and agro-processing sectors.',
                'content'        => '<p>The third annual Nepal-Australia Business Forum, held at the Sydney International Convention Centre, concluded with the signing of 14 Memoranda of Understanding totalling AUD $120 million in committed investment, primarily targeting Nepal\'s hydropower energy, information technology, and agro-processing industries.</p><p>Over 200 business delegates from both countries attended the two-day event, which featured panel discussions on investment opportunities, regulatory frameworks, and market entry strategies for Australian companies looking to expand into Nepal.</p><p>Australian firm Green Horizons Energy signed the largest single agreement — a AUD $45 million partnership with Nepal Electricity Authority to develop a 30-megawatt run-of-river hydropower project in Bagmati Province, expected to be operational by 2028.</p><p>The technology sector also attracted significant attention, with three Australian fintech companies announcing partnerships with Nepali banks to develop digital payment and mobile banking solutions targeting Nepal\'s largely unbanked rural population.</p><p>"Nepal is an emerging market with tremendous potential. The combination of a young, educated workforce, abundant natural resources, and improving governance makes it a compelling destination for Australian investment," said Business Council of Australia representative Sarah Mitchell.</p>',
                'category'       => 'business',
                'featured_image' => 'https://images.pexels.com/photos/1181354/pexels-photo-1181354.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1987,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Business', 'Nepal', 'Australia', 'Economy'],
                'published_at'   => now()->subDays(12),
            ],

            // ─── ARTICLE 16 ──────────────────────────────────
            [
                'title'          => 'Nepali Tech Startup "FinKhata" Raises $8 Million in Australian-Led Series A',
                'summary'        => 'Kathmandu-based accounting and invoicing platform FinKhata closes a landmark funding round led by Sydney venture capital firm Atlassian Ventures, signalling growing investor confidence in Nepal\'s tech sector.',
                'content'        => '<p>FinKhata, a Kathmandu-based cloud accounting and invoicing platform designed for Nepal\'s small and medium enterprises, has successfully closed an $8 million AUD Series A funding round led by Sydney-based venture capital firm Pacific Basin Ventures, marking one of the largest early-stage investments ever made in a Nepali tech company.</p><p>The platform, which launched in 2023, currently serves over 12,000 SME clients across Nepal and has processed more than $500 million in transactions. Its mobile-first design and support for both English and Nepali language interfaces have been key differentiators in a market where most accounting software is still desktop-based and English-only.</p><p>FinKhata will use the new funding to expand its product to Bangladesh and Sri Lanka, hire 50 additional engineers at its Kathmandu development hub, and integrate with Australian banking platforms to serve the growing number of Nepali-owned businesses in Australia.</p><p>"Nepal has exceptional software engineering talent and a vibrant startup ecosystem. FinKhata is exactly the type of company that proves Nepali tech can compete globally," said Pacific Basin Ventures managing director James Ng.</p>',
                'category'       => 'business',
                'featured_image' => 'https://images.pexels.com/photos/546819/pexels-photo-546819.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => true,
                'is_breaking'    => false,
                'views'          => 3544,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Business', 'Technology', 'Nepal', 'Economy'],
                'published_at'   => now()->subDays(13),
            ],

            // ─── ARTICLE 17 ──────────────────────────────────
            [
                'title'          => 'Teej Festival Brings Together Thousands of Nepali Women Across Australian Cities',
                'summary'        => 'The Hindu festival of Teej, celebrating the bond between women and their families, drew record turnout at events in Sydney, Melbourne, Brisbane, and Perth.',
                'content'        => '<p>The Hindu festival of Teej — a celebration of feminine strength, marriage, and family bonds — was celebrated with unprecedented enthusiasm across Australia\'s major cities this year, with simultaneous events in Sydney, Melbourne, Brisbane, and Perth drawing a combined attendance of over 8,000 Nepali women.</p><p>The Sydney event, organised by the Nepali Women\'s Community of NSW at Fairfield Showground, was the largest, with over 3,200 attendees dressed in traditional red saris and gold jewellery. The day began with the traditional Teej vrat (fast), followed by communal singing of Teej songs, traditional dance performances, and the exchange of gifts and blessings among women.</p><p>In Melbourne, the Nepali Women\'s Forum of Victoria hosted a sunrise prayer ceremony at the Footscray Community Centre, followed by a procession to Maribyrnong River where women offered prayers to the river in a tradition echoing the Bagmati river ceremonies in Kathmandu.</p><p>"Teej reminds us that even thousands of kilometres from home, our traditions are alive and strong. Every year this celebration grows bigger, and that gives me immense joy," said Sydney event organiser Kavita Tamang.</p>',
                'category'       => 'community',
                'featured_image' => 'https://images.pexels.com/photos/1371360/pexels-photo-1371360.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 3892,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Community', 'Culture', 'Women', 'Festival', 'Religion'],
                'published_at'   => now()->subDays(14),
            ],

            // ─── ARTICLE 18 ──────────────────────────────────
            [
                'title'          => 'Nepal\'s Remittance Milestone: Over $10 Billion Received in Single Year',
                'summary'        => 'Nepal has crossed the $10 billion remittance threshold for the first time in its history, with Australia among the top five source countries.',
                'content'        => '<p>Nepal has crossed a historic economic milestone, receiving over $10 billion USD in remittances in the 2025-26 fiscal year for the first time in the country\'s history, according to data released by Nepal Rastra Bank (NRB).</p><p>Remittances now account for 27.3% of Nepal\'s GDP — among the highest ratios in the world — and represent the single largest source of foreign exchange earnings, exceeding export revenue, tourism receipts, and foreign direct investment combined.</p><p>The Gulf countries (Qatar, UAE, Saudi Arabia, and Kuwait) remain the largest source of remittances by volume, but Australia has risen to fifth position overall, reflecting the rapid growth of the Nepali diaspora in Australian cities. Remittances from Australia grew by 34% in 2025-26, driven by rising wages and the increasing number of Nepali-Australians entering higher-paid professional occupations.</p><p>Economists have welcomed the milestone but also cautioned against over-reliance on remittances. "The remittance economy funds consumption and construction, but it does not build the productive capacity Nepal needs for long-term development," said Dr Dilli Raj Khatiwada, former NRB Governor.</p>',
                'category'       => 'nepal',
                'featured_image' => 'https://images.pexels.com/photos/210742/pexels-photo-210742.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 2103,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Remittance', 'Economy', 'Australia'],
                'published_at'   => now()->subDays(15),
            ],

            // ─── ARTICLE 19 ──────────────────────────────────
            [
                'title'          => 'Perth Nepali Community Centre Opens After Decade-Long Fundraising Drive',
                'summary'        => 'The new $2.4 million Nepali Community Centre in Perth\'s northern suburbs will serve as a cultural and social hub for the city\'s growing Nepali population of over 18,000.',
                'content'        => '<p>After a decade of fundraising, advocacy, and perseverance by Perth\'s Nepali community, the new $2.4 million Nepali Community Centre officially opened in Mirrabooka on Saturday, providing the 18,000-strong local Nepali community with a permanent cultural and social hub for the first time.</p><p>The 800-square-metre facility, partially funded by the Western Australian State Government\'s Multicultural Communities Infrastructure Fund, includes a multipurpose event hall seating 300, a commercial-grade kitchen, a children\'s learning centre, a library with Nepali-language books, and offices for community organisations.</p><p>The opening ceremony was attended by WA Premier Roger Cook, federal multicultural affairs minister and over 500 community members. Traditional Nepali cultural performances including Maruni dance, Dhime drumming, and Newari musical ensembles entertained the crowd throughout the day.</p><p>"This is not just a building — it is a home for our community, a place to celebrate who we are and pass our heritage to the next generation," said Nepali Community of WA president Keshav Malla, who has led the fundraising effort since 2015.</p>',
                'category'       => 'community',
                'featured_image' => 'https://images.pexels.com/photos/1105766/pexels-photo-1105766.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => true,
                'is_breaking'    => false,
                'views'          => 4650,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Community', 'Perth', 'Culture'],
                'published_at'   => now()->subDays(16),
            ],

            // ─── ARTICLE 20 ──────────────────────────────────
            [
                'title'          => 'Nepal Passes Landmark Climate Resilience Law Backed by Australian Aid',
                'summary'        => 'Nepal\'s parliament has enacted a comprehensive climate adaptation law, developed with technical assistance from Australia\'s DFAT and backed by $80 million in Australian climate finance.',
                'content'        => '<p>Nepal\'s parliament has unanimously passed the Climate Resilience and Adaptation Act 2026, a landmark piece of legislation that establishes the country\'s first comprehensive legal framework for responding to climate change — developed with significant technical assistance from the Australian Department of Foreign Affairs and Trade (DFAT).</p><p>Australia committed AUD $80 million in climate finance to Nepal as part of the legislation\'s development and implementation, one of the largest bilateral climate investments Australia has made in South Asia.</p><p>The new law creates a National Climate Adaptation Fund, requires climate risk assessments for all major infrastructure projects, establishes legal protections for climate migrants, and mandates a 50% reduction in Nepal\'s dependence on fossil fuels by 2035.</p><p>Nepal is among the world\'s most climate-vulnerable nations despite contributing less than 0.1% of global greenhouse gas emissions. The Himalayan country faces threats including accelerating glacial melt, increasingly erratic monsoons, and more frequent and severe flooding — all of which have direct impacts on agriculture, water security, and mountain communities.</p><p>"Australia is proud to partner with Nepal in addressing the climate crisis. Nepal\'s leadership on this issue should inspire all nations," said Australian High Commissioner Margaret Thompson at the law\'s enactment ceremony in Kathmandu.</p>',
                'category'       => 'nepal',
                'featured_image' => 'https://images.pexels.com/photos/4793824/pexels-photo-4793824.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1756,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Climate', 'Australia', 'Environment', 'Politics'],
                'published_at'   => now()->subDays(17),
            ],

            // ─── ARTICLE 21 ──────────────────────────────────
            [
                'title'          => 'Nepali-Australian Youth Basketball Team Wins Asia-Pacific Championships',
                'summary'        => 'The Australian team featuring five Nepali-Australian players clinched the Asia-Pacific Under-20 Basketball Championship title in a dramatic final against the Philippines.',
                'content'        => '<p>An Australian national Under-20 basketball team featuring five Nepali-Australian players from Sydney and Melbourne has claimed the Asia-Pacific Basketball Championship title in a dramatic 78-74 final victory over the Philippines in Kuala Lumpur.</p><p>Star players Aashish Karki (Melbourne) and Dibesh Tamang (Sydney) were standouts throughout the tournament, with Karki earning the tournament\'s Most Valuable Player award after averaging 22 points and 8 rebounds per game across six matches.</p><p>Both players were born in Nepal and moved to Australia as children, representing a new generation of Nepali-Australians making their mark in mainstream Australian sports beyond cricket and football.</p><p>The Nepali-Australian community erupted with celebrations following the championship victory, with watch parties held at community centres in Parramatta, Footscray, and Fortitude Valley. The Nepal Australia Sports Foundation described the achievement as "a defining moment for Nepali-Australian youth in sport."</p><p>Karki and Tamang have both received invitations to trial for the senior Australian Boomers squad ahead of the 2028 Los Angeles Olympics.</p>',
                'category'       => 'sports',
                'featured_image' => 'https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 2987,
                'status'         => 'published',
                'author_id'      => $contributor2->id,
                'tags'           => ['Sports', 'Youth', 'Australia', 'Community'],
                'published_at'   => now()->subDays(18),
            ],

            // ─── ARTICLE 22 ──────────────────────────────────
            [
                'title'          => 'Canberra Hosts First Nepal-Australia Parliamentary Friendship Group Meeting',
                'summary'        => 'Members of parliament from both countries gathered in Canberra to strengthen bilateral ties and discuss migration, education, and climate cooperation priorities.',
                'content'        => '<p>Canberra hosted the inaugural meeting of the Nepal-Australia Parliamentary Friendship Group this week, bringing together 12 Australian MPs and Senators with a delegation of eight members of Nepal\'s House of Representatives and National Assembly for two days of dialogue on bilateral cooperation priorities.</p><p>The Australian delegation was co-chaired by Labor MP Zanele Morrison (representing the electorate of Parramatta, home to Sydney\'s largest Nepali-Australian community) and Liberal Senator James Patterson. The Nepali delegation was led by Deputy Speaker of the House of Representatives Hon. Purna Kumari Subedi.</p><p>Discussions focused on four priority themes: expanding migration pathways for skilled Nepali workers, deepening education and research partnerships between universities, scaling up climate finance for Nepal\'s adaptation programs, and improving consular services for the growing Nepali-Australian community.</p><p>A joint communiqué issued at the close of the meeting committed both parliamentary delegations to annual meetings alternating between Canberra and Kathmandu, and called on their respective governments to fast-track the negotiation of a bilateral social security agreement.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/1550337/pexels-photo-1550337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1243,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Australia', 'Nepal', 'Politics', 'Canberra', 'Migration'],
                'published_at'   => now()->subDays(19),
            ],

            // ─── ARTICLE 23 ──────────────────────────────────
            [
                'title'          => 'Nepali Arts Exhibition "Peaks and Plains" Opens at Sydney\'s Powerhouse Museum',
                'summary'        => 'A landmark exhibition showcasing contemporary Nepali art — from Himalayan thangka painting to urban Kathmandu photography — draws thousands of visitors in its opening week.',
                'content'        => '<p>The Powerhouse Museum in Sydney has opened "Peaks and Plains: Contemporary Art from Nepal," a landmark exhibition featuring works by 24 Nepali artists spanning traditional thangka painting, sculpture, textile art, photography, and digital media — the most comprehensive display of contemporary Nepali art ever mounted in the Southern Hemisphere.</p><p>Curated in partnership with Kathmandu\'s Siddhartha Art Gallery and the Australia Council for the Arts, the exhibition explores the tensions and connections between Nepal\'s ancient artistic traditions and the rapid social, political, and urban transformations reshaping contemporary Nepali society.</p><p>Highlights include a 12-metre immersive thangka installation by celebrated Nepali artist Sunanda Bajracharya, a photography series documenting everyday life in Kathmandu\'s medieval Ason market by Bikash Karmacharya, and a digital art installation by Melbourne-based Nepali-Australian artist Suman Rai exploring themes of diaspora, belonging, and cultural identity.</p><p>"This exhibition is a long-overdue introduction to one of Asia\'s most vibrant and under-recognised contemporary art scenes," said exhibition curator Dr. Patricia Collins. "Nepali art is in conversation with global art movements while remaining deeply rooted in its own extraordinary cultural traditions."</p>',
                'category'       => 'culture',
                'featured_image' => 'https://images.pexels.com/photos/3153367/pexels-photo-3153367.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 2198,
                'status'         => 'published',
                'author_id'      => $contributor->id,
                'tags'           => ['Culture', 'Arts', 'Sydney', 'Australia', 'Nepal'],
                'published_at'   => now()->subDays(20),
            ],

            // ─── ARTICLE 24 ──────────────────────────────────
            [
                'title'          => 'Nepali-Australian Community Raises $500,000 for Koshi Flood Relief',
                'summary'        => 'Following devastating flooding in Nepal\'s Koshi River basin, the Nepali diaspora in Australia has mobilised an extraordinary relief fundraising campaign.',
                'content'        => '<p>The Nepali-Australian community has demonstrated extraordinary solidarity following devastating floods in Nepal\'s Koshi River basin, raising over $500,000 AUD in just two weeks through a coordinated fundraising campaign organised by the Non-Resident Nepali Association Australia (NRNA Australia).</p><p>The August floods, triggered by record monsoon rainfall, inundated thousands of hectares of farmland in Sunsari, Saptari, and Udayapur districts in eastern Nepal\'s Terai region, displacing over 80,000 people and destroying crops for hundreds of thousands of farming families approaching the harvest season.</p><p>NRNA Australia chapters in all six states launched simultaneous fundraising drives using a combination of community events, online crowdfunding, and direct corporate solicitations. The Australian government announced a matching contribution of $250,000 to the official NRNA Nepal Relief Fund, bringing the total raised through the Australian campaign to over $750,000.</p><p>"When Nepal is in pain, we feel it here in Australia just as intensely. Our community came together with incredible speed and generosity," said NRNA Australia national president Dipen Karmacharya.</p><p>Funds are being distributed in coordination with the Nepal Red Cross Society and will prioritise immediate food relief, temporary shelter, and agricultural recovery support for affected families.</p>',
                'category'       => 'nepal',
                'featured_image' => 'https://images.pexels.com/photos/1756959/pexels-photo-1756959.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => true,
                'views'          => 5320,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Nepal', 'Community', 'Australia', 'Climate', 'Environment'],
                'published_at'   => now()->subDays(21),
            ],

            // ─── ARTICLE 25 ──────────────────────────────────
            [
                'title'          => 'Opinion: The Nepali-Australian Community Needs More Political Representation',
                'summary'        => 'With over 130,000 Nepali-Australians now calling Australia home, it is time for our community to step up and stand for elected office at all levels of government.',
                'content'        => '<p>Our community has been in Australia long enough. We have built businesses, staffed hospitals, educated children, paid taxes, and contributed to the cultural fabric of this nation. And yet, at the most recent federal election, not a single candidate of Nepali heritage stood for any party in any electorate — despite the fact that Nepali-Australians are now the swing vote in at least three western Sydney seats.</p><p>This must change. Political representation matters not just symbolically but practically. Without Nepali-Australian voices in parliament, in state legislatures, and on local councils, our community\'s specific concerns — from streamlined skills recognition to anti-discrimination protections in rental markets — remain at the bottom of every policy agenda.</p><p>I know the counterarguments. Migration journeys are difficult; the first generation is focused on economic stability, not political ambition. Nepali culture traditionally discourages drawing attention to oneself. And Australian politics can seem like a closed shop, dominated by party networks that take decades to penetrate.</p><p>But look at the Indian-Australian, Chinese-Australian, and Lebanese-Australian communities, all of which have successfully transitioned from diaspora communities focused on economic establishment to communities with genuine political agency and elected representatives. Their paths are not identical to ours, but the trajectory is clear: engage or be invisible.</p><p>The community organisations that exist today — NRNA Australia, the various state Nepali associations, the women\'s networks, the business councils — represent an organisational infrastructure that any political aspirant would envy. What we lack is the ambition and the willingness to step forward. That needs to change before the 2028 federal election.</p>',
                'category'       => 'opinion',
                'featured_image' => 'https://images.pexels.com/photos/1550337/pexels-photo-1550337.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 1456,
                'status'         => 'published',
                'author_id'      => $editor->id,
                'tags'           => ['Community', 'Australia', 'Politics', 'Youth'],
                'published_at'   => now()->subDays(22),
            ],

            // ─── ARTICLE 26 (DRAFT) ───────────────────────────
            [
                'title'          => 'Nepal to Launch Direct Air Route to Sydney Under New Open Skies Agreement',
                'summary'        => 'Negotiations for a direct Kathmandu-Sydney flight route are in the final stages, with two carriers — Nepal Airlines and Qantas — expected to announce codeshare services by mid-2026.',
                'content'        => '<p>A long-cherished ambition of the Nepali-Australian community is edging closer to reality, with senior aviation officials from both countries confirming that negotiations for a direct Kathmandu-Sydney air route are in their final stages under the new Nepal-Australia Open Skies Agreement signed in February 2026.</p><p>Both Nepal Airlines Corporation and Qantas have confirmed that they are in discussions about codeshare arrangements that would support direct or near-direct services, potentially cutting travel time from the current average of 18-22 hours (with one or two stops) to as little as 13 hours.</p><p>The route would likely operate three times weekly initially, with potential for daily services subject to demand. Sydney and Melbourne have both been identified as preferred Australian endpoints, though Sydney has stronger case given the size of the Nepali community in western Sydney.</p><p>The absence of a direct Kathmandu-Australia flight has been one of the most persistent complaints of the Nepali-Australian community, forcing travellers to transit through Kuala Lumpur, Bangkok, Singapore, Doha, or Dubai — adding significant cost, time, and inconvenience to visits home.</p>',
                'category'       => 'australia',
                'featured_image' => 'https://images.pexels.com/photos/358319/pexels-photo-358319.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                'is_featured'    => false,
                'is_breaking'    => false,
                'views'          => 890,
                'status'         => 'draft',
                'author_id'      => $contributor->id,
                'tags'           => ['Australia', 'Nepal', 'Migration', 'Community'],
                'published_at'   => null,
            ],
        ];

        foreach ($articles as $data) {
            $tagNames = $data['tags'];
            unset($data['tags']);
            $article = Article::create($data);
            $tagIds  = [];
            foreach ($tagNames as $name) {
                if (isset($tags[$name])) {
                    $tagIds[] = $tags[$name]->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        // ── RETRIEVE PUBLISHED ARTICLES FOR COMMENTS ─────────
        $publishedArticles = Article::where('status', 'published')->get();

        // ── CREATE COMMENTS ───────────────────────────────────
        $commentData = [
            [
                'body'        => 'This is fantastic news for the Nepali community in Australia! The scholarship program will be life-changing for thousands of families.',
                'is_approved' => true,
            ],
            [
                'body'        => 'Finally some positive economic news from Nepal. The IT sector growth is particularly encouraging for young Nepalis.',
                'is_approved' => true,
            ],
            [
                'body'        => 'As a Nepali nurse working in Brisbane, I am so glad to see this agreement. The AHPRA recognition process was incredibly long and stressful for me when I arrived.',
                'is_approved' => true,
            ],
            [
                'body'        => 'The Dashain festival in Melbourne was incredible this year. So proud to see our culture celebrated at such scale.',
                'is_approved' => true,
            ],
            [
                'body'        => 'Great news about the cricket World Cup qualification! Rohit Paudel is an absolute legend.',
                'is_approved' => true,
            ],
            [
                'body'        => 'The legal aid service in Brisbane is so needed. Many people I know have faced exploitation by dodgy employers and had no idea where to turn.',
                'is_approved' => true,
            ],
            [
                'body'        => 'I visited Himalayan Kitchen last week — the food is absolutely extraordinary. The buckwheat bread with yak butter is unlike anything I\'ve ever had.',
                'is_approved' => true,
            ],
            [
                'body'        => 'The new Nepali Community Centre in Perth is long overdue. I have been donating to the fund since 2017 and am so happy to finally see it open.',
                'is_approved' => true,
            ],
            [
                'body'        => 'This article raises important points but I think we also need to build leadership pipelines from within community organisations before jumping into electoral politics.',
                'is_approved' => true,
            ],
            [
                'body'        => 'A direct flight between Kathmandu and Sydney cannot come soon enough. Paying $2,500+ for a flight home every year is not sustainable for many families.',
                'is_approved' => true,
            ],
            [
                'body'        => 'The FinKhata investment is great but let\'s hope the founders remember Nepal\'s SMEs and keep the product accessible and affordable.',
                'is_approved' => false,
            ],
            [
                'body'        => 'Wonderful to see the Teej coverage. These celebrations are so important for keeping our culture alive for the next generation.',
                'is_approved' => true,
            ],
        ];

        foreach ($commentData as $i => $comment) {
            if ($publishedArticles->count() > 0) {
                Comment::create([
                    'article_id'  => $publishedArticles[$i % $publishedArticles->count()]->id,
                    'user_id'     => [$reader->id, $contributor->id, $contributor2->id][$i % 3],
                    'body'        => $comment['body'],
                    'is_approved' => $comment['is_approved'],
                ]);
            }
        }

        // ── CREATE EVENTS ─────────────────────────────────────
        $events = [
            [
                'title'        => 'Baisakh New Year Celebration 2083 BS',
                'description'  => 'Join the Nepalese community of NSW for the traditional Nepali New Year celebration featuring cultural performances, food stalls, music, and Tika ceremony. All are welcome!',
                'event_date'   => now()->addDays(5)->setTime(10, 0),
                'venue'        => 'Tumbalong Park',
                'address'      => 'Darling Harbour',
                'city'         => 'Sydney',
                'organiser'    => 'Nepalese Society of NSW',
                'category'     => 'cultural',
                'is_free'      => true,
                'is_approved'  => true,
                'created_by'   => $admin->id,
            ],
            [
                'title'        => 'Free Visa & Immigration Seminar',
                'description'  => 'Registered migration agents will answer questions on skilled migration, permanent residency applications, partner visas, and family reunification. Nepali interpreters available.',
                'event_date'   => now()->addDays(12)->setTime(13, 0),
                'venue'        => 'Melbourne Town Hall',
                'address'      => 'Swanston Street, Melbourne CBD',
                'city'         => 'Melbourne',
                'organiser'    => 'Nepal Australia Friendship Society',
                'category'     => 'education',
                'is_free'      => true,
                'is_approved'  => true,
                'created_by'   => $admin->id,
            ],
            [
                'title'        => 'Nepal Australia Cricket Friendly Match',
                'description'  => 'Annual cricket match between the Nepali Community XI and Australian Multicultural XI. Proceeds go to the Nepal Flood Relief Fund. BBQ and refreshments provided.',
                'event_date'   => now()->addDays(19)->setTime(9, 0),
                'venue'        => 'Pratten Park Cricket Ground',
                'address'      => 'Ashfield, NSW',
                'city'         => 'Sydney',
                'organiser'    => 'Nepal Cricket Club Sydney',
                'category'     => 'sports',
                'is_free'      => true,
                'is_approved'  => true,
                'created_by'   => $admin->id,
            ],
            [
                'title'        => 'Nepali Business Networking Night — Brisbane',
                'description'  => 'Connect with Nepali entrepreneurs, business owners, and investors in Brisbane. Guest speaker from ANZ Bank on small business financing. Dinner included.',
                'event_date'   => now()->addDays(26)->setTime(18, 30),
                'venue'        => 'Brisbane Convention Centre',
                'address'      => 'Merivale Street, South Brisbane',
                'city'         => 'Brisbane',
                'organiser'    => 'Nepali Business Association Queensland',
                'category'     => 'business',
                'is_free'      => false,
                'ticket_price' => 45.00,
                'is_approved'  => true,
                'created_by'   => $admin->id,
            ],
            [
                'title'        => 'Nepali Language Class for Children',
                'description'  => 'Weekly Nepali language and culture classes for children aged 5-15. Taught by qualified Nepali teachers. Registration required.',
                'event_date'   => now()->addDays(7)->setTime(10, 0),
                'venue'        => 'Perth Community Centre',
                'address'      => 'Northbridge, Perth',
                'city'         => 'Perth',
                'organiser'    => 'Nepali Community of Western Australia',
                'category'     => 'education',
                'is_free'      => false,
                'ticket_price' => 15.00,
                'is_approved'  => true,
                'created_by'   => $admin->id,
            ],
            [
                'title'        => 'Nepal Startup & Tech Showcase',
                'description'  => 'A showcase of the best Nepali tech startups presenting to Australian investors and technology partners. Networking cocktail reception to follow.',
                'event_date'   => now()->addDays(33)->setTime(9, 30),
                'venue'        => 'Fishburners Innovation Hub',
                'address'      => '11 York Street, Sydney CBD',
                'city'         => 'Sydney',
                'organiser'    => 'Nepal Australia Tech Alliance',
                'category'     => 'business',
                'is_free'      => false,
                'ticket_price' => 30.00,
                'is_approved'  => true,
                'created_by'   => $editor->id,
            ],
            [
                'title'        => 'Teej Festival Celebration',
                'description'  => 'Melbourne\'s Nepali Women\'s Forum invites all women to celebrate Teej at this colourful community event with traditional songs, dance, prayers, and a vrat feast.',
                'event_date'   => now()->addDays(45)->setTime(8, 0),
                'venue'        => 'Footscray Community Centre',
                'address'      => 'Cnr Irving & Geelong Road, Footscray',
                'city'         => 'Melbourne',
                'organiser'    => 'Nepali Women\'s Forum of Victoria',
                'category'     => 'cultural',
                'is_free'      => true,
                'is_approved'  => true,
                'created_by'   => $contributor->id,
            ],
            [
                'title'        => 'Peaks and Plains: Nepali Art Exhibition Tour — Adelaide',
                'description'  => 'The acclaimed Nepali contemporary art exhibition travels to Adelaide after its successful Sydney run. Free entry. Guided tours available on weekends.',
                'event_date'   => now()->addDays(60)->setTime(10, 0),
                'venue'        => 'Art Gallery of South Australia',
                'address'      => 'North Terrace, Adelaide',
                'city'         => 'Adelaide',
                'organiser'    => 'Nepal Australia Cultural Exchange Foundation',
                'category'     => 'cultural',
                'is_free'      => true,
                'is_approved'  => true,
                'created_by'   => $admin->id,
            ],
            [
                'title'        => 'Community Health Fair: Free Screenings & Wellness Check',
                'description'  => 'Free health screenings including blood pressure, diabetes, cholesterol, and mental health consultations. Nepali-speaking health workers available. No appointment needed.',
                'event_date'   => now()->addDays(14)->setTime(9, 0),
                'venue'        => 'Parramatta Town Hall',
                'address'      => 'Darcy Street, Parramatta',
                'city'         => 'Sydney',
                'organiser'    => 'Nepali Health Professionals Association Australia',
                'category'     => 'social',
                'is_free'      => true,
                'is_approved'  => true,
                'created_by'   => $contributor2->id,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        // ── CREATE ADVERTISEMENTS ─────────────────────────────
        $ads = [
            [
                'title'       => 'NepalPay — Send Money Home Instantly',
                'position'    => 'sidebar_top',
                'type'        => 'image',
                'image_url'   => 'https://images.pexels.com/photos/210742/pexels-photo-210742.jpeg?auto=compress&cs=tinysrgb&w=400&h=200&dpr=1',
                'link_url'    => 'https://nepalpay.com.au',
                'alt_text'    => 'NepalPay — Best exchange rates for Nepal remittance from Australia',
                'is_active'   => true,
                'starts_at'   => now()->subMonth()->toDateString(),
                'ends_at'     => now()->addMonths(3)->toDateString(),
                'impressions' => 14520,
                'clicks'      => 832,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Himalayan Kitchen Melbourne — Book a Table',
                'position'    => 'sidebar_bottom',
                'type'        => 'image',
                'image_url'   => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=400&h=200&dpr=1',
                'link_url'    => 'https://himalayankitchen.com.au',
                'alt_text'    => 'Himalayan Kitchen — Authentic Nepali Cuisine in Melbourne CBD',
                'is_active'   => true,
                'starts_at'   => now()->subWeeks(2)->toDateString(),
                'ends_at'     => now()->addMonth()->toDateString(),
                'impressions' => 8341,
                'clicks'      => 621,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Nepal Trekking Company — Everest Base Camp Packages',
                'position'    => 'banner_top',
                'type'        => 'image',
                'image_url'   => 'https://images.pexels.com/photos/2070485/pexels-photo-2070485.jpeg?auto=compress&cs=tinysrgb&w=1200&h=200&dpr=1',
                'link_url'    => 'https://nepaltrekking.com.au',
                'alt_text'    => 'Nepal Trekking Company — Everest Base Camp from $2,100 AUD',
                'is_active'   => true,
                'starts_at'   => now()->subMonth()->toDateString(),
                'ends_at'     => now()->addMonths(6)->toDateString(),
                'impressions' => 22104,
                'clicks'      => 1043,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Australian Migration Services — Registered Migration Agents',
                'position'    => 'article_inline',
                'type'        => 'image',
                'image_url'   => 'https://images.pexels.com/photos/4050291/pexels-photo-4050291.jpeg?auto=compress&cs=tinysrgb&w=800&h=150&dpr=1',
                'link_url'    => 'https://ausmigration.com.au',
                'alt_text'    => 'Australian Migration Services — Expert Visa & PR Advice in Nepali',
                'is_active'   => true,
                'starts_at'   => now()->subWeeks(3)->toDateString(),
                'ends_at'     => now()->addMonths(2)->toDateString(),
                'impressions' => 11289,
                'clicks'      => 504,
                'created_by'  => $admin->id,
            ],
        ];

        foreach ($ads as $ad) {
            Advertisement::create($ad);
        }

        // ── SUMMARY ──────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅  Database seeded successfully!');
        $this->command->info('────────────────────────────────────────────────');
        $this->command->info('  Users:         5   (admin, editor, 2×contributor, reader)');
        $this->command->info('  Tags:          35');
        $this->command->info('  Articles:      26  (25 published + 1 draft)');
        $this->command->info('  Comments:      12');
        $this->command->info('  Events:        9');
        $this->command->info('  Advertisements:4');
        $this->command->info('────────────────────────────────────────────────');
        $this->command->info('  Admin:         admin@nepalnews.com.au     / admin123');
        $this->command->info('  Editor:        editor@nepalnews.com.au    / editor123');
        $this->command->info('  Contributor:   contributor@nepalnews.com.au / contributor123');
        $this->command->info('  Contributor 2: suman@nepalnews.com.au     / suman123');
        $this->command->info('  Reader:        reader@nepalnews.com.au    / reader123');
        $this->command->info('────────────────────────────────────────────────');
        $this->command->info('');
    }
}
