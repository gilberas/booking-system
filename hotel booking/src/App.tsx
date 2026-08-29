import { useState, useEffect, useRef } from "react";

const HOTELS = [
  {
    id: 1,
    name: "Amalfi Crest",
    location: "Positano, Italy",
    category: "coastal",
    tag: "Coastal Retreat",
    price: 680,
    rating: 4.9,
    reviews: 412,
    image: "https://images.unsplash.com/photo-1742844552700-3926862c5311?w=800&h=700&fit=crop&auto=format",
    desc: "Cliffside infinity suite with panoramic Tyrrhenian Sea views.",
  },
  {
    id: 2,
    name: "Obsidian Peaks",
    location: "Zermatt, Switzerland",
    category: "mountain",
    tag: "Alpine Lodge",
    price: 920,
    rating: 4.8,
    reviews: 287,
    image: "https://images.unsplash.com/photo-1615676893771-94c4d0a2f1ca?w=800&h=700&fit=crop&auto=format",
    desc: "Ski-in/ski-out lodge framing the iconic Matterhorn.",
  },
  {
    id: 3,
    name: "Velour Skyline",
    location: "Dubai, UAE",
    category: "city",
    tag: "Urban Penthouse",
    price: 1240,
    rating: 4.9,
    reviews: 631,
    image: "https://images.unsplash.com/photo-1688933758128-83d40ab10b4e?w=800&h=700&fit=crop&auto=format",
    desc: "Floor-to-ceiling city panorama from the 72nd floor.",
  },
  {
    id: 4,
    name: "Cerulean Isle",
    location: "Baa Atoll, Maldives",
    category: "coastal",
    tag: "Overwater Villa",
    price: 1850,
    rating: 5.0,
    reviews: 198,
    image: "https://images.unsplash.com/photo-1721617864119-611e4544ff07?w=800&h=700&fit=crop&auto=format",
    desc: "Private overwater bungalow with direct reef access.",
  },
  {
    id: 5,
    name: "Palomar Grand",
    location: "Barcelona, Spain",
    category: "city",
    tag: "Heritage Palace",
    price: 560,
    rating: 4.7,
    reviews: 844,
    image: "https://images.unsplash.com/photo-1646991761123-d83ce47c30c9?w=800&h=700&fit=crop&auto=format",
    desc: "Chandelier halls in a restored 19th-century merchant palace.",
  },
  {
    id: 6,
    name: "Kaia Cove",
    location: "Phuket, Thailand",
    category: "coastal",
    tag: "Jungle Escape",
    price: 390,
    rating: 4.8,
    reviews: 521,
    image: "https://images.unsplash.com/photo-1725006136539-46bef885df06?w=800&h=700&fit=crop&auto=format",
    desc: "Lush hillside villas cascading to a private beach.",
  },
];

const SERVICES = [
  { image: "https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?w=400&h=280&fit=crop&auto=format", title: "Beach Resorts", desc: "Overwater villas and beachfront retreats across tropical coasts." },
  { image: "https://images.unsplash.com/photo-1776248221078-76561f3ce9f0?w=400&h=280&fit=crop&auto=format", title: "Mountain Lodges", desc: "Alpine escapes with ski access and panoramic summit views." },
  { image: "https://images.unsplash.com/photo-1727224455272-a517635f9856?w=400&h=280&fit=crop&auto=format", title: "City Hotels", desc: "Penthouse suites and heritage palaces in the world's great cities." },
  { image: "https://images.unsplash.com/photo-1675657144361-98ae33e6b6f9?w=400&h=280&fit=crop&auto=format", title: "Eco Retreats", desc: "Sustainably designed properties in remote natural settings." },
  { image: "https://images.unsplash.com/photo-1758241111370-460859cddde4?w=400&h=280&fit=crop&auto=format", title: "Private Islands", desc: "Exclusive island buyouts for groups and bespoke escapes." },
];

