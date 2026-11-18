<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Admission Enquiry</title>
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
            padding: 28px 24px;
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
            margin: 6px 0 0;
            font-size: 13px;
            color: #94a3b8;
        }
        .badge {
            display: inline-block;
            margin-top: 12px;
            background-color: #dc2626;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .body {
            padding: 28px 24px;
        }
        .intro {
            margin: 0 0 20px;
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
        }
        .table-wrap {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .table-wrap tr:not(:last-child) td {
            border-bottom: 1px solid #f1f5f9;
        }
        .table-wrap td {
            padding: 12px 16px;
            font-size: 13px;
            line-height: 1.5;
        }
        .table-wrap td.label {
            width: 38%;
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        .table-wrap td.value {
            color: #0f172a;
            font-weight: 500;
        }
        .table-wrap td.highlight {
            color: #dc2626;
            font-weight: 700;
            font-size: 14px;
        }
        .phone-link {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }
        .notes-box {
            background-color: #f8fafc;
            border-left: 4px solid #dc2626;
            padding: 14px 16px;
            border-radius: 8px;
            margin: 16px 0 24px;
            font-size: 13px;
            color: #334155;
            line-height: 1.6;
        }
        .btn-wrap {
            text-align: center;
            margin: 28px 0 10px;
        }
        .btn {
            display: inline-block;
            background-color: #dc2626;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 10px;
            letter-spacing: 0.3px;
        }
        .footer {
            padding: 18px 24px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>JRS International School</h1>
            <p>Admissions & Enrollment Portal</p>
            <span class="badge">New Admission Enquiry</span>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="intro">
                A new prospective parent has submitted an admission enquiry through the official school website. Details are outlined below:
            </p>

            <table class="table-wrap" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="label">Applying Grade</td>
                    <td class="value highlight">{{ $enquiry->grade ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Parent Mobile</td>
                    <td class="value">
                        <a href="tel:{{ $enquiry->parent_mobile }}" class="phone-link">
                            {{ $enquiry->parent_mobile }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="label">Academic Year</td>
                    <td class="value">{{ $enquiry->academic_year ?? '2026-2027' }}</td>
                </tr>
                <tr>
                    <td class="label">Admission Type</td>
                    <td class="value">{{ $enquiry->admission_type ?? 'DAY SCHOLAR' }}</td>
                </tr>
                <tr>
                    <td class="label">Student DOB</td>
                    <td class="value">
                        {{ $enquiry->student_dob ? \Carbon\Carbon::parse($enquiry->student_dob)->format('d M Y') : 'Not Provided' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Campus Branch</td>
                    <td class="value">{{ $enquiry->branch ?? 'JRS INTERNATIONAL SCHOOL' }}</td>
                </tr>
                <tr>
                    <td class="label">Received On</td>
                    <td class="value">
                        {{ $enquiry->created_at ? $enquiry->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}
                    </td>
                </tr>
            </table>

            @if(!empty($enquiry->notes))
                <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">
                    Parent Notes / Query:
                </div>
                <div class="notes-box">
                    {{ $enquiry->notes }}
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            This is an automated notification from JRS International School Web System.<br>
            Please follow up with the prospective parent within standard admission response hours.
        </div>
    </div>
</body>
</html>

