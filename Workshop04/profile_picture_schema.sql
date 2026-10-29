-- Run after provinces_schema.sql
-- Stores only the generated file name; the image itself lives in uploads/profile_pictures/
ALTER TABLE users
    ADD COLUMN profile_picture VARCHAR(255) NULL AFTER province_id;
