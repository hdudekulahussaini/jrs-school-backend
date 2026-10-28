@extends('admin.layout')

@section('title', 'Contact Us Settings & Social Media')
@section('header', 'Contact Us')

@section('content')
<div class="space-y-6">

    <!-- Top Action Header Banner -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-red-50 text-jrs-red text-xs font-semibold uppercase tracking-wider mb-1.5 border border-red-100">
                <span class="w-1.5 h-1.5 rounded-full bg-jrs-red animate-pulse"></span>
                <span>Get In Touch</span>
            </div>
            <h2 class="text-xl font-extrabold text-jrs-navy font-heading">Contact Information & Social Links</h2>
            <p class="text-xs text-slate-500 mt-1">Manage official campus contact details, address, phone numbers, Google Maps location, and social media channels.</p>
        </div>
    </div>



    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Settings Form</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Edit Contact & Social Channels</h3>
            </div>
        </div>

        <form action="{{ route('admin.contact-settings.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- SECTION 1: Address, Phone, Email & Map -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-lg bg-red-50 text-jrs-red flex items-center justify-center text-xs font-bold">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <h4 class="font-bold text-sm text-jrs-navy">Campus Location & Inquiries</h4>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Campus Address <span class="text-red-500">*</span></label>
                    <textarea name="address" id="address" rows="3" required placeholder="e.g. JRS International School, Narapally, Near Uppal Depot, Hyderabad, Telangana" class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 leading-relaxed">{{ old('address', $contact->address) }}</textarea>
                    @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                            <input type="text" name="phone" id="phone" required value="{{ old('phone', $contact->phone) }}" placeholder="+91 915740 43210" class="w-full pl-9 pr-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        </div>
                        @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" required value="{{ old('email', $contact->email) }}" placeholder="info@jrsinternationalschool.com" class="w-full pl-9 pr-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        </div>
                        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Map Direct Link -->
                <div>
                    <label for="map_link" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Google Maps Link (URL)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                            <i class="fas fa-directions"></i>
                        </span>
                        <input type="url" name="map_link" id="map_link" value="{{ old('map_link', $contact->map_link) }}" placeholder="https://maps.google.com/?q=..." class="w-full pl-9 pr-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-mono text-xs">
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Opened when visitors click "Get Directions" on the Contact Us page.</span>
                    @error('map_link') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION 2: Social Media Channels (CONNECT WITH US) DYNAMIC REPEATER -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold shadow-2xs border border-blue-100">
                            <i class="fas fa-share-alt"></i>
                        </span>
                        <div>
                            <h4 class="font-bold text-sm text-jrs-navy flex items-center gap-2">
                                Connect With Us (Social Media Channels)
                                <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">Dynamic Repeater</span>
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">Customize feature type (platform), URL & icon type for links shown on contact page & footer.</p>
                        </div>
                    </div>

                    <!-- (+) Add Social Link Button -->
                    <button type="button" id="add-social-link-btn" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-jrs-navy hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm shrink-0 self-start sm:self-auto cursor-pointer">
                        <i class="fas fa-plus text-xs"></i>
                        <span>Add Social Link</span>
                    </button>
                </div>

                <!-- Quick Presets Shortcut Bar -->
                <div class="bg-slate-50/90 p-3.5 rounded-2xl border border-slate-200/90 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-bolt text-amber-500"></i>
                            <span>Quick Add Presets (1-Click to Insert Channel)</span>
                        </span>
                        <span class="text-[10px] text-slate-400 font-medium hidden sm:inline-block">Click any platform to instantly add with icon pre-configured</span>
                    </div>

                    <div class="flex items-center gap-1.5 flex-wrap text-xs">
                        <!-- Facebook -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-blue-500 hover:text-blue-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="Facebook" data-icon="fab fa-facebook-f" data-url="https://facebook.com/jrsinternationalschool">
                            <i class="fab fa-facebook text-[#1877F2]"></i> Facebook
                        </button>

                        <!-- Instagram -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-pink-500 hover:text-pink-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="Instagram" data-icon="fab fa-instagram" data-url="https://instagram.com/jrsinternationalschool">
                            <i class="fab fa-instagram text-[#E4405F]"></i> Instagram
                        </button>

                        <!-- X (Twitter) -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-slate-800 hover:text-slate-900 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="X (Twitter)" data-icon="fab fa-x-twitter" data-url="https://x.com/jrs_school">
                            <i class="fab fa-x-twitter text-slate-900"></i> X (Twitter)
                        </button>

                        <!-- YouTube -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-red-500 hover:text-red-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="YouTube" data-icon="fab fa-youtube" data-url="https://youtube.com/@jrsinternationalschool">
                            <i class="fab fa-youtube text-[#FF0000]"></i> YouTube
                        </button>

                        <!-- LinkedIn -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-blue-700 hover:text-blue-700 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="LinkedIn" data-icon="fab fa-linkedin-in" data-url="https://linkedin.com/company/jrs-international-school">
                            <i class="fab fa-linkedin text-[#0A66C2]"></i> LinkedIn
                        </button>

                        <!-- WhatsApp -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-emerald-500 hover:text-emerald-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="WhatsApp" data-icon="fab fa-whatsapp" data-url="https://wa.me/9191574043210">
                            <i class="fab fa-whatsapp text-[#25D366]"></i> WhatsApp
                        </button>

                        <!-- Telegram -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-sky-500 hover:text-sky-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="Telegram" data-icon="fab fa-telegram" data-url="https://t.me/jrsinternationalschool">
                            <i class="fab fa-telegram text-[#229ED9]"></i> Telegram
                        </button>

                        <!-- Google Maps -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-blue-600 hover:text-blue-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="Google Maps" data-icon="fas fa-map-marked-alt" data-url="https://maps.google.com/?q=JRS+International+School+Narapally+Hyderabad">
                            <i class="fas fa-map-marked-alt text-[#4285F4]"></i> Google Maps
                        </button>

                        <!-- Website / Portal -->
                        <button type="button" class="preset-add-btn px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white border border-slate-200 text-slate-700 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-2xs transition-all inline-flex items-center gap-1.5 cursor-pointer shadow-2xs" data-platform="Website" data-icon="fas fa-globe" data-url="https://jrsinternationalschool.com">
                            <i class="fas fa-globe text-indigo-600"></i> Website
                        </button>
                    </div>
                </div>

                @php
                    $linksList = old('social_links', $socialLinks ?? []);
                    if (!is_array($linksList)) {
                        $linksList = [];
                    }
                @endphp

                <!-- Dynamic Repeater Items Container -->
                <div id="social-links-container" class="space-y-3">
                    @forelse($linksList as $index => $link)
                        <div class="social-link-item p-4 rounded-xl border border-slate-200 bg-white shadow-2xs relative group hover:border-slate-300 transition-all">
                            <div class="flex items-center justify-between pb-2.5 mb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="social-link-badge-num text-[11px] font-bold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fas fa-grip-vertical text-slate-300 text-xs"></i>
                                        Social Channel #{{ $loop->iteration }}
                                    </span>
                                    <span class="platform-display-badge px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ !empty($link['platform']) ? $link['platform'] : 'Custom Link' }}
                                    </span>
                                </div>
                                <button type="button" class="remove-social-link-btn text-slate-400 hover:text-red-600 text-xs font-bold px-2 py-1 rounded-lg hover:bg-red-50 transition-colors inline-flex items-center gap-1 cursor-pointer">
                                    <i class="bi bi-trash3 text-xs"></i>
                                    <span>Remove</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">
                                <!-- Feature Type (Platform) -->
                                <div class="md:col-span-4">
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Feature Type (Platform) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           list="platform-options" 
                                           name="social_links[{{ $index }}][platform]" 
                                           required 
                                           value="{{ $link['platform'] ?? '' }}" 
                                           placeholder="e.g. Facebook, Instagram, YouTube" 
                                           class="platform-input w-full px-3 py-2 rounded-xl text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-slate-50/50 font-semibold transition-all">
                                </div>

                                <!-- Icon Type with Live Preview -->
                                <div class="md:col-span-3">
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Icon Type (Class)
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 text-base shadow-2xs icon-preview shrink-0 transition-all">
                                            <i class="{{ !empty($link['icon']) ? $link['icon'] : 'fas fa-link' }}"></i>
                                        </div>
                                        <input type="text" 
                                               name="social_links[{{ $index }}][icon]" 
                                               value="{{ $link['icon'] ?? 'fas fa-link' }}" 
                                               placeholder="fab fa-facebook-f" 
                                               class="social-icon-input w-full px-2.5 py-2 rounded-xl text-xs border border-slate-200 font-mono text-slate-800 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-slate-50/50 transition-all">
                                    </div>
                                </div>

                                <!-- Destination URL -->
                                <div class="md:col-span-5">
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Channel / Profile URL <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                                            <i class="fas fa-link"></i>
                                        </span>
                                        <input type="url" 
                                               name="social_links[{{ $index }}][url]" 
                                               required 
                                               value="{{ $link['url'] ?? '' }}" 
                                               placeholder="https://..." 
                                               class="social-url-input w-full pl-8 pr-3 py-2 rounded-xl text-xs border border-slate-200 font-mono text-slate-800 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-slate-50/50 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="no-links-msg" class="p-8 rounded-2xl border border-dashed border-slate-200 text-center text-slate-400 text-xs bg-slate-50/50">
                            <i class="fas fa-share-alt text-2xl text-slate-300 mb-2 block"></i>
                            <span class="font-medium">No social media links added yet.</span> Click <span class="font-bold text-jrs-navy">+ Add Social Link</span> above or click a quick preset to add one.
                        </div>
                    @endforelse
                </div>

                <!-- Hidden Datalist for autocomplete -->
                <datalist id="platform-options">
                    <option value="Facebook">
                    <option value="Instagram">
                    <option value="X (Twitter)">
                    <option value="YouTube">
                    <option value="LinkedIn">
                    <option value="WhatsApp">
                    <option value="Telegram">
                    <option value="Google Maps">
                    <option value="Website">
                </datalist>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Updates are reflected on the React site & Swagger API in real-time.</span>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20 flex items-center gap-2 cursor-pointer">
                    <i class="fas fa-save"></i>
                    <span>Save Contact & Social Details</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const socialLinksContainer = document.getElementById('social-links-container');
    const addSocialLinkBtn = document.getElementById('add-social-link-btn');

    // Default icon and color mapping based on platform name
    const platformIconMap = {
        'facebook': { icon: 'fab fa-facebook-f', color: '#1877F2' },
        'instagram': { icon: 'fab fa-instagram', color: '#E4405F' },
        'twitter': { icon: 'fab fa-x-twitter', color: '#0f172a' },
        'x': { icon: 'fab fa-x-twitter', color: '#0f172a' },
        'x (twitter)': { icon: 'fab fa-x-twitter', color: '#0f172a' },
        'youtube': { icon: 'fab fa-youtube', color: '#FF0000' },
        'linkedin': { icon: 'fab fa-linkedin-in', color: '#0A66C2' },
        'whatsapp': { icon: 'fab fa-whatsapp', color: '#25D366' },
        'telegram': { icon: 'fab fa-telegram', color: '#229ED9' },
        'google maps': { icon: 'fas fa-map-marked-alt', color: '#4285F4' },
        'google': { icon: 'fab fa-google', color: '#4285F4' },
        'website': { icon: 'fas fa-globe', color: '#4F46E5' },
    };

    function getPlatformMeta(name) {
        const key = (name || '').trim().toLowerCase();
        for (const [k, v] of Object.entries(platformIconMap)) {
            if (key.includes(k)) return v;
        }
        return { icon: 'fas fa-link', color: '#475569' };
    }

    function reindexSocialLinks() {
        const items = socialLinksContainer.querySelectorAll('.social-link-item');
        if (items.length === 0) {
            if (!document.getElementById('no-links-msg')) {
                socialLinksContainer.innerHTML = `
                    <div id="no-links-msg" class="p-8 rounded-2xl border border-dashed border-slate-200 text-center text-slate-400 text-xs bg-slate-50/50">
                        <i class="fas fa-share-alt text-2xl text-slate-300 mb-2 block"></i>
                        <span class="font-medium">No social media links added yet.</span> Click <span class="font-bold text-jrs-navy">+ Add Social Link</span> above or click a quick preset to add one.
                    </div>
                `;
            }
            return;
        }

        const noMsg = document.getElementById('no-links-msg');
        if (noMsg) noMsg.remove();

        items.forEach((item, index) => {
            const badgeNum = item.querySelector('.social-link-badge-num');
            if (badgeNum) {
                badgeNum.innerHTML = `<i class="fas fa-grip-vertical text-slate-300 text-xs"></i> Social Channel #${index + 1}`;
            }

            const platformInput = item.querySelector('.platform-input');
            const iconInput = item.querySelector('.social-icon-input');
            const urlInput = item.querySelector('.social-url-input');

            if (platformInput) platformInput.name = `social_links[${index}][platform]`;
            if (iconInput) iconInput.name = `social_links[${index}][icon]`;
            if (urlInput) urlInput.name = `social_links[${index}][url]`;
        });
    }

    function addSocialLink(platform = '', icon = '', url = '') {
        const noMsg = document.getElementById('no-links-msg');
        if (noMsg) noMsg.remove();

        if (!icon && platform) {
            icon = getPlatformMeta(platform).icon;
        }
        if (!icon) {
            icon = 'fas fa-link';
        }

        const index = socialLinksContainer.querySelectorAll('.social-link-item').length;
        const itemHtml = `
            <div class="social-link-item p-4 rounded-xl border border-slate-200 bg-white shadow-2xs relative group hover:border-slate-300 transition-all">
                <div class="flex items-center justify-between pb-2.5 mb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="social-link-badge-num text-[11px] font-bold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-grip-vertical text-slate-300 text-xs"></i>
                            Social Channel #${index + 1}
                        </span>
                        <span class="platform-display-badge px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                            ${platform || 'Custom Link'}
                        </span>
                    </div>
                    <button type="button" class="remove-social-link-btn text-slate-400 hover:text-red-600 text-xs font-bold px-2 py-1 rounded-lg hover:bg-red-50 transition-colors inline-flex items-center gap-1 cursor-pointer">
                        <i class="bi bi-trash3 text-xs"></i>
                        <span>Remove</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">
                    <div class="md:col-span-4">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Feature Type (Platform) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               list="platform-options" 
                               name="social_links[${index}][platform]" 
                               required 
                               value="${platform}" 
                               placeholder="e.g. Facebook, Instagram, YouTube" 
                               class="platform-input w-full px-3 py-2 rounded-xl text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-slate-50/50 font-semibold transition-all">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Icon Type (Class)
                        </label>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 text-base shadow-2xs icon-preview shrink-0 transition-all">
                                <i class="${icon}"></i>
                            </div>
                            <input type="text" 
                                   name="social_links[${index}][icon]" 
                                   value="${icon}" 
                                   placeholder="fab fa-facebook-f" 
                                   class="social-icon-input w-full px-2.5 py-2 rounded-xl text-xs border border-slate-200 font-mono text-slate-800 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-slate-50/50 transition-all">
                        </div>
                    </div>

                    <div class="md:col-span-5">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Channel / Profile URL <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url" 
                                   name="social_links[${index}][url]" 
                                   required 
                                   value="${url}" 
                                   placeholder="https://..." 
                                   class="social-url-input w-full pl-8 pr-3 py-2 rounded-xl text-xs border border-slate-200 font-mono text-slate-800 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-slate-50/50 transition-all">
                        </div>
                    </div>
                </div>
            </div>
        `;

        socialLinksContainer.insertAdjacentHTML('beforeend', itemHtml);
        reindexSocialLinks();
    }

    if (addSocialLinkBtn) {
        addSocialLinkBtn.addEventListener('click', function () {
            addSocialLink('', 'fas fa-link', '');
        });
    }

    // Quick presets handler
    document.querySelectorAll('.preset-add-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const platform = this.getAttribute('data-platform');
            const icon = this.getAttribute('data-icon');
            const url = this.getAttribute('data-url');
            addSocialLink(platform, icon, url);
        });
    });

    // Remove button event delegation
    socialLinksContainer.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('.remove-social-link-btn');
        if (removeBtn) {
            const item = removeBtn.closest('.social-link-item');
            if (item) {
                item.remove();
                reindexSocialLinks();
            }
        }
    });

    // Dynamic icon preview and platform auto-match
    socialLinksContainer.addEventListener('input', function (e) {
        const item = e.target.closest('.social-link-item');
        if (!item) return;

        // When icon input changes, update preview icon
        if (e.target.classList.contains('social-icon-input')) {
            const previewIcon = item.querySelector('.icon-preview i');
            if (previewIcon) {
                previewIcon.className = e.target.value.trim() || 'fas fa-link';
            }
        }

        // When platform changes, update platform badge and optionally auto-fill icon
        if (e.target.classList.contains('platform-input')) {
            const badge = item.querySelector('.platform-display-badge');
            if (badge) {
                badge.textContent = e.target.value.trim() || 'Custom Link';
            }

            const iconInput = item.querySelector('.social-icon-input');
            const previewIcon = item.querySelector('.icon-preview i');
            const meta = getPlatformMeta(e.target.value);

            // If icon is currently default or empty, set matching icon
            if (iconInput && (!iconInput.value || iconInput.value === 'fas fa-link' || iconInput.value.startsWith('fab fa-'))) {
                if (meta.icon !== 'fas fa-link') {
                    iconInput.value = meta.icon;
                    if (previewIcon) previewIcon.className = meta.icon;
                }
            }
        }
    });
});
</script>
@endpush
@endsection
