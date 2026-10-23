@extends('admin.layout')

@section('title', 'React API Integration')
@section('header', 'React Frontend API Specs & Live Testing')

@section('content')
<div class="space-y-6">

    <!-- Overview Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3 mb-2">
            <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">API</span>
            <div>
                <h3 class="text-base font-bold text-slate-900 font-heading">RESTful APIs for JRS React Website</h3>
                <p class="text-xs text-slate-500">Connects <code class="text-jrs-navy font-mono font-bold">https://jrs-school.vercel.app</code> with this backend server</p>
            </div>
        </div>
        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
            All endpoints support JSON responses, CORS cross-origin requests, and input validation. You can test each endpoint below directly from this panel or copy the React code snippets into your React project components.
        </p>
    </div>

    <!-- Live Endpoints List -->
    <div class="space-y-4">
        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Available Endpoints</h4>

        <!-- Endpoint 1: Home Data Unified Bundle -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase bg-emerald-100 text-emerald-800">GET</span>
                    <code class="text-xs sm:text-sm font-bold text-slate-900 font-mono">/api/home-data</code>
                    <span class="text-xs text-slate-500 hidden sm:inline">• Unified homepage data bundle</span>
                </div>
                <button onclick="testApi('/api/home-data', 'homeDataResult')" class="px-3.5 py-1.5 text-xs font-bold text-white bg-jrs-navy hover:bg-jrs-navy-dark rounded-xl transition-colors">
                    Test Endpoint
                </button>
            </div>
            <p class="text-xs text-slate-500 mt-2">Returns news tickers, hero slides, academic stages, campus facilities, stats, and school settings in a single fast call.</p>
            <pre id="homeDataResult" class="hidden mt-3 p-3 bg-slate-900 text-emerald-400 rounded-xl text-xs overflow-x-auto max-h-60 font-mono"></pre>
        </div>

        <!-- Endpoint 2: News Tickers -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase bg-emerald-100 text-emerald-800">GET</span>
                    <code class="text-xs sm:text-sm font-bold text-slate-900 font-mono">/api/news-ticker</code>
                    <span class="text-xs text-slate-500 hidden sm:inline">• Active marquee announcements</span>
                </div>
                <button onclick="testApi('/api/news-ticker', 'tickerResult')" class="px-3.5 py-1.5 text-xs font-bold text-white bg-jrs-navy hover:bg-jrs-navy-dark rounded-xl transition-colors">
                    Test Endpoint
                </button>
            </div>
            <pre id="tickerResult" class="hidden mt-3 p-3 bg-slate-900 text-emerald-400 rounded-xl text-xs overflow-x-auto max-h-60 font-mono"></pre>
        </div>

        <!-- Endpoint 3: Submit Admission Enquiry -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase bg-blue-100 text-blue-800">POST</span>
                    <code class="text-xs sm:text-sm font-bold text-slate-900 font-mono">/api/admissions/enquiry</code>
                    <span class="text-xs text-slate-500 hidden sm:inline">• Submit admission lead</span>
                </div>
                <button onclick="testSubmitEnquiry()" class="px-3.5 py-1.5 text-xs font-bold text-white bg-jrs-red hover:bg-jrs-red-dark rounded-xl transition-colors">
                    Simulate Form Submission
                </button>
            </div>
            <p class="text-xs text-slate-500 mt-2">Payload fields: <code class="text-slate-800 font-mono">parent_name, student_name, email, phone, grade_applying, academic_year, city, message</code></p>
            <pre id="enquiryResult" class="hidden mt-3 p-3 bg-slate-900 text-emerald-400 rounded-xl text-xs overflow-x-auto max-h-60 font-mono"></pre>
        </div>

        <!-- Endpoint 4: Submit Contact Message -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase bg-blue-100 text-blue-800">POST</span>
                    <code class="text-xs sm:text-sm font-bold text-slate-900 font-mono">/api/contact</code>
                    <span class="text-xs text-slate-500 hidden sm:inline">• Submit contact inquiry</span>
                </div>
                <button onclick="testSubmitContact()" class="px-3.5 py-1.5 text-xs font-bold text-white bg-jrs-navy hover:bg-jrs-navy-dark rounded-xl transition-colors">
                    Simulate Contact Submit
                </button>
            </div>
            <p class="text-xs text-slate-500 mt-2">Payload fields: <code class="text-slate-800 font-mono">name, email, phone, subject, message</code></p>
            <pre id="contactResult" class="hidden mt-3 p-3 bg-slate-900 text-emerald-400 rounded-xl text-xs overflow-x-auto max-h-60 font-mono"></pre>
        </div>
    </div>

    <!-- React Code Snippet Guide -->
    <div class="bg-slate-900 text-slate-100 rounded-2xl p-6 shadow-xl border border-slate-800 space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-white font-heading flex items-center gap-2">
                <span class="text-amber-400">⚡</span>
                <span>Connecting Your React Component (Admission Enquiry Form)</span>
            </h4>
            <span class="text-xs text-slate-400 font-mono">React JSX / Fetch Example</span>
        </div>

        <pre class="bg-slate-950 p-4 rounded-xl text-xs text-slate-300 font-mono overflow-x-auto">
