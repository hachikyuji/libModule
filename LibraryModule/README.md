TO DO LIST:
	REGISTER - INPUT VALIDATION
	BOOK ACQUISITION - INPUT VALIDATION, RESULT MESSAGE
	BOOK TERMINATION - INPUT VALIDATION, RESULT MESSAGE
	HISTORY - FINES UPDATE
	// PRIORITY
	CHECK IN - POPULATION SUBLOCATION 
	! REQUEST APPROVAL - REQUEST HISTORY & SEARCH FUNCTIONALITY
	BOOK STATUS
	AVAILABLE COPIES - COUNT


Here's how to create the new table for the new system:

In 'library_module' schema,

CREATE TABLE `users` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`last_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`account_type` VARCHAR(255) NOT NULL DEFAULT 'patron' COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `users_email_unique` (`email`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6
;

Run this in your books table to give entries for the database:
INSERT INTO library_module.`books` (
  call_number, author, title, publish_location, publish_date, 
  total_copies, available_copies, sublocation, book_description, count
) VALUES 
  ('100-001', 'John Doe', 'The Great Book', 'New York', '2022-02-01', 5, 5, 'Law Library', 'A fascinating book that captivates readers with its intriguing plot and well-developed characters.', 50),
  ('100-0011', 'Jennifer Smith', 'The Ultimate Guide to Fitness', 'New York', '2022-02-01', 5, 5, 'Health Sciences Library', 'A comprehensive guide to achieving optimal fitness through exercise and nutrition.', 51),
  ('100-002', 'John Anderson', 'Strength Training 101', 'Los Angeles', '2022-03-15', 5, 5, 'Multimedia Library', 'Learn the fundamentals of strength training and build a strong, resilient body.', 52),
  ('100-003', 'Jessica Martin', 'Yoga for Beginners', 'San Francisco', '2022-04-20', 5, 5, 'Health Sciences Library', 'Discover the benefits of yoga and start your journey to physical and mental well-being.', 53),
  ('100-004', 'Alex Turner', 'Cardiovascular Fitness', 'Chicago', '2022-05-10', 5, 5, 'Health Sciences Library', 'Improve your cardiovascular health with effective cardio workouts and lifestyle tips.', 54),
  ('100-005', 'Emily Davis', 'Nutrition Essentials for Athletes', 'Miami', '2022-08-05', 5, 5, 'Multimedia Library', 'Explore the key nutritional principles for athletes to enhance performance and recovery.', 55),
  ('100-006', 'Daniel Harris', 'Mindful Running', 'Denver', '2022-09-15', 5, 5, 'Health Sciences Library', 'Combine running with mindfulness techniques for a holistic approach to fitness.', 56),
  ('100-007', 'Sophie Lee', 'Functional Fitness Workouts', 'Seattle', '2022-10-20', 5, 5, 'Multimedia Library', 'Engage in functional exercises to improve everyday movements and overall fitness.', 57),
  ('100-008', 'Michael Carter', 'Healthy Habits for a Fit Life', 'Austin', '2022-11-05', 5, 5, 'Health Sciences Library', 'Establish and maintain healthy habits for a lifelong commitment to fitness.', 58),
  ('100-009', 'Olivia White', 'Bodyweight Training at Home', 'Dallas', '2022-12-10', 5, 5, 'Multimedia Library', 'Achieve a full-body workout using your own body weight, no gym equipment required.', 59),
  ('100-010', 'Ryan Johnson', 'HIIT: High-Intensity Interval Training', 'Houston', '2023-01-15', 5, 5, 'Health Sciences Library', 'Experience the benefits of high-intensity interval training for efficient and effective workouts.', 60),
  ('100-012', 'Sophie Davis', 'Running for Beginners', 'Chicago', '2023-02-01', 5, 5, 'Multimedia Library', 'Get started on your running journey with practical tips for beginners.', 61),
  ('100-013', 'Chris Evans', 'Healthy Eating Habits', 'New York', '2023-03-15', 5, 5, 'Periodicals Section', 'Learn how to develop and maintain healthy eating habits for a balanced lifestyle.', 62),
  ('100-014', 'Eva Turner', 'Pilates Essentials', 'Los Angeles', '2023-04-20', 5, 5, 'Multimedia Library', 'Discover the core-strengthening benefits of Pilates with step-by-step exercises.', 63),
  ('100-015', 'Robert White', 'Mindful Meditation', 'San Francisco', '2023-05-10', 5, 5, 'Multimedia Library', 'Practice mindfulness and meditation for mental clarity and stress relief.', 64),
  ('100-016', 'Mia Johnson', 'Cycling Adventures', 'Miami', '2023-08-05', 5, 5, 'Adventure', 'Embark on cycling adventures and explore scenic routes for a fun and active lifestyle.', 65),
  ('100-017', 'Lucas Harris', 'Total Body Workout', 'Denver', '2023-09-15', 5, 5, 'Multimedia Library', 'Achieve a complete workout targeting all major muscle groups for overall fitness.', 66),
  ('100-018', 'Ava Martin', 'Vegan Nutrition Guide', 'Seattle', '2023-10-20', 5, 5, 'Nutrition', 'Explore a plant-based diet with nutrition tips and delicious vegan recipes.', 67),
  ('100-019', 'Dylan Turner', 'Outdoor Fitness Challenges', 'Austin', '2023-11-05', 5, 5, 'Adventure', 'Challenge yourself with outdoor fitness activities for an adrenaline-packed experience.', 68),
  ('100-020', 'Isabella Clark', 'Strength and Flexibility', 'Dallas', '2023-12-10', 5, 5, 'Multimedia Library', 'Combine strength training and flexibility exercises for a balanced and functional body.', 69),
  ('100-021', 'Liam White', 'Mental Toughness Training', 'Houston', '2024-01-15', 5, 5, 'Health Sciences Library', 'Develop mental resilience and toughness through targeted training.', 70),
  ('100-022', 'Emma Turner', 'Holistic Wellness', 'New York', '2024-06-01', 5, 5, 'Health Sciences Library', 'Achieve holistic wellness with a focus on mind, body, and spirit.', 71),
  ('100-023', 'Olivia Baker', 'Science Fiction Adventure', 'London', '2024-07-15', 5, 5, 'Science Fiction', 'Embark on a thrilling adventure through space and time.', 72),
  ('100-024', 'Noah Turner', 'Historical Mystery', 'Paris', '2024-08-20', 5, 5, 'Mystery', 'Solve mysteries from the past in this captivating historical mystery novel.', 73),
  ('100-025', 'Sophia Carter', 'Romantic Comedy', 'Tokyo', '2024-09-10', 5, 5, 'Romance', 'Laugh and fall in love with the humorous twists of romantic comedy.', 74),
  ('100-026', 'Jack Wilson', 'Fantasy Epic', 'Sydney', '2024-10-05', 5, 5, 'Fantasy', 'Immerse yourself in a world of magic and mythical creatures in this epic fantasy adventure.', 75),
  ('100-027', 'Ella Martinez', 'Detective Noir', 'Berlin', '2024-11-15', 5, 5, 'Mystery', 'Step into the gritty world of detective noir and solve crimes in a dark urban setting.', 76),
  ('100-028', 'Gabriel Harris', 'Thriller Suspense', 'Moscow', '2024-12-20', 5, 5, 'Thriller', 'Hold your breath as you navigate through twists and turns in this thrilling suspense novel.', 77),
  ('100-029', 'Amelia Clark', 'Biographical Memoir', 'Rome', '2025-01-05', 5, 5, 'Biography', 'Explore the life and experiences of fascinating individuals in this biographical memoir.', 78),
  ('100-030', 'Max Turner', 'Travel Adventure', 'Cairo', '2025-02-10', 5, 5, 'Adventure', 'Embark on a globetrotting adventure and explore diverse cultures and landscapes.', 79),
  ('100-031', 'Lily White', 'Psychological Drama', 'Rio de Janeiro', '2025-03-15', 5, 5, 'Drama', 'Delve into the complexities of the human mind with this gripping psychological drama.', 80),
  ('100-032', 'Oliver Johnson', 'The Art of Cooking', 'New York', '2025-01-01', 5, 5, 'Culinary', 'Master the art of cooking with creative and delicious recipes.', 81),
  ('100-033', 'Isabella Turner', 'Nature Exploration', 'Los Angeles', '2025-02-15', 5, 5, 'Adventure', 'Explore the wonders of nature with exciting and educational outdoor activities.', 82),
  ('100-034', 'Ethan Harris', 'Financial Literacy', 'San Francisco', '2025-03-20', 5, 5, 'Finance', 'Develop essential financial skills and achieve financial literacy for a secure future.', 83),
  ('100-035', 'Sophie Davis', 'Yoga for Stress Relief', 'Chicago', '2025-04-10', 5, 5, 'Wellness', 'Practice yoga techniques to manage stress and promote mental and physical well-being.', 84),
  ('100-036', 'Liam White', 'Running Challenges', 'Miami', '2025-05-05', 5, 5, 'Fitness', 'Take on running challenges and improve your endurance with structured training plans.', 85),
  ('100-037', 'Ava Martin', 'Healthy Desserts', 'Denver', '2025-08-01', 5, 5, 'Culinary', 'Indulge in guilt-free desserts with recipes that prioritize health and taste.', 86),
  ('100-038', 'Lucas Harris', 'Mindful Parenting', 'Seattle', '2025-09-15', 5, 5, 'Wellness', 'Apply mindfulness principles to parenting for a harmonious and connected family life.', 87),
  ('100-039', 'Eva Turner', 'Pilates Fusion', 'Austin', '2025-10-20', 5, 5, 'Fitness', 'Experience the benefits of Pilates combined with other fitness modalities for a well-rounded workout.', 88),
  ('100-040', 'Dylan Smith', 'Adventure Travel', 'Dallas', '2025-11-05', 5, 5, 'Adventure', 'Plan exciting and adventurous travels with tips on destinations and unique experiences.', 89),
  ('100-041', 'Olivia White', 'Mental Wellness', 'Houston', '2025-12-10', 5, 5, 'Wellness', 'Prioritize mental wellness with practices that enhance resilience, focus, and emotional balance.', 90),
  ('100-042', 'Noah Johnson', 'Culinary Adventures', 'New York', '2026-01-15', 5, 5, 'Culinary', 'Embark on culinary adventures with diverse and flavorful recipes from different cultures.', 91),
  ('100-043', 'Sophia Davis', 'Mindful Gardening', 'Los Angeles', '2026-02-28', 5, 5, 'Wellness', 'Connect with nature through mindful gardening practices that promote relaxation and joy.', 92),
  ('100-044', 'Mia Turner', 'Strength Training for Beginners', 'San Francisco', '2026-03-15', 5, 5, 'Fitness', 'Start your strength training journey with beginner-friendly exercises and training plans.', 93),
  ('100-045', 'Ethan White', 'Financial Planning for Retirement', 'Chicago', '2026-04-20', 5, 5, 'Finance', 'Secure your financial future with effective planning and strategies for retirement.', 94),
  ('100-046', 'Ava Harris', 'Healthy Living Habits', 'Miami', '2026-05-10', 5, 5, 'Health Sciences Library', 'Adopt and maintain healthy living habits for a balanced and fulfilling life.', 95),
  ('100-047', 'Oliver Turner', 'Creative Writing', 'Denver', '2026-08-05', 5, 5, 'Literature', 'Unleash your creativity with tips and exercises to enhance your creative writing skills.', 96),
  ('100-048', 'Isabella Harris', 'Mindful Technology Use', 'Seattle', '2026-09-15', 5, 5, 'Wellness', 'Explore mindful approaches to using technology for a healthier and more balanced lifestyle.', 97),
  ('100-049', 'Ethan Davis', 'Home Workout Essentials', 'Austin', '2026-10-20', 5, 5, 'Fitness', 'Achieve fitness goals with essential home workout routines and equipment.', 98),
  ('100-050', 'Sophie Smith', 'Vegan Cooking', 'Dallas', '2026-11-05', 5, 5, 'Culinary', 'Discover the world of plant-based cooking with delicious and nutritious vegan recipes.', 99);

