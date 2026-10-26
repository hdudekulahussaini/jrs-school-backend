<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger API Documentation | JRS International School</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #fafafa;
        }
        .header-bar {
            background: #031c3f;
            color: white;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #e31e24;
        }
        .header-bar h1 {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .header-bar p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #94a3b8;
        }
        .back-link {
            background: #e31e24;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .back-link:hover {
            opacity: 0.9;
        }
        .swagger-ui .topbar { display: none; }
    </style>
</head>
<body>
    <div class="header-bar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="background: white; border-radius: 8px; padding: 4px 10px; display: flex; align-items: center;">
                <img src="{{ asset('images/logo.png') }}" alt="JRS Logo" style="height: 32px; width: auto; object-fit: contain;">
            </div>
            <div>
                <h1>JRS International School — Swagger API Docs</h1>
                <p>Interactive OpenAPI 3.0 Documentation for News Ticker & Web Services</p>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="back-link">&larr; Back to Admin Panel</a>
    </div>

    <div id="swagger-ui"></div>

    <!-- Swagger UI JS -->
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const spec = {
                openapi: "3.0.3",
                info: {
                    title: "JRS International School API",
                    description: "RESTful API endpoints for JRS School React Frontend (https://jrs-school.vercel.app/) and Backend Dashboard.",
                    version: "1.0.0",
                    contact: {
                        name: "JRS International School Dev Team",
                        url: "https://jrs-school.vercel.app"
                    }
                },
                servers: [
                    {
                        url: "{{ url('/api') }}",
                        description: "Current Application API Server"
                    }
                ],
                paths: {
                    "/news-ticker": {
                        get: {
                            tags: ["News Ticker (Frontend)"],
                            summary: "Get active marquee ticker announcements for React site",
                            description: "Returns all active announcements sorted by sort_order for the homepage top red marquee banner.",
                            responses: {
                                "200": {
                                    description: "List of active news tickers",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 2,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Admissions Open for Academic Year 2026–2027 (Nursery to Grade XII) — Enroll Today!",
                                                        badge_text: "NEWS",
                                                        link_url: "https://jrs-school.vercel.app/admissions",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/hero-slider": {
                        get: {
                            tags: ["Hero Slider (Frontend)"],
                            summary: "Get active hero slider slides for React homepage banner",
                            description: "Returns all published hero banner slides sorted by sort_order including titles, gold highlights, button links, and background photos.",
                            responses: {
                                "200": {
                                    description: "List of active hero slides",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 2,
                                                data: [
                                                    {
                                                        id: 1,
                                                        badge_title: "NURTURING BRIGHT MINDS • BUILDING A BETTER TOMORROW",
                                                        title: "Empowering",
                                                        highlight_text: "Future Leaders",
                                                        description: "At JRS International School, we inspire curiosity, creativity and compassion. A place where every child discovers their potential and shines in their own unique way.",
                                                        primary_button_text: "Admissions 2026-27",
                                                        secondary_button_text: "Take a Virtual Tour",
                                                        secondary_button_url: "https://jrs-school.vercel.app/#tour",
                                                        image_path: "https://images.unsplash.com/photo-1580582932707-520aed937b7b",
                                                        image_full_url: "https://images.unsplash.com/photo-1580582932707-520aed937b7b",
                                                        contact_phone: "+91 91574 04321",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/sliders": {
                        get: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "List all hero slides",
                            parameters: [
                                {
                                    name: "active",
                                    in: "query",
                                    description: "Filter by status (true or false)",
                                    required: false,
                                    schema: { type: "boolean" }
                                }
                            ],
                            responses: {
                                "200": { description: "Full list of slides" }
                            }
                        },
                        post: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Create a new hero slide",
                            requestBody: {
                                required: true,
                                content: {
                                    "multipart/form-data": {
                                        schema: {
                                            type: "object",
                                            properties: {
                                                title: { type: "string", example: "Empowering" },
                                                highlight_text: { type: "string", example: "Future Leaders" },
                                                badge_title: { type: "string", example: "NURTURING BRIGHT MINDS" },
                                                description: { type: "string" },
                                                primary_button_text: { type: "string", example: "Admissions 2026-27" },
                                                secondary_button_text: { type: "string", example: "Take a Virtual Tour" },
                                                secondary_button_url: { type: "string" },
                                                image: { type: "string", format: "binary" },
                                                image_url: { type: "string" },
                                                contact_phone: { type: "string", example: "+91 91574 04321" },
                                                sort_order: { type: "integer", example: 1 },
                                                is_active: { type: "boolean", example: true }
                                            },
                                            required: ["title"]
                                        }
                                    }
                                }
                            },
                            responses: {
                                "201": { description: "Hero slide created successfully" }
                            }
                        }
                    },
                    "/sliders/{id}": {
                        get: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Get specific slide by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Slide details" } }
                        },
                        delete: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Delete a slide by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Slide deleted successfully" } }
                        }
                    },
                    "/sliders/{id}/toggle": {
                        patch: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Toggle active status of a slide",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Status toggled" } }
                        }
                    },
                    "/features": {
                        get: {
                            tags: ["Key Features (Frontend)"],
                            summary: "Get active homepage Key Features / value cards",
                            description: "Returns the 5 value cards appearing right under the Hero Slider on the homepage (CBSE Curriculum, Holistic Development, Experienced Faculty, Safe & Inclusive, Modern Infrastructure). Also accessible via /home-features.",
                            responses: {
                                "200": {
                                    description: "List of active key features",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active home features fetched successfully",
                                                total: 5,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "CBSE Curriculum",
                                                        subtitle: "Strong academic foundation",
                                                        icon: "graduation-cap",
                                                        icon_svg: null,
                                                        bg_color: "#e31e24",
                                                        text_color: "#ffffff",
                                                        link_url: null,
                                                        sort_order: 1,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 2,
                                                        title: "Holistic Development",
                                                        subtitle: "Academic, co-curricular & life skills",
                                                        icon: "sparkles",
                                                        icon_svg: null,
                                                        bg_color: "#059669",
                                                        text_color: "#ffffff",
                                                        link_url: null,
                                                        sort_order: 2,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/features/{id}": {
                        get: {
                            tags: ["Key Features (Frontend)"],
                            summary: "Get specific Key Feature details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Feature details" } }
                        }
                    },
                    "/facilities": {
                        get: {
                            tags: ["Facilities (Public Frontend)"],
                            summary: "Get active school facilities / infrastructure cards",
                            description: "Returns all active facilities sorted by sort_order for the 'World-Class Infrastructure' section on the frontend.",
                            responses: {
                                "200": {
                                    description: "List of active facilities",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active facilities fetched successfully",
                                                total: 5,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Smart Classrooms",
                                                        description: "Modern and interactive learning spaces",
                                                        image_path: "uploads/facilities/smart_classrooms.jpg",
                                                        image_url: "http://127.0.0.1:8000/uploads/facilities/smart_classrooms.jpg",
                                                        icon: "monitor",
                                                        theme_color: "navy",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/vision-mission": {
                        get: {
                            tags: ["Vision & Mission (Frontend)"],
                            summary: "Get active Vision & Mission cards for React site",
                            description: "Returns all active Vision, Mission, and Core Values cards sorted by sort_order for the JRS International School React frontend.",
                            responses: {
                                "200": {
                                    description: "List of active Vision & Mission cards retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    count: { type: "integer", example: 2 },
                                                    data: {
                                                        type: "array",
                                                        items: {
                                                            type: "object",
                                                            properties: {
                                                                id: { type: "integer", example: 1 },
                                                                type: { type: "string", enum: ["vision", "mission", "values"], example: "vision" },
                                                                eyebrow: { type: "string", example: "OUR GUIDING STAR" },
                                                                title: { type: "string", example: "Vision for Global Excellence" },
                                                                description: { type: "string", example: "To be a premier institution inspiring students to achieve academic brilliance, ethical integrity, and global citizenship." },
                                                                icon: { type: "string", nullable: true, example: "sparkles" },
                                                                image_url: { type: "string", nullable: true, example: "http://127.0.0.1:8000/uploads/vision/vision_1.jpg" },
                                                                sort_order: { type: "integer", example: 1 },
                                                                is_active: { type: "boolean", example: true }
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                count: 2,
                                                data: [
                                                    {
                                                        id: 1,
                                                        type: "vision",
                                                        eyebrow: "OUR GUIDING STAR",
                                                        title: "Vision for Global Excellence",
                                                        description: "To be a premier institution inspiring students to achieve academic brilliance, ethical integrity, and global citizenship.",
                                                        icon: "sparkles",
                                                        image_url: "http://127.0.0.1:8000/uploads/vision/vision_1.jpg",
                                                        sort_order: 1,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 2,
                                                        type: "mission",
                                                        eyebrow: "OUR CORE MISSION",
                                                        title: "Mission to Empower Leaders",
                                                        description: "Nurturing intellectual curiosity, character, and lifelong learning through an innovative CBSE & international curriculum.",
                                                        icon: "target",
                                                        image_url: "http://127.0.0.1:8000/uploads/vision/mission_1.jpg",
                                                        sort_order: 2,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/about": {
                        get: {
                            tags: ["About JRS (Frontend)"],
                            summary: "Get active About JRS School section content",
                            description: "Returns the active About section including tagline, headline, descriptions, badges, image URLs, and campus video tour link.",
                            responses: {
                                "200": {
                                    description: "Active About section retrieved successfully",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                data: {
                                                    id: 1,
                                                    tagline: "NURTURING FUTURE LEADERS SINCE 2010",
                                                    title: "Welcome to JRS International School",
                                                    title_highlight: "Where Excellence Meets Character",
                                                    description_p1: "JRS International School is committed to delivering world-class holistic education...",
                                                    description_p2: "Our campus features modern smart classrooms, specialized science and computer laboratories...",
                                                    button_text: "Discover Campus Life",
                                                    button_link: "https://jrs-school.vercel.app/about",
                                                    image_1_url: "http://127.0.0.1:8000/uploads/about/campus_1.jpg",
                                                    image_2_url: "http://127.0.0.1:8000/uploads/about/students_1.jpg",
                                                    video_title: "Campus Tour & Life at JRS",
                                                    video_url: "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
                                                    is_active: true
                                                }
                                            }
                                        }
                                    }
                                },
                                "404": {
                                    description: "No active About section found",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: false,
                                                message: "No active About section content found",
                                                data: null
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/academic-programs": {
                        get: {
                            tags: ["Academic Programs (Frontend)"],
                            summary: "Get active academic stage cards for React homepage",
                            description: "Returns all active academic programmes (Pre-Primary, Primary School, Middle School, etc.) sorted by sort_order. Matches the exact curriculum cards on the homepage with stage badges, titles, subtitles, checklists, and images.",
                            responses: {
                                "200": {
                                    description: "List of active academic programmes",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active academic programs fetched successfully",
                                                total: 3,
                                                data: [
                                                    {
                                                        id: 1,
                                                        stage_badge: "STAGE 01 • EARLY YEARS",
                                                        title: "Pre-Primary",
                                                        slug: "pre-primary",
                                                        subtitle: "NURSERY, LKG & UKG",
                                                        description: "Feel grounded and supported in an environment where early learners are encouraged to participate, share ideas, explore phonics, and build confidence through play.",
                                                        highlights: [
                                                            "Phonics-based English language & early communication",
                                                            "Montessori-inspired sensorial and tactile activities",
                                                            "Early numeracy, number sense and playful logical thinking"
                                                        ],
                                                        image: "images/programs/pre-primary.jpg",
                                                        image_url: "http://127.0.0.1:8000/images/programs/pre-primary.jpg",
                                                        button_text: "Explore More",
                                                        button_link: "https://jrs-school.vercel.app/academics/pre-primary",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/admin/programs": {
                        get: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "List all academic programmes with optional active filter",
                            parameters: [
                                {
                                    name: "active",
                                    in: "query",
                                    description: "Filter by status (true or false)",
                                    required: false,
                                    schema: { type: "boolean" }
                                }
                            ],
                            responses: { "200": { description: "Full list of academic programmes" } }
                        },
                        post: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Create a new academic stage programme",
                            requestBody: {
                                required: true,
                                content: {
                                    "multipart/form-data": {
                                        schema: {
                                            type: "object",
                                            properties: {
                                                stage_badge: { type: "string", example: "STAGE 01 • EARLY YEARS" },
                                                title: { type: "string", example: "Pre-Primary" },
                                                subtitle: { type: "string", example: "NURSERY, LKG & UKG" },
                                                description: { type: "string" },
                                                highlights: {
                                                    type: "array",
                                                    items: { type: "string" },
                                                    example: ["Phonics-based English language", "Montessori activities"]
                                                },
                                                image: { type: "string", format: "binary" },
                                                image_url: { type: "string" },
                                                button_text: { type: "string", example: "Explore More" },
                                                button_link: { type: "string" },
                                                sort_order: { type: "integer", example: 1 },
                                                is_active: { type: "boolean", example: true }
                                            },
                                            required: ["title"]
                                        }
                                    }
                                }
                            },
                            responses: { "201": { description: "Programme created successfully" } }
                        }
                    },
                    "/admin/programs/{id}": {
                        get: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Get specific academic programme details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Academic programme details" } }
                        },
                        delete: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Delete an academic programme by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Programme deleted successfully" } }
                        }
                    },
                    "/beyond-classrooms": {
                        get: {
                            tags: ["Beyond Classroom (Frontend)"],
                            summary: "Get active Beyond Classroom talent activities for homepage",
                            description: "Returns all 6 published activities (Sports, Music, Dance, Karate, Science & Activities, Skating) sorted by sort_order with category tags, badges, and colors.",
                            responses: {
                                "200": {
                                    description: "List of active Beyond Classroom activities",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 6,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Sports",
                                                        category: "Fitness & Teamwork",
                                                        description: "Developing physical stamina, athletic discipline, teamwork, and sportsmanship across diverse track, court, and field games.",
                                                        icon: "trophy",
                                                        color: "#15803d",
                                                        image_path: "/images/beyond/sports.jpg",
                                                        image_full_url: "http://localhost:8000/images/beyond/sports.jpg",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/beyond-classrooms/{id}": {
                        get: {
                            tags: ["Beyond Classroom (Frontend)"],
                            summary: "Get specific Beyond Classroom activity details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Beyond Classroom activity details" } }
                        }
                    },
                    "/events": {
                        get: {
                            tags: ["Latest Events (Frontend)"],
                            summary: "Get active Latest Events for homepage What's Happening section",
                            description: "Returns all published school event cards (Republic Day, Annual Day, Sports Day) with date badges (e.g. 26 JAN), description, and photos.",
                            responses: {
                                "200": {
                                    description: "List of active events",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 3,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Republic Day Celebrations",
                                                        event_date: "2026-01-26",
                                                        badge_day: "26",
                                                        badge_month: "JAN",
                                                        display_day: "26",
                                                        display_month: "JAN",
                                                        description: "Students showcased patriotic fervor in traditional costumes, march past and cultural performances.",
                                                        image_path: "/images/events/republic-day.jpg",
                                                        image_full_url: "http://localhost:8000/images/events/republic-day.jpg",
                                                        link_url: "/gallery",
                                                        link_text: "Explore event",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/events/{id}": {
                        get: {
                            tags: ["Latest Events (Frontend)"],
                            summary: "Get specific school event details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Event details" } }
                        }
                    },
                    "/stats": {
                        get: {
                            tags: ["Stats Section (Frontend)"],
                            summary: "Get active homepage statistics & milestones (e.g. 2021 Establishment, 1000+ Students, 50+ Faculty, 100+ Activities)",
                            description: "Returns all published homepage counter stats cards sorted by sort_order for the glassmorphic stats bar.",
                            responses: {
                                "200": {
                                    description: "List of active statistics",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 4,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Year of Establishment",
                                                        value: "2021",
                                                        icon: "graduation-cap",
                                                        color: "#eab308",
                                                        description: "Founded with a vision for world-class holistic education.",
                                                        sort_order: 1,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 2,
                                                        title: "Happy Students",
                                                        value: "1000+",
                                                        icon: "users",
                                                        color: "#eab308",
                                                        description: "Nurturing bright young minds across all grade levels.",
                                                        sort_order: 2,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 3,
                                                        title: "Experienced Faculty",
                                                        value: "50+",
                                                        icon: "award",
                                                        color: "#eab308",
                                                        description: "Dedicated and passionate educators shaping tomorrow.",
                                                        sort_order: 3,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 4,
                                                        title: "Co-curricular Activities",
                                                        value: "100+",
                                                        icon: "trophy",
                                                        color: "#eab308",
                                                        description: "Wide array of sports, arts, robotics, and clubs.",
                                                        sort_order: 4,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/home-stats": {
                        get: {
                            tags: ["Stats Section (Frontend)"],
                            summary: "Alias endpoint for /stats",
                            responses: { "200": { description: "List of active stats" } }
                        }
                    },
                    "/stats/{id}": {
                        get: {
                            tags: ["Stats Section (Frontend)"],
                            summary: "Get specific stat item by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Stat details" } }
                        }
                    },
                    "/academic-journeys": {
                        get: {
                            tags: ["Academics Page (Frontend)"],
                            summary: "Get active academic journeys for Academics page",
                            description: "Returns all published early developmental stages (Pre-Primary, Young Buddies, Butterflies, Honey Bees) sorted by sort_order.",
                            responses: {
                                "200": {
                                    description: "List of active academic journeys",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active academic journeys fetched successfully",
                                                count: 4,
                                                total: 4,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Pre-Primary Programme",
                                                        age_group: "Early Years",
                                                        slug: "pre-primary-programme",
                                                        description: "We have adopted the inquiry and self-research-based Pre-primary program of international quality for the first few and most critical learning years of your child.",
                                                        icon: "baby",
                                                        image_path: "images/journey/pre-primary-learning.jpg",
                                                        image_full_url: "http://127.0.0.1:8000/images/journey/pre-primary-learning.jpg",
                                                        link_url: "/academics/pre-primary-programme",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/academic-journeys/{idOrSlug}": {
                        get: {
                            tags: ["Academics Page (Frontend)"],
                            summary: "Get specific academic journey by ID or slug",
                            parameters: [{ name: "idOrSlug", in: "path", required: true, schema: { type: "string" } }],
                            responses: { "200": { description: "Academic journey details" } }
                        }
                    },
                    "/beyond-classroom-page": {
                        get: {
                            tags: ["Beyond Classroom Page (Frontend)"],
                            summary: "Get dedicated Beyond Classroom page metadata, activities and CTA banner",
                            description: "Returns page title, badge, description, all 10 co-curricular activities, and the active CTA banner for the standalone Beyond Classroom page.",
                            responses: {
                                "200": {
                                    description: "Beyond Classroom page payload with activities and CTA banner"
                                }
                            }
                        }
                    },
                    "/beyond-classroom-cta": {
                        get: {
                            tags: ["Beyond Classroom Page (Frontend)"],
                            summary: "Get active Beyond Classroom Call-To-Action (CTA) banner",
                            description: "Returns the active admission CTA banner headline (e.g. 'Give Your Child A Strong Foundation For Tomorrow'), description, red enquiry button, campus tour button, and student montage artwork.",
                            responses: {
                                "200": {
                                    description: "Active CTA banner data",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Beyond Classroom CTA retrieved successfully",
                                                data: {
                                                    id: 1,
                                                    badge: "Admissions Open 2026-27",
                                                    title: "Give Your Child A Strong Foundation",
                                                    highlight_text: "For Tomorrow",
                                                    description: "Join JRS International School and be a part of a nurturing environment that shapes confident, responsible and future-ready individuals.",
                                                    primary_button_text: "Enquire for Admission",
                                                    primary_button_url: "/admissions",
                                                    secondary_button_text: "Take a Campus Tour",
                                                    secondary_button_url: "/campus-tour",
                                                    image_path: "/images/beyond/cta-banner.png",
                                                    image_full_url: "http://127.0.0.1:8000/images/beyond/cta-banner.png",
                                                    bg_color: "#031c3f",
                                                    is_active: true
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/beyond-classrooms": {
                        get: {
                            tags: ["Beyond Classroom Page (Frontend)"],
                            summary: "Get active co-curricular activities for Beyond Classroom page",
                            description: "Returns all 10 published Beyond Classroom activities (Art & Painting, Music, Dance, Karate, Yoga, Skating, Games & Sports, Project Work, Excursions, Clubs) sorted by sort_order.",
                            responses: {
                                "200": {
                                    description: "List of active activities",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active Beyond Classroom activities fetched successfully",
                                                count: 10,
                                                total: 10,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Art & Painting",
                                                        category: "Creative Expression",
                                                        description: "Nurturing aesthetic imagination, visual storytelling, and self-expression through color, sketching, and canvas painting.",
                                                        icon: "palette",
                                                        color: "#e11d48",
                                                        image_path: "/images/journey/butterflies-programme.jpg",
                                                        image_full_url: "http://127.0.0.1:8000/images/journey/butterflies-programme.jpg",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/beyond": {
                        get: {
                            tags: ["Beyond Classroom (Frontend)"],
                            summary: "Alias endpoint for /beyond-classrooms",
                            responses: { "200": { description: "List of active activities" } }
                        }
                    },
                    "/beyond-classrooms/{id}": {
                        get: {
                            tags: ["Beyond Classroom (Frontend)"],
                            summary: "Get specific Beyond Classroom activity details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "string" } }],
                            responses: { "200": { description: "Activity details" } }
                        }
                    },
                    "/amenities-page": {
                        get: {
                            tags: ["Amenities & Facilities (Frontend)"],
                            summary: "Get campus amenities page metadata and all 8 state-of-the-art facilities",
                            description: "Returns 'OUR CAMPUS' badge, 'State-Of-The-Art Facilities' headline, and 8 facility cards (Athletics Track & Pool, Playgrounds, Canteen, Transport, CCTV Security, Medical, Infrastructure, Computing Wi-Fi).",
                            responses: {
                                "200": {
                                    description: "Amenities page payload with 8 facility cards"
                                }
                            }
                        }
                    },
                    "/amenities": {
                        get: {
                            tags: ["Amenities & Facilities (Frontend)"],
                            summary: "Get active campus amenities array",
                            description: "Returns all active campus facilities sorted by sort_order for the React website.",
                            responses: { "200": { description: "List of active amenities" } }
                        }
                    },
                    "/facilities": {
                        get: {
                            tags: ["Amenities & Facilities (Frontend)"],
                            summary: "Alias endpoint for /amenities",
                            responses: { "200": { description: "List of active facilities" } }
                        }
                    },
                    "/careers-page": {
                        get: {
                            tags: ["Careers Page (Frontend)"],
                            summary: "Get complete Careers page payload (Teaching at JRS overview + Job Openings)",
                            description: "Returns the Teaching at JRS section (headline: 'Grow. Teach. Inspire. Make A Difference.', description, campus photo) along with active job openings array.",
                            responses: {
                                "200": {
                                    description: "Careers page payload"
                                }
                            }
                        }
                    },
                    "/careers/teaching": {
                        get: {
                            tags: ["Careers Page (Frontend)"],
                            summary: "Get 'Teaching at JRS' culture & overview section",
                            description: "Returns badge, headline, red highlights, description, campus photo, and resume submission email.",
                            responses: { "200": { description: "Teaching overview data" } }
                        }
                    },
                    "/careers/benefits": {
                        get: {
                            tags: ["Careers Page (Frontend)"],
                            summary: "Get 'Why Join JRS? / Work Culture & Benefits' cards",
                            description: "Returns the 4 key culture cards (Collaborative Community, Continuous Growth, Innovative Teaching, Make A Difference) with icons and text.",
                            responses: { "200": { description: "Work culture & benefits cards array and metadata" } }
                        }
                    },
                    "/careers/how-to-apply": {
                        get: {
                            tags: ["Careers Page (Frontend)"],
                            summary: "Get 'Career Opportunities & How To Apply' section",
                            description: "Returns the career opportunity pitch ('Who Are Passionate About Their Field...'), application process instructions, HR resume email, and checklist items.",
                            responses: { "200": { description: "How to apply data" } }
                        }
                    },
                    "/careers/openings": {
                        get: {
                            tags: ["Careers Page (Frontend)"],
                            summary: "Get list of active job openings",
                            description: "Returns all active teaching and administrative vacancies sorted by order.",
                            responses: { "200": { description: "List of job openings" } }
                        }
                    }
                }
            };

            const ui = SwaggerUIBundle({
                spec: spec,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "BaseLayout"
            });
            window.ui = ui;
        };
    </script>
</body>
</html>
