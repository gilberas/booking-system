<x-layouts.landing>

    {{-- NAV --}}
    <nav class="lp-nav" id="lp-nav">
        <div class="lp-nav-inner">
            <a href="{{ route('home') }}" class="lp-nav-logo">
                <div class="lp-nav-logo-icon">A</div>
                <span class="lp-nav-logo-text">Aurum</span>
            </a>
            <div class="lp-nav-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#hotels">Hotels</a>
                <a href="#services">Services</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="lp-nav-actions">
                <a href="{{ route('login') }}" class="lp-nav-signin">Sign In</a>
                <a href="{{ route('search') }}" class="lp-btn-forest">Book Now</a>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="lp-hero-section" id="home">
        <div class="lp-hero-left">
            <p class="lp-hero-badge">Hotel Booking Platform</p>
            <h1 class="lp-hero-title">
                Discover Hotels<br>
                for a <em>Better Stay</em>
            </h1>
            <p class="lp-hero-desc">
                At Aurum, we curate timeless and exceptional properties that inspire,
                elevate, and bring your vision of travel to life.
            </p>
            <div class="lp-hero-actions">
                <a href="{{ route('search') }}" class="lp-btn-forest">Explore Hotels <span style="margin-left:6px;">→</span></a>
                <a href="#hotels" class="lp-hero-view">View Portfolio <span>↗</span></a>
            </div>
            <div class="lp-hero-stats">
                <div>
                    <div class="lp-hero-stat-num">10+</div>
                    <div class="lp-hero-stat-label">Years<br>Experience</div>
                </div>
                <div>
                    <div class="lp-hero-stat-num">250+</div>
                    <div class="lp-hero-stat-label">Hotels<br>Curated</div>
                </div>
                <div>
                    <div class="lp-hero-stat-num">98%</div>
                    <div class="lp-hero-stat-label">Guest<br>Satisfaction</div>
                </div>
                <div>
                    <div class="lp-hero-stat-num">40+</div>
                    <div class="lp-hero-stat-label">Countries<br>Covered</div>
                </div>
            </div>
        </div>
        <div class="lp-hero-right">
            <div class="lp-hero-image-wrap">
                <img src="https://images.unsplash.com/photo-1742844552700-3926862c5311?w=900&h=1100&fit=crop&auto=format" alt="Elegant hotel interior with panoramic views">
                <div class="lp-hero-float-card">
                    <div class="lp-hero-float-label">
                        Next Available
                        <span>Amalfi Crest</span>
                    </div>
                    <div class="lp-hero-search-row">
                        <div>
                            <label>Check In</label>
                            <input type="date" readonly>
                        </div>
                        <div>
                            <label>Check Out</label>
                            <input type="date" readonly>
                        </div>
                        <a href="{{ route('search') }}" class="lp-btn-forest" style="align-self:center;">
                            Search
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Vision + Testimonial Strip --}}
    <section class="lp-strip">
        <div class="lp-strip-inner">
            <div class="lp-strip-card">
                <p class="lp-section-label">Our Approach</p>
                <h3 class="lp-section-heading" style="font-size:1.5rem;font-weight:500;line-height:1.3;margin-bottom:0.75rem;">
                    From Vision<br>to Reality
                </h3>
                <p style="font-size:13px;color:var(--lo-ink-soft);line-height:1.7;margin-bottom:1.25rem;">
                    Every great space starts with a vision. At Aurum, we guide you through
                    every step — discovering a seamless and inspiring experience.
                </p>
                <a href="#about" style="font-size:13px;color:var(--lo-forest);font-weight:500;text-decoration:none;">Our Process →</a>
                <div style="margin-top:1rem;width:7rem;height:7rem;border-radius:12px;overflow:hidden;">
                    <img src="https://images.unsplash.com/photo-1646991761123-d83ce47c30c9?w=200&h=200&fit=crop&auto=format" alt="Hotel lobby" style="width:100%;height:100%;object-fit:cover;">
                </div>
            </div>
            <div class="lp-strip-card-dark">
                <p class="lp-section-label">Client Testimonials</p>
                <p class="lp-section-heading" style="font-style:italic;">
                    "What Our Guests Say"
                </p>
                @php
                    $testimonials = [
                        [
                            'quote' => 'Every detail was curated with such precision. Arriving at Cerulean Isle felt like stepping into a dream already perfected.',
                            'author' => 'Isabelle Marchand',
                            'title' => 'Creative Director, Paris',
                            'rating' => 5,
                        ],
                        [
                            'quote' => 'Aurum redefined what city luxury means to me. The booking was effortless — the stay was unforgettable.',
                            'author' => 'Kaito Nishimura',
                            'title' => 'Architect, Tokyo',
                            'rating' => 5,
                        ],
                        [
                            'quote' => 'I\'ve traveled to sixty countries. Obsidian Peaks is the first place that made me want to stop counting.',
                            'author' => 'Priya Anand',
                            'title' => 'Travel Writer, London',
                            'rating' => 5,
                        ],
                    ];
                @endphp
                <div class="lp-testimonial-active">
                    <p class="lp-strip-quote">
                        "{{ $testimonials[0]['quote'] }}"
                    </p>
                    <div class="lp-strip-author">
                        <div class="lp-strip-avatar">{{ substr($testimonials[0]['author'], 0, 1) }}</div>
                        <div>
                            <div class="lp-strip-author-name">{{ $testimonials[0]['author'] }}</div>
                            <div class="lp-strip-author-title">{{ $testimonials[0]['title'] }}</div>
                        </div>
                        <div class="lp-strip-stars" style="margin-left:auto;">
                            @for ($i = 0; $i < $testimonials[0]['rating']; $i++)
                                <span style="color:#e8c87a;font-size:12px;">★</span>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="lp-strip-dots">
                    <button class="lp-strip-dot active" data-index="0"></button>
                    <button class="lp-strip-dot" data-index="1"></button>
                    <button class="lp-strip-dot" data-index="2"></button>
                </div>
            </div>
        </div>
    </section>

    {{-- About Split --}}
    <section id="about" style="padding:5rem 1.5rem;">
        <div class="lp-about-grid" style="max-width:1280px;margin:0 auto;">
            <div class="lp-about-images">
                <div class="lp-about-img-tall">
                    <img src="https://images.unsplash.com/photo-1679310289844-68ea389b37ac?w=500&h=700&fit=crop&auto=format" alt="Luxury resort pool" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div class="lp-about-img-small">
                        <img src="https://images.unsplash.com/photo-1701421016474-09b19faa9f77?w=400&h=400&fit=crop&auto=format" alt="Hotel pool view" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div class="lp-about-badge">
                        <div class="lp-about-badge-num">10+</div>
                        <div class="lp-about-badge-text">Years of<br>Experience</div>
                    </div>
                </div>
            </div>
            <div class="lp-about-text">
                <p class="lp-section-label">About Aurum</p>
                <h2 class="lp-section-heading" style="font-size:2.5rem;margin-bottom:1.25rem;line-height:1.1;">
                    We Curate<br><em>Meaningful</em> Stays
                </h2>
                <p>
                    Aurum is a modern hotel booking platform focused on creating beautiful,
                    functional, and timeless travel experiences. We blend curation with
                    technology to design journeys that reflect your lifestyle and values.
                </p>
                <p>
                    Every property in our portfolio is personally visited by our editorial
                    team — only the top 4% of submitted hotels earn their place.
                </p>
                <div style="margin-top:1.5rem;">
                    <a href="{{ route('search') }}" style="font-size:14px;color:var(--lo-forest);font-weight:500;text-decoration:none;">
                        Learn More <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Search Bar --}}
    <section class="lp-searchbar" style="margin-top:-1.5rem;position:relative;z-index:10;">
        <div class="lp-searchbar-inner">
            <form action="{{ route('search') }}" method="GET" style="display:contents;">
                <div class="lp-searchbar-grid" style="grid-template-columns:2fr 1fr 1fr 1fr auto;align-items:end;">
                    <div class="lp-searchbar-field">
                        <label>Destination</label>
                        <input type="text" name="q" placeholder="City, hotel or resort">
                    </div>
                    <div class="lp-searchbar-field">
                        <label>Check In</label>
                        <input type="text" name="check_in" placeholder="Select date" class="flatpickr-input" required>
                    </div>
                    <div class="lp-searchbar-field">
                        <label>Check Out</label>
                        <input type="text" name="check_out" placeholder="Select date" class="flatpickr-input" required>
                    </div>
                    <div class="lp-searchbar-field">
                        <label>Guests</label>
                        <select name="guests" style="cursor:pointer;">
                            <option value="1">1 Guest</option>
                            <option value="2" selected>2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                            <option value="5">5+ Guests</option>
                        </select>
                    </div>
                    <div class="lp-searchbar-action">
                        <button type="submit" class="lp-searchbar-btn">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- Services / What We Offer --}}
    <section id="services" style="padding:5rem 1.5rem;">
        <div style="max-width:1280px;margin:0 auto;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2.5rem;">
                <div>
                    <p class="lp-section-label">Our Services</p>
                    <h2 class="lp-section-heading">
                        What We <em>Offer</em>
                    </h2>
                </div>
            </div>
            @php
                $services = [
                    ['title' => 'Beach Resorts', 'desc' => 'Overwater villas and beachfront retreats across tropical coasts.', 'image' => 'https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?w=400&h=280&fit=crop&auto=format'],
                    ['title' => 'Mountain Lodges', 'desc' => 'Alpine escapes with ski access and panoramic summit views.', 'image' => 'https://images.unsplash.com/photo-1776248221078-76561f3ce9f0?w=400&h=280&fit=crop&auto=format'],
                    ['title' => 'City Hotels', 'desc' => 'Penthouse suites and heritage palaces in the world\'s great cities.', 'image' => 'https://images.unsplash.com/photo-1727224455272-a517635f9856?w=400&h=280&fit=crop&auto=format'],
                    ['title' => 'Eco Retreats', 'desc' => 'Sustainably designed properties in remote natural settings.', 'image' => 'https://images.unsplash.com/photo-1675657144361-98ae33e6b6f9?w=400&h=280&fit=crop&auto=format'],
                    ['title' => 'Private Islands', 'desc' => 'Exclusive island buyouts for groups and bespoke escapes.', 'image' => 'https://images.unsplash.com/photo-1758241111370-460859cddde4?w=400&h=280&fit=crop&auto=format'],
                ];
            @endphp
            <div class="lp-grid-services" style="grid-template-columns:repeat(5, 1fr);">
                @foreach ($services as $svc)
                    <div class="lp-service-card">
                        <div class="lp-service-card-img" style="height:140px;">
                            <img src="{{ $svc['image'] }}" alt="{{ $svc['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div class="lp-service-card-body">
                            <h4 class="lp-service-card-title">{{ $svc['title'] }}</h4>
                            <p class="lp-service-card-desc">{{ $svc['desc'] }}</p>
                            <a href="{{ route('search') }}" class="lp-service-card-link">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Hotels --}}
    <section id="hotels" style="padding:3rem 1.5rem 5rem;">
        <div style="max-width:1280px;margin:0 auto;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2.5rem;">
                <div>
                    <p class="lp-section-label">Our Portfolio</p>
                    <h2 class="lp-section-heading">
                        Featured <em>Hotels</em>
                    </h2>
                </div>
                <div style="display:flex;gap:.75rem;align-items:center;">
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                        <button class="lp-filter-btn active" onclick="filterHotels('all')">All</button>
                        <button class="lp-filter-btn" onclick="filterHotels('coastal')">Coastal</button>
                        <button class="lp-filter-btn" onclick="filterHotels('mountain')">Mountain</button>
                        <button class="lp-filter-btn" onclick="filterHotels('city')">City</button>
                    </div>
                </div>
            </div>
            <div class="lp-grid-rooms" id="hotel-grid">
                @php
                    $hotelMeta = [
                        'amalfi-crest' => ['tag' => 'Coastal Retreat', 'category' => 'coastal'],
                        'obsidian-peaks' => ['tag' => 'Alpine Lodge', 'category' => 'mountain'],
                        'velour-skyline' => ['tag' => 'Urban Penthouse', 'category' => 'city'],
                        'cerulean-isle' => ['tag' => 'Overwater Villa', 'category' => 'coastal'],
                        'palomar-grand' => ['tag' => 'Heritage Palace', 'category' => 'city'],
                        'kaia-cove' => ['tag' => 'Jungle Escape', 'category' => 'coastal'],
                    ];
                @endphp
                @forelse ($hotels as $hotel)
                    @php
                        $img = $hotel->images->first();
                        $meta = $hotelMeta[$hotel->slug] ?? ['tag' => 'Boutique Hotel', 'category' => 'city'];
                    @endphp
                    <div class="lp-hotel-card" data-category="{{ $meta['category'] }}">
                        <div class="lp-hotel-card-img">
                            @if ($img)
                                <img src="{{ $img->url }}" alt="{{ $hotel->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1742844552700-3926862c5311?w=800&h=700&fit=crop&auto=format" alt="{{ $hotel->name }}">
                            @endif
                            <div class="lp-hotel-card-tag">{{ $meta['tag'] }}</div>
                            <div class="lp-hotel-card-rating">
                                <span class="star">★</span> {{ number_format($hotel->rating, 1) }}
                            </div>
                        </div>
                        <div class="lp-hotel-card-body">
                            <div class="lp-hotel-card-location">{{ $hotel->city }}, {{ $hotel->country }}</div>
                            <h3 class="lp-hotel-card-name">{{ $hotel->name }}</h3>
                            <p class="lp-hotel-card-desc">{{ $hotel->description }}</p>
                            <div class="lp-hotel-card-footer">
                                <div class="lp-hotel-card-price">
                                    From
                                    <br>
                                    <strong>${{ number_format($hotel->price, 0) }}</strong>
                                    <small>/night</small>
                                </div>
                                <a href="{{ route('search', ['hotel_id' => $hotel->id]) }}" class="lp-hotel-card-book">Reserve</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center;color:var(--lo-ash);grid-column:1/-1;">No hotels available at this time.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Newsletter + Footer Columns --}}
    <section id="contact" class="lp-newsletter-section">
        <div class="lp-newsletter-card" style="display:grid;grid-template-columns:2fr 1fr;gap:0;">
            <div class="lp-newsletter-main">
                <p class="lp-section-label" style="color:var(--lo-forest-light);margin-bottom:1rem;">Stay Updated</p>
                <h2 class="lp-section-heading" style="color:#fff;font-size:2rem;margin-bottom:.75rem;">
                    Join Our<br>
                    <em>Newsletter</em>
                </h2>
                <p style="font-size:13px;color:#a8c4a8;margin-bottom:2rem;">
                    Get the latest hotel drops, exclusive rates, and curated city guides delivered weekly.
                </p>
                <form action="{{ route('newsletter.store') }}" method="POST">
                    @csrf
                    <div class="lp-newsletter-input-group">
                        <input type="email" name="email" class="lp-newsletter-input" placeholder="Your email address" required>
                        <button type="submit" class="lp-newsletter-submit">Subscribe →</button>
                    </div>
                </form>
            </div>
            <div class="lp-newsletter-brand" style="background:#fff;border-radius:0 16px 16px 0;padding:2rem;display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
                        <div class="lp-nav-logo-icon" style="width:32px;height:32px;font-size:11px;">A</div>
                        <span style="font-family:'Playfair Display',serif;font-size:18px;font-weight:600;color:var(--lo-ink);">Aurum</span>
                    </div>
                    <p style="font-size:13px;color:var(--lo-ash);line-height:1.7;">
                        We design travel experiences that inspire and endure. Your journey starts here.
                    </p>
                </div>
                <div style="margin-top:1.5rem;">
                    <p style="font-size:11px;color:var(--lo-ash);">&copy; {{ date('Y') }} Aurum Collection. All rights reserved.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="lp-footer">
        <div class="lp-footer-inner">
            <div class="lp-footer-brand">
                <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1rem;">
                    <div style="width:28px;height:28px;background:var(--lo-forest-light);border-radius:4px;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#fff;font-size:10px;font-weight:600;">A</span>
                    </div>
                    <span style="font-family:'Playfair Display',serif;font-size:16px;">Aurum</span>
                </div>
                <p>Curated hospitality for the discerning traveler.</p>
            </div>
            <div>
                <div class="lp-footer-col-title">Quick Links</div>
                <ul class="lp-footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#hotels">Portfolio</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div>
                <div class="lp-footer-col-title">Services</div>
                <ul class="lp-footer-links">
                    <li><a href="#services">Beach Resorts</a></li>
                    <li><a href="#services">Mountain Lodges</a></li>
                    <li><a href="#services">City Hotels</a></li>
                    <li><a href="#services">Eco Retreats</a></li>
                    <li><a href="#services">Private Islands</a></li>
                </ul>
            </div>
            <div>
                <div class="lp-footer-col-title">Contact</div>
                <ul class="lp-footer-links">
                    <li><a href="tel:+1800000000">+1 800 000 000</a></li>
                    <li><a href="mailto:hello@aurum.co">hello@aurum.co</a></li>
                    <li><a href="#">New York, USA</a></li>
                    <li><a href="#">Mon–Fri 9–6pm</a></li>
                </ul>
            </div>
        </div>
        <div class="lp-footer-bottom">
            <span>&copy; {{ date('Y') }} Aurum. All rights reserved.</span>
            <span>Designed for beautiful experiences</span>
        </div>
    </footer>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.flatpickr-input', { minDate: 'today', dateFormat: 'Y-m-d', altInput: true, altFormat: 'M j, Y' });
            }

            // Navbar scroll effect
            const nav = document.getElementById('lp-nav');
            if (nav) {
                window.addEventListener('scroll', () => {
                    nav.classList.toggle('scrolled', window.scrollY > 50);
                });
            }

            // Testimonial carousel
            const testimonials = @json($testimonials);
            let activeTesti = 0;
            const dots = document.querySelectorAll('.lp-strip-dot');
            const quoteEl = document.querySelector('.lp-testimonial-active .lp-strip-quote');
            const authorEl = document.querySelector('.lp-testimonial-active .lp-strip-author-name');
            const titleEl = document.querySelector('.lp-testimonial-active .lp-strip-author-title');
            const avatarEl = document.querySelector('.lp-testimonial-active .lp-strip-avatar');
            const starsEl = document.querySelector('.lp-testimonial-active .lp-strip-stars');

            function showTestimonial(index) {
                activeTesti = index;
                const t = testimonials[index];
                if (quoteEl) quoteEl.textContent = '"' + t.quote + '"';
                if (authorEl) authorEl.textContent = t.author;
                if (titleEl) titleEl.textContent = t.title;
                if (avatarEl) avatarEl.textContent = t.author.charAt(0);
                if (starsEl) starsEl.innerHTML = '★'.repeat(t.rating).split('').map(s => '<span style="color:#e8c87a;font-size:12px;">' + s + '</span>').join('');
                dots.forEach((d, i) => d.classList.toggle('active', i === index));
            }

            dots.forEach(d => d.addEventListener('click', () => showTestimonial(parseInt(d.dataset.index))));
            setInterval(() => showTestimonial((activeTesti + 1) % testimonials.length), 5000);
        });

        function filterHotels(category) {
            document.querySelectorAll('.lp-filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            document.querySelectorAll('#hotel-grid .lp-hotel-card').forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    @endpush
</x-layouts.landing>
