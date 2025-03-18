import { useState } from "react";
import { Product } from "@shared/schema";
import { useCart } from "@/context/CartContext";
import { 
  Star, 
  StarHalf, 
  ShoppingBag, 
  Heart, 
  Share2, 
  Truck, 
  ShieldCheck, 
  Gift, 
  Plus, 
  Minus 
} from "lucide-react";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

interface ProductDetailProps {
  product: Product;
}

const ProductDetail = ({ product }: ProductDetailProps) => {
  const [quantity, setQuantity] = useState(1);
  const [selectedSize, setSelectedSize] = useState<string | null>(null);
  const { addToCart } = useCart();
  const { toast } = useToast();

  const handleAddToCart = async () => {
    if (!selectedSize) {
      toast({
        title: "Please select a size",
        description: "You need to select a size before adding to cart",
        variant: "destructive",
      });
      return;
    }

    try {
      await addToCart(product.id, quantity, selectedSize);
    } catch (error) {
      console.error("Error adding to cart:", error);
    }
  };

  const incrementQuantity = () => setQuantity(prev => prev + 1);
  const decrementQuantity = () => setQuantity(prev => Math.max(1, prev - 1));

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
      <div className="flex text-[#d4af37] text-sm mb-4">
        {Array(fullStars).fill(0).map((_, i) => (
          <Star key={i} fill="#d4af37" className="h-4 w-4" />
        ))}
        {hasHalfStar && <StarHalf fill="#d4af37" className="h-4 w-4" />}
        <span className="text-gray-500 ml-2">(24 reviews)</span>
      </div>
    );
  };

  const sizes = ["5", "6", "7", "8", "9"];

  return (
    <div className="grid md:grid-cols-2 gap-6 p-6">
      <div className="aspect-square rounded-lg overflow-hidden">
        <img 
          src={product.imageUrl} 
          alt={product.name} 
          className="object-cover w-full h-full"
        />
      </div>
      <div>
        <h3 className="text-2xl font-bold font-serif mb-2">{product.name}</h3>
        {renderRating(product.rating)}
        <p className="text-xl font-medium text-[#d4af37] mb-4">{formatPrice(product.price)}</p>
        <p className="text-gray-600 mb-6">
          {product.description}
        </p>
        
        <div className="mb-6">
          <h4 className="font-medium mb-2">Size</h4>
          <div className="flex flex-wrap gap-2">
            {sizes.map((size) => (
              <Button
                key={size}
                variant="outline"
                className={`w-10 h-10 rounded-full ${
                  selectedSize === size 
                    ? 'border-[#d4af37] bg-[#d4af37]/5' 
                    : 'border-[#e5e5e5] hover:border-[#d4af37]'
                }`}
                onClick={() => setSelectedSize(size)}
              >
                {size}
              </Button>
            ))}
          </div>
        </div>
        
        <div className="flex items-center mb-6">
          <div className="flex items-center border rounded mr-4">
            <Button
              variant="ghost"
              onClick={decrementQuantity}
              disabled={quantity <= 1}
            >
              <Minus className="h-4 w-4" />
            </Button>
            <span className="px-3 py-2">{quantity}</span>
            <Button
              variant="ghost"
              onClick={incrementQuantity}
            >
              <Plus className="h-4 w-4" />
            </Button>
          </div>
          <Button
            className="flex-grow bg-[#0a2342] hover:bg-[#0a2342]/90 text-white font-medium py-3 px-6"
            onClick={handleAddToCart}
          >
            <ShoppingBag className="mr-2 h-4 w-4" /> Add to Cart
          </Button>
        </div>
        
        <div className="flex space-x-3 mb-6">
          <Button
            variant="outline"
            className="border-[#e5e5e5] hover:border-[#d4af37]"
          >
            <Heart className="mr-2 h-4 w-4" /> Wishlist
          </Button>
          <Button
            variant="outline"
            className="border-[#e5e5e5] hover:border-[#d4af37]"
          >
            <Share2 className="mr-2 h-4 w-4" /> Share
          </Button>
        </div>
        
        <div className="border-t border-[#e5e5e5] pt-6">
          <div className="flex items-center mb-2">
            <Truck className="text-[#d4af37] mr-2 h-4 w-4" />
            <span>Free shipping on orders over $1000</span>
          </div>
          <div className="flex items-center mb-2">
            <ShieldCheck className="text-[#d4af37] mr-2 h-4 w-4" />
            <span>30-day returns & lifetime warranty</span>
          </div>
          <div className="flex items-center">
            <Gift className="text-[#d4af37] mr-2 h-4 w-4" />
            <span>Complimentary gift packaging</span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductDetail;
