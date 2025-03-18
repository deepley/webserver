import { useEffect, useState } from "react";
import { Product } from "@shared/schema";
import ProductDetail from "./ProductDetail";
import { X } from "lucide-react";
import { Button } from "@/components/ui/button";

interface QuickViewModalProps {
  product: Product;
  onClose: () => void;
}

const QuickViewModal = ({ product, onClose }: QuickViewModalProps) => {
  const [isOpen, setIsOpen] = useState(false);

  useEffect(() => {
    setIsOpen(true);
    
    // Disable body scroll
    document.body.style.overflow = 'hidden';
    
    // Cleanup function
    return () => {
      document.body.style.overflow = 'auto';
    };
  }, []);

  const handleClose = () => {
    setIsOpen(false);
    setTimeout(onClose, 300); // Wait for animation to complete
  };

  const handleOverlayClick = (e: React.MouseEvent<HTMLDivElement>) => {
    if (e.target === e.currentTarget) {
      handleClose();
    }
  };

  return (
    <div 
      className={`fixed inset-0 z-50 bg-black/50 flex items-center justify-center transition-opacity duration-300 ${
        isOpen ? 'opacity-100' : 'opacity-0'
      }`}
      onClick={handleOverlayClick}
    >
      <div className="container mx-auto h-full flex items-center justify-center px-4 py-8">
        <div 
          className={`bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto transition-transform duration-300 ${
            isOpen ? 'translate-y-0' : 'translate-y-8'
          }`}
        >
          <div className="relative">
            <Button
              variant="ghost"
              size="icon"
              className="absolute top-4 right-4 text-gray-500 hover:text-[#0a2342] z-10"
              onClick={handleClose}
            >
              <X className="h-6 w-6" />
            </Button>
            
            <ProductDetail product={product} />
          </div>
        </div>
      </div>
    </div>
  );
};

export default QuickViewModal;
