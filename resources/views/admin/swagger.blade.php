<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger API Documentation | JRS International School</title>
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
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
            font-family: 'Outfit', sans-serif;
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
            background: #b91c1c;
        }
        .swagger-ui .topbar { display: none; }
    </style>
</head>
<body>
    <div class="header-bar">
        <div>
            <h1>JRS International School — Swagger API Docs</h1>
            <p>Interactive OpenAPI 3.0 Documentation for News Ticker & Web Services</p>
        </div>
        <a href="{{ route('admin.tickers.index') }}" class="back-link">&larr; Back to Admin Panel</a>
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
                                                    },
                                                    {
                                                        id: 2,
                                                        title: "CBSE Curriculum with State-of-the-Art STEM, Robotics & AI Labs",
                                                        badge_text: "NEWS",
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