const TESTIMONIALS = [
  {
    quote: "Every detail was curated with such precision. Arriving at Cerulean Isle felt like stepping into a dream already perfected.",
    author: "Isabelle Marchand",
    title: "Creative Director, Paris",
    rating: 5,
  },
  {
    quote: "Aurum redefined what city luxury means to me. The booking was effortless — the stay was unforgettable.",
    author: "Kaito Nishimura",
    title: "Architect, Tokyo",
    rating: 5,
  },
  {
    quote: "I've traveled to sixty countries. Obsidian Peaks is the first place that made me want to stop counting.",
    author: "Priya Anand",
    title: "Travel Writer, London",
    rating: 5,
  },
];

const FILTERS = ["All", "Coastal", "Mountain", "City"];

export default function App() {
  const [activeFilter, setActiveFilter] = useState("All");
  const [checkIn, setCheckIn] = useState("");
  const [checkOut, setCheckOut] = useState("");
  const [guests, setGuests] = useState("2 Guests");
  const [destination, setDestination] = useState("");
  const [scrolled, setScrolled] = useState(false);
  const [activeTesti, setActiveTesti] = useState(0);
  const [email, setEmail] = useState("");
  const [subscribed, setSubscribed] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);
  const scrollRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const fn = () => setScrolled(window.scrollY > 50);
    window.addEventListener("scroll", fn);
    return () => window.removeEventListener("scroll", fn);
  }, []);

  useEffect(() => {
    const t = setInterval(() => setActiveTesti((p) => (p + 1) % TESTIMONIALS.length), 5000);
    return () => clearInterval(t);
  }, []);

  const filtered = HOTELS.filter(
    (h) => activeFilter === "All" || h.category === activeFilter.toLowerCase()
  );

  return (
    <div className="min-h-screen bg-[#f5f1eb] text-[#1a1a18] font-[DM_Sans,sans-serif]">

      {/* ── NAV ── */}
      <nav
        className="fixed top-0 left-0 right-0 z-50 transition-all duration-400"
        style={{
          background: scrolled ? "rgba(245,241,235,0.95)" : "rgba(245,241,235,0.9)",
          backdropFilter: "blur(12px)",
          borderBottom: "1px solid #ddd8ce",
        }}
      >
        <div className="max-w-[1280px] mx-auto px-6 lg:px-10 h-[68px] flex items-center justify-between">
          {/* Logo */}
          <a href="#" className="flex items-center gap-2.5">
            <div className="w-8 h-8 bg-[#2c4a35] rounded-sm flex items-center justify-center">
              <span className="text-white text-[11px] font-semibold tracking-wide">A</span>
            </div>
            <span className="font-display text-[18px] font-semibold text-[#1a1a18]">Aurum</span>
          </a>

          {/* Links */}
          <div className="hidden lg:flex items-center gap-8">
            {["Home", "About", "Hotels", "Services", "Contact"].map((l) => (
              <a key={l} href={`#${l.toLowerCase()}`} className="text-[14px] text-[#4a4a45] hover:text-[#2c4a35] transition-colors duration-200">
                {l}
              </a>
            ))}
          </div>

          <div className="hidden lg:flex items-center gap-4">
            <button className="text-[14px] text-[#4a4a45] hover:text-[#2c4a35] transition-colors">Sign In</button>
            <button className="px-5 py-2.5 bg-[#2c4a35] text-white text-[13px] font-medium rounded-full hover:bg-[#3d6349] transition-colors duration-200">
              Book Now
            </button>
          </div>

          <button className="lg:hidden text-[#4a4a45]" onClick={() => setMenuOpen(!menuOpen)}>
            <div className="space-y-1.5 w-6">
              <span className={`block h-px bg-current transition-all duration-300 ${menuOpen ? "rotate-45 translate-y-2" : "w-6"}`} />
              <span className={`block h-px bg-current transition-all duration-300 ${menuOpen ? "opacity-0 w-6" : "w-4"}`} />
              <span className={`block h-px bg-current transition-all duration-300 ${menuOpen ? "-rotate-45 -translate-y-2 w-6" : "w-6"}`} />
            </div>
          </button>
        </div>

        {menuOpen && (
          <div className="lg:hidden bg-[#f5f1eb] border-t border-[#ddd8ce] px-6 py-5 space-y-3">
            {["Home", "About", "Hotels", "Services", "Contact"].map((l) => (
              <a key={l} href={`#${l.toLowerCase()}`} className="block text-[14px] text-[#4a4a45] hover:text-[#2c4a35]" onClick={() => setMenuOpen(false)}>{l}</a>
            ))}
            <button className="mt-2 w-full py-2.5 bg-[#2c4a35] text-white text-[13px] font-medium rounded-full">Book Now</button>
          </div>
        )}
      </nav>

      {/* ── HERO ── */}
      <section className="pt-[68px] min-h-screen grid lg:grid-cols-[1fr_1fr] overflow-hidden">
        {/* Left */}
        <div className="flex flex-col justify-center px-6 lg:pl-16 xl:pl-24 pr-8 py-16 lg:py-0">
          <div className="mb-5 flex items-center gap-2">
            <span className="text-[11px] tracking-[0.18em] uppercase text-[#8a8a82]">Hotel Booking Platform</span>
          </div>
          <h1 className="font-display text-[52px] lg:text-[64px] xl:text-[76px] leading-[1.07] font-light text-[#1a1a18] mb-6">
            Discover Hotels<br />
            for a{" "}
            <span className="italic text-[#2c4a35]">Better Stay</span>
          </h1>
          <p className="text-[15px] text-[#6b6b63] leading-relaxed max-w-md mb-10">
            At Aurum, we curate timeless and exceptional properties that inspire, elevate, and bring your vision of travel to life.
          </p>

          <div className="flex items-center gap-4 mb-14">
            <button className="flex items-center gap-3 px-6 py-3.5 bg-[#2c4a35] text-white text-[14px] font-medium rounded-full hover:bg-[#3d6349] transition-colors duration-200">
              Explore Hotels
              <span className="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-xs">→</span>
            </button>
            <button className="text-[14px] text-[#4a4a45] hover:text-[#2c4a35] transition-colors flex items-center gap-2">
              View Portfolio <span>↗</span>
            </button>
          </div>

          {/* Stats */}
          <div className="flex gap-8 pt-8 border-t border-[#ddd8ce]">
            {[
              { n: "10+", label: "Years\nExperience" },
              { n: "250+", label: "Hotels\nCurated" },
              { n: "98%", label: "Guest\nSatisfaction" },
              { n: "40+", label: "Countries\nCovered" },
            ].map(({ n, label }) => (
              <div key={n}>
                <div className="font-display text-[28px] lg:text-[32px] font-semibold text-[#1a1a18]">{n}</div>
                <div className="text-[11px] text-[#8a8a82] mt-0.5 whitespace-pre-line leading-tight">{label}</div>
              </div>
            ))}
          </div>
        </div>

        {/* Right — arched hero image */}
        <div className="relative hidden lg:flex items-center justify-end pr-8 py-8 bg-[#f5f1eb]">
          <div
            className="relative w-full max-w-[520px] h-[calc(100vh-84px)] overflow-hidden"
            style={{ borderRadius: "240px 240px 24px 24px" }}
          >
            <img
              src="https://images.unsplash.com/photo-1742844552700-3926862c5311?w=900&h=1100&fit=crop&auto=format"
              alt="Elegant hotel interior with panoramic views"
              className="w-full h-full object-cover"
            />
            {/* Float badge */}
            <div className="absolute bottom-10 left-8 right-8 bg-white/90 backdrop-blur-sm rounded-2xl p-5 shadow-xl">
              <div className="flex items-center justify-between mb-3">
                <div className="text-[12px] text-[#8a8a82] uppercase tracking-wide">Next Available</div>
                <div className="text-[#2c4a35] text-[12px] font-medium">Amalfi Crest</div>
              </div>
              <div className="grid grid-cols-3 gap-3">
                <div>
                  <div className="text-[10px] text-[#aaa] mb-1">Check In</div>
                  <input type="date" value={checkIn} onChange={(e) => setCheckIn(e.target.value)}
                    className="text-[12px] text-[#1a1a18] border-0 outline-none bg-transparent w-full [color-scheme:light]" />
                </div>
                <div>
                  <div className="text-[10px] text-[#aaa] mb-1">Check Out</div>
                  <input type="date" value={checkOut} onChange={(e) => setCheckOut(e.target.value)}
                    className="text-[12px] text-[#1a1a18] border-0 outline-none bg-transparent w-full [color-scheme:light]" />
                </div>
                <div className="flex items-end">
                  <button className="w-full py-2 bg-[#2c4a35] text-white text-[11px] font-medium rounded-lg hover:bg-[#3d6349] transition-colors">
                    Search
                  </button>
                </div>
              </div>
            </div>
          </div>

          {/* Side scroll label */}
          <div className="absolute left-4 top-1/2 -translate-y-1/2 flex flex-col items-center gap-2">
            <div className="text-[10px] tracking-[0.3em] uppercase text-[#bbb] rotate-90 whitespace-nowrap mb-6">Scroll to explore</div>
            <div className="w-px h-16 bg-[#ddd8ce]" />
          </div>
        </div>
      </section>

      {/* ── RIGHT PANEL STRIP (Vision + Testimonial) ── */}
      <section className="bg-[#ece7de] py-16 px-6 lg:px-0">
        <div className="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 lg:px-10">
          {/* From Vision to Reality */}
          <div className="bg-white rounded-2xl p-8 flex gap-6">
            <div className="flex-1">
              <div className="text-[10px] tracking-[0.2em] uppercase text-[#8a8a82] mb-3">Our Approach</div>
              <h3 className="font-display text-[24px] font-medium leading-tight text-[#1a1a18] mb-3">
                From Vision<br />to Reality
              </h3>
              <p className="text-[13px] text-[#6b6b63] leading-relaxed mb-5">
                Every great space starts with a vision. At Aurum, we guide you through every step — discovering a seamless and inspiring experience.
              </p>
              <button className="flex items-center gap-2 text-[13px] text-[#2c4a35] font-medium hover:gap-3 transition-all">
                Our Process <span>→</span>
              </button>
            </div>
            <div className="w-28 flex-none">
              <div className="h-28 rounded-xl overflow-hidden">
                <img
                  src="https://images.unsplash.com/photo-1646991761123-d83ce47c30c9?w=200&h=200&fit=crop&auto=format"
                  alt="Hotel lobby"
                  className="w-full h-full object-cover"
                />
              </div>
            </div>
          </div>

          {/* Testimonial preview */}
          <div className="bg-[#2c4a35] rounded-2xl p-8 text-white">
            <div className="text-[10px] tracking-[0.2em] uppercase text-[#a8c4a8] mb-3">Client Testimonials</div>
            <h3 className="font-display text-[22px] font-light italic leading-tight mb-5">
              "What Our Guests Say"
            </h3>
            <div style={{ animation: "fadeSlide 0.5s ease" }} key={activeTesti}>
              <p className="text-[13px] text-[#c8d8c8] leading-relaxed mb-5">
                "{TESTIMONIALS[activeTesti].quote}"
              </p>
              <div className="flex items-center gap-3">
                <div className="w-9 h-9 rounded-full bg-[#3d6349] flex items-center justify-center text-[11px] font-semibold">
                  {TESTIMONIALS[activeTesti].author.split(" ").map((n) => n[0]).join("")}
                </div>
                <div>
                  <div className="text-[13px] font-medium">{TESTIMONIALS[activeTesti].author}</div>
                  <div className="text-[11px] text-[#a8c4a8]">{TESTIMONIALS[activeTesti].title}</div>
                </div>
                <div className="ml-auto flex gap-1">
                  {[...Array(TESTIMONIALS[activeTesti].rating)].map((_, i) => (
                    <span key={i} className="text-[#e8c87a] text-xs">★</span>
                  ))}
                </div>
              </div>
            </div>
            <div className="flex gap-1.5 mt-6">
              {TESTIMONIALS.map((_, i) => (
                <button key={i} onClick={() => setActiveTesti(i)}
                  className={`h-1 rounded-full transition-all duration-300 ${i === activeTesti ? "w-6 bg-white" : "w-3 bg-white/30"}`} />
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ── ABOUT SPLIT ── */}
      <section id="about" className="py-24 px-6 lg:px-10 max-w-[1280px] mx-auto">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          {/* Images */}
          <div className="relative">
            <div className="grid grid-cols-2 gap-4">
              <div
                className="h-[380px] overflow-hidden col-span-1"
                style={{ borderRadius: "160px 160px 16px 16px" }}
              >
                <img
                  src="https://images.unsplash.com/photo-1679310289844-68ea389b37ac?w=500&h=700&fit=crop&auto=format"
                  alt="Luxury resort pool"
                  className="w-full h-full object-cover"
                />
              </div>
              <div className="flex flex-col gap-4">
                <div className="h-[220px] overflow-hidden rounded-2xl">
                  <img
                    src="https://images.unsplash.com/photo-1701421016474-09b19faa9f77?w=400&h=400&fit=crop&auto=format"
                    alt="Hotel pool view"
                    className="w-full h-full object-cover"
                  />
                </div>
                {/* Badge */}
                <div className="flex-1 bg-[#2c4a35] rounded-2xl flex flex-col items-center justify-center text-white p-6">
                  <div className="font-display text-[42px] font-semibold">10+</div>
                  <div className="text-[11px] text-[#a8c4a8] text-center leading-tight mt-1">Years of<br />Experience</div>
                </div>
              </div>
            </div>
          </div>

          {/* Text */}
          <div>
            <div className="text-[10px] tracking-[0.25em] uppercase text-[#8a8a82] mb-4">About Aurum</div>
            <h2 className="font-display text-[42px] lg:text-[52px] font-light leading-[1.1] text-[#1a1a18] mb-6">
              We Curate<br />
              <span className="italic text-[#2c4a35]">Meaningful</span> Stays
            </h2>
            <p className="text-[15px] text-[#6b6b63] leading-relaxed mb-5">
              Aurum is a modern hotel booking platform focused on creating beautiful, functional, and timeless travel experiences. We blend curation with technology to design journeys that reflect your lifestyle and values.
            </p>
            <p className="text-[15px] text-[#6b6b63] leading-relaxed mb-8">
              Every property in our portfolio is personally visited by our editorial team — only the top 4% of submitted hotels earn their place.
            </p>
            <button className="flex items-center gap-2 text-[14px] text-[#2c4a35] font-medium hover:gap-3 transition-all duration-200">
              Learn More <span>→</span>
            </button>
          </div>
        </div>
      </section>

      {/* ── SEARCH BAR ── */}
      <div className="px-6 lg:px-10 max-w-[1280px] mx-auto mb-8">
        <div className="bg-white border border-[#ddd8ce] rounded-2xl p-2 shadow-sm">
          <div className="grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x divide-[#ddd8ce]">
            <div className="px-5 py-3 md:col-span-2">
              <div className="text-[10px] tracking-[0.15em] uppercase text-[#8a8a82] mb-1">Destination</div>
              <input
                type="text"
                placeholder="City, hotel or resort"
                value={destination}
                onChange={(e) => setDestination(e.target.value)}
                className="w-full text-[14px] text-[#1a1a18] placeholder-[#bbb] outline-none bg-transparent"
              />
            </div>
            <div className="px-5 py-3">
              <div className="text-[10px] tracking-[0.15em] uppercase text-[#8a8a82] mb-1">Check In</div>
              <input type="date" value={checkIn} onChange={(e) => setCheckIn(e.target.value)}
                className="w-full text-[14px] text-[#1a1a18] outline-none bg-transparent [color-scheme:light]" />
            </div>
            <div className="px-5 py-3">
              <div className="text-[10px] tracking-[0.15em] uppercase text-[#8a8a82] mb-1">Check Out</div>
              <input type="date" value={checkOut} onChange={(e) => setCheckOut(e.target.value)}
                className="w-full text-[14px] text-[#1a1a18] outline-none bg-transparent [color-scheme:light]" />
            </div>
            <div className="px-5 py-3 flex items-center gap-3">
              <div className="flex-1">
                <div className="text-[10px] tracking-[0.15em] uppercase text-[#8a8a82] mb-1">Guests</div>
                <select value={guests} onChange={(e) => setGuests(e.target.value)}
                  className="w-full text-[14px] text-[#1a1a18] outline-none bg-transparent appearance-none">
                  {["1 Guest", "2 Guests", "3 Guests", "4 Guests", "5+ Guests"].map((g) => (
                    <option key={g} value={g}>{g}</option>
                  ))}
                </select>
              </div>
              <button className="px-5 py-2.5 bg-[#2c4a35] text-white text-[12px] font-medium rounded-xl hover:bg-[#3d6349] transition-colors whitespace-nowrap">
                Search
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* ── SERVICES / CATEGORIES ── */}
      <section id="services" className="py-16 px-6 lg:px-10 max-w-[1280px] mx-auto">
        <div className="flex items-center justify-between mb-10">
          <div>
            <div className="text-[10px] tracking-[0.25em] uppercase text-[#8a8a82] mb-3">Our Services</div>
            <h2 className="font-display text-[36px] lg:text-[44px] font-light leading-tight text-[#1a1a18]">
              What We <span className="italic text-[#2c4a35]">Offer</span>
            </h2>
          </div>
          <button className="hidden lg:flex items-center gap-2 text-[13px] text-[#2c4a35] border border-[#2c4a35] px-5 py-2.5 rounded-full hover:bg-[#2c4a35] hover:text-white transition-all duration-200">
            View All Services <span>→</span>
          </button>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
          {SERVICES.map((s) => (
            <div key={s.title} className="group bg-white border border-[#ece7de] rounded-2xl overflow-hidden hover:border-[#2c4a35] hover:shadow-md transition-all duration-300 cursor-pointer">
              <div className="h-[140px] overflow-hidden">
                <img
                  src={s.image}
                  alt={s.title}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>
              <div className="p-5">
                <h3 className="text-[14px] font-semibold text-[#1a1a18] mb-1.5">{s.title}</h3>
                <p className="text-[12px] text-[#8a8a82] leading-relaxed mb-3">{s.desc}</p>
                <button className="text-[12px] text-[#2c4a35] font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                  Learn More <span>→</span>
                </button>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* ── FEATURED HOTELS ── */}
      <section id="hotels" className="py-16 px-6 lg:px-10 max-w-[1280px] mx-auto">
        <div className="flex items-center justify-between mb-10">
          <div>
            <div className="text-[10px] tracking-[0.25em] uppercase text-[#8a8a82] mb-3">Our Portfolio</div>
            <h2 className="font-display text-[36px] lg:text-[44px] font-light leading-tight text-[#1a1a18]">
              Featured <span className="italic text-[#2c4a35]">Hotels</span>
            </h2>
          </div>
          <div className="flex gap-3 items-center">
            <div className="hidden lg:flex gap-2 flex-wrap">
              {FILTERS.map((f) => (
                <button key={f} onClick={() => setActiveFilter(f)}
                  className={`px-4 py-1.5 rounded-full text-[12px] font-medium border transition-all duration-200 ${
                    activeFilter === f
                      ? "bg-[#2c4a35] text-white border-[#2c4a35]"
                      : "border-[#ddd8ce] text-[#6b6b63] hover:border-[#2c4a35] hover:text-[#2c4a35]"
                  }`}>
                  {f}
                </button>
              ))}
            </div>
            <button className="hidden lg:flex items-center gap-2 text-[13px] text-[#2c4a35] border border-[#2c4a35] px-5 py-2.5 rounded-full hover:bg-[#2c4a35] hover:text-white transition-all duration-200">
              View All Projects →
            </button>
          </div>
        </div>

        {/* Mobile filters */}
        <div className="flex gap-2 flex-wrap lg:hidden mb-6">
          {FILTERS.map((f) => (
            <button key={f} onClick={() => setActiveFilter(f)}
              className={`px-4 py-1.5 rounded-full text-[12px] font-medium border transition-all duration-200 ${
                activeFilter === f ? "bg-[#2c4a35] text-white border-[#2c4a35]" : "border-[#ddd8ce] text-[#6b6b63]"
              }`}>
              {f}
            </button>
          ))}
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filtered.map((hotel, idx) => (
            <div
              key={hotel.id}
              className="group bg-white rounded-2xl overflow-hidden border border-[#ece7de] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer"
              style={idx === 0 ? { gridColumn: "span 1" } : {}}
            >
              <div className="relative overflow-hidden h-[260px]">
                <img
                  src={hotel.image}
                  alt={hotel.name}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-600"
                />
                <div className="absolute top-4 left-4">
                  <span className="bg-white/90 backdrop-blur-sm text-[#2c4a35] text-[10px] tracking-[0.15em] uppercase font-semibold px-3 py-1 rounded-full">
                    {hotel.tag}
                  </span>
                </div>
                <div className="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-1">
                  <span className="text-[#e8a020] text-xs">★</span>
                  <span className="text-[12px] font-semibold text-[#1a1a18]">{hotel.rating}</span>
                </div>
              </div>
              <div className="p-5">
                <div className="text-[11px] text-[#8a8a82] mb-1">{hotel.location}</div>
                <h3 className="font-display text-[20px] font-medium text-[#1a1a18] mb-2">{hotel.name}</h3>
                <p className="text-[12px] text-[#8a8a82] mb-4 leading-relaxed">{hotel.desc}</p>
                <div className="flex items-center justify-between pt-4 border-t border-[#f0ece5]">
                  <div>
                    <span className="text-[10px] text-[#bbb] uppercase">From </span>
                    <span className="font-display text-[22px] font-semibold text-[#1a1a18]">${hotel.price.toLocaleString()}</span>
                    <span className="text-[11px] text-[#bbb]">/night</span>
                  </div>
                  <button className="px-4 py-2 bg-[#2c4a35] text-white text-[12px] font-medium rounded-full hover:bg-[#3d6349] transition-colors">
                    Reserve
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* ── NEWSLETTER + FOOTER COLUMNS ── */}
      <section className="bg-[#ece7de] py-16 px-6 lg:px-10">
        <div className="max-w-[1280px] mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Newsletter */}
          <div className="lg:col-span-2 bg-[#2c4a35] rounded-2xl p-10 relative overflow-hidden">
            <div
              className="absolute right-0 top-0 w-48 h-48 rounded-full opacity-10"
              style={{ background: "radial-gradient(circle, #fff, transparent)", transform: "translate(30%,-30%)" }}
            />
            <div className="text-[10px] tracking-[0.2em] uppercase text-[#a8c4a8] mb-4">Stay Updated</div>
            <h2 className="font-display text-[32px] lg:text-[40px] font-light text-white leading-tight mb-3">
              Join Our<br />
              <span className="italic">Newsletter</span>
            </h2>
            <p className="text-[13px] text-[#a8c4a8] mb-8 max-w-sm leading-relaxed">
              Get the latest hotel drops, exclusive rates, and curated city guides delivered weekly.
            </p>
            {subscribed ? (
              <div className="text-[#c8d8c8] text-[14px]">✓ You&apos;re subscribed. Expect the extraordinary.</div>
            ) : (
              <div className="flex gap-0 max-w-sm">
                <input
                  type="email"
                  placeholder="Your email address"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="flex-1 bg-white/10 border border-white/20 text-white placeholder-[#a8c4a8] px-5 py-3 text-[13px] outline-none rounded-l-full focus:bg-white/15 transition-colors"
                />
                <button
                  onClick={() => email && setSubscribed(true)}
                  className="px-5 py-3 bg-white text-[#2c4a35] text-[13px] font-semibold rounded-r-full hover:bg-[#f5f1eb] transition-colors whitespace-nowrap"
                >
                  Subscribe →
                </button>
              </div>
            )}
          </div>

          {/* Quick brand card */}
          <div className="bg-white rounded-2xl p-8 flex flex-col justify-between">
            <div>
              <div className="flex items-center gap-2.5 mb-5">
                <div className="w-8 h-8 bg-[#2c4a35] rounded-sm flex items-center justify-center">
                  <span className="text-white text-[11px] font-semibold">A</span>
                </div>
                <span className="font-display text-[18px] font-semibold text-[#1a1a18]">Aurum</span>
              </div>
              <p className="text-[13px] text-[#8a8a82] leading-relaxed mb-6">
                We design travel experiences that inspire and endure. Your journey starts here.
              </p>
              <div className="flex gap-3 mb-8">
                {["f", "ig", "in", "yt"].map((s) => (
                  <div key={s} className="w-8 h-8 border border-[#ddd8ce] rounded-full flex items-center justify-center text-[10px] text-[#8a8a82] hover:border-[#2c4a35] hover:text-[#2c4a35] cursor-pointer transition-all">
                    {s}
                  </div>
                ))}
              </div>
            </div>
            <div className="text-[11px] text-[#bbb]">© 2026 Aurum Collection. All rights reserved.</div>
          </div>
        </div>
      </section>

      {/* ── FOOTER ── */}
      <footer className="bg-[#1c1a14] text-white py-12 px-6 lg:px-10">
        <div className="max-w-[1280px] mx-auto grid grid-cols-2 lg:grid-cols-5 gap-8">
          <div className="col-span-2 lg:col-span-1">
            <div className="flex items-center gap-2.5 mb-4">
              <div className="w-7 h-7 bg-[#3d6349] rounded-sm flex items-center justify-center">
                <span className="text-white text-[10px] font-semibold">A</span>
              </div>
              <span className="font-display text-[16px]">Aurum</span>
            </div>
            <p className="text-[12px] text-[#666] leading-relaxed">
              Curated hospitality for the discerning traveler.
            </p>
          </div>
          {[
            { title: "Quick Links", links: ["Home", "About", "Portfolio", "Services", "Contact"] },
            { title: "Services", links: ["Beach Resorts", "Mountain Lodges", "City Hotels", "Eco Retreats", "Private Islands"] },
            { title: "Contact", links: ["+1 800 000 000", "hello@aurum.co", "New York, USA", "Mon–Fri 9–6pm"] },
          ].map(({ title, links }) => (
            <div key={title}>
              <div className="text-[11px] tracking-[0.2em] uppercase text-[#3d6349] mb-4">{title}</div>
              <ul className="space-y-2.5">
                {links.map((l) => (
                  <li key={l}><a href="#" className="text-[12px] text-[#666] hover:text-[#a8c4a8] transition-colors">{l}</a></li>
                ))}
              </ul>
            </div>
          ))}
        </div>
        <div className="max-w-[1280px] mx-auto mt-10 pt-6 border-t border-[#2e2b20] flex flex-col lg:flex-row items-center justify-between gap-3 text-[11px] text-[#4a4640]">
          <span>© 2026 Aurum. All rights reserved.</span>
          <span>Designed for beautiful experiences</span>
        </div>
      </footer>

      <style>{`
        @keyframes fadeSlide {
          from { opacity: 0; transform: translateY(8px); }
          to { opacity: 1; transform: translateY(0); }
        }
      `}</style>
    </div>
  );
}
