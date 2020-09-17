create table inventory_item
(
    id          int auto_increment
        primary key,
    name        varchar(255) null,
    description varchar(255) null,
    price       float        null,
    type        varchar(255) null,
    use_by      int          null
);

INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (2, 'Granola', 'Granola is a breakfast food and snack food consisting of rolled oats, nuts, honey.', 2.49, 'Breakfast and cereal', 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (3, 'French Artisan Rolls', '', 1.99, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (4, 'Kalamata Olive', '', 0.5, 'Cans and Packets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (5, 'Gummy Bears, Organic', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (6, 'Vegi-Dressing, Creamy Dill', '', 0, 'Sauce', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (7, 'Marinade in A Bag, Cracked Peppercorn', '', 0, 'Sauce', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (8, 'Maintenance Elemental Diet, Unflavored Powder', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (9, 'Beef Burgers', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (10, 'Sweet Strawberry Smoothie', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (11, 'Lattice Apple Pie', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (12, 'Gourmet Salsa, Verde, Medium', '', 0, 'Sauce', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (13, 'CARBmaster Cultured Dairy Blend, Cherry', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (14, 'Flossugar, Blue Raspberry', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (15, 'Creme Soda, French Vanilla Contour', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (16, 'Sour Cream, Light', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (18, 'Pizza Snacks, Pepperoni & Bacon', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (19, 'Best Fiber Powder, Fiber Supplement', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (20, 'Tomatoes, Stewed Italian', '', 0, 'Vegetables', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (21, 'Razz-Ade', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (22, 'Orange Juice', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (23, 'Warm Delights, Molten Chocolate Cake', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (24, 'Brown Sugar Cinnamon Roll Wafflers', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (25, 'Peanuts, Brittle 8 Oz', '', 0, 'Roasted, Salted & Flavoured Nuts', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (26, 'Whipped Cream Cheese, Chive', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (27, 'Energy Drink', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (28, 'Potato Chips, Lightly Salted', '', 0, 'Snacks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (29, 'Buffalo-Style Chicken Strips', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (30, 'Spreadable Cheese, Parmesan With Garlic & Herbs', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (31, 'Steamers Basil Vegetable Medley', '', 0, 'Vegetables', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (32, 'Salsa, Twist of Greece, Medium', '', 0, 'Sauce', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (33, 'Spinach, Chopped', '', 0, 'Vegetables', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (34, 'Oatmeal Toasters, Cranberry Orange', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (35, 'Party Cheese Tray', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (36, 'Hazelnut Butter Blend, Chocolate', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (37, 'Ice Cream Bar, Double Caramel', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (38, 'Pop, Jumbo Cherry With Bubble Gum Filling', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (39, 'Enrichie Vanille', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (40, 'Cooking Spray, Vegetable Oil', '', 0, 'Cooking Ingredients', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (41, 'Mini Bagels, Plain', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (42, 'Nonfat Yogurt, Lemon', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (43, 'Pitted California Ripe Olives', '', 0.75, 'Cans and Packets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (44, 'Noodles & Beef', '', 0, 'Dried pasta and noodles', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (45, 'Pork Roll, Mild, Hickory Smoked, Slices', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (46, 'Sausage, Smoked', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (47, 'Chocolate Digestive', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (48, 'Luxury Wafers, Vanilla', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (49, 'Milk, 2% Reduced Fat', '', 1.2, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (50, 'Beef Burgers', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (51, 'Milk, Sweetened Condensed, Low Fat', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (52, 'Soup, Caribbean Black Bean', '', 0, 'Cans and Packets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (54, 'Grapeseed Oil', '', 0, 'Cooking Ingredients', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (55, 'Cream Cheese Spread & Greek Nonfat Yogurt, Greek', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (56, 'Pancakes, Chocolate Chip', '', 0, 'Cooking Ingredients', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (57, 'Fudge Double Filled Twist & Shout Sandwich Cookies', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (58, 'Juice, White Grape', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (60, 'Melba Rounds, Sesame 5.25 Oz', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (61, 'Mini Cakes, Creme Filled Chocolate, Cakes, Individual Servings', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (62, 'Black Bean & Corn Salsa', '', 0, 'Cans and Packets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (63, 'Simmer Sauce, Butter Chicken', '', 0, 'Cooking Ingredients', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (64, 'Dark Chocolates, Assorted', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (65, 'Assorted Lollies', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (66, 'Red Salmon, Wild Alaska Sockeye', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (67, 'French Vanilla Shake', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (68, 'Cashews, Halves & Pieces, Salted', '', 0, 'Cans and Packets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (69, 'Maple Brown Sugar Oatmeal', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (70, 'Santa Fe Style Salad', '', 0, 'Vegetables', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (71, 'Meal Replacement, Rich Vanilla Beans', '', 0, 'Breakfast and cereal', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (72, 'Crispy Halibut Fillets, Golden Battered', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (73, 'Long Grain Brown Rice', '', 1.5, 'Cooking Ingredients', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (74, 'French Bread', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (75, 'Cheddar Cheese Twice Baked Potatoes', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (76, 'Chicken Sausage Burgers, Hot Italian Style', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (77, 'Soymilk, Organic, Unsweetened', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (78, 'Cheese Snacks, Twists', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (79, 'SpaghettiOs, Meatballs', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (80, 'Pancetta', '', 0, 'Meat', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (81, 'Spreadable Cheese, Parmesan With Garlic & Herbs', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (82, 'Ice Cream Bar, Double Caramel', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (83, 'Bread, Whole Wheat 7-Grain', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (84, 'Spin Pop Candy, Toy Story 2, Woody', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (85, 'Assorted Lollies', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (86, 'Nonfat Greek Yogurt, Classic Cherry Fruit on the Bottom', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (87, '1% Lowfat Milk', '', 0, 'Milk, butter and eggs', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (88, 'Energy Drink, Organic Energy', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (89, 'Frozen Dessert Cake, Vanilla Chocolate Allure', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (90, 'Meatballs', '', 0, 'Meat', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (91, 'Pistachios', '', 0, 'Cans and Packets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (92, 'Bread Pudding Mix', '', 0, 'Cooking Ingredients', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (93, 'Romaine Hearts', '', 0, 'Vegetables', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (94, 'Grilled Asiago Chicken & Penne Pasta', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (95, 'Benevento Croccantino Allo Strega Chocolatey Covered Hazelnuts', '', 0, 'Sweets', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (96, 'Sauce with Vegetables, Golden Curry, Hot', '', 0, 'Sauce', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (97, 'Sandwiches, Ham & Cheese, Whole Grain Crust', '', 0, 'Bakery', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (98, 'Carbonated Natural Mineral Water, Lime', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (100, 'Flavored Juice Drink, Fruit Punch', '', 0, 'Drinks', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (101, 'Bean and Beef Enchiladas', '', 0, 'Frozen food', 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (103, 'Teabags', null, 3.95, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (104, 'Strawberry Jam', null, 2, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (105, 'Granulated Sugar', null, 1.25, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (106, 'Sunflower Oil', null, 1.1, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (107, 'Single Cream', null, 0.85, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (108, 'Grounded Black Pepper', null, 1.8, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (109, 'Garlic paste', null, 1.25, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (110, 'Medium Bread', null, 0.85, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (111, 'Egg Noodles', null, 0.5, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (112, 'Self Raising Flour', null, 1.3, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (113, 'Chilli Flakes', null, 1.6, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (114, 'Potatoes - 3 Kg', null, 1.2, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (115, 'Tomatoes 6 pack - 360g', null, 0.75, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (116, 'Spring Onions', null, 0.48, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (117, 'Lamb Steaks', null, 4, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (118, 'Diced Beef', null, 3, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (119, 'Chicken Breast Portions - 950g', null, 5, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (120, 'Nescafe Original Instant Coffee 300G', null, 4.5, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (121, 'Kellogg''s Corn Flakes Cereal 450G', null, 1.89, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (122, 'Fruit & Nut Muesli 750G', null, 2, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (123, 'Honey', null, 1.8, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (124, 'Salted Butter', null, 1.49, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (125, 'Table Salt', null, 0.35, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (126, 'Brown Onions - 1 Kg', null, 0.85, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (127, 'Pepper Pack - 3 of a kind', null, 1.35, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (128, 'Gala Apples', null, 1.6, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (129, 'Green Seedless Grapes Pack 500G', null, 2, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (130, 'Pineapple Chunks 270G', null, 2, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (131, 'Penne Pasta 1Kg', null, 2.28, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (132, 'Nutella Hazelnut Chocolate Spread 400G', null, 2.53, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (133, 'Large Free Range Eggs 6 Pack', null, 1.1, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (134, 'Pure Apple Juice 1 Litre', null, 0.85, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (135, 'Baking Powder', null, 1, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (136, 'Olive Oil', null, 3, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (137, 'Red Split Lentils 1Kg', null, 1.8, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (138, 'Strong Kitchen Foil 450Mm X 10M', null, 3, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (139, 'Milk Chocolate Cookie 5 Pack', null, 1, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (140, 'Kit Kat 2 Finger Milk Chocolate Biscuit 21 Pack 434.7G', null, 3.49, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (141, 'All Butter Croissants 4 Pack', null, 1.75, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (142, 'White Pepper 25G', null, 0.8, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (143, 'Ginger Paste', null, 1.25, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (144, 'Condensed Milk 397G', null, 1.05, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (145, 'Milk Cooking Chocolate 150G', null, 0.8, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (146, 'Heinz Top Down Squeezy Tomato Ketchup Sauce 910G', null, 2.8, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (147, 'Chilli Sauce', null, 0.8, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (148, 'Cod Fish Fingers 10 Pack 280G', null, 3.25, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (149, 'Spicy Potato Wedges 750G', null, 1, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (150, 'Dove Daily Care Shampoo 250Ml', null, 1.5, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (151, 'Colgate Total Enamel Health Toothpaste 75Ml', null, 2, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (152, 'Comfort Blue Fabric Conditioner 85 Wash 3L', null, 3, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (153, 'Canned Tuna', null, 0.74, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (154, 'Almonds 200G', null, 2.3, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (155, 'Pistachio Nuts 250G', null, 5, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (156, 'Yeast 56G', null, 0.85, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (157, 'Carrots 1Kg', null, 0.45, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (158, 'Heinz Baked Beans In Tomato Sauce 415G', null, 0.85, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (159, 'Frozen Garden Peas 1Kg', null, 0.66, null, 5);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (160, 'Iceberg Lettuce 220G', null, 0.79, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (161, 'Whole Large Cucumber', null, 0.75, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (162, 'Wholefood Stoned Dates 450G', null, 3.3, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (163, 'Fairy Original Washing Up Liquid 1150Ml', null, 2, null, 6);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (164, 'Dove Deeply Nourishing Body Wash 450Ml', null, 2, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (165, 'Closed Cup Mushrooms 300G', null, 0.69, null, 1);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (166, '30 Breaded Chicken Nuggets 450G', null, 1.5, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (167, 'Kitchen Towel 2 Rolls', null, 2, null, 3);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (168, 'Toilet Tissue 9 Roll White', null, 3.3, null, 4);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (169, 'Ariel All In 1 Washing Pods 25 Washes 630G', null, 4.5, null, 2);
INSERT INTO dissertation.inventory_item (id, name, description, price, type, use_by) VALUES (181, 'Cashew Nut ', null, 1.49, 'Cans and Packets', 2);