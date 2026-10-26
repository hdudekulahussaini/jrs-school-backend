<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Amphitheatre Open-Air Arena
        $album1 = GalleryAlbum::updateOrCreate(
            ['slug' => 'amphitheatre-open-air-arena'],
            [
                'badge' => 'CAMPUS INFRASTRUCTURE & OPEN AIR ARENA',
                'title' => 'Amphitheatre Open-Air Arena',
                'highlight_text' => 'Open-Air Arena',
                'description' => 'A world-class architectural amphitheatre surrounded by lush manicured greenery, facilitating assemblies, performing arts, and student gatherings.',
                'media_type' => 'image',
                'cover_image' => '/images/beyond/sports.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $album1Items = [
            ['caption' => 'Open-Air Amphitheatre View', 'image_path' => '/images/beyond/sports.jpg'],
            ['caption' => 'Central Tree Seating Arena', 'image_path' => '/images/beyond/arts.jpg'],
            ['caption' => 'Lush Green Outdoor Circle', 'image_path' => '/images/beyond/sports.jpg'],
            ['caption' => 'Classroom', 'image_path' => '/images/journey/primary.png'],
            ['caption' => 'Classroom', 'image_path' => '/images/journey/middle.png'],
            ['caption' => 'Classroom', 'image_path' => '/images/journey/kindergarten.png'],
            ['caption' => 'Classroom', 'image_path' => '/images/journey/primary.png'],
            ['caption' => 'Walk Gallery', 'image_path' => '/images/beyond/arts.jpg'],
            ['caption' => 'Entrance', 'image_path' => '/images/amenities/cta-banner.png'],
            ['caption' => 'Campus', 'image_path' => '/images/amenities/cta-banner.png'],
        ];

        foreach ($album1Items as $idx => $item) {
            GalleryItem::updateOrCreate(
                ['gallery_album_id' => $album1->id, 'sort_order' => $idx + 1],
                [
                    'caption' => $item['caption'],
                    'image_path' => $item['image_path'],
                    'video_url' => null,
                    'is_active' => true,
                ]
            );
        }

        // 2. Feb 17 Annual Day Celebrations 2023-24
        $album2 = GalleryAlbum::updateOrCreate(
            ['slug' => 'feb-17-annual-day-celebrations-2023-24'],
            [
                'badge' => 'ANNUAL DAY HIGHLIGHTS',
                'title' => 'Feb 17 Annual Day Celebrations 2023-24',
                'highlight_text' => 'Annual Day Celebrations 2023-24',
                'description' => 'Capturing the joyous milestones, cultural pageantry, student theatrical performances, and prestigious honors of our Annual Day.',
                'media_type' => 'image',
                'cover_image' => '/images/beyond/arts.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        for ($i = 1; $i <= 8; $i++) {
            GalleryItem::updateOrCreate(
                ['gallery_album_id' => $album2->id, 'sort_order' => $i],
                [
                    'caption' => 'Annual Day Celebration Moment #' . $i,
                    'image_path' => ($i % 2 === 0) ? '/images/beyond/arts.jpg' : '/images/beyond/sports.jpg',
                    'video_url' => null,
                    'is_active' => true,
                ]
            );
        }

        // 3. Feb 11th Annual Day Celebrations
        $album3 = GalleryAlbum::updateOrCreate(
            ['slug' => 'feb-11th-annual-day-celebrations'],
            [
                'badge' => 'ANNUAL DAY CELEBRATIONS',
                'title' => 'Feb 11th Annual Day Celebrations',
                'highlight_text' => 'Annual Day Celebrations',
                'description' => 'A spectacular night of rhythm, dance, musical ensembles, and artistic expression on our grand open auditorium stage.',
                'media_type' => 'image',
                'cover_image' => '/images/beyond/arts.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        for ($i = 1; $i <= 17; $i++) {
            GalleryItem::updateOrCreate(
                ['gallery_album_id' => $album3->id, 'sort_order' => $i],
                [
                    'caption' => 'Stage Performance #' . $i,
                    'image_path' => ($i % 3 === 0) ? '/images/beyond/arts.jpg' : '/images/beyond/sports.jpg',
                    'video_url' => null,
                    'is_active' => true,
                ]
            );
        }

        // 4. Science Experiment & Activities ..
        $album4 = GalleryAlbum::updateOrCreate(
            ['slug' => 'science-experiment-activities'],
            [
                'badge' => 'EXPLORATION & EXPERIMENTS',
                'title' => 'Science Experiment & Activities ..',
                'highlight_text' => 'Activities ..',
                'description' => 'Fostering scientific temper, curiosity, laboratory exploration, martial arts, roller skating, and hands-on skill development.',
                'media_type' => 'image',
                'cover_image' => '/images/beyond/science-lab.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        for ($i = 1; $i <= 10; $i++) {
            GalleryItem::updateOrCreate(
                ['gallery_album_id' => $album4->id, 'sort_order' => $i],
                [
                    'caption' => 'Lab & Activity Session #' . $i,
                    'image_path' => ($i % 2 === 0) ? '/images/beyond/science-lab.jpg' : '/images/beyond/robotics.jpg',
                    'video_url' => null,
                    'is_active' => true,
                ]
            );
        }

        // 5. Create Life Skills (Videos)
        $album5 = GalleryAlbum::updateOrCreate(
            ['slug' => 'create-life-skills'],
            [
                'badge' => 'LIFELONG EXPERIENTIAL LEARNING',
                'title' => 'Create Life Skills',
                'highlight_text' => 'Life Skills',
                'description' => 'Empowering students through leadership workshops, community activities, public speaking, and life skill development.',
                'media_type' => 'video',
                'cover_image' => '/images/beyond/sports.jpg',
                'sort_order' => 5,
                'is_active' => true,
            ]
        );

        GalleryItem::updateOrCreate(
            ['gallery_album_id' => $album5->id, 'sort_order' => 1],
            [
                'caption' => 'Leadership & Team Building Seminar',
                'image_path' => '/images/beyond/sports.jpg',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
            ]
        );

        GalleryItem::updateOrCreate(
            ['gallery_album_id' => $album5->id, 'sort_order' => 2],
            [
                'caption' => 'Public Speaking & Debate Workshop',
                'image_path' => '/images/beyond/arts.jpg',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
            ]
        );

        // 6. Republic Day Celebrations
        $album6 = GalleryAlbum::updateOrCreate(
            ['slug' => 'republic-day-celebrations'],
            [
                'badge' => 'PATRIOTIC & CULTURAL EVENTS',
                'title' => 'Republic Day Celebrations',
                'highlight_text' => 'Celebrations',
                'description' => 'Patriotic fervor, flag hoisting ceremony, cultural dances, parade march, and national pride celebrated at JRS.',
                'media_type' => 'image',
                'cover_image' => '/images/beyond/arts.jpg',
                'sort_order' => 6,
                'is_active' => true,
            ]
        );

        for ($i = 1; $i <= 21; $i++) {
            GalleryItem::updateOrCreate(
                ['gallery_album_id' => $album6->id, 'sort_order' => $i],
                [
                    'caption' => 'Republic Day Parade & Tribute #' . $i,
                    'image_path' => ($i % 2 === 0) ? '/images/beyond/arts.jpg' : '/images/beyond/sports.jpg',
                    'video_url' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
