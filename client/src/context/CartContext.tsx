import { createContext, useContext, useState, useEffect, ReactNode } from "react";
import { apiRequest } from "@/lib/queryClient";
import { useToast } from "@/hooks/use-toast";

interface CartItem {
  id: number;
  userId: number;
  productId: number;
  quantity: number;
  size?: string;
  color?: string;
  product?: {
    id: number;
    name: string;
    price: string;
    imageUrl: string;
    slug: string;
  };
}

interface CartContextType {
  cartItems: CartItem[];
  isLoading: boolean;
  addToCart: (productId: number, quantity: number, size?: string, color?: string) => Promise<void>;
  updateCartItem: (cartItemId: number, quantity: number) => Promise<void>;
  removeFromCart: (cartItemId: number) => Promise<void>;
  clearCart: () => Promise<void>;
}

const CartContext = createContext<CartContextType | undefined>(undefined);

export function CartProvider({ children }: { children: ReactNode }) {
  const [cartItems, setCartItems] = useState<CartItem[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const { toast } = useToast();

  const fetchCart = async () => {
    try {
      setIsLoading(true);
      const response = await fetch('/api/cart', { credentials: 'include' });
      if (!response.ok) throw new Error('Failed to fetch cart');
      const data = await response.json();
      setCartItems(data);
    } catch (error) {
      console.error('Error fetching cart:', error);
      toast({
        title: "Error",
        description: "Failed to load cart items.",
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchCart();
  }, []);

  const addToCart = async (productId: number, quantity: number, size?: string, color?: string) => {
    try {
      setIsLoading(true);
      const response = await apiRequest('POST', '/api/cart', {
        productId,
        quantity,
        size,
        color
      });
      if (!response.ok) throw new Error('Failed to add to cart');
      toast({
        title: "Added to cart",
        description: "Item has been added to your cart.",
      });
      await fetchCart();
    } catch (error) {
      console.error('Error adding to cart:', error);
      toast({
        title: "Error",
        description: "Could not add item to cart.",
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  };

  const updateCartItem = async (cartItemId: number, quantity: number) => {
    try {
      setIsLoading(true);
      const response = await apiRequest('PUT', `/api/cart/${cartItemId}`, { quantity });
      if (!response.ok) throw new Error('Failed to update cart');
      await fetchCart();
    } catch (error) {
      console.error('Error updating cart:', error);
      toast({
        title: "Error",
        description: "Could not update cart item.",
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  };

  const removeFromCart = async (cartItemId: number) => {
    try {
      setIsLoading(true);
      const response = await apiRequest('DELETE', `/api/cart/${cartItemId}`, undefined);
      if (!response.ok) throw new Error('Failed to remove from cart');
      await fetchCart();
      toast({
        title: "Item removed",
        description: "Item has been removed from your cart.",
      });
    } catch (error) {
      console.error('Error removing from cart:', error);
      toast({
        title: "Error",
        description: "Could not remove item from cart.",
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  };

  const clearCart = async () => {
    try {
      setIsLoading(true);
      const response = await apiRequest('DELETE', '/api/cart', undefined);
      if (!response.ok) throw new Error('Failed to clear cart');
      await fetchCart();
      toast({
        title: "Cart cleared",
        description: "All items have been removed from your cart.",
      });
    } catch (error) {
      console.error('Error clearing cart:', error);
      toast({
        title: "Error",
        description: "Could not clear cart.",
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <CartContext.Provider
      value={{
        cartItems,
        isLoading,
        addToCart,
        updateCartItem,
        removeFromCart,
        clearCart,
      }}
    >
      {children}
    </CartContext.Provider>
  );
}

export function useCart() {
  const context = useContext(CartContext);
  if (context === undefined) {
    throw new Error("useCart must be used within a CartProvider");
  }
  return context;
}
