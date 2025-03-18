import { 
  users, type User, type InsertUser,
  categories, type Category, type InsertCategory,
  products, type Product, type InsertProduct,
  cartItems, type CartItem, type InsertCartItem,
  customOrders, type CustomOrder, type InsertCustomOrder,
  testimonials, type Testimonial, type InsertTestimonial,
  subscriptions, type Subscription, type InsertSubscription
} from "@shared/schema";

export interface IStorage {
  // User methods
  getUser(id: number): Promise<User | undefined>;
  getUserByUsername(username: string): Promise<User | undefined>;
  createUser(user: InsertUser): Promise<User>;

  // Category methods
  getCategories(): Promise<Category[]>;
  getCategoryBySlug(slug: string): Promise<Category | undefined>;
  createCategory(category: InsertCategory): Promise<Category>;

  // Product methods
  getProducts(): Promise<Product[]>;
  getProductsByCategory(categoryId: number): Promise<Product[]>;
  getProductBySlug(slug: string): Promise<Product | undefined>;
  getFeaturedProducts(): Promise<Product[]>;
  createProduct(product: InsertProduct): Promise<Product>;

  // Cart methods
  getCartItems(userId: number): Promise<CartItem[]>;
  getCartItemWithDetails(userId: number): Promise<any[]>;
  addToCart(cartItem: InsertCartItem): Promise<CartItem>;
  updateCartItem(id: number, quantity: number): Promise<CartItem | undefined>;
  removeFromCart(id: number): Promise<boolean>;
  clearCart(userId: number): Promise<boolean>;

  // Custom order methods
  createCustomOrder(order: InsertCustomOrder): Promise<CustomOrder>;
  getCustomOrders(): Promise<CustomOrder[]>;

  // Testimonial methods
  getTestimonials(): Promise<Testimonial[]>;
  createTestimonial(testimonial: InsertTestimonial): Promise<Testimonial>;

  // Subscription methods
  addSubscription(subscription: InsertSubscription): Promise<Subscription>;
}

export class MemStorage implements IStorage {
  private users: Map<number, User>;
  private categories: Map<number, Category>;
  private products: Map<number, Product>;
  private cartItems: Map<number, CartItem>;
  private customOrders: Map<number, CustomOrder>;
  private testimonials: Map<number, Testimonial>;
  private subscriptions: Map<number, Subscription>;
  
  private userId: number;
  private categoryId: number;
  private productId: number;
  private cartItemId: number;
  private customOrderId: number;
  private testimonialId: number;
  private subscriptionId: number;

  constructor() {
    this.users = new Map();
    this.categories = new Map();
    this.products = new Map();
    this.cartItems = new Map();
    this.customOrders = new Map();
    this.testimonials = new Map();
    this.subscriptions = new Map();
    
    this.userId = 1;
    this.categoryId = 1;
    this.productId = 1;
    this.cartItemId = 1;
    this.customOrderId = 1;
    this.testimonialId = 1;
    this.subscriptionId = 1;
  }

  // Initialize the database with sample data
  async init() {
    await this.initializeData();
    return this;
  }

