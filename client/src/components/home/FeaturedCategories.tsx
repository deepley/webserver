import { useQuery } from "@tanstack/react-query";
import { Link } from "wouter";
import { Category } from "@shared/schema";
import { Skeleton } from "@/components/ui/skeleton";

const FeaturedCategories = () => {
  const { data: categories, isLoading, error } = useQuery<Category[]>({
    queryKey: ['/api/categories'],
  });

  if (error) {
    return (
      <div className="py-16 container mx-auto px-4 text-center">
        <p className="text-red-500">Error loading categories. Please try again later.</p>
      </div>
    );
  }

  return (
    <section className="py-16 container mx-auto px-4">
      <div className="text-center mb-12">
        <h2 className="text-3xl md:text-4xl font-bold font-serif mb-2">Our Collections</h2>
        <div className="w-20 h-1 bg-[#d4af37] mx-auto"></div>
        <p className="mt-4 text-gray-600 max-w-2xl mx-auto">
          Explore our carefully curated categories of fine jewelry
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {isLoading ? (
          // Loading skeletons
          Array(4).fill(0).map((_, index) => (
            <div key={index} className="relative rounded-lg overflow-hidden">
              <Skeleton className="aspect-square w-full" />
            </div>
          ))
        ) : (
          categories?.map((category) => (
            <Link 
              key={category.id} 
              href={`/collections/${category.slug}`}
              className="relative group overflow-hidden rounded-lg hover:scale-105 transition-transform duration-300 shadow-md hover:shadow-[0_4px_6px_-1px_rgba(212,175,55,0.1),_0_2px_4px_-1px_rgba(212,175,55,0.06)]"
            >
              <div className="aspect-square">
                <img 
                  src={category.imageUrl} 
                  alt={`${category.name} collection`} 
                  className="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110"
                />
              </div>
              <div className="absolute inset-0 bg-gradient-to-t from-[#0a2342]/80 to-transparent flex items-end">
                <div className="p-6">
                  <h3 className="text-white text-xl font-semibold font-serif">{category.name}</h3>
                  <div className="w-8 h-0.5 bg-[#d4af37] mt-2"></div>
                </div>
              </div>
            </Link>
          ))
        )}
      </div>
    </section>
  );
};

export default FeaturedCategories;