// Example: In your React project (e.g. AdmissionForm.jsx)
const handleSubmit = async (e) => {
  e.preventDefault();
  
  const payload = {
    student_name: formData.studentName,
    parent_name: formData.parentName,
    email: formData.email,
    phone: formData.phone,
    grade_applying: formData.grade,
    city: formData.city,
    message: formData.message,
    academic_year: '2026-2027'
  };

  try {
    const response = await fetch('http://localhost:8000/api/admissions/enquiry', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();
    if (data.success) {
      alert('Thank you! Your enquiry has been received.');
    } else {
      console.error(data.errors);
    }
  } catch (error) {
    console.error('Error submitting form:', error);
  }
};</pre>
    </div>

</div>

<script>
    async function testApi(endpoint, targetId) {
        const el = document.getElementById(targetId);
        el.classList.remove('hidden');
        el.textContent = 'Fetching from ' + endpoint + '...';

        try {
            const res = await fetch(endpoint);
            const json = await res.json();
            el.textContent = JSON.stringify(json, null, 2);
        } catch (err) {
            el.textContent = 'Error: ' + err.message;
        }
    }

    async function testSubmitEnquiry() {
        const el = document.getElementById('enquiryResult');
        el.classList.remove('hidden');
        el.textContent = 'Submitting test enquiry...';

        const sample = {
            parent_name: 'Dr. Suresh Kumar',
            student_name: 'Rohan Kumar',
            email: 'suresh.kumar@example.com',
            phone: '+91 98888 77777',
            grade_applying: 'Grade IX',
            academic_year: '2026-2027',
            city: 'Hyderabad',
            message: 'Inquiring for admission into Grade IX with CBSE STEM syllabus.'
        };

        try {
            const res = await fetch('/api/admissions/enquiry', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(sample)
            });
            const json = await res.json();
            el.textContent = JSON.stringify(json, null, 2);
        } catch (err) {
            el.textContent = 'Error: ' + err.message;
        }
    }

    async function testSubmitContact() {
        const el = document.getElementById('contactResult');
        el.classList.remove('hidden');
        el.textContent = 'Submitting test contact message...';

        const sample = {
            name: 'Priya Sharma',
            email: 'priya.sharma@example.com',
            phone: '+91 97777 66666',
            subject: 'School Transport Uppal Route Inquiry',
            message: 'Hello, please share the morning bus timings for the Uppal depot route.'
        };

        try {
            const res = await fetch('/api/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(sample)
            });
            const json = await res.json();
            el.textContent = JSON.stringify(json, null, 2);
        } catch (err) {
            el.textContent = 'Error: ' + err.message;
        }
    }
</script>
@endsection
