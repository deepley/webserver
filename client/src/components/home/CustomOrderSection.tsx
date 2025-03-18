import { Link } from "wouter";
import { Check } from "lucide-react";
import { Button } from "@/components/ui/button";

const CustomOrderSection = () => {
  return (
    <section className="py-20 bg-[#0a2342]">
      <div className="container mx-auto px-4">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold font-serif mb-4 text-white">
              Custom <span className="text-[#d4af37]">Designed</span> Jewelry
            </h2>
            <div className="w-20 h-1 bg-[#d4af37] mb-6"></div>
            <p className="text-white/80 mb-6 text-lg">
              Create a piece as unique as your story. Our expert artisans will work with you to design and craft bespoke jewelry that captures your vision.
            </p>
            <ul className="space-y-4 mb-8">
              <li className="flex items-start text-white/80">
                <Check className="text-[#d4af37] h-5 w-5 mr-3 mt-0.5" />
                <span>Personal consultation with our master jewelers</span>
              </li>
              <li className="flex items-start text-white/80">
                <Check className="text-[#d4af37] h-5 w-5 mr-3 mt-0.5" />
                <span>Custom sketches and 3D renderings of your design</span>
              </li>
              <li className="flex items-start text-white/80">
                <Check className="text-[#d4af37] h-5 w-5 mr-3 mt-0.5" />
                <span>Handcrafted with ethically sourced materials</span>
              </li>
              <li className="flex items-start text-white/80">
                <Check className="text-[#d4af37] h-5 w-5 mr-3 mt-0.5" />
                <span>Lifetime warranty on all custom creations</span>
              </li>
            </ul>
            <Button
              asChild
              className="bg-[#d4af37] hover:bg-[#d4af37]/90 text-black py-3 px-8"
            >
              <Link href="/custom">
                Start Your Custom Design
              </Link>
            </Button>
          </div>
          <div className="relative">
            <div className="aspect-[4/5] rounded-lg overflow-hidden">
              <img 
                src="https://images.unsplash.com/photo-1618403088890-3d9ff6f4c8b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                alt="Custom jewelry design process" 
                className="object-cover w-full h-full"
              />
            </div>
            <div className="absolute -bottom-6 -left-6 w-48 h-48 bg-[#d4af37]/20 rounded-lg -z-10"></div>
            <div className="absolute -top-6 -right-6 w-48 h-48 bg-[#d4af37]/20 rounded-lg -z-10"></div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default CustomOrderSection;
