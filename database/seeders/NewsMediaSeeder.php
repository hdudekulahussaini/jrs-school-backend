<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsMedia;

class NewsMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            // Featured News Cards (Section 1: Our Achievements In The News)
            [
                'title' => 'విద్యార్థుల నైపుణ్యతను గుర్తించి ప్రోత్సహించాలి - సినీ హీరో, డైరెక్టర్ విశ్వక్ సేన్',
                'english_title' => '"Identify and Encourage Students\' Innate Talents" — Actor & Director Vishwak Sen at JRS Annual Day',
                'newspaper_name' => 'మన తెలంగాణ (Mana Telangana)',
                'location' => 'Hyderabad',
                'published_date' => '2023-02-15',
                'description' => 'Actor and Director Vishwak Sen graced the JRS International School Annual Day Celebrations as the Chief Guest, inspiring young scholars to chase their creative passions and academic milestones.',
                'image_path' => '/images/beyond/arts.jpg',
                'article_url' => null,
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'విద్యార్థుల నైపుణ్యతను గుర్తించి ప్రోత్సహించాలి - ప్రముఖ డైరెక్టర్ విశ్వక్...',
                'english_title' => '"Identify and Encourage Student Talents" — Director Vishwak Sen at JRS International School',
                'newspaper_name' => 'సూర్య (Surya Daily)',
                'location' => 'Ghatkesar',
                'published_date' => '2023-02-14',
                'description' => 'Coverage of the grand annual cultural showcase at JRS, highlighting innovative robotics projects, athletic displays, and performing arts by students.',
                'image_path' => '/images/beyond/sports.jpg',
                'article_url' => null,
                'is_featured' => true,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'పాఠశాలలో సాంస్కృతిక కార్యక్రమాలు - గణతంత్ర దినోత్సవ వేడుకలు',
                'english_title' => 'Patriotic Celebrations & Cultural Performances on Republic Day',
                'newspaper_name' => 'వార్త (Vaartha Daily)',
                'location' => 'Ghatkesar',
                'published_date' => '2023-01-28',
                'description' => 'Vaartha Daily press report covering the 74th Republic Day ceremonies with March Past parades, acrobatic human pyramids, and patriotic choreography.',
                'image_path' => '/images/beyond/robotics.jpg',
                'article_url' => null,
                'is_featured' => true,
                'sort_order' => 3,
                'is_active' => true,
            ],

            // Latest News Cards (Section 2: Latest News / Press Coverage)
            [
                'title' => 'విద్యార్థుల నైపుణ్యతను గుర్తించి ప్రోత్సహించాలి - ...',
                'english_title' => 'Empowering Student Talents with Awards and Recognition',
                'newspaper_name' => 'సూర్య (Surya Daily)',
                'location' => 'Ghatkesar',
                'published_date' => '2023-02-14',
                'description' => 'విద్యార్థులలో దాగి ఉన్న కళానైపుణ్యాలను గుర్తించి ఆ దిశగా ప్రోత్సాహకాలు అందించినప్పుడే ఉన్నత స్థాయికి చేరుకుంటారని సినీ హీరో విశ్వక్ సేన్ పేర్కొన్నారు.',
                'image_path' => '/images/beyond/sports.jpg',
                'article_url' => null,
                'is_featured' => false,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'పాఠశాలలో సాంస్కృతిక కార్యక్రమాలు - గణతంత్ర...',
                'english_title' => 'Grand 74th Republic Day Celebrations at JRS School',
                'newspaper_name' => 'వార్త (Vaartha Daily)',
                'location' => 'Ghatkesar',
                'published_date' => '2023-01-28',
                'description' => 'నారపల్లిలోని జేఆర్ఎస్ ఇంటర్నేషనల్ స్కూల్లో ఘనంగా 74వ గణతంత్ర దినోత్సవ వేడుకలు ఘనంగా జరిగాయి. విద్యార్థుల చేతుల మీదుగా సంస్కృతి నృత్యాలు ప్రదర్శించారు.',
                'image_path' => '/images/beyond/arts.jpg',
                'article_url' => null,
                'is_featured' => false,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'నారపల్లి జేఆర్ఎస్ ఇంటర్నేషనల్ పాఠశాల...',
                'english_title' => 'Cultural Festivities and Patriotic Flag Hoisting Ceremony',
                'newspaper_name' => 'ఆంధ్రప్రభ (Andhra Prabha)',
                'location' => 'Ranga Reddy',
                'published_date' => '2023-01-28',
                'description' => 'మేడ్చల్ జిల్లా, బోడారం మున్సిపల్ నారపల్లిలోని జేఆర్ఎస్ ఇంటర్నేషనల్ పాఠశాలలో 74వ గణతంత్ర దినోత్సవం ఘనంగా నిర్వహించారు.',
                'image_path' => '/images/beyond/robotics.jpg',
                'article_url' => null,
                'is_featured' => false,
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'విద్యార్థులు రాజ్యాంగ స్ఫూర్తిని...',
                'english_title' => 'Constitutional Values and Youth Leadership Seminar',
                'newspaper_name' => 'మన తెలంగాణ (Mana Telangana)',
                'location' => 'Medchal',
                'published_date' => '2023-01-28',
                'description' => 'విద్యార్థులు రాజ్యాంగ స్ఫూర్తితో గణతంత్ర దినోత్సవం వేడుకలు జరుపుకోవడం హర్షనీయమని మేడ్చల్ ప్రముఖులు కొనియాడారు.',
                'image_path' => '/images/beyond/science-lab.jpg',
                'article_url' => null,
                'is_featured' => false,
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($articles as $article) {
            NewsMedia::updateOrCreate(
                [
                    'newspaper_name' => $article['newspaper_name'],
                    'published_date' => $article['published_date'],
                    'sort_order' => $article['sort_order'],
                ],
                $article
            );
        }
    }
}