  private async initializeData() {
    // Create categories
    const ringCategory = await this.createCategory({
      name: "Rings",
      slug: "rings",
      imageUrl: "https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80"
    });

    const necklaceCategory = await this.createCategory({
      name: "Necklaces",
      slug: "necklaces",
      imageUrl: "https://images.unsplash.com/photo-1611652022419-a9419f74613c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80"
    });

    const earringCategory = await this.createCategory({
      name: "Earrings",
      slug: "earrings",
      imageUrl: "https://images.unsplash.com/photo-1589128777073-53586befb9f8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80"
    });

    const braceletCategory = await this.createCategory({
      name: "Bracelets",
      slug: "bracelets",
      imageUrl: "https://images.unsplash.com/photo-1588891825655-aa240a492fe0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80"
    });

    // Create products
    await this.createProduct({
      name: "Celestial Diamond Ring",
      slug: "celestial-diamond-ring",
      description: "This exquisite ring features a brilliant-cut diamond surrounded by a halo of smaller diamonds, all set in 18k white gold. The celestial design is inspired by the night sky, creating a timeless piece that captures light from every angle.",
      price: "1250.00",
      imageUrl: "https://images.unsplash.com/photo-1605100804763-247f67b3557e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80",
      categoryId: ringCategory.id,
      featured: true,
      rating: "4.5",
      stock: 10
    });

    await this.createProduct({
      name: "Sapphire Cascade Necklace",
      slug: "sapphire-cascade-necklace",
      description: "An elegant cascade of blue sapphires set in white gold, this necklace embodies sophistication and grace. The graduated design creates a waterfall effect that beautifully catches the light.",
      price: "2450.00",
      imageUrl: "https://images.unsplash.com/photo-1602173574767-37ac01994b2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80",
      categoryId: necklaceCategory.id,
      featured: true,
      rating: "5.0",
      stock: 5
    });

    await this.createProduct({
      name: "Emerald Halo Earrings",
      slug: "emerald-halo-earrings",
      description: "These stunning earrings feature vibrant emeralds surrounded by a halo of diamonds, creating a perfect balance of color and sparkle. The secure post backs ensure comfortable wear all day long.",
      price: "1850.00",
      imageUrl: "https://images.unsplash.com/photo-1633810273562-3f0c4895bc7c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80",
      categoryId: earringCategory.id,
      featured: true,
      rating: "4.0",
      stock: 8
    });

    await this.createProduct({
      name: "Pearl Infinity Bracelet",
      slug: "pearl-infinity-bracelet",
      description: "This delicate bracelet features lustrous freshwater pearls connected by an infinity symbol crafted in 18k gold. A timeless piece that represents endless elegance and can be worn for any occasion.",
      price: "890.00",
      imageUrl: "https://images.unsplash.com/photo-1561828995-aa79a2db86dd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80",
      categoryId: braceletCategory.id,
      featured: true,
      rating: "4.5",
      stock: 15
    });
    
    // Add more products for each category
    await this.createProduct({
      name: "Diamond Eternity Band",
      slug: "diamond-eternity-band",
      description: "A classic eternity band featuring a continuous circle of round brilliant diamonds set in platinum. This ring symbolizes never-ending love and makes a perfect anniversary gift.",
      price: "1750.00",
      imageUrl: "https://images.unsplash.com/photo-1605101479435-005f9c563944?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80",
      categoryId: ringCategory.id,
      featured: false,
      rating: "4.8",
      stock: 7
    });

    // Add testimonials
    await this.createTestimonial({
      name: "Rebecca Thompson",
      location: "New York, NY",
      content: "The engagement ring I purchased exceeded all expectations. The craftsmanship is exquisite and the diamonds catch light in a way I've never seen before. The personal service made the experience even more special.",
      rating: 5,
      avatarUrl: "https://randomuser.me/api/portraits/women/44.jpg"
    });

    await this.createTestimonial({
      name: "Michael Chen",
      location: "Los Angeles, CA",
      content: "Working with the custom design team was a dream. They took my vague ideas and created a necklace that perfectly captures my style. The attention to detail and quality is unmatched. Worth every penny.",
      rating: 5,
      avatarUrl: "https://randomuser.me/api/portraits/men/32.jpg"
    });

    await this.createTestimonial({
      name: "Sophia Martinez",
      location: "Chicago, IL",
      content: "I've purchased several pieces from Elegante over the years and have always been impressed. Their anniversary collection is stunning and the compliments I receive when wearing their pieces are endless.",
      rating: 4,
      avatarUrl: "https://randomuser.me/api/portraits/women/68.jpg"
    });
  }

  // User methods
  async getUser(id: number): Promise<User | undefined> {
    return this.users.get(id);
  }

  async getUserByUsername(username: string): Promise<User | undefined> {
    return Array.from(this.users.values()).find(
      (user) => user.username === username,
    );
  }

  async createUser(insertUser: InsertUser): Promise<User> {
    const id = this.userId++;
    const user: User = { ...insertUser, id };
    this.users.set(id, user);
    return user;
  }

  // Category methods
  async getCategories(): Promise<Category[]> {
    return Array.from(this.categories.values());
  }

  async getCategoryBySlug(slug: string): Promise<Category | undefined> {
    return Array.from(this.categories.values()).find(
      (category) => category.slug === slug,
    );
  }

  async createCategory(insertCategory: InsertCategory): Promise<Category> {
    const id = this.categoryId++;
    const category: Category = { ...insertCategory, id };
    this.categories.set(id, category);
    return category;
  }

  // Product methods
  async getProducts(): Promise<Product[]> {
    return Array.from(this.products.values());
  }

  async getProductsByCategory(categoryId: number): Promise<Product[]> {
    return Array.from(this.products.values()).filter(
      (product) => product.categoryId === categoryId,
    );
  }

  async getProductBySlug(slug: string): Promise<Product | undefined> {
    return Array.from(this.products.values()).find(
      (product) => product.slug === slug,
    );
  }

  async getFeaturedProducts(): Promise<Product[]> {
    return Array.from(this.products.values()).filter(
      (product) => product.featured,
    );
  }

