import { useState } from "react";
import { Product } from "@shared/schema";
import { Link } from "wouter";
import { useCart } from "@/context/CartContext";
import { Star, StarHalf, Eye, Heart, ShoppingBag } from "lucide-react";
import { Button } from "@/components/ui/button";
import QuickViewModal from "./QuickViewModal";

interface ProductCardProps {
  product: Product;
}

const ProductCard = ({ product }: ProductCardProps) => {
  const [showQuickView, setShowQuickView] = useState(false);
  const { addToCart } = useCart();

  const handleAddToCart = (e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    addToCart(product.id, 1);
  };

  const openQuickView = (e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    setShowQuickView(true);
  };

  // Format price to USD
  const formatPrice = (price: string) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD'
    }).format(Number(price));
  };

  // Render rating stars
  const renderRating = (rating: string | null) => {
    if (!rating) return null;
    
    const ratingNum = parseFloat(rating);
    const fullStars = Math.floor(ratingNum);
    const hasHalfStar = ratingNum % 1 !== 0;
    
    return (
      <div className="flex text-[#d4af37] text-sm">
        {Array(fullStars).fill(0).map((_, i) => (
          <Star key={i} fill="#d4af37" className="h-4 w-4" />
        ))}
        {hasHalfStar && <StarHalf fill="#d4af37" className="h-4 w-4" />}
      </div>
    );
  };

  return (
    <>
      <Link href={`/product/${product.slug}`}>
        <div className="product-card group relative bg-white rounded-lg overflow-hidden shadow-md transition duration-300 hover:shadow-lg cursor-pointer">
          <div className="relative aspect-square overflow-hidden">
            <img 
              src={product.imageUrl} 
              alt={product.name} 
              className="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110"
            />
            <div className="product-actions absolute inset-0 bg-[#0a2342]/30 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
              <div className="flex space-x-2">
                <Button
                  variant="outline"
                  size="icon"
                  className="bg-white text-[#0a2342] p-2 rounded-full hover:bg-[#d4af37] hover:text-white transition-colors"
                  onClick={openQuickView}
                >
                  <Eye className="h-4 w-4" />
                </Button>
                <Button
                  variant="outline"
                  size="icon"
                  className="bg-white text-[#0a2342] p-2 rounded-full hover:bg-[#d4af37] hover:text-white transition-colors"
                >
                  <Heart className="h-4 w-4" />
                </Button>
                <Button
                  variant="outline"
                  size="icon"
                  className="bg-white text-[#0a2342] p-2 rounded-full hover:bg-[#d4af37] hover:text-white transition-colors"
                  onClick={handleAddToCart}
                >
                  <ShoppingBag className="h-4 w-4" />
                </Button>
              </div>
            </div>
          </div>
          <div className="px-4 py-5">
            <h3 className="text-lg font-semibold font-serif">{product.name}</h3>
            <div className="flex justify-between items-center mt-2">
              <p className="text-[#d4af37] font-medium">{formatPrice(product.price)}</p>
              {renderRating(product.rating)}
            </div>
          </div>
        </div>
      </Link>

      {showQuickView && (
        <QuickViewModal 
          product={product}
          onClose={() => setShowQuickView(false)}
        />
      )}
    </>
  );
};

export default ProductCard;
