import { useCart } from "@/context/CartContext";
import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { X, Minus, Plus, Trash2 } from "lucide-react";
import { Skeleton } from "@/components/ui/skeleton";

interface CartSidebarProps {
  isOpen: boolean;
  onClose: () => void;
}

const CartSidebar = ({ isOpen, onClose }: CartSidebarProps) => {
  const { cartItems, isLoading, updateCartItem, removeFromCart, clearCart } = useCart();

  // Calculate subtotal
  const subtotal = cartItems.reduce((total, item) => {
    return total + (Number(item.product?.price) * item.quantity);
  }, 0);

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD'
    }).format(price);
  };

  return (
    <div 
      className={`fixed top-0 right-0 w-full md:w-96 h-full bg-white shadow-lg z-50 transform transition-transform duration-300 ${
        isOpen ? 'translate-x-0' : 'translate-x-full'
      }`}
    >
      <div className="h-full flex flex-col">
        <div className="p-4 bg-[#0a2342] text-white flex justify-between items-center">
          <h3 className="text-xl font-semibold">Your Cart ({cartItems.length})</h3>
          <Button 
            variant="ghost" 
            onClick={onClose}
            className="text-white hover:text-[#d4af37] -mr-2"
          >
            <X className="h-6 w-6" />
          </Button>
        </div>

        <div className="overflow-y-auto flex-grow p-4">
          {isLoading ? (
            // Loading skeleton
            Array(3).fill(0).map((_, index) => (
              <div key={index} className="flex items-center border-b border-[#e5e5e5] py-4">
                <Skeleton className="w-20 h-20 rounded" />
                <div className="ml-4 flex-grow">
                  <Skeleton className="h-5 w-4/5 mb-2" />
                  <Skeleton className="h-4 w-2/5 mb-3" />
                  <div className="flex justify-between items-center">
                    <Skeleton className="h-8 w-24" />
                    <Skeleton className="h-5 w-16" />
                  </div>
                </div>
                <Skeleton className="ml-2 h-8 w-8 rounded-full" />
              </div>
            ))
          ) : cartItems.length === 0 ? (
            <div className="flex flex-col items-center justify-center h-full">
              <p className="text-gray-500 mb-4">Your cart is empty</p>
              <Button
                variant="outline"
                onClick={onClose}
                className="hover:bg-[#0a2342] hover:text-white"
              >
                Continue Shopping
              </Button>
            </div>
          ) : (
            cartItems.map((item) => (
              <div key={item.id} className="flex items-center border-b border-[#e5e5e5] py-4">
                <div className="w-20 h-20 rounded overflow-hidden flex-shrink-0">
                  <img 
                    src={item.product?.imageUrl} 
                    alt={item.product?.name} 
                    className="object-cover w-full h-full"
                  />
                </div>
                <div className="ml-4 flex-grow">
                  <h4 className="font-medium">{item.product?.name}</h4>
                  {item.size && <p className="text-sm text-gray-500">Size: {item.size}</p>}
                  {item.color && <p className="text-sm text-gray-500">Color: {item.color}</p>}
                  <div className="flex justify-between items-center mt-2">
                    <div className="flex items-center border rounded">
                      <Button
                        variant="ghost"
                        size="icon"
                        className="h-8 w-8 p-0"
                        onClick={() => updateCartItem(item.id, item.quantity - 1)}
                        disabled={item.quantity <= 1}
                      >
                        <Minus className="h-3 w-3" />
                      </Button>
                      <span className="px-2 py-1">{item.quantity}</span>
                      <Button
                        variant="ghost"
                        size="icon"
                        className="h-8 w-8 p-0"
                        onClick={() => updateCartItem(item.id, item.quantity + 1)}
                      >
                        <Plus className="h-3 w-3" />
                      </Button>
                    </div>
                    <p className="font-medium text-[#0a2342]">
                      {formatPrice(Number(item.product?.price) * item.quantity)}
                    </p>
                  </div>
                </div>
                <Button
                  variant="ghost"
                  size="icon"
                  className="ml-2 text-gray-500 hover:text-[#b00020]"
                  onClick={() => removeFromCart(item.id)}
                >
                  <Trash2 className="h-4 w-4" />
                </Button>
              </div>
            ))
          )}
        </div>

        {cartItems.length > 0 && (
          <div className="border-t border-[#e5e5e5] p-4">
            <div className="flex justify-between mb-2">
              <span className="text-gray-600">Subtotal</span>
              <span className="font-medium">{formatPrice(subtotal)}</span>
            </div>
            <div className="flex justify-between mb-6">
              <span className="text-gray-600">Shipping</span>
              <span>Calculated at checkout</span>
            </div>
            <Button 
              className="w-full bg-[#d4af37] hover:bg-[#d4af37]/90 text-white font-medium mb-3"
            >
              Checkout Now
            </Button>
            <Button 
              variant="ghost"
              className="w-full text-[#0a2342] hover:text-[#d4af37] transition-colors"
              onClick={onClose}
            >
              Continue Shopping
            </Button>
          </div>
        )}
      </div>
    </div>
  );
};

export default CartSidebar;
