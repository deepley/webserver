import { Link } from "wouter";
import { 
  Facebook, 
  Instagram, 
  Linkedin,
  Twitter,
  MapPin,
  Phone,
  Mail,
  Clock 
} from "lucide-react";

const Footer = () => {
  return (
    <footer className="bg-[#0a2342] text-white pt-16 pb-8">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
          <div>
            <h3 className="text-xl font-bold font-serif mb-6">
              Elegante<span className="text-[#d4af37]">Jewels</span>
            </h3>
            <p className="text-white/70 mb-6">
              Crafting timeless elegance since 1985. Each piece tells a unique story 
              through exceptional craftsmanship and ethically sourced materials.
            </p>
            <div className="flex space-x-4">
              <a href="#" className="text-white/70 hover:text-[#d4af37] transition-colors">
                <Facebook className="h-5 w-5" />
              </a>
              <a href="#" className="text-white/70 hover:text-[#d4af37] transition-colors">
                <Instagram className="h-5 w-5" />
              </a>
              <a href="#" className="text-white/70 hover:text-[#d4af37] transition-colors">
                <Linkedin className="h-5 w-5" />
              </a>
              <a href="#" className="text-white/70 hover:text-[#d4af37] transition-colors">
                <Twitter className="h-5 w-5" />
              </a>
            </div>
          </div>

          <div>
            <h4 className="text-lg font-semibold mb-6">Quick Links</h4>
            <ul className="space-y-3 text-white/70">
              <li>
                <Link href="/" className="hover:text-[#d4af37] transition-colors">
                  Home
                </Link>
              </li>
              <li>
                <Link href="/collections" className="hover:text-[#d4af37] transition-colors">
                  Shop Collections
                </Link>
              </li>
              <li>
                <Link href="/about" className="hover:text-[#d4af37] transition-colors">
                  About Us
                </Link>
              </li>
              <li>
                <Link href="/custom" className="hover:text-[#d4af37] transition-colors">
                  Custom Design
                </Link>
              </li>
              <li>
                <a href="#" className="hover:text-[#d4af37] transition-colors">
                  Care Guide
                </a>
              </li>
              <li>
                <Link href="/contact" className="hover:text-[#d4af37] transition-colors">
                  Contact Us
                </Link>
              </li>
            </ul>
          </div>

          <div>
            <h4 className="text-lg font-semibold mb-6">Collections</h4>
            <ul className="space-y-3 text-white/70">
              <li>
                <Link href="/collections/rings" className="hover:text-[#d4af37] transition-colors">
                  Rings
                </Link>
              </li>
              <li>
                <Link href="/collections/necklaces" className="hover:text-[#d4af37] transition-colors">
                  Necklaces
                </Link>
              </li>
              <li>
                <Link href="/collections/earrings" className="hover:text-[#d4af37] transition-colors">
                  Earrings
                </Link>
              </li>
              <li>
                <Link href="/collections/bracelets" className="hover:text-[#d4af37] transition-colors">
                  Bracelets
                </Link>
              </li>
              <li>
                <Link href="/collections/wedding" className="hover:text-[#d4af37] transition-colors">
                  Wedding & Engagement
                </Link>
              </li>
              <li>
                <Link href="/collections/mens" className="hover:text-[#d4af37] transition-colors">
                  Men's Collection
                </Link>
              </li>
            </ul>
          </div>

          <div>
            <h4 className="text-lg font-semibold mb-6">Contact Us</h4>
            <ul className="space-y-4 text-white/70">
              <li className="flex items-start">
                <MapPin className="text-[#d4af37] h-5 w-5 mr-3 mt-1" />
                <span>123 Luxury Lane, New York, NY 10001</span>
              </li>
              <li className="flex items-start">
                <Phone className="text-[#d4af37] h-5 w-5 mr-3 mt-1" />
                <span>+1 (212) 555-7890</span>
              </li>
              <li className="flex items-start">
                <Mail className="text-[#d4af37] h-5 w-5 mr-3 mt-1" />
                <span>contact@elegantejewels.com</span>
              </li>
              <li className="flex items-start">
                <Clock className="text-[#d4af37] h-5 w-5 mr-3 mt-1" />
                <span>Mon-Sat: 10am - 8pm<br />Sunday: 12pm - 6pm</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center">
          <p className="text-white/50 text-sm mb-4 md:mb-0">
            © 2023 Elegante Jewels. All rights reserved.
          </p>
          <div className="flex flex-wrap justify-center gap-4 text-white/50 text-sm">
            <a href="#" className="hover:text-[#d4af37] transition-colors">Privacy Policy</a>
            <a href="#" className="hover:text-[#d4af37] transition-colors">Terms of Service</a>
            <a href="#" className="hover:text-[#d4af37] transition-colors">Shipping Policy</a>
            <a href="#" className="hover:text-[#d4af37] transition-colors">Return Policy</a>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
