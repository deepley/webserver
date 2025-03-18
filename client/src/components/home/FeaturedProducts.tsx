import { useState } from "react";
import { useQuery } from "@tanstack/react-query";
import { Product } from "@shared/schema";
import ProductCard from "../product/ProductCard";
import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { Skeleton } from "@/components/ui/skeleton";

const FeaturedProducts = () => {
  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 4;

  const { data: products, isLoading, error } = useQuery<Product[]>({
    queryKey: ['/api/products/featured'],
  });

  if (error) {
    return (
      <div className="py-16 bg-white text-center">
        <p className="text-red-500">Error loading featured products. Please try again later.</p>
      </div>
    );
  }

  const totalProducts = products?.length || 0;
  const totalPages = Math.ceil(totalProducts / itemsPerPage);
  
  const handleNext = () => {
    setCurrentPage((prev) => (prev + 1) % totalPages);
  };

  const handlePrev = () => {
    setCurrentPage((prev) => (prev - 1 + totalPages) % totalPages);
  };

  const displayedProducts = products?.slice(
    currentPage * itemsPerPage, 
    (currentPage + 1) * itemsPerPage
  );

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <div className="flex justify-between items-end mb-10">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold font-serif mb-2">Featured Collection</h2>
            <div className="w-20 h-1 bg-[#d4af37]"></div>
          </div>
          <div className="hidden md:flex space-x-2">
            <Button
              variant="outline"
              size="icon"
              className="p-2 border-[#0a2342]/20 rounded-full hover:bg-[#fffaf0]"
              onClick={handlePrev}
              disabled={isLoading || totalPages <= 1}
            >
              <ChevronLeft className="h-5 w-5 text-[#0a2342]" />
            </Button>
            <Button
              variant="outline"
              size="icon"
              className="p-2 border-[#0a2342]/20 rounded-full hover:bg-[#fffaf0]"
              onClick={handleNext}
              disabled={isLoading || totalPages <= 1}
            >
              <ChevronRight className="h-5 w-5 text-[#0a2342]" />
            </Button>
          </div>
        </div>

        <div className="relative overflow-hidden">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            {isLoading ? (
              // Loading skeletons
              Array(4).fill(0).map((_, index) => (
                <div key={index} className="bg-white rounded-lg overflow-hidden shadow-md">
                  <Skeleton className="aspect-square w-full" />
                  <div className="p-4">
                    <Skeleton className="h-6 w-3/4 mb-2" />
                    <div className="flex justify-between">
                      <Skeleton className="h-5 w-1/4" />
                      <Skeleton className="h-5 w-1/4" />
                    </div>
                  </div>
                </div>
              ))
            ) : (
              displayedProducts?.map((product) => (
                <ProductCard key={product.id} product={product} />
              ))
            )}
          </div>
        </div>

        <div className="mt-10 text-center">
          <Button
            asChild
            variant="outline"
            className="border-2 border-[#0a2342] text-[#0a2342] hover:bg-[#0a2342] hover:text-white py-3 px-8"
          >
            <Link href="/collections">
              View All Collections
            </Link>
          </Button>
        </div>
      </div>
    </section>
  );
};

export default FeaturedProducts;
