<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger API Documentation | JRS International School</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui.min.css" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui-standalone-preset.min.js"></script>
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
                    },
                    "/campus-tour": {
                        get: {
                            tags: ["Campus Tour & Life (Frontend)"],
                            summary: "Get active Campus Tour & Life cards and section details",
                            description: "Returns active campus tour cards (Beyond Classroom, Sports Excellence, Visual & Performing Arts, Campus Infrastructure) with section headers, CTA links, and full image URLs for the React frontend.",
                            responses: {
                                "200": {
                                    description: "List of active campus tour cards retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    section: {
                                                        type: "object",
                                                        properties: {
                                                            eyebrow: { type: "string", example: "CAMPUS TOUR & LIFE AT JRS" },
                                                            title: { type: "string", example: "Experience The Spirit Of JRS International School" },
                                                            title_highlight: { type: "string", example: "JRS International School" },
                                                            description: { type: "string", example: "Explore our state-of-the-art campus, modern facilities, and vibrant learning spaces where every student discovers their unique passions and potential." },
                                                            cta_primary: {
                                                                type: "object",
                                                                properties: {
                                                                    text: { type: "string", example: "Book a Campus Visit" },
                                                                    url: { type: "string", example: "https://jrs-school.vercel.app/#tour" }
                                                                }
                                                            },
                                                            cta_secondary: {
                                                                type: "object",
                                                                properties: {
                                                                    text: { type: "string", example: "Admissions 2026-27" },
                                                                    url: { type: "string", example: "https://jrs-school.vercel.app/admissions" }
                                                                }
                                                            }
                                                        }
                                                    },
                                                    count: { type: "integer", example: 4 },
                                                    data: {
                                                        type: "array",
                                                        items: {
                                                            type: "object",
                                                            properties: {
                                                                id: { type: "integer", example: 1 },
                                                                title: { type: "string", example: "Beyond Classroom" },
                                                                subtitle: { type: "string", example: "Holistic student development programs" },
                                                                icon: { type: "string", example: "fa-solid fa-graduation-cap" },
                                                                image_url: { type: "string", example: "https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80" },
                                                                sort_order: { type: "integer", example: 1 },
                                                                is_active: { type: "boolean", example: true }
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                section: {
                                                    eyebrow: "CAMPUS TOUR & LIFE AT JRS",
                                                    title: "Experience The Spirit Of JRS International School",
                                                    title_highlight: "JRS International School",
                                                    description: "Explore our state-of-the-art campus, modern facilities, and vibrant learning spaces where every student discovers their unique passions and potential.",
                                                    cta_primary: {
                                                        text: "Book a Campus Visit",
                                                        url: "https://jrs-school.vercel.app/#tour"
                                                    },
                                                    cta_secondary: {
                                                        text: "Admissions 2026-27",
                                                        url: "https://jrs-school.vercel.app/admissions"
                                                    }
                                                },

                                                count: 4,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Year of Establishment",
                                                        value: "2021",
                                                        icon: "graduation-cap",
                                                        color: "#eab308",
                                                        description: "Founded with a vision for world-class holistic education.",
                                                        title: "Beyond Classroom",
                                                        subtitle: "Holistic student development programs",
                                                        icon: "fa-solid fa-graduation-cap",
                                                        image_url: "https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80",
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
                                                        title: "Sports Excellence",
                                                        subtitle: "Olympic standard athletic facilities",
                                                        icon: "fa-solid fa-trophy",
                                                        image_url: "https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&q=80",
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
                                                        title: "Visual & Performing Arts",
                                                        subtitle: "Creative studios & music theatre",
                                                        icon: "fa-solid fa-palette",
                                                        image_url: "https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?auto=format&fit=crop&w=800&q=80",
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
                                                        title: "Campus Infrastructure",
                                                        subtitle: "Eco-friendly, digital-first learning environment",
                                                        icon: "fa-solid fa-building-columns",
                                                        image_url: "https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80",
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
                    "/why-choose": {
                        get: {
                            tags: ["Why Choose JRS (Frontend)"],
                            summary: "Get active 'What Makes JRS Different' feature cards",
                            description: "Returns all 13 active feature cards (Academic Excellence, Holistic Development, Best Infrastructure, Personal Attention, Safe & Secure, 1:25 Ratio, etc.) with icons and accent colors for the React site.",
                            responses: {
                                "200": {
                                    description: "List of active Why Choose features retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    section: {
                                                        type: "object",
                                                        properties: {
                                                            eyebrow: { type: "string", example: "WHY CHOOSE JRS" },
                                                            title: { type: "string", example: "What Makes JRS Different?" },
                                                            title_highlight: { type: "string", example: "Different?" }
                                                        }
                                                    },
                                                    count: { type: "integer", example: 13 },
                                                    cards: {
                                                        type: "array",
                                                        items: {
                                                            type: "object",
                                                            properties: {
                                                                id: { type: "integer", example: 1 },
                                                                title: { type: "string", example: "Academic Excellence" },
                                                                description: { type: "string", example: "Rigorous curriculum fostering critical thinking, intellectual curiosity and academic brilliance." },
                                                                icon: { type: "string", example: "fa-solid fa-graduation-cap" },
                                                                icon_color: { type: "string", example: "#2563eb" },
                                                                sort_order: { type: "integer", example: 1 },
                                                                is_active: { type: "boolean", example: true }
                                                            }
                                                        }
                                                    },
                                                    data: {
                                                        type: "array",
                                                        items: {
                                                            type: "object"
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                section: {
                                                    eyebrow: "WHY CHOOSE JRS",
                                                    title: "What Makes JRS Different?",
                                                    title_highlight: "Different?"
                                                },
                                                count: 13,
                                                cards: [
                                                    {
                                                        id: 1,
                                                        title: "Academic Excellence",
                                                        description: "Rigorous curriculum fostering critical thinking, intellectual curiosity and academic brilliance.",
                                                        icon: "fa-solid fa-graduation-cap",
                                                        icon_color: "#2563eb",
                                                        sort_order: 1,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 2,
                                                        title: "Holistic Development",
                                                        description: "Balancing academics, sports, arts and emotional intelligence for well-rounded students.",
                                                        icon: "fa-solid fa-child-reaching",
                                                        icon_color: "#7c3aed",
                                                        sort_order: 2,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 3,
                                                        title: "Best Infrastructure",
                                                        description: "World-class campus with smart digital classrooms, modern labs and sports complexes.",
                                                        icon: "fa-solid fa-school",
                                                        icon_color: "#0891b2",
                                                        sort_order: 3,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 4,
                                                        title: "Personal Attention",
                                                        description: "Dedicated mentorship ensuring every learner receives individualized guidance and care.",
                                                        icon: "fa-solid fa-hands-holding-child",
                                                        icon_color: "#ea580c",
                                                        sort_order: 4,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 5,
                                                        title: "Safe & Secure",
                                                        description: "24/7 CCTV surveillance, biometric security and caring campus support personnel.",
                                                        icon: "fa-solid fa-shield-halved",
                                                        icon_color: "#16a34a",
                                                        sort_order: 5,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 6,
                                                        title: "1:25 Ratio",
                                                        description: "Optimal student-to-teacher ratio for interactive learning and focused personal growth.",
                                                        icon: "fa-solid fa-users",
                                                        icon_color: "#dc2626",
                                                        sort_order: 6,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 7,
                                                        title: "Professional Dev",
                                                        description: "Continuous teacher training and modern pedagogical workshops for academic excellence.",
                                                        icon: "fa-solid fa-chalkboard-user",
                                                        icon_color: "#0284c7",
                                                        sort_order: 7,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 8,
                                                        title: "Qualitative Assessment",
                                                        description: "Comprehensive continuous evaluation focusing on student conceptual clarity and skills.",
                                                        icon: "fa-solid fa-chart-line",
                                                        icon_color: "#4f46e5",
                                                        sort_order: 8,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 9,
                                                        title: "Resource Media",
                                                        description: "Rich digital library, online study repositories and smart multimedia educational content.",
                                                        icon: "fa-solid fa-photo-film",
                                                        icon_color: "#d97706",
                                                        sort_order: 9,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 10,
                                                        title: "Field Trips",
                                                        description: "Experiential outdoor study excursions, museum tours and industrial visits for real-world learning.",
                                                        icon: "fa-solid fa-compass",
                                                        icon_color: "#059669",
                                                        sort_order: 10,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 11,
                                                        title: "Career Guidance",
                                                        description: "Personalized career counseling, university admission roadmaps and competitive exam prep.",
                                                        icon: "fa-solid fa-briefcase",
                                                        icon_color: "#9333ea",
                                                        sort_order: 11,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 12,
                                                        title: "Performing Arts",
                                                        description: "Theatre, dance, vocal and instrumental music studios encouraging creative expression.",
                                                        icon: "fa-solid fa-masks-theater",
                                                        icon_color: "#db2777",
                                                        sort_order: 12,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 13,
                                                        title: "Sports Education",
                                                        description: "Professional coaching in cricket, football, basketball, swimming, athletics and martial arts.",
                                                        icon: "fa-solid fa-medal",
                                                        icon_color: "#e11d48",
                                                        sort_order: 13,
                                                        is_active: true
                                                    }
                                                ],
                                                data: []
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
                    "/pta-members": {
                        get: {
                            tags: ["Parent Teacher Association - PTA (Frontend)"],
                            summary: "Get active PTA Committee Members list",
                            description: "Returns all 11 executive and parent/teacher committee members (Chairman, Vice Chairman, Secretary, Joint Secretary, Members) with designations, addresses, phone contacts, and photo URLs for the React website.",
                            responses: {
                                "200": {
                                    description: "List of active PTA committee members retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    section: {
                                                        type: "object",
                                                        properties: {
                                                            eyebrow: { type: "string", example: "COMMUNITY & COLLABORATION" },
                                                            title: { type: "string", example: "Parent Teacher Association" },
                                                            title_highlight: { type: "string", example: "Association" },
                                                            description: { type: "string", example: "Promoting continuous collaboration between parents and educators to support the holistic development of our students." }
                                                        }
                                                    },
                                                    count: { type: "integer", example: 11 },
                                                    data: {
                                                        type: "array",
                                                        items: {
                                                            type: "object",
                                                            properties: {
                                                                id: { type: "integer", example: 1 },
                                                                name: { type: "string", example: "S. Sudhakar Reddy" },
                                                                designation: { type: "string", example: "Chairman" },
                                                                address: { type: "string", example: "Plot No. 12, Sri Krishna Nagar, Hyderabad" },
                                                                phone: { type: "string", example: "+91 98490 12345" },
                                                                image_url: { type: "string", nullable: true, example: "http://127.0.0.1:8000/uploads/pta-members/chairman.jpg" },
                                                                sort_order: { type: "integer", example: 1 }
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                section: {
                                                    eyebrow: "COMMUNITY & COLLABORATION",
                                                    title: "Parent Teacher Association",
                                                    title_highlight: "Association",
                                                    description: "Promoting continuous collaboration between parents and educators to support the holistic development of our students."
                                                },
                                                count: 11,
                                                data: [
                                                    {
                                                        id: 1,
                                                        name: "S. Sudhakar Reddy",
                                                        designation: "Chairman",
                                                        address: "Plot No. 12, Sri Krishna Nagar, Hyderabad",
                                                        phone: "+91 98490 12345",
                                                        image_url: null,
                                                        sort_order: 1
                                                    },
                                                    {
                                                        id: 2,
                                                        name: "Mrs. J. Rohini",
                                                        designation: "Vice Chairman",
                                                        address: "H.No 4-21, Madhapur, Hyderabad",
                                                        phone: "+91 94401 23456",
                                                        image_url: null,
                                                        sort_order: 2
                                                    },
                                                    {
                                                        id: 3,
                                                        name: "K. Ramesh Babu",
                                                        designation: "Secretary",
                                                        address: "Flat 302, Green Meadows, Jubilee Hills",
                                                        phone: "+91 99890 34567",
                                                        image_url: null,
                                                        sort_order: 3
                                                    },
                                                    {
                                                        id: 4,
                                                        name: "Mrs. P. Sunitha",
                                                        designation: "Joint Secretary",
                                                        address: "Plot 88, Vivekananda Colony, Kukatpally",
                                                        phone: "+91 91212 45678",
                                                        image_url: null,
                                                        sort_order: 4
                                                    },
                                                    {
                                                        id: 5,
                                                        name: "Dr. M. Venkat Rao",
                                                        designation: "Member (Parent)",
                                                        address: "Road No. 10, Banjara Hills, Hyderabad",
                                                        phone: "+91 98480 56789",
                                                        image_url: null,
                                                        sort_order: 5
                                                    },
                                                    {
                                                        id: 6,
                                                        name: "Mrs. T. Anitha",
                                                        designation: "Member (Parent)",
                                                        address: "Flat 101, Sai Teja Residency, Nizampet",
                                                        phone: "+91 97012 67890",
                                                        image_url: null,
                                                        sort_order: 6
                                                    },
                                                    {
                                                        id: 7,
                                                        name: "G. Srinivas",
                                                        designation: "Member (Teacher)",
                                                        address: "Staff Quarters, JRS Campus, Hyderabad",
                                                        phone: "+91 96180 78901",
                                                        image_url: null,
                                                        sort_order: 7
                                                    },
                                                    {
                                                        id: 8,
                                                        name: "Mrs. V. Lalitha Kumari",
                                                        designation: "Member (Teacher)",
                                                        address: "Plot 55, Mathrusree Nagar, Miyapur",
                                                        phone: "+91 95023 89012",
                                                        image_url: null,
                                                        sort_order: 8
                                                    },
                                                    {
                                                        id: 9,
                                                        name: "B. Suresh Kumar",
                                                        designation: "Member (Parent)",
                                                        address: "H.No 3-6-140, Himayatnagar, Hyderabad",
                                                        phone: "+91 93910 90123",
                                                        image_url: null,
                                                        sort_order: 9
                                                    },
                                                    {
                                                        id: 10,
                                                        name: "Mrs. K. Madhavi",
                                                        designation: "Member (Parent)",
                                                        address: "Villa 18, Palm Meadows, Kompally",
                                                        phone: "+91 92461 01234",
                                                        image_url: null,
                                                        sort_order: 10
                                                    },
                                                    {
                                                        id: 11,
                                                        name: "Ch. Rajeshwar Rao",
                                                        designation: "Member (Parent)",
                                                        address: "Plot 104, Srinivasa Nagar, Bachupally",
                                                        phone: "+91 91770 12340",
                                                        image_url: null,
                                                        sort_order: 11
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
=======
                    },
                    "/admission-banner": {
                        get: {
                            tags: ["Admission CTA Banner (About Page)"],
                            summary: "Get active Admission & Campus Tour CTA banner for React frontend",
                            description: "Returns the configured headline ('Give Your Child A Strong Foundation For Tomorrow'), description, primary & secondary action buttons, and background image URL for the About Page CTA banner.",
                            responses: {
                                "200": {
                                    description: "Active admission banner content retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    data: {
                                                        type: "object",
                                                        properties: {
                                                            id: { type: "integer", example: 1 },
                                                            title: { type: "string", example: "Give Your Child A Strong Foundation" },
                                                            title_highlight: { type: "string", example: "For Tomorrow" },
                                                            description: { type: "string", example: "Join JRS International School and be a part of a nurturing environment that shapes confident, responsible and future-ready individuals." },
                                                            primary_button: {
                                                                type: "object",
                                                                properties: {
                                                                    text: { type: "string", example: "Enquire for Admission" },
                                                                    url: { type: "string", nullable: true, example: null }
                                                                }
                                                            },
                                                            secondary_button: {
                                                                type: "object",
                                                                properties: {
                                                                    text: { type: "string", example: "Take a Campus Tour" },
                                                                    url: { type: "string", example: "https://jrs-school.vercel.app/#tour" }
                                                                }
                                                            },
                                                            image_url: { type: "string", example: "http://127.0.0.1:8000/images/beyond/science-lab.jpg" },
                                                            updated_at: { type: "string", example: "2026-10-24T07:45:00.000000Z" }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                data: {
                                                    id: 1,
                                                    title: "Give Your Child A Strong Foundation",
                                                    title_highlight: "For Tomorrow",
                                                    description: "Join JRS International School and be a part of a nurturing environment that shapes confident, responsible and future-ready individuals.",
                                                    primary_button: {
                                                        text: "Enquire for Admission",
                                                        url: null
                                                    },
                                                    secondary_button: {
                                                        text: "Take a Campus Tour",
                                                        url: "https://jrs-school.vercel.app/#tour"
                                                    },
                                                    image_url: "http://127.0.0.1:8000/images/beyond/science-lab.jpg",
                                                    updated_at: "2026-10-24T07:45:00.000000Z"
                                                }
                                            }
                                        }
                                    }
                                },
                                "404": {
                                    description: "No active admission banner configured"
                                }
                            }
                        }
                    },
                    "/chairman": {
                        get: {
                            tags: ["Leadership (Chairman of JRS)"],
                            summary: "Get Chairman of JRS Address & Strategic Commitment sections",
                            description: "Returns the complete data for the Chairman Leadership page on the React website (https://jrs-school.vercel.app/): Section 1 (Chairman's Address, Founding Leadership Profile card, Motto Quote, Portrait Photo, Address Paragraph, Sign-off) and Section 2 (Our Strategic Commitment navy card).",
                            responses: {
                                "200": {
                                    description: "Chairman leadership page data retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    data: {
                                                        type: "object",
                                                        properties: {
                                                            id: { type: "integer", example: 1 },
                                                            is_active: { type: "boolean", example: true },
                                                            chairman_address: {
                                                                type: "object",
                                                                properties: {
                                                                    badge: { type: "string", example: "CHAIRMAN'S ADDRESS" },
                                                                    heading: { type: "string", example: "Empowering Young Minds For A Changing World" },
                                                                    profile: {
                                                                        type: "object",
                                                                        properties: {
                                                                            badge: { type: "string", example: "FOUNDING LEADERSHIP" },
                                                                            name: { type: "string", example: "Chairman Of JRS" },
                                                                            sub_title: { type: "string", example: "JRS International School • Hyderabad" },
                                                                            quote: { type: "string", example: "“Nurturing Tomorrow's Leaders with Global Competence & Indian Values”" },
                                                                            image_url: { type: "string", nullable: true, example: "http://127.0.0.1:8000/uploads/chairman/chairman_sample.jpg" },
                                                                            image_path: { type: "string", nullable: true, example: "uploads/chairman/chairman_sample.jpg" }
                                                                        }
                                                                    },
                                                                    paragraph: {
                                                                        type: "string",
                                                                        example: "Welcome to JRS International School. It gives me immense pride to introduce our institution as a place where education transcends the boundaries of textbooks and rote memorization, becoming an exhilarating voyage of curiosity, character formation, and discovery.\n\nIn today's dynamic global landscape, the role of schooling is not merely to prepare students for examinations, but to equip them with the resilience, creativity, critical thinking, and ethical depth necessary to solve real-world problems.\n\nAt JRS, we have seamlessly woven the timeless values of Indian ethos—respect, empathy, integrity, and humility—with cutting-edge international pedagogical practices. Our campus is envisioned not just as a center of academic excellence, but as a vibrant incubator of leadership, innovation, and global citizenship.\n\nWe invite you to partner with us in shaping a generation of compassionate thinkers and visionary trailblazers who will illuminate the world."
                                                                    },
                                                                    paragraphs: {
                                                                        type: "array",
                                                                        items: { type: "string" }
                                                                    },
                                                                    signoff: {
                                                                        type: "object",
                                                                        properties: {
                                                                            note: { type: "string", example: "WITH WARM WISHES & COMMITMENT," },
                                                                            name: { type: "string", example: "Chairman" },
                                                                            sub_title: { type: "string", example: "JRS International School, Hyderabad" }
                                                                        }
                                                                    }
                                                                }
                                                            },
                                                            strategic_commitment: {
                                                                type: "object",
                                                                properties: {
                                                                    badge: { type: "string", example: "OUR STRATEGIC COMMITMENT" },
                                                                    heading: { type: "string", example: "Building An Empowered Generation For Tomorrow" },
                                                                    description: { type: "string", example: "Under the chairman's visionary stewardship, JRS International School continues to upgrade educational infrastructure, introduce emerging digital technologies, and ensure every child receives the finest learning foundation in Hyderabad." }
                                                                }
                                                            },
                                                            section_badge: { type: "string", example: "CHAIRMAN'S ADDRESS" },
                                                            title: { type: "string", example: "Empowering Young Minds For A Changing World" },
                                                            profile_badge: { type: "string", example: "FOUNDING LEADERSHIP" },
                                                            name: { type: "string", example: "Chairman Of JRS" },
                                                            sub_title: { type: "string", example: "JRS International School • Hyderabad" },
                                                            quote: { type: "string", example: "“Nurturing Tomorrow's Leaders with Global Competence & Indian Values”" },
                                                            image_url: { type: "string", nullable: true, example: "http://127.0.0.1:8000/uploads/chairman/chairman_sample.jpg" },
                                                            paragraph: { type: "string", example: "Welcome to JRS International School..." },
                                                            signoff_note: { type: "string", example: "WITH WARM WISHES & COMMITMENT," },
                                                            signoff_name: { type: "string", example: "Chairman" },
                                                            signoff_sub: { type: "string", example: "JRS International School, Hyderabad" },
                                                            commitment_badge: { type: "string", example: "OUR STRATEGIC COMMITMENT" },
                                                            commitment_title: { type: "string", example: "Building An Empowered Generation For Tomorrow" },
                                                            commitment_description: { type: "string", example: "Under the chairman's visionary stewardship..." },
                                                            updated_at: { type: "string", example: "2026-10-25T06:30:00.000000Z" }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                data: {
                                                    id: 1,
                                                    is_active: true,
                                                    chairman_address: {
                                                        badge: "CHAIRMAN'S ADDRESS",
                                                        heading: "Empowering Young Minds For A Changing World",
                                                        profile: {
                                                            badge: "FOUNDING LEADERSHIP",
                                                            name: "Chairman Of JRS",
                                                            sub_title: "JRS International School • Hyderabad",
                                                            quote: "“Nurturing Tomorrow's Leaders with Global Competence & Indian Values”",
                                                            image_url: "http://127.0.0.1:8000/uploads/chairman/chairman_sample.jpg",
                                                            image_path: "uploads/chairman/chairman_sample.jpg"
                                                        },
                                                        paragraph: "Welcome to JRS International School. It gives me immense pride to introduce our institution as a place where education transcends the boundaries of textbooks and rote memorization, becoming an exhilarating voyage of curiosity, character formation, and discovery.\n\nIn today's dynamic global landscape, the role of schooling is not merely to prepare students for examinations, but to equip them with the resilience, creativity, critical thinking, and ethical depth necessary to solve real-world problems.\n\nAt JRS, we have seamlessly woven the timeless values of Indian ethos—respect, empathy, integrity, and humility—with cutting-edge international pedagogical practices. Our campus is envisioned not just as a center of academic excellence, but as a vibrant incubator of leadership, innovation, and global citizenship.\n\nWe invite you to partner with us in shaping a generation of compassionate thinkers and visionary trailblazers who will illuminate the world.",
                                                        paragraphs: [
                                                            "Welcome to JRS International School. It gives me immense pride to introduce our institution as a place where education transcends the boundaries of textbooks and rote memorization, becoming an exhilarating voyage of curiosity, character formation, and discovery.",
                                                            "In today's dynamic global landscape, the role of schooling is not merely to prepare students for examinations, but to equip them with the resilience, creativity, critical thinking, and ethical depth necessary to solve real-world problems.",
                                                            "At JRS, we have seamlessly woven the timeless values of Indian ethos—respect, empathy, integrity, and humility—with cutting-edge international pedagogical practices. Our campus is envisioned not just as a center of academic excellence, but as a vibrant incubator of leadership, innovation, and global citizenship.",
                                                            "We invite you to partner with us in shaping a generation of compassionate thinkers and visionary trailblazers who will illuminate the world."
                                                        ],
                                                        signoff: {
                                                            note: "WITH WARM WISHES & COMMITMENT,",
                                                            name: "Chairman",
                                                            sub_title: "JRS International School, Hyderabad"
                                                        }
                                                    },
                                                    strategic_commitment: {
                                                        badge: "OUR STRATEGIC COMMITMENT",
                                                        heading: "Building An Empowered Generation For Tomorrow",
                                                        description: "Under the chairman's visionary stewardship, JRS International School continues to upgrade educational infrastructure, introduce emerging digital technologies, and ensure every child receives the finest learning foundation in Hyderabad."
                                                    },
                                                    section_badge: "CHAIRMAN'S ADDRESS",
                                                    title: "Empowering Young Minds For A Changing World",
                                                    profile_badge: "FOUNDING LEADERSHIP",
                                                    name: "Chairman Of JRS",
                                                    sub_title: "JRS International School • Hyderabad",
                                                    quote: "“Nurturing Tomorrow's Leaders with Global Competence & Indian Values”",
                                                    image_url: "http://127.0.0.1:8000/uploads/chairman/chairman_sample.jpg",
                                                    paragraph: "Welcome to JRS International School. It gives me immense pride to introduce our institution as a place where education transcends the boundaries of textbooks and rote memorization, becoming an exhilarating voyage of curiosity, character formation, and discovery.\n\nIn today's dynamic global landscape, the role of schooling is not merely to prepare students for examinations, but to equip them with the resilience, creativity, critical thinking, and ethical depth necessary to solve real-world problems.\n\nAt JRS, we have seamlessly woven the timeless values of Indian ethos—respect, empathy, integrity, and humility—with cutting-edge international pedagogical practices. Our campus is envisioned not just as a center of academic excellence, but as a vibrant incubator of leadership, innovation, and global citizenship.\n\nWe invite you to partner with us in shaping a generation of compassionate thinkers and visionary trailblazers who will illuminate the world.",
                                                    signoff_note: "WITH WARM WISHES & COMMITMENT,",
                                                    signoff_name: "Chairman",
                                                    signoff_sub: "JRS International School, Hyderabad",
                                                    commitment_badge: "OUR STRATEGIC COMMITMENT",
                                                    commitment_title: "Building An Empowered Generation For Tomorrow",
                                                    commitment_description: "Under the chairman's visionary stewardship, JRS International School continues to upgrade educational infrastructure, introduce emerging digital technologies, and ensure every child receives the finest learning foundation in Hyderabad.",
                                                    updated_at: "2026-10-25T06:30:00.000000Z"
                                                }
                                            }
                                        }
                                    }
                                },
                                "404": {
                                    description: "No active Chairman section content found",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: false,
                                                message: "No active Chairman section content found",
                                                data: null
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/principal": {
                        get: {
                            tags: ["Leadership (Principal of JRS)"],
                            summary: "Get Principal of JRS Message & Academic Leadership sections",
                            description: "Returns the complete data for the Principal Leadership page on the React website (https://jrs-school.vercel.app/): Document Header (From the Desk of, Academic Year), Academic Leadership Profile card (Portrait, Badges, Name, Designation), Principal's Address (Heading, Salutation, Paragraphs, Highlight Quote), and Official Sign-off & Seal.",
                            responses: {
                                "200": {
                                    description: "Principal leadership page data retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    data: {
                                                        type: "object",
                                                        properties: {
                                                            id: { type: "integer", example: 1 },
                                                            is_active: { type: "boolean", example: true },
                                                            document_header: {
                                                                type: "object",
                                                                properties: {
                                                                    desk_title: { type: "string", example: "FROM THE DESK OF" },
                                                                    desk_subtitle: { type: "string", example: "The Principal, JRS International School" },
                                                                    official_address_badge: { type: "string", example: "OFFICIAL ADDRESS" },
                                                                    academic_year: { type: "string", example: "Academic Year 2026 – 2027" }
                                                                }
                                                            },
                                                            profile: {
                                                                type: "object",
                                                                properties: {
                                                                    card_badge: { type: "string", example: "PRINCIPAL" },
                                                                    profile_badge: { type: "string", example: "ACADEMIC LEADERSHIP" },
                                                                    name: { type: "string", example: "Mrs. Marlene Mannas" },
                                                                    sub_title: { type: "string", example: "Principal, JRS International School" },
                                                                    image_url: { type: "string", nullable: true, example: "http://127.0.0.1:8000/uploads/principal/principal_sample.jpg" },
                                                                    image_path: { type: "string", nullable: true, example: "uploads/principal/principal_sample.jpg" }
                                                                }
                                                            },
                                                            message: {
                                                                type: "object",
                                                                properties: {
                                                                    section_badge: { type: "string", example: "PRINCIPAL'S MESSAGE" },
                                                                    title: { type: "string", example: "Empowering Minds And Enriching Lives" },
                                                                    salutation: { type: "string", example: "Dear Parents, Students And Well-Wishers," },
                                                                    paragraph: { type: "string", example: "Welcome to JRS International School..." },
                                                                    paragraphs: {
                                                                        type: "array",
                                                                        items: { type: "string" }
                                                                    },
                                                                    quote: { type: "string", example: "“At JRS, we don't just prepare students for the future—we empower them to shape it.”" }
                                                                }
                                                            },
                                                            signoff: {
                                                                type: "object",
                                                                properties: {
                                                                    note: { type: "string", example: "WARM REGARDS," },
                                                                    signature: { type: "string", example: "Marlene Mannas" },
                                                                    name: { type: "string", example: "Mrs. Marlene Mannas" },
                                                                    sub_title: { type: "string", example: "Principal, JRS International School" }
                                                                }
                                                            },
                                                            desk_title: { type: "string", example: "FROM THE DESK OF" },
                                                            desk_subtitle: { type: "string", example: "The Principal, JRS International School" },
                                                            official_address_badge: { type: "string", example: "OFFICIAL ADDRESS" },
                                                            academic_year: { type: "string", example: "Academic Year 2026 – 2027" },
                                                            section_badge: { type: "string", example: "PRINCIPAL'S MESSAGE" },
                                                            title: { type: "string", example: "Empowering Minds And Enriching Lives" },
                                                            salutation: { type: "string", example: "Dear Parents, Students And Well-Wishers," },
                                                            card_badge: { type: "string", example: "PRINCIPAL" },
                                                            profile_badge: { type: "string", example: "ACADEMIC LEADERSHIP" },
                                                            name: { type: "string", example: "Mrs. Marlene Mannas" },
                                                            sub_title: { type: "string", example: "Principal, JRS International School" },
                                                            image_url: { type: "string", nullable: true, example: "http://127.0.0.1:8000/uploads/principal/principal_sample.jpg" },
                                                            paragraph: { type: "string", example: "Welcome to JRS International School..." },
                                                            quote: { type: "string", example: "“At JRS, we don't just prepare students for the future—we empower them to shape it.”" },
                                                            signoff_note: { type: "string", example: "WARM REGARDS," },
                                                            signoff_signature: { type: "string", example: "Marlene Mannas" },
                                                            signoff_name: { type: "string", example: "Mrs. Marlene Mannas" },
                                                            signoff_sub: { type: "string", example: "Principal, JRS International School" },
                                                            updated_at: { type: "string", example: "2026-10-25T07:00:00.000000Z" }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                data: {
                                                    id: 1,
                                                    is_active: true,
                                                    document_header: {
                                                        desk_title: "FROM THE DESK OF",
                                                        desk_subtitle: "The Principal, JRS International School",
                                                        official_address_badge: "OFFICIAL ADDRESS",
                                                        academic_year: "Academic Year 2026 – 2027"
                                                    },
                                                    profile: {
                                                        card_badge: "PRINCIPAL",
                                                        profile_badge: "ACADEMIC LEADERSHIP",
                                                        name: "Mrs. Marlene Mannas",
                                                        sub_title: "Principal, JRS International School",
                                                        image_url: "http://127.0.0.1:8000/uploads/principal/principal_sample.jpg",
                                                        image_path: "uploads/principal/principal_sample.jpg"
                                                    },
                                                    message: {
                                                        section_badge: "PRINCIPAL'S MESSAGE",
                                                        title: "Empowering Minds And Enriching Lives",
                                                        salutation: "Dear Parents, Students And Well-Wishers,",
                                                        paragraph: "Welcome to JRS International School, where we are committed to “Empowering Minds and Enriching Lives.” We believe that every child has unique potential, and meaningful education is about discovering, nurturing and transforming that potential into purpose.\n\nAt JRS, we go beyond academic excellence to develop curious thinkers, confident communicators, compassionate individuals and responsible global citizens. Through strong academics, innovative pedagogy, technology-enabled learning, AI, robotics and experiential opportunities, we create an environment where students are encouraged to question, explore, create and lead.\n\nOur focus extends beyond the classroom. We nurture character, values, leadership, creativity, collaboration and resilience, preparing our students not simply for examinations, but for life.\n\nWith the partnership of our dedicated teachers and supportive parents, we strive to provide every learner with the confidence, knowledge and values needed to embrace the opportunities of tomorrow.",
                                                        paragraphs: [
                                                            "Welcome to JRS International School, where we are committed to “Empowering Minds and Enriching Lives.” We believe that every child has unique potential, and meaningful education is about discovering, nurturing and transforming that potential into purpose.",
                                                            "At JRS, we go beyond academic excellence to develop curious thinkers, confident communicators, compassionate individuals and responsible global citizens. Through strong academics, innovative pedagogy, technology-enabled learning, AI, robotics and experiential opportunities, we create an environment where students are encouraged to question, explore, create and lead.",
                                                            "Our focus extends beyond the classroom. We nurture character, values, leadership, creativity, collaboration and resilience, preparing our students not simply for examinations, but for life.",
                                                            "With the partnership of our dedicated teachers and supportive parents, we strive to provide every learner with the confidence, knowledge and values needed to embrace the opportunities of tomorrow."
                                                        ],
                                                        quote: "“At JRS, we don't just prepare students for the future—we empower them to shape it.”"
                                                    },
                                                    signoff: {
                                                        note: "WARM REGARDS,",
                                                        signature: "Marlene Mannas",
                                                        name: "Mrs. Marlene Mannas",
                                                        sub_title: "Principal, JRS International School"
                                                    },
                                                    desk_title: "FROM THE DESK OF",
                                                    desk_subtitle: "The Principal, JRS International School",
                                                    official_address_badge: "OFFICIAL ADDRESS",
                                                    academic_year: "Academic Year 2026 – 2027",
                                                    section_badge: "PRINCIPAL'S MESSAGE",
                                                    title: "Empowering Minds And Enriching Lives",
                                                    salutation: "Dear Parents, Students And Well-Wishers,",
                                                    card_badge: "PRINCIPAL",
                                                    profile_badge: "ACADEMIC LEADERSHIP",
                                                    name: "Mrs. Marlene Mannas",
                                                    sub_title: "Principal, JRS International School",
                                                    image_url: "http://127.0.0.1:8000/uploads/principal/principal_sample.jpg",
                                                    paragraph: "Welcome to JRS International School, where we are committed to “Empowering Minds and Enriching Lives.” We believe that every child has unique potential, and meaningful education is about discovering, nurturing and transforming that potential into purpose.\n\nAt JRS, we go beyond academic excellence to develop curious thinkers, confident communicators, compassionate individuals and responsible global citizens. Through strong academics, innovative pedagogy, technology-enabled learning, AI, robotics and experiential opportunities, we create an environment where students are encouraged to question, explore, create and lead.\n\nOur focus extends beyond the classroom. We nurture character, values, leadership, creativity, collaboration and resilience, preparing our students not simply for examinations, but for life.\n\nWith the partnership of our dedicated teachers and supportive parents, we strive to provide every learner with the confidence, knowledge and values needed to embrace the opportunities of tomorrow.",
                                                    quote: "“At JRS, we don't just prepare students for the future—we empower them to shape it.”",
                                                    signoff_note: "WARM REGARDS,",
                                                    signoff_signature: "Marlene Mannas",
                                                    signoff_name: "Mrs. Marlene Mannas",
                                                    signoff_sub: "Principal, JRS International School",
                                                    updated_at: "2026-10-25T07:00:00.000000Z"
                                                }
                                            }
                                        }
                                    }
                                },
                                "404": {
                                    description: "No active Principal section content found",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: false,
                                                message: "No active Principal section content found",
                                                data: null
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/educational-society": {
                        get: {
                            tags: ["Committee (Educational Society)"],
                            summary: "Get Educational Society Managing Committee members and page header",
                            description: "Returns the Educational Society Managing Committee header metadata and all members (Photo, Name, Designation/Role badge, Address, Phone) for the About Pages -> Committee -> Educational Society section.",
                            responses: {
                                "200": {
                                    description: "Educational Society Managing Committee members retrieved successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    section: {
                                                        type: "object",
                                                        properties: {
                                                            eyebrow: { type: "string", example: "GOVERNING BODY & LEADERSHIP" },
                                                            title: { type: "string", example: "Managing Committee" },
                                                            title_highlight: { type: "string", example: "Committee" },
                                                            description: { type: "string", example: "Distinguished governing body steering the vision, academic excellence, statutory compliance, and strategic growth of JRS International School." }
                                                        }
                                                    },
                                                    count: { type: "integer", example: 8 },
                                                    data: {
                                                        type: "array",
                                                        items: {
                                                            type: "object",
                                                            properties: {
                                                                id: { type: "integer", example: 1 },
                                                                name: { type: "string", example: "Mr. C. R. Jagadish" },
                                                                designation: { type: "string", example: "PRESIDENT" },
                                                                address: { type: "string", example: "Karthikeya Nagar, Nacharam, Hyderabad" },
                                                                phone: { type: "string", example: "9542664980" },
                                                                image_url: { type: "string", nullable: true, example: null }
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                section: {
                                                    eyebrow: "GOVERNING BODY & LEADERSHIP",
                                                    title: "Managing Committee",
                                                    title_highlight: "Committee",
                                                    description: "Distinguished governing body steering the vision, academic excellence, statutory compliance, and strategic growth of JRS International School."
                                                },
                                                count: 8,
                                                data: [
                                                    {
                                                        id: 1,
                                                        name: "Mr. C. R. Jagadish",
                                                        designation: "PRESIDENT",
                                                        address: "Karthikeya Nagar, Nacharam, Hyderabad",
                                                        phone: "9542664980",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 2,
                                                        name: "Ms. V. Jyothi",
                                                        designation: "VICE-PRESIDENT",
                                                        address: "12-13-415/3 Tarnaka, Secunderabad",
                                                        phone: "9666312947",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 3,
                                                        name: "Ms. C. Amaravathi",
                                                        designation: "GENERAL SECRETARY",
                                                        address: "Karthikeya Nagar, Nacharam, Hyderabad",
                                                        phone: "9346065525",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 4,
                                                        name: "Dr. C. Suman Kumar",
                                                        designation: "JOINT-SECRETARY",
                                                        address: "Boduppal, Hyderabad",
                                                        phone: "9926811371",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 5,
                                                        name: "Ms. V. Vedavathi",
                                                        designation: "TREASURER",
                                                        address: "Divya Enclave Vijaypuri, Tarnaka, Hyderabad",
                                                        phone: "9160300046",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 6,
                                                        name: "Mr. Sreepathi Rao",
                                                        designation: "EXECUTIVE-MEMBER",
                                                        address: "Uppal, Hyderabad",
                                                        phone: "9963701615",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 7,
                                                        name: "Mr. Sudharshan Rao",
                                                        designation: "EXE-MEMBER",
                                                        address: "L.B Nagar, Hyderabad",
                                                        phone: "8520047067",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 8,
                                                        name: "Mr. Baskar Reddy",
                                                        designation: "EXE-MEMBER",
                                                        address: "Venkatadri Township, Chowdarguda, Hyderabad",
                                                        phone: "9908330490",
                                                        image_url: null
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/school-management-committee": {
                        get: {
                            tags: ["Committee (School Management Committee)"],
                            summary: "Get School Management Committee (SMC) members & section header",
                            description: "Returns the 11 School Management Committee members (Mrs. Jagadishwari Devi as CHAIRMAN and 10 MEMBERS) along with statutory governance & compliance section header.",
                            responses: {
                                "200": {
                                    description: "SMC members list and section details fetched successfully",
                                    content: {
                                        "application/json": {
                                            schema: {
                                                type: "object",
                                                properties: {
                                                    success: { type: "boolean", example: true },
                                                    section: {
                                                        type: "object",
                                                        properties: {
                                                            eyebrow: { type: "string", example: "STATUTORY GOVERNANCE & COMPLIANCE" },
                                                            title: { type: "string", example: "School Management Committee" },
                                                            title_prefix: { type: "string", example: "School Management" },
                                                            title_highlight: { type: "string", example: "Committee" },
                                                            description: { type: "string", example: "The School Management Committee (SMC) ensures academic integrity, statutory compliance, student welfare, and continuous institutional growth at JRS International School." }
                                                        }
                                                    },
                                                    count: { type: "integer", example: 11 },
                                                    data: {
                                                        type: "array",
                                                        items: {
                                                            type: "object",
                                                            properties: {
                                                                id: { type: "integer", example: 1 },
                                                                name: { type: "string", example: "Mrs. Jagadishwari Devi" },
                                                                designation: { type: "string", example: "CHAIRMAN" },
                                                                address: { type: "string", example: "Divya Enclave Vijaypuri Tarnaka, Hyderabad" },
                                                                phone: { type: "string", example: "9160300046" },
                                                                image_url: { type: "string", nullable: true, example: null }
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            example: {
                                                success: true,
                                                section: {
                                                    eyebrow: "STATUTORY GOVERNANCE & COMPLIANCE",
                                                    title: "School Management Committee",
                                                    title_prefix: "School Management",
                                                    title_highlight: "Committee",
                                                    description: "The School Management Committee (SMC) ensures academic integrity, statutory compliance, student welfare, and continuous institutional growth at JRS International School."
                                                },
                                                count: 11,
                                                data: [
                                                    {
                                                        id: 1,
                                                        name: "Mrs. Jagadishwari Devi",
                                                        designation: "CHAIRMAN",
                                                        address: "Divya Enclave Vijaypuri Tarnaka, Hyderabad",
                                                        phone: "9160300046",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 2,
                                                        name: "Mr. C. R. Jagadish",
                                                        designation: "MEMBER",
                                                        address: "Karthikeya Nagar Nacharam, Hyderabad",
                                                        phone: "9542664980",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 3,
                                                        name: "Mrs. Jyothi",
                                                        designation: "MEMBER",
                                                        address: "12-13-415/3 Tarnaka, Secunderabad",
                                                        phone: "9666312947",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 4,
                                                        name: "Mr. Vijay Bhaskar",
                                                        designation: "MEMBER",
                                                        address: "Venkatadri Township Chowdarguda, Hyderabad",
                                                        phone: "9908330490",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 5,
                                                        name: "Mr. Ashok",
                                                        designation: "MEMBER",
                                                        address: "Sai Enclave, Narapally, Hyderabad",
                                                        phone: "9949845482",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 6,
                                                        name: "Mrs B. Sheetal",
                                                        designation: "MEMBER",
                                                        address: "Venkatadri Township Chowdarguda, Hyderabad",
                                                        phone: "8309981778",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 7,
                                                        name: "Mrs Nagasunitha",
                                                        designation: "MEMBER",
                                                        address: "Muthvelliguda, Hyderabad",
                                                        phone: "8897503215",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 8,
                                                        name: "Dr. VinayShree",
                                                        designation: "MEMBER",
                                                        address: "Siddhartha School Boduppal, Hyderabad",
                                                        phone: "9502499979",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 9,
                                                        name: "Mr. Narsing Rao",
                                                        designation: "MEMBER",
                                                        address: "Sivaji Vidya Peeth School, Hyderabad",
                                                        phone: "9963701615",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 10,
                                                        name: "Dr Srinivas",
                                                        designation: "MEMBER",
                                                        address: "Venkatadri Township Chowdarguda, Hyderabad",
                                                        phone: "9912712798",
                                                        image_url: null
                                                    },
                                                    {
                                                        id: 11,
                                                        name: "Dr. Anil Kumar",
                                                        designation: "MEMBER",
                                                        address: "Boduppal, Hyderabad",
                                                        phone: "9926811371",
                                                        image_url: null
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
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
