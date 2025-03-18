import { Link } from "wouter";
import { Button } from "@/components/ui/button";

const HeroSection = () => {
  return (
    <section className="relative h-[70vh] bg-[#0a2342] overflow-hidden">
      <div className="absolute inset-0 overflow-hidden">
        <img 
          src="https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80" 
          alt="Luxury jewelry collection" 
          className="object-cover w-full h-full opacity-60"
        />
      </div>
      <div className="absolute inset-0 bg-gradient-to-r from-[#0a2342]/70 to-[#0a2342]/30"></div>
      <div className="relative container mx-auto px-4 h-full flex flex-col justify-center">
        <div className="max-w-xl">
          <h2 className="text-4xl md:text-5xl lg:text-6xl font-bold font-serif text-white leading-tight">
            Timeless Elegance <span className="text-[#d4af37]">Redefined</span>
          </h2>
          <p className="mt-4 text-white/90 text-lg md:text-xl">
            Discover our exquisite collection of handcrafted jewelry pieces that celebrate your unique story.
          </p>
          <div className="mt-8 flex flex-col sm:flex-row gap-4">
            <Button
              asChild
              className="bg-[#d4af37] hover:bg-[#d4af37]/90 text-black py-3 px-8"
              size="lg"
            >
              <Link href="/collections">
                Shop Collection
              </Link>
            </Button>
            <Button
              asChild
              className="bg-[#d4af37] hover:bg-[#d4af37]/90 text-black py-3 px-8"
              size="lg"
            >
              <Link href="/custom">
                Custom Design
              </Link>
            </Button>
          </div>
        </div>
      </div>
    </section>
  );
};

export default HeroSection;
