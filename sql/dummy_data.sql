-- Insert Categories
INSERT INTO categories (name, description) VALUES
('Skincare', 'Premium skincare products for all skin types'),
('Makeup', 'Beautiful makeup products for every occasion'),
('Hair Care', 'Professional hair care products'),
('Body Care', 'Luxurious body care products');

-- Insert Products
INSERT INTO products (category_id, name, description, price, stock_quantity, image_url) VALUES
-- Skincare Products
(1, 'Natural Moisturizer', 'Hydrating natural moisturizer for all skin types', 24.99, 50, 'uploads/products/moisturizer.jpg'),
(1, 'Night Cream', 'Rejuvenating night cream for skin repair', 34.99, 40, 'uploads/products/night-cream.jpg'),
(1, 'Face Serum', 'Advanced formula face serum for glowing skin', 29.99, 30, 'uploads/products/face-serum.jpg'),

-- Makeup Products
(2, 'Organic Lipstick', 'Long-lasting organic lipstick with natural ingredients', 19.99, 60, 'uploads/products/lipstick.jpg'),
(2, 'Foundation', 'Lightweight foundation for natural coverage', 39.99, 45, 'uploads/products/foundation.jpg'),
(2, 'Mascara', 'Volumizing mascara for dramatic lashes', 14.99, 55, 'uploads/products/mascara.jpg'),

-- Hair Care Products
(3, 'Shampoo', 'Nourishing shampoo for all hair types', 18.99, 70, 'uploads/products/shampoo.jpg'),
(3, 'Hair Conditioner', 'Deep conditioning treatment', 21.99, 65, 'uploads/products/conditioner.jpg'),
(3, 'Hair Oil', 'Luxurious hair oil for shine and smoothness', 25.99, 40, 'uploads/products/hair-oil.jpg'),

-- Body Care Products
(4, 'Body Lotion', 'Hydrating body lotion with natural oils', 22.99, 80, 'uploads/products/body-lotion.jpg'),
(4, 'Body Scrub', 'Exfoliating body scrub for smooth skin', 27.99, 35, 'uploads/products/body-scrub.jpg'),
(4, 'Hand Cream', 'Nourishing hand cream with shea butter', 15.99, 90, 'uploads/products/hand-cream.jpg');
