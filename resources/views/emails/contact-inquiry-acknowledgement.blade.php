<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting JRS International School</title>
    <style>
        body {
            margin: 0;
            padding: 24px;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-text-size-adjust: 100%;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
            border-bottom: 4px solid #dc2626;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .header p {
            margin: 8px 0 0;
            font-size: 13px;
            color: #94a3b8;
        }
        .body {
            padding: 32px 24px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .paragraph {
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
            margin: 0 0 16px;
        }
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px;
            margin: 20px 0;
        }
        .summary-title {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }
        .summary-item {
            font-size: 13px;
            margin-bottom: 8px;
            color: #334155;
        }
        .summary-item strong {
            color: #64748b;
            display: inline-block;
            width: 90px;
        }
        .contact-box {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            border-radius: 8px;
            padding: 16px;
            margin: 24px 0;
            font-size: 13px;
            line-height: 1.6;
            color: #1e3a8a;
        }
        .footer {
            padding: 20px 24px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer a {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>JRS International School</h1>
            <p>Affiliated to CBSE, New Delhi (Affiliation No: 3630478)</p>
        </div>

        <!-- Body -->
        <div class="body">
            <div class="greeting">Dear {{ $inquiry->parent_name }},</div>
            <p class="paragraph">
                Thank you for reaching out to <strong>JRS International School</strong>. We have received your message, and our admissions and counseling team is currently reviewing your query.
            </p>
            <p class="paragraph">
                One of our academic counselors will contact you shortly via phone or email to provide the necessary information and assist with any questions you may have.
            </p>

            <!-- Summary Box -->
            <div class="summary-box">
                <div class="summary-title">Your Submitted Inquiry Summary</div>
                <div class="summary-item"><strong>Contact No:</strong> {{ $inquiry->phone }}</div>
                @if(!empty($inquiry->grade))
                    <div class="summary-item"><strong>Grade:</strong> {{ $inquiry->grade }}</div>
                @endif
                <div class="summary-item" style="margin-top: 10px;">
                    <strong>Message:</strong>
                    <div style="margin-top: 4px; padding: 10px; background: #ffffff; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13px; color: #1e293b;">
                        {{ $inquiry->message }}
                    </div>
                </div>
            </div>

            <!-- Campus Contact Box -->
            <div class="contact-box">
                <strong>Need immediate assistance?</strong><br>
                Feel free to call our admissions helpline directly or visit our campus:<br>
                📞 Phone: +91 92814 09674 / +91 91574 04321<br>
                📍 Campus: Narapally, Near Uppal Depot, Hyderabad, Telangana
            </div>

            <p class="paragraph" style="margin-bottom: 0;">
                Warm regards,<br>
                <strong>Admissions & Counseling Team</strong><br>
                JRS International School
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            JRS International School • Narapally, Hyderabad
        </div>
    </div>
</body>
</html>

