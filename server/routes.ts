import express, { type Express } from "express";
import { createServer, type Server } from "http";
import { storage } from "./storage";
import { z } from "zod";
import { ZodError } from "zod";
import { 
  insertCartItemSchema,
  insertCustomOrderSchema,
  insertSubscriptionSchema,
} from "@shared/schema";

// Initialize the storage with sample data
let storageInitialized = false;

export async function registerRoutes(app: Express): Promise<Server> {
  // Initialize storage if not already done
  if (!storageInitialized) {
    await storage.init();
    storageInitialized = true;
    console.log("Storage initialized with sample data");
  }

  const router = express.Router();

  // Define API error handler
  router.use((err: any, req: express.Request, res: express.Response, next: express.NextFunction) => {
    if (err instanceof ZodError) {
      return res.status(400).json({
        message: "Validation error",
        errors: err.errors
      });
    }
    next(err);
  });

  // Get all categories
  router.get("/categories", async (req, res) => {
    const categories = await storage.getCategories();
    res.json(categories);
  });

  // Get category by slug
  router.get("/categories/:slug", async (req, res) => {
    const category = await storage.getCategoryBySlug(req.params.slug);
    if (!category) {
      return res.status(404).json({ message: "Category not found" });
    }
    res.json(category);
  });

  // Get all products
  router.get("/products", async (req, res) => {
    const products = await storage.getProducts();
    res.json(products);
  });

  // Get products by category
  router.get("/products/category/:categoryId", async (req, res) => {
    const categoryId = parseInt(req.params.categoryId);
    if (isNaN(categoryId)) {
      return res.status(400).json({ message: "Invalid category ID" });
    }
    const products = await storage.getProductsByCategory(categoryId);
    res.json(products);
  });

  // Get featured products
  router.get("/products/featured", async (req, res) => {
    const products = await storage.getFeaturedProducts();
    res.json(products);
  });

  // Get product by slug
  router.get("/products/:slug", async (req, res) => {
    const product = await storage.getProductBySlug(req.params.slug);
    if (!product) {
      return res.status(404).json({ message: "Product not found" });
    }
    res.json(product);
  });

  // Cart endpoints - using user ID 1 for demo purposes
  const DEFAULT_USER_ID = 1; 

  // Get cart items
  router.get("/cart", async (req, res) => {
    const cartItems = await storage.getCartItemWithDetails(DEFAULT_USER_ID);
    res.json(cartItems);
  });

  // Add to cart
  router.post("/cart", async (req, res) => {
    try {
      const cartItem = insertCartItemSchema.parse({
        ...req.body,
        userId: DEFAULT_USER_ID
      });
      const newCartItem = await storage.addToCart(cartItem);
      res.status(201).json(newCartItem);
    } catch (error) {
      if (error instanceof ZodError) {
        return res.status(400).json({
          message: "Validation error",
          errors: error.errors
        });
      }
      throw error;
    }
  });

  // Update cart item
  router.put("/cart/:id", async (req, res) => {
    const id = parseInt(req.params.id);
    if (isNaN(id)) {
      return res.status(400).json({ message: "Invalid cart item ID" });
    }

    const quantitySchema = z.object({
      quantity: z.number().int().positive()
    });

    try {
      const { quantity } = quantitySchema.parse(req.body);
      const updatedItem = await storage.updateCartItem(id, quantity);
      if (!updatedItem) {
        return res.status(404).json({ message: "Cart item not found or removed" });
      }
      res.json(updatedItem);
    } catch (error) {
      if (error instanceof ZodError) {
        return res.status(400).json({
          message: "Validation error",
          errors: error.errors
        });
      }
      throw error;
    }
  });

  // Remove from cart
  router.delete("/cart/:id", async (req, res) => {
    const id = parseInt(req.params.id);
    if (isNaN(id)) {
      return res.status(400).json({ message: "Invalid cart item ID" });
    }
    const success = await storage.removeFromCart(id);
    if (!success) {
      return res.status(404).json({ message: "Cart item not found" });
    }
    res.status(204).end();
  });

  // Clear cart
  router.delete("/cart", async (req, res) => {
    await storage.clearCart(DEFAULT_USER_ID);
    res.status(204).end();
  });

  // Submit custom order
  router.post("/custom-order", async (req, res) => {
    try {
      const customOrder = insertCustomOrderSchema.parse(req.body);
      const newOrder = await storage.createCustomOrder(customOrder);
      res.status(201).json(newOrder);
    } catch (error) {
      if (error instanceof ZodError) {
        return res.status(400).json({
          message: "Validation error",
          errors: error.errors
        });
      }
      throw error;
    }
  });

  // Get testimonials
  router.get("/testimonials", async (req, res) => {
    const testimonials = await storage.getTestimonials();
    res.json(testimonials);
  });

  // Subscribe to newsletter
  router.post("/subscribe", async (req, res) => {
    try {
      const subscription = insertSubscriptionSchema.parse(req.body);
      const newSubscription = await storage.addSubscription(subscription);
      res.status(201).json(newSubscription);
    } catch (error) {
      if (error instanceof ZodError) {
        return res.status(400).json({
          message: "Validation error",
          errors: error.errors
        });
      }
      throw error;
    }
  });

  app.use("/api", router);

  const httpServer = createServer(app);
  return httpServer;
}
