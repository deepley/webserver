import { useQuery } from "@tanstack/react-query";
import { Testimonial } from "@shared/schema";
import { Star, StarHalf } from "lucide-react";
import { Skeleton } from "@/components/ui/skeleton";

const TestimonialsSection = () => {
  const { data: testimonials, isLoading, error } = useQuery<Testimonial[]>({
    queryKey: ['/api/testimonials'],
  });

  if (error) {
    return (
      <div className="py-16 bg-[#fffaf0] text-center">
        <p className="text-red-500">Error loading testimonials. Please try again later.</p>
      </div>
    );
  }

  // Function to render rating stars
  const renderRating = (rating: number) => {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;
    
    return (
      <div className="flex text-[#d4af37] text-sm mb-4">
        {Array(fullStars).fill(0).map((_, i) => (
          <Star key={i} fill="#d4af37" className="h-4 w-4" />
        ))}
        {hasHalfStar && <StarHalf fill="#d4af37" className="h-4 w-4" />}
      </div>
    );
  };

  return (
    <section className="py-16 bg-[#fffaf0]">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-bold font-serif mb-2">Client Testimonials</h2>
          <div className="w-20 h-1 bg-[#d4af37] mx-auto"></div>
          <p className="mt-4 text-gray-600 max-w-2xl mx-auto">
            See what our valued clients have to say about their Elegante Jewels experience
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-8">
          {isLoading ? (
            // Loading skeletons
            Array(3).fill(0).map((_, index) => (
              <div key={index} className="bg-white p-8 rounded-lg shadow-md">
                <Skeleton className="h-4 w-24 mb-4" />
                <Skeleton className="h-20 w-full mb-6" />
                <div className="flex items-center">
                  <Skeleton className="h-12 w-12 rounded-full mr-4" />
                  <div>
                    <Skeleton className="h-5 w-32 mb-1" />
                    <Skeleton className="h-4 w-24" />
                  </div>
                </div>
              </div>
            ))
          ) : (
            testimonials?.map((testimonial) => (
              <div key={testimonial.id} className="bg-white p-8 rounded-lg shadow-md">
                {renderRating(testimonial.rating)}
                <p className="italic text-gray-700 mb-6">
                  "{testimonial.content}"
                </p>
                <div className="flex items-center">
                  <div className="w-12 h-12 rounded-full overflow-hidden mr-4">
                    <img 
                      src={testimonial.avatarUrl} 
                      alt={`${testimonial.name} portrait`} 
                      className="w-full h-full object-cover"
                    />
                  </div>
                  <div>
                    <h4 className="font-medium">{testimonial.name}</h4>
                    <p className="text-sm text-gray-500">{testimonial.location}</p>
                  </div>
                </div>
              </div>
            ))
          )}
        </div>
      </div>
    </section>
  );
};

export default TestimonialsSection;
