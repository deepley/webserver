import express, { type Request, Response, NextFunction } from "express";
import { registerRoutes } from "./routes";
import { setupVite, serveStatic, log } from "./vite";
import path from "path";

const app = express();
app.use(express.json());
app.use(express.urlencoded({ extended: false }));

// Add CORS headers for Vercel deployment
app.use((req, res, next) => {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Authorization");
  
  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }
  
  next();
});

app.use((req, res, next) => {
  const start = Date.now();
  const path = req.path;
  let capturedJsonResponse: Record<string, any> | undefined = undefined;

  const originalResJson = res.json;
  res.json = function (bodyJson, ...args) {
    capturedJsonResponse = bodyJson;
    return originalResJson.apply(res, [bodyJson, ...args]);
  };

  res.on("finish", () => {
    const duration = Date.now() - start;
    if (path.startsWith("/api")) {
      let logLine = `${req.method} ${path} ${res.statusCode} in ${duration}ms`;
      if (capturedJsonResponse) {
        logLine += ` :: ${JSON.stringify(capturedJsonResponse)}`;
      }

      if (logLine.length > 80) {
        logLine = logLine.slice(0, 79) + "…";
      }

      log(logLine);
    }
  });

  next();
});

(async () => {
  const server = await registerRoutes(app);

  app.use((err: any, _req: Request, res: Response, _next: NextFunction) => {
    const status = err.status || err.statusCode || 500;
    const message = err.message || "Internal Server Error";

    res.status(status).json({ message });
    console.error(err);
  });

  // Check if running in Vercel (production environment)
  const isVercel = process.env.VERCEL === '1';
  const isDev = app.get("env") === "development";

  if (isDev) {
    // Development mode - use Vite dev server
    await setupVite(app, server);
  } else {
    // Production mode - serve static files
    serveStatic(app);
  }

  // For Vercel, we don't need to start a server as it's handled by the platform
  if (!isVercel) {
    const port = parseInt(process.env.PORT || "5000", 10);
    
    // Set up error handling for address in use
    process.on('uncaughtException', (err: NodeJS.ErrnoException) => {
      if (err.code === 'EADDRINUSE') {
        log(`Port ${port} is already in use. Please close other applications using this port.`);
        process.exit(1);
      }
    });
    
    // Fix for TypeScript error - server.listen expects a number for port
    server.listen({
      port: port,
      host: "0.0.0.0"
    }, () => {
      log(`serving on port ${port}`);
      console.log(`Server running at http://0.0.0.0:${port}`);
    });
  }
})();

// Export the Express application for Vercel serverless deployment
export default app;