  async createProduct(insertProduct: InsertProduct): Promise<Product> {
    const id = this.productId++;
    const now = new Date();
    const product: Product = { 
      id,
      name: insertProduct.name,
      slug: insertProduct.slug,
      categoryId: insertProduct.categoryId,
      imageUrl: insertProduct.imageUrl,
      description: insertProduct.description,
      price: insertProduct.price,
      featured: insertProduct.featured || null,
      rating: insertProduct.rating || null,
      stock: insertProduct.stock || null,
      createdAt: now
    };
    this.products.set(id, product);
    return product;
  }

  // Cart methods
  async getCartItems(userId: number): Promise<CartItem[]> {
    return Array.from(this.cartItems.values()).filter(
      (item) => item.userId === userId,
    );
  }

  async getCartItemWithDetails(userId: number): Promise<any[]> {
    const cartItems = await this.getCartItems(userId);
    return Promise.all(
      cartItems.map(async (item) => {
        const product = this.products.get(item.productId);
        return {
          ...item,
          product,
        };
      }),
    );
  }

  async addToCart(insertCartItem: InsertCartItem): Promise<CartItem> {
    // Check if product already in cart for this user
    const existingItems = Array.from(this.cartItems.values()).filter(
      (item) => item.userId === insertCartItem.userId && item.productId === insertCartItem.productId
        && item.size === insertCartItem.size && item.color === insertCartItem.color
    );

    if (existingItems.length > 0) {
      const existingItem = existingItems[0];
      const newQuantity = existingItem.quantity + (insertCartItem.quantity || 1);
      const updatedItem = await this.updateCartItem(existingItem.id, newQuantity);
      if (updatedItem) return updatedItem;
    }

    const id = this.cartItemId++;
    const cartItem: CartItem = { 
      id,
      userId: insertCartItem.userId,
      productId: insertCartItem.productId,
      quantity: insertCartItem.quantity || 1,
      size: insertCartItem.size || null,
      color: insertCartItem.color || null
    };
    this.cartItems.set(id, cartItem);
    return cartItem;
  }

  async updateCartItem(id: number, quantity: number): Promise<CartItem | undefined> {
    const cartItem = this.cartItems.get(id);
    if (!cartItem) return undefined;

    if (quantity <= 0) {
      this.cartItems.delete(id);
      return undefined;
    }

    const updatedItem = { ...cartItem, quantity };
    this.cartItems.set(id, updatedItem);
    return updatedItem;
  }

  async removeFromCart(id: number): Promise<boolean> {
    return this.cartItems.delete(id);
  }

  async clearCart(userId: number): Promise<boolean> {
    const cartItems = await this.getCartItems(userId);
    cartItems.forEach((item) => {
      this.cartItems.delete(item.id);
    });
    return true;
  }

  // Custom order methods
  async createCustomOrder(insertOrder: InsertCustomOrder): Promise<CustomOrder> {
    const id = this.customOrderId++;
    const now = new Date();
    const order: CustomOrder = { 
      id,
      name: insertOrder.name,
      description: insertOrder.description,
      email: insertOrder.email,
      jewelryType: insertOrder.jewelryType,
      budget: insertOrder.budget,
      phone: insertOrder.phone || null,
      createdAt: now 
    };
    this.customOrders.set(id, order);
    return order;
  }

  async getCustomOrders(): Promise<CustomOrder[]> {
    return Array.from(this.customOrders.values());
  }

  // Testimonial methods
  async getTestimonials(): Promise<Testimonial[]> {
    return Array.from(this.testimonials.values());
  }

  async createTestimonial(insertTestimonial: InsertTestimonial): Promise<Testimonial> {
    const id = this.testimonialId++;
    const testimonial: Testimonial = { 
      id,
      name: insertTestimonial.name,
      rating: insertTestimonial.rating,
      location: insertTestimonial.location,
      content: insertTestimonial.content,
      avatarUrl: insertTestimonial.avatarUrl || null
    };
    this.testimonials.set(id, testimonial);
    return testimonial;
  }

  // Subscription methods
  async addSubscription(insertSubscription: InsertSubscription): Promise<Subscription> {
    // Check if email already exists
    const existingSubscription = Array.from(this.subscriptions.values()).find(
      (sub) => sub.email === insertSubscription.email,
    );

    if (existingSubscription) {
      return existingSubscription;
    }

    const id = this.subscriptionId++;
    const now = new Date();
    const subscription: Subscription = { 
      id,
      email: insertSubscription.email,
      createdAt: now 
    };
    this.subscriptions.set(id, subscription);
    return subscription;
  }
}

export const storage = new MemStorage();
