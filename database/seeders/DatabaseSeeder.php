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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── CREATE USERS ─────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@nepalnews.com.au',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'bio'      => 'Platform administrator for Nepal News Australia.',
            'is_active'=> true,
        ]);

        $editor = User::create([
            'name'     => 'Bikash Thapa',
            'email'    => 'editor@nepalnews.com.au',
            'password' => Hash::make('editor123'),
            'role'     => 'editor',
            'bio'      => 'Senior editor covering Nepal politics and Australia affairs.',
            'is_active'=> true,
        ]);

        $contributor = User::create([
            'name'     => 'Priya Adhikari',
            'email'    => 'contributor@nepalnews.com.au',
            'password' => Hash::make('contributor123'),
            'role'     => 'contributor',
            'bio'      => 'Community reporter based in Melbourne.',
            'is_active'=> true,
        ]);

        $reader = User::create([
            'name'     => 'Rajan Sharma',
            'email'    => 'reader@nepalnews.com.au',
            'password' => Hash::make('reader123'),
            'role'     => 'reader',
            'bio'      => 'Regular reader from Sydney.',
            'is_active'=> true,
        ]);

        // ── CREATE TAGS ──────────────────────────────────────
        $tagData = [
            'Nepal', 'Australia', 'Education', 'Migration', 'Community',
            'Business', 'Sports', 'Culture', 'Politics', 'Economy',
            'Cricket', 'Sydney', 'Melbourne', 'Brisbane', 'Festival',
            'Visa', 'Health', 'Technology', 'Climate', 'Dashain',
        ];
        $tags = [];
        foreach ($tagData as $name) {
            $tags[$name] = Tag::create(['name' => $name, 'slug' => Str::slug($name)]);
        }

        // ── CREATE ARTICLES ──────────────────────────────────
        $articles = [
            [
                'title'         => 'Nepal and Australia Sign Historic Education Partnership Worth $500 Million',
                'summary'       => 'Prime ministers of both nations gathered in Canberra to finalise a landmark deal covering universities, scholarships, and research collaboration.',
                'content'       => '<p>In a historic summit held at Parliament House in Canberra, the Prime Ministers of Nepal and Australia signed a comprehensive education partnership agreement worth $500 million, marking a new era in bilateral relations between the two nations.</p><p>The agreement covers a wide range of areas including university partnerships, scholarship programs, and joint research initiatives. Under the deal, over 5,000 Nepali students will receive full scholarships to study at Australian universities over the next decade.</p><p>Speaking at the signing ceremony, the Australian Prime Minister emphasized the importance of people-to-people connections between the two countries. "This partnership is not just about education — it is about building bridges between our communities and investing in the future leaders of both nations," he said.</p><p>The Nepali Prime Minister welcomed the agreement, noting that it would help address the brain drain issue Nepal has been facing for decades. "Our talented young people will now have the opportunity to receive world-class education and return home with the skills to transform Nepal," he said.</p><p>The partnership also includes provisions for joint research in areas such as clean energy, sustainable agriculture, and disaster management — all critical priorities for Nepal given its vulnerability to natural disasters and climate change.</p>',
                'category'      => 'australia',
                'featured_image'=> 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => true,
                'is_breaking'   => true,
                'views'         => 4821,
                'status'        => 'published',
                'author_id'     => $editor->id,
                'tags'          => ['Nepal', 'Australia', 'Education'],
                'published_at'  => now()->subHours(2),
            ],
            [
                'title'         => "Nepal's GDP Growth Hits 6.8 Percent — Highest in a Decade",
                'summary'       => 'The International Monetary Fund credits remittances from abroad and the growing IT sector as key drivers of Nepal\'s economic resurgence.',
                'content'       => '<p>The International Monetary Fund has confirmed that Nepal achieved 6.8% GDP growth in the 2025-26 fiscal year, the highest recorded growth rate in a decade. The achievement comes despite global economic headwinds and marks a significant milestone in Nepal\'s post-pandemic recovery.</p><p>Remittances from Nepalese workers abroad, which account for approximately 26% of the national GDP, continued to be the primary driver of economic growth. Australia emerged as one of the top five source countries for remittances, reflecting the growing Nepali diaspora in cities like Sydney, Melbourne, and Brisbane.</p><p>The IT sector has also emerged as a significant contributor, with exports of software services growing by 45% year-on-year. Several Nepali tech startups have secured international contracts, and the government\'s IT park initiative in Kathmandu has attracted over 200 companies.</p><p>Tourism, which had been severely impacted by the COVID-19 pandemic, also showed strong recovery with over 1.2 million international visitors in 2025-26, surpassing pre-pandemic levels for the first time.</p>',
                'category'      => 'nepal',
                'featured_image'=> 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => true,
                'is_breaking'   => false,
                'views'         => 3267,
                'status'        => 'published',
                'author_id'     => $editor->id,
                'tags'          => ['Nepal', 'Economy'],
                'published_at'  => now()->subHours(5),
            ],
            [
                'title'         => 'Sydney Welcomes Record 12,000 Nepali Migrants in First Quarter of 2026',
                'summary'       => 'New immigration data reveals unprecedented growth in the Nepali-Australian population, driven by skilled worker visas and family reunification programs.',
                'content'       => '<p>New data released by the Australian Bureau of Statistics reveals that over 12,000 Nepalese-born migrants settled in Sydney during the first quarter of 2026 alone, making it the highest quarterly migration figure on record from Nepal to Australia.</p><p>The surge is primarily driven by the skilled worker visa program, with nursing, aged care, IT, and construction emerging as the top occupational categories. The federal government\'s regional migration incentives have also encouraged a significant number of Nepali migrants to settle in outer Sydney suburbs and regional New South Wales.</p><p>The Nepalese-Australian community now numbers over 130,000 across the country, with Sydney (42%), Melbourne (31%), Brisbane (12%), Perth (8%), and Adelaide (7%) being the primary settlement cities.</p><p>Community organizations such as the Non-Resident Nepali Association of Australia (NRNA Australia) have welcomed the growth but called for better support services for new arrivals. "We need more Nepali-speaking settlement workers, legal aid services, and mental health support," said NRNA Australia president.</p>',
                'category'      => 'australia',
                'featured_image'=> 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => false,
                'views'         => 2914,
                'status'        => 'published',
                'author_id'     => $editor->id,
                'tags'          => ['Australia', 'Migration', 'Sydney'],
                'published_at'  => now()->subHours(8),
            ],
            [
                'title'         => 'Melbourne Nepali Community Hosts Largest Ever Dashain Festival',
                'summary'       => 'Over 5,000 community members attended the two-day celebration at Federation Square, featuring cultural performances, traditional food, and Tika ceremonies.',
                'content'       => '<p>Melbourne\'s vibrant Nepali community came together in record numbers for the annual Dashain festival at Federation Square, with over 5,000 attendees over two days making it the largest Dashain celebration in Australian history.</p><p>The event, organized by the Nepalese Community of Victoria (NCV), featured traditional cultural performances including dance, music, and theatrical presentations showcasing Nepal\'s rich cultural heritage. A dedicated food court offered authentic Nepali cuisine including sel roti, momo, dhido, and gundruk.</p><p>The highlight of the festival was the traditional Tika ceremony on the tenth day of Dashain, where elders blessed younger family and community members with a mixture of yogurt, rice, and red tika powder while offering them jamara (sacred barley grass).</p><p>"Dashain is more than just a festival — it is a reminder of who we are and where we come from. Celebrating it here in Melbourne, thousands of kilometres from home, makes it even more meaningful," said festival director Sunita Karmacharya.</p><p>The festival also featured a marketplace with Nepali handicrafts, artwork, and cultural products, providing a platform for Nepali artisans and small businesses in the community.</p>',
                'category'      => 'community',
                'featured_image'=> 'https://images.unsplash.com/photo-1514395462725-fb4566210144?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => true,
                'is_breaking'   => false,
                'views'         => 5102,
                'status'        => 'published',
                'author_id'     => $contributor->id,
                'tags'          => ['Community', 'Dashain', 'Melbourne', 'Festival', 'Culture'],
                'published_at'  => now()->subDay(),
            ],
            [
                'title'         => 'Nepali Cricket Team Qualifies for 2027 ODI World Cup',
                'summary'       => 'Nepal secured their spot in the 2027 ICC Cricket World Cup after a thrilling five-wicket victory over the UAE in the qualification tournament in Namibia.',
                'content'       => '<p>Nepal\'s national cricket team has made history by qualifying for the 2027 ICC Cricket World Cup, their first-ever appearance at the sport\'s premier 50-over tournament. The team secured their spot with a thrilling five-wicket victory over the United Arab Emirates in the final qualifying match played in Windhoek, Namibia.</p><p>Captain Rohit Paudel, who hit an unbeaten 87 runs off 94 balls in the chase, dedicated the victory to all Nepali cricket fans around the world. "This is a historic moment for Nepal cricket. We have been working towards this for years, and today we have achieved it," he said.</p><p>The Nepali-Australian community celebrated the historic qualification with spontaneous gatherings in Sydney, Melbourne, and Brisbane. The Nepal Australia Cricket Association announced plans for a special charity match between Nepal and an Australian XI to celebrate the qualification.</p><p>Nepal will face cricket powerhouses including India, Pakistan, Australia, and England in the group stage of the World Cup to be held in South Africa and Zimbabwe.</p>',
                'category'      => 'sports',
                'featured_image'=> 'https://images.unsplash.com/photo-1540747913346-19212a4b423a?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => true,
                'views'         => 7638,
                'status'        => 'published',
                'author_id'     => $editor->id,
                'tags'          => ['Sports', 'Cricket', 'Nepal'],
                'published_at'  => now()->subDays(2),
            ],
            [
                'title'         => 'Nepali Women\'s Association Launches Free Legal Aid Service in Brisbane',
                'summary'       => 'The newly launched service provides free legal consultations for visa issues, workplace rights, and domestic matters to Nepali community members across Queensland.',
                'content'       => '<p>The Nepali Women\'s Association of Queensland launched a groundbreaking free legal aid service in Brisbane this week, providing access to legal consultations for Nepali community members across Queensland who cannot afford private legal services.</p><p>The service, which is funded through a combination of government grants and community donations, will offer advice on immigration and visa matters, workplace rights and employment disputes, family law and domestic violence, tenancy and housing issues, and general consumer rights.</p><p>Registered migration agents and volunteer lawyers will be available for consultations every Saturday at the Nepali Community Centre in Fortitude Valley, Brisbane. Nepali-speaking interpreters will be available for all sessions.</p><p>"Many Nepali migrants are not aware of their rights or are too afraid to seek help due to language barriers or concerns about their visa status. This service aims to change that," said association president Mina Gurung.</p>',
                'category'      => 'community',
                'featured_image'=> 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => false,
                'views'         => 1893,
                'status'        => 'published',
                'author_id'     => $contributor->id,
                'tags'          => ['Community', 'Brisbane', 'Visa'],
                'published_at'  => now()->subDays(3),
            ],
            [
                'title'         => 'Australia Announces New Visa Pathways for Nepali Skilled Workers',
                'summary'       => 'The Australian government has announced expanded visa pathways specifically targeting skilled workers from Nepal in nursing, aged care, IT, and construction sectors.',
                'content'       => '<p>The Australian government has announced a significant expansion of visa pathways for skilled workers from Nepal, in response to critical shortages in key industries including nursing, aged care, information technology, and construction.</p><p>The new measures include a dedicated fast-track processing system for Nepali applicants in critical shortage occupations, an increase in the annual quota for Nepali workers under the Skilled Worker Program, streamlined skills recognition for Nepali qualifications, and a new regional sponsorship pathway specifically for Nepali workers willing to settle in regional and rural Australia.</p><p>Immigration Minister Tony Burke said the measures reflect Australia\'s commitment to filling critical workforce gaps while supporting legal migration pathways. "Nepal has a highly skilled and hardworking workforce, and we want to welcome more Nepali professionals to contribute to Australia\'s economy and communities," he said.</p>',
                'category'      => 'australia',
                'featured_image'=> 'https://images.unsplash.com/photo-1529528744093-6f8abeee511d?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => false,
                'views'         => 2341,
                'status'        => 'published',
                'author_id'     => $editor->id,
                'tags'          => ['Australia', 'Visa', 'Migration'],
                'published_at'  => now()->subDays(4),
            ],
            [
                'title'         => 'UNESCO Adds Patan Durbar Square to Expanded World Heritage Protection',
                'summary'       => 'The medieval city of Patan\'s historic Durbar Square complex receives expanded protections following renewed conservation efforts by Nepali authorities.',
                'content'       => '<p>UNESCO has announced expanded World Heritage protections for Patan Durbar Square, the medieval city complex located in the Kathmandu Valley, following a successful conservation effort by the Nepali government and international preservation organizations.</p><p>The expansion covers newly documented temples, courtyards, and traditional Newari architecture that were previously outside the protected boundary. The decision was made at the UNESCO World Heritage Committee meeting in New Delhi.</p><p>Patan, also known as Lalitpur, is one of the three ancient cities in the Kathmandu Valley and contains some of the finest examples of traditional Newari architecture in the world. The Durbar Square houses over 136 courtyards and 55 major temples.</p><p>The Nepali-Australian community has expressed pride at the recognition, with cultural organizations planning special events to raise awareness about Nepal\'s rich cultural heritage among the diaspora.</p>',
                'category'      => 'culture',
                'featured_image'=> 'https://images.unsplash.com/photo-1572912664826-4d0eb37aded1?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => false,
                'views'         => 1654,
                'status'        => 'published',
                'author_id'     => $contributor->id,
                'tags'          => ['Culture', 'Nepal'],
                'published_at'  => now()->subDays(5),
            ],
            [
                'title'         => 'Opinion: Nepal\'s Federal System Is Maturing — Slowly But Surely',
                'summary'       => 'Seven years into federalism, Nepal\'s provinces are beginning to demonstrate fiscal independence and policy innovation that seemed impossible in 2017.',
                'content'       => '<p>When Nepal adopted its new constitution in 2015 and transitioned to a federal democratic republic with three tiers of government — federal, provincial, and local — the skeptics were many. The logistics of dividing a historically centralized state into seven provinces, 753 municipalities, and over 6,000 ward offices seemed overwhelming.</p><p>Seven years on, the picture is more nuanced than either the optimists or pessimists predicted. Yes, federalism has been messy, expensive, and at times chaotic. But there are also genuine signs of progress that deserve recognition.</p><p>Provincial governments in Bagmati and Gandaki are now designing their own health and education policies, with measurably different outcomes from the federal baseline. Karnali Province, historically the most marginalized, has implemented innovative social protection programs that have reduced extreme poverty.</p><p>Local governments have been particularly active, with hundreds of municipalities now running their own agricultural extension services, building local roads, and managing primary schools in ways that simply did not happen under the old unitary system.</p>',
                'category'      => 'opinion',
                'featured_image'=> 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => false,
                'views'         => 987,
                'status'        => 'published',
                'author_id'     => $editor->id,
                'tags'          => ['Nepal', 'Politics'],
                'published_at'  => now()->subDays(6),
            ],
            [
                'title'         => 'New Student Visa Rules Favour Nepali Applicants With Regional University Offers',
                'summary'       => 'Changes to the student visa framework prioritise regional campus placements, opening new opportunities for thousands of Nepali students annually.',
                'content'       => '<p>The Australian government has announced significant changes to its student visa framework that will particularly benefit Nepali students who accept offers from regional university campuses and vocational training colleges.</p><p>Under the new rules, Nepali students accepting offers from universities in regional areas (outside Sydney, Melbourne, and Brisbane) will receive priority processing, reduced visa fees, and access to the Regional Graduate Visa — a pathway to permanent residency after just two years of work in regional Australia.</p><p>The changes are expected to benefit up to 15,000 Nepali students annually and will help address workforce shortages in regional Australia while providing Nepali graduates with a clearer pathway to permanent residency.</p>',
                'category'      => 'australia',
                'featured_image'=> 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=800&q=80&auto=format&fit=crop',
                'is_featured'   => false,
                'is_breaking'   => false,
                'views'         => 1432,
                'status'        => 'published',
                'author_id'     => $contributor->id,
                'tags'          => ['Australia', 'Education', 'Visa'],
                'published_at'  => now()->subDays(7),
            ],
        ];

        foreach ($articles as $data) {
            $tagNames = $data['tags'];
            unset($data['tags']);
            $article = Article::create($data);
            $tagIds = [];
            foreach ($tagNames as $name) {
                if (isset($tags[$name])) {
                    $tagIds[] = $tags[$name]->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        // ── CREATE EVENTS ────────────────────────────────────
        $events = [
            [
                'title'       => 'Baisakh New Year Celebration 2081 BS',
                'description' => 'Join the Nepalese community of NSW for the traditional Nepali New Year celebration featuring cultural performances, food stalls, music, and Tika ceremony. All are welcome!',
                'event_date'  => now()->addDays(5)->setTime(10, 0),
                'venue'       => 'Tumbalong Park',
                'address'     => 'Darling Harbour',
                'city'        => 'Sydney',
                'organiser'   => 'Nepalese Society of NSW',
                'category'    => 'cultural',
                'is_free'     => true,
                'is_approved' => true,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Free Visa & Immigration Seminar',
                'description' => 'Registered migration agents will answer questions on skilled migration, permanent residency applications, partner visas, and family reunification. Nepali interpreters available.',
                'event_date'  => now()->addDays(12)->setTime(13, 0),
                'venue'       => 'Melbourne Town Hall',
                'address'     => 'Swanston Street, Melbourne CBD',
                'city'        => 'Melbourne',
                'organiser'   => 'Nepal Australia Friendship Society',
                'category'    => 'education',
                'is_free'     => true,
                'is_approved' => true,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Nepal Australia Cricket Friendly Match',
                'description' => 'Annual cricket match between the Nepali Community XI and Australian Multicultural XI. Proceeds go to the Nepal Earthquake Relief Fund. BBQ and refreshments provided.',
                'event_date'  => now()->addDays(19)->setTime(9, 0),
                'venue'       => 'Pratten Park Cricket Ground',
                'address'     => 'Ashfield, NSW',
                'city'        => 'Sydney',
                'organiser'   => 'Nepal Cricket Club Sydney',
                'category'    => 'sports',
                'is_free'     => true,
                'is_approved' => true,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Nepali Business Networking Night',
                'description' => 'Connect with Nepali entrepreneurs, business owners, and investors in Brisbane. Guest speaker from ANZ Bank on small business financing. Dinner included.',
                'event_date'  => now()->addDays(26)->setTime(18, 30),
                'venue'       => 'Brisbane Convention Centre',
                'address'     => 'Merivale Street, South Brisbane',
                'city'        => 'Brisbane',
                'organiser'   => 'Nepali Business Association Queensland',
                'category'    => 'business',
                'is_free'     => false,
                'ticket_price'=> 45.00,
                'is_approved' => true,
                'created_by'  => $admin->id,
            ],
            [
                'title'       => 'Nepali Language Class for Children',
                'description' => 'Weekly Nepali language and culture classes for children aged 5-15. Taught by qualified Nepali teachers. Registration required.',
                'event_date'  => now()->addDays(7)->setTime(10, 0),
                'venue'       => 'Perth Community Centre',
                'address'     => 'Northbridge, Perth',
                'city'        => 'Perth',
                'organiser'   => 'Nepali Community of Western Australia',
                'category'    => 'education',
                'is_free'     => false,
                'ticket_price'=> 15.00,
                'is_approved' => true,
                'created_by'  => $admin->id,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('─────────────────────────────────────');
        $this->command->info('Admin:       admin@nepalnews.com.au / admin123');
        $this->command->info('Editor:      editor@nepalnews.com.au / editor123');
        $this->command->info('Contributor: contributor@nepalnews.com.au / contributor123');
        $this->command->info('Reader:      reader@nepalnews.com.au / reader123');
        $this->command->info('─────────────────────────────────────');
    }
}
