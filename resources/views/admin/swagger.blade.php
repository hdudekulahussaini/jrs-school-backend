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
                                                        title: "Beyond Classroom",
                                                        subtitle: "Holistic student development programs",
                                                        icon: "fa-solid fa-graduation-cap",
                                                        image_url: "https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80",
                                                        sort_order: 1,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 2,
                                                        title: "Sports Excellence",
                                                        subtitle: "Olympic standard athletic facilities",
                                                        icon: "fa-solid fa-trophy",
                                                        image_url: "https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&q=80",
                                                        sort_order: 2,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 3,
                                                        title: "Visual & Performing Arts",
                                                        subtitle: "Creative studios & music theatre",
                                                        icon: "fa-solid fa-palette",
                                                        image_url: "https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?auto=format&fit=crop&w=800&q=80",
                                                        sort_order: 3,
                                                        is_active: true
                                                    },
                                                    {
                                                        id: 4,
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
