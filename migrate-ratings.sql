-- Migrate book ratings from Unicode stars to numbers
-- Run with: wp db query < migrate-ratings.sql

-- First, let's see what we're working with
SELECT meta_value as current_rating, COUNT(*) as book_count
FROM wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
WHERE pm.meta_key='rating' AND p.post_type='books'
GROUP BY meta_value;

-- Convert each rating value
UPDATE wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
SET pm.meta_value = '5'
WHERE pm.meta_key = 'rating' AND p.post_type = 'books' AND pm.meta_value = '★★★★★';

UPDATE wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
SET pm.meta_value = '4'
WHERE pm.meta_key = 'rating' AND p.post_type = 'books' AND pm.meta_value = '★★★★☆';

UPDATE wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
SET pm.meta_value = '3'
WHERE pm.meta_key = 'rating' AND p.post_type = 'books' AND pm.meta_value = '★★★☆☆';

UPDATE wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
SET pm.meta_value = '2'
WHERE pm.meta_key = 'rating' AND p.post_type = 'books' AND pm.meta_value = '★★☆☆☆';

UPDATE wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
SET pm.meta_value = '1'
WHERE pm.meta_key = 'rating' AND p.post_type = 'books' AND pm.meta_value = '★☆☆☆☆';

UPDATE wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
SET pm.meta_value = '0'
WHERE pm.meta_key = 'rating' AND p.post_type = 'books' AND pm.meta_value = '☆☆☆☆☆';

-- Verify the migration
SELECT meta_value as new_rating, COUNT(*) as book_count
FROM wp_postmeta pm
JOIN wp_posts p ON pm.post_id = p.ID
WHERE pm.meta_key='rating' AND p.post_type='books'
GROUP BY meta_value
ORDER BY meta_value DESC;
