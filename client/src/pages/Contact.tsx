import { useState } from "react";
import { z } from "zod";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { apiRequest } from "@/lib/queryClient";
import { useToast } from "@/hooks/use-toast";
import { Card, CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Textarea } from "@/components/ui/textarea";
import { 
  Form, 
  FormControl, 
  FormField, 
  FormItem, 
  FormLabel, 
  FormMessage 
} from "@/components/ui/form";
import { MapPin, Phone, Mail, Clock } from "lucide-react";

const formSchema = z.object({
  name: z.string().min(2, { message: "Name must be at least 2 characters" }),
  email: z.string().email({ message: "Please enter a valid email address" }),
  subject: z.string().min(2, { message: "Subject must be at least 2 characters" }),
  message: z.string().min(10, { message: "Message must be at least 10 characters" }),
});

type FormValues = z.infer<typeof formSchema>;

const Contact = () => {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const { toast } = useToast();

  const form = useForm<FormValues>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      name: "",
      email: "",
      subject: "",
      message: "",
    },
  });

  const onSubmit = async (values: FormValues) => {
    try {
      setIsSubmitting(true);
      // In a real application, this would make an API call to send the contact form
      // Since there's no dedicated endpoint for contact forms, we'll mock success
      await new Promise(resolve => setTimeout(resolve, 1000)); // Simulate API call
      
      form.reset();
      toast({
        title: "Message Sent",
        description: "Thank you for your message. We'll get back to you shortly.",
      });
    } catch (error) {
      toast({
        title: "Submission Failed",
        description: "There was an error sending your message. Please try again.",
        variant: "destructive",
      });
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <>
      <div 
        className="h-64 bg-[#0a2342] relative overflow-hidden"
        style={{
          backgroundImage: "url('https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80')",
          backgroundSize: "cover",
          backgroundPosition: "center 30%",
        }}
      >
        <div className="absolute inset-0 bg-[#0a2342]/60"></div>
        <div className="container mx-auto px-4 h-full flex items-center justify-center relative">
          <h1 className="text-4xl md:text-5xl font-bold font-serif text-white text-center">
            Contact Us
          </h1>
        </div>
      </div>

      <div className="container mx-auto px-4 py-16">
        <div className="grid md:grid-cols-2 gap-12">
          <div>
            <h2 className="text-3xl font-bold font-serif mb-4">Get in Touch</h2>
            <div className="w-20 h-1 bg-[#d4af37] mb-6"></div>
            <p className="text-gray-700 mb-8">
              We'd love to hear from you. Whether you have a question about our collections, 
              custom designs, or would like to schedule an appointment, our team is here to assist you.
            </p>
            
            <div className="space-y-6 mb-8">
              <div className="flex items-start">
                <div className="bg-[#d4af37]/10 rounded-full p-3 mr-4">
                  <MapPin className="text-[#d4af37] h-5 w-5" />
                </div>
                <div>
                  <h3 className="font-semibold text-lg mb-1">Visit Our Showroom</h3>
                  <p className="text-gray-600">123 Luxury Lane, New York, NY 10001</p>
                </div>
              </div>
              
              <div className="flex items-start">
                <div className="bg-[#d4af37]/10 rounded-full p-3 mr-4">
                  <Phone className="text-[#d4af37] h-5 w-5" />
                </div>
                <div>
                  <h3 className="font-semibold text-lg mb-1">Call Us</h3>
                  <p className="text-gray-600">+1 (212) 555-7890</p>
                </div>
              </div>
              
              <div className="flex items-start">
                <div className="bg-[#d4af37]/10 rounded-full p-3 mr-4">
                  <Mail className="text-[#d4af37] h-5 w-5" />
                </div>
                <div>
                  <h3 className="font-semibold text-lg mb-1">Email Us</h3>
                  <p className="text-gray-600">contact@elegantejewels.com</p>
                </div>
              </div>
              
              <div className="flex items-start">
                <div className="bg-[#d4af37]/10 rounded-full p-3 mr-4">
                  <Clock className="text-[#d4af37] h-5 w-5" />
                </div>
                <div>
                  <h3 className="font-semibold text-lg mb-1">Hours</h3>
                  <p className="text-gray-600">
                    Monday - Saturday: 10am - 8pm<br />
                    Sunday: 12pm - 6pm
                  </p>
                </div>
              </div>
            </div>
            
            <div className="border border-[#d4af37]/20 rounded-lg p-6 bg-[#fffaf0]">
              <h3 className="font-semibold text-lg mb-2">Book an Appointment</h3>
              <p className="text-gray-600 mb-4">
                For a personalized shopping experience or to discuss custom designs, 
                we recommend scheduling an appointment with one of our jewelry consultants.
              </p>
              <Button className="bg-[#0a2342] hover:bg-[#0a2342]/90 text-white">
                Schedule Consultation
              </Button>
            </div>
          </div>
          
          <div>
            <Card>
              <CardContent className="pt-6">
                <h2 className="text-2xl font-bold font-serif mb-4">Send Us a Message</h2>
                <Form {...form}>
                  <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
                    <FormField
                      control={form.control}
                      name="name"
                      render={({ field }) => (
                        <FormItem>
                          <FormLabel>Name</FormLabel>
                          <FormControl>
                            <Input placeholder="Your name" {...field} />
                          </FormControl>
                          <FormMessage />
                        </FormItem>
                      )}
                    />
                    
                    <FormField
                      control={form.control}
                      name="email"
                      render={({ field }) => (
                        <FormItem>
                          <FormLabel>Email</FormLabel>
                          <FormControl>
                            <Input placeholder="your.email@example.com" type="email" {...field} />
                          </FormControl>
                          <FormMessage />
                        </FormItem>
                      )}
                    />
                    
                    <FormField
                      control={form.control}
                      name="subject"
                      render={({ field }) => (
                        <FormItem>
                          <FormLabel>Subject</FormLabel>
                          <FormControl>
                            <Input placeholder="What is this regarding?" {...field} />
                          </FormControl>
                          <FormMessage />
                        </FormItem>
                      )}
                    />
                    
                    <FormField
                      control={form.control}
                      name="message"
                      render={({ field }) => (
                        <FormItem>
                          <FormLabel>Message</FormLabel>
                          <FormControl>
                            <Textarea 
                              placeholder="Your message"
                              rows={5}
                              {...field}
                            />
                          </FormControl>
                          <FormMessage />
                        </FormItem>
                      )}
                    />
                    
                    <Button 
                      type="submit"
                      className="w-full bg-[#d4af37] hover:bg-[#d4af37]/90 text-white"
                      disabled={isSubmitting}
                    >
                      {isSubmitting ? "Sending..." : "Send Message"}
                    </Button>
                  </form>
                </Form>
              </CardContent>
            </Card>
          </div>
        </div>
        
        <div className="mt-16">
          <h2 className="text-2xl font-bold font-serif mb-4 text-center">Visit Our Boutique</h2>
          <div className="w-20 h-1 bg-[#d4af37] mx-auto mb-6"></div>
          
          <div className="rounded-lg overflow-hidden h-80 shadow-md">
            {/* Replace with a proper map iframe in production */}
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215053961996!2d-73.99992508459423!3d40.75466727932711!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9aeb1c6b5%3A0x35b1cfbc89a6097f!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1652275878673!5m2!1sen!2sus" 
              width="100%" 
              height="100%" 
              style={{ border: 0 }} 
              allowFullScreen 
              loading="lazy" 
              referrerPolicy="no-referrer-when-downgrade"
              title="Elegante Jewels Location"
            ></iframe>
          </div>
        </div>
      </div>
    </>
  );
};

export default Contact;
