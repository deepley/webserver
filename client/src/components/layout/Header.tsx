import { useState } from "react";
import { Link, useLocation } from "wouter";
import { useCart } from "@/context/CartContext";
import CartSidebar from "./CartSidebar";
import { Search, User, ShoppingBag, Menu } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";

const Header = () => {
  const [location] = useLocation();
  const { cartItems } = useCart();
  const [isSearchOpen, setIsSearchOpen] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [isCartOpen, setIsCartOpen] = useState(false);

  const toggleSearch = () => setIsSearchOpen(!isSearchOpen);
  const toggleMobileMenu = () => setIsMobileMenuOpen(!isMobileMenuOpen);
  const toggleCart = () => setIsCartOpen(!isCartOpen);

  const isActiveLink = (path: string) => {
    return location === path;
  };

  return (
    <header className="bg-white shadow-md">
      <div className="container mx-auto px-4 py-3">
        <div className="flex justify-between items-center">
          {/* Mobile menu button */}
          <Button 
            variant="ghost" 
            size="icon"
            className="lg:hidden text-navy p-2"
            onClick={toggleMobileMenu}
          >
            <Menu className="h-6 w-6" />
          </Button>

          {/* Logo */}
          <div className="flex-1 lg:flex-initial text-center lg:text-left">
            <Link href="/" className="inline-block">
              <h1 className="text-2xl md:text-3xl font-bold font-serif text-[#0a2342]">
                Elegante<span className="text-[#d4af37]">Jewels</span>
              </h1>
            </Link>
          </div>

          {/* Desktop Navigation */}
          <nav className="hidden lg:flex flex-1 justify-center">
            <ul className="flex space-x-8 uppercase tracking-wider text-sm font-medium">
              <li>
                <Link 
                  href="/" 
                  className={`py-2 border-b-2 ${isActiveLink('/') ? 'border-[#d4af37]' : 'border-transparent hover:border-[#d4af37] transition-colors duration-300'}`}
                >
                  Home
                </Link>
              </li>
              <li>
                <Link 
                  href="/collections" 
                  className={`py-2 border-b-2 ${isActiveLink('/collections') ? 'border-[#d4af37]' : 'border-transparent hover:border-[#d4af37] transition-colors duration-300'}`}
                >
                  Collections
                </Link>
              </li>
              <li>
                <Link 
                  href="/custom" 
                  className={`py-2 border-b-2 ${isActiveLink('/custom') ? 'border-[#d4af37]' : 'border-transparent hover:border-[#d4af37] transition-colors duration-300'}`}
                >
                  Custom
                </Link>
              </li>
              <li>
                <Link 
                  href="/about" 
                  className={`py-2 border-b-2 ${isActiveLink('/about') ? 'border-[#d4af37]' : 'border-transparent hover:border-[#d4af37] transition-colors duration-300'}`}
                >
                  About
                </Link>
              </li>
              <li>
                <Link 
                  href="/contact" 
                  className={`py-2 border-b-2 ${isActiveLink('/contact') ? 'border-[#d4af37]' : 'border-transparent hover:border-[#d4af37] transition-colors duration-300'}`}
                >
                  Contact
                </Link>
              </li>
            </ul>
          </nav>

          {/* Icons */}
          <div className="flex items-center space-x-4">
            <Button 
              variant="ghost" 
              size="icon"
              className="p-2"
              onClick={toggleSearch}
            >
              <Search className="h-5 w-5 text-[#0a2342]" />
            </Button>
            
            <Button 
              variant="ghost" 
              size="icon"
              className="p-2"
              asChild
            >
              <Link href="/account">
                <User className="h-5 w-5 text-[#0a2342]" />
              </Link>
            </Button>
            
            <Button 
              variant="ghost" 
              size="icon"
              className="relative p-2"
              onClick={toggleCart}
            >
              <ShoppingBag className="h-5 w-5 text-[#0a2342]" />
              {cartItems.length > 0 && (
                <span className="absolute -top-2 -right-2 bg-[#d4af37] text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                  {cartItems.length}
                </span>
              )}
            </Button>
          </div>
        </div>

        {/* Search bar - hidden by default */}
        {isSearchOpen && (
          <div className="mt-3 pb-3 fade-in">
            <div className="relative">
              <Input 
                type="text" 
                placeholder="Search for jewelry..." 
                className="w-full border border-platinum rounded-md pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#d4af37]"
              />
              <Search className="absolute left-3 top-3 h-4 w-4 text-gray-400" />
            </div>
          </div>
        )}
      </div>

      {/* Mobile menu - hidden by default */}
      {isMobileMenuOpen && (
        <nav className="bg-white lg:hidden fade-in">
          <ul className="container mx-auto px-4 py-2 space-y-3 uppercase text-sm font-medium">
            <li>
              <Link 
                href="/" 
                className={`block py-2 px-4 text-[#0a2342] ${isActiveLink('/') ? 'border-l-4 border-[#d4af37]' : 'hover:bg-[#fffaf0] border-l-4 border-transparent'}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Home
              </Link>
            </li>
            <li>
              <Link 
                href="/collections" 
                className={`block py-2 px-4 text-[#0a2342] ${isActiveLink('/collections') ? 'border-l-4 border-[#d4af37]' : 'hover:bg-[#fffaf0] border-l-4 border-transparent'}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Collections
              </Link>
            </li>
            <li>
              <Link 
                href="/custom" 
                className={`block py-2 px-4 text-[#0a2342] ${isActiveLink('/custom') ? 'border-l-4 border-[#d4af37]' : 'hover:bg-[#fffaf0] border-l-4 border-transparent'}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Custom
              </Link>
            </li>
            <li>
              <Link 
                href="/about" 
                className={`block py-2 px-4 text-[#0a2342] ${isActiveLink('/about') ? 'border-l-4 border-[#d4af37]' : 'hover:bg-[#fffaf0] border-l-4 border-transparent'}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                About
              </Link>
            </li>
            <li>
              <Link 
                href="/contact" 
                className={`block py-2 px-4 text-[#0a2342] ${isActiveLink('/contact') ? 'border-l-4 border-[#d4af37]' : 'hover:bg-[#fffaf0] border-l-4 border-transparent'}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Contact
              </Link>
            </li>
          </ul>
        </nav>
      )}

      {/* Cart Sidebar */}
      <CartSidebar isOpen={isCartOpen} onClose={() => setIsCartOpen(false)} />
    </header>
  );
};

export default Header;
