-- ============================================================
-- Jess Linton Website — Seed Data
-- Migrated from the static site content
-- Run AFTER schema.sql:
--   mysql -u root -p jess_linton < database/seed.sql
-- ============================================================

USE jess_linton;

-- ── Admin user ────────────────────────────────────────────────────────────────
-- Password: admin123  (CHANGE THIS immediately after first login)
-- Generated with: password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (username, email, password_hash) VALUES
  ('admin', 'jess.a.linton@gmail.com',
   '$2y$12$YourHashHere_REPLACE_WITH_REAL_HASH')
ON DUPLICATE KEY UPDATE username = username;

-- NOTE: Generate a real hash before deploying:
--   php -r "echo password_hash('your_password', PASSWORD_BCRYPT) . PHP_EOL;"
-- Then replace the hash above.

-- ── Contact settings ─────────────────────────────────────────────────────────
INSERT INTO contact_settings (`key`, value) VALUES
  ('email',          'jess.a.linton@gmail.com'),
  ('phone',          '+44 (0) 7834 686838'),
  ('address',        'Sussex, UK'),
  ('hcpc_number',    'AS14954'),
  ('dbs_number',     '004178606999'),
  ('copyright_year', '2025'),
  ('session_fee',    '£35–£60 per hour'),
  ('location_text',  'Sessions take place at The Plot Stanmer, Stanmer Park, Brighton, and at other locations in Sussex. Online sessions are also available.')
ON DUPLICATE KEY UPDATE value = VALUES(value);

-- ── SEO settings ─────────────────────────────────────────────────────────────
INSERT INTO seo_settings (page_slug, title, meta_description) VALUES
  ('home',
   'Jess Linton — Art Psychotherapist, Visual Artist & Creative Practitioner',
   'HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner based in Sussex, UK. Over 15 years in community, education and health settings.'),
  ('about',
   'About — Jess Linton',
   'About Jess Linton — HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner based in Sussex, UK.'),
  ('art-therapy',
   'Art Therapy — Jess Linton',
   'Art therapy services by Jess Linton — HCPC registered Art Psychotherapist offering individual and group art therapy in Sussex, UK.'),
  ('what-is-art-therapy',
   'What is Art Therapy? — Jess Linton',
   'Understand what art therapy is, how it works, and who it can help. Explained by HCPC registered Art Psychotherapist Jess Linton.'),
  ('what-can-jess-offer',
   'What Can Jess Offer? — Jess Linton',
   'Individual therapy, group work, consultation, supervision and training from HCPC registered Art Psychotherapist Jess Linton.'),
  ('what-else-do-i-need-to-know',
   'Fees & Practical Information — Jess Linton',
   'Fees, location, sessions and practical information about art therapy with Jess Linton in Sussex, UK.'),
  ('artist',
   'Artist Statement — Jess Linton',
   'Artist statement of Jess Linton — socially engaged visual art exploring displacement, identity, natural materials and the politics of belonging.'),
  ('artwork',
   'Artwork — Jess Linton',
   'Gallery of artwork by Jess Linton. Socially engaged visual art practice based in Sussex, UK.'),
  ('community',
   'Community Practice — Jess Linton',
   'Community arts and creative practice by Jess Linton — schools, hospitals, refugee networks and community groups across Sussex and beyond.'),
  ('overview',
   'Community Overview — Jess Linton',
   'Overview of Jess Linton's community arts practice — schools, SEN, hospitals, refugee networks, family and youth work.'),
  ('starling-project',
   'The Starling Project — Jess Linton',
   'The Starling Project — arts and wellbeing programmes supporting refugees and asylum seekers in Brighton and Hove.'),
  ('the-plot-stanmer',
   'The Plot Stanmer — Jess Linton',
   'The Plot Stanmer — an outdoor wellbeing and creative arts space in Stanmer Park, Brighton.'),
  ('blog',
   'Blog — Jess Linton',
   'Writing and reflections from Jess Linton on art therapy, community practice, and creative life.'),
  ('articles',
   'Articles & Press — Jess Linton',
   'Press, publications, interviews and media featuring Jess Linton and her work.'),
  ('contact',
   'Contact — Jess Linton',
   'Get in touch with Jess Linton — HCPC registered Art Psychotherapist and Creative Practitioner based in Sussex, UK.')
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  meta_description = VALUES(meta_description);

-- ── Page content (editable sections) ─────────────────────────────────────────
INSERT INTO pages (slug, content) VALUES
  ('home', '{"hero_title":"Art that heals,\\nconnects & bears witness.","hero_subtitle":"HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner. Over 15 years working in community, education and health settings.","about_heading":"Fifteen years in arts, health & community","about_text":"Jess Linton is an HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner. She has been working creatively in community, arts, social action, education and health settings with all ages for over 15 years.\\n\\nShe is an advocate for play and curiosity as a basic human right — for helping us to explore and make sense of ourselves, our relationships and the world around us."}'),
  ('about', '{"page_heading":"Jess Linton","bio_text":"Jess Linton is an HCPC registered Art Psychotherapist, Visual Artist and Creative Practitioner. She has been working creatively in community, arts, social action, education and health settings with all ages for over 15 years.\\n\\nJess trained as an Art Therapist at Goldsmiths, University of London and has worked in a wide range of settings including schools, hospitals, refugee and asylum-seeker support services, community centres and outdoor wellbeing spaces.","expertise_text":"Jess works with individuals, groups and communities to explore difficult experiences, emotions and relationships through the creative process. She is particularly skilled in working with themes of displacement, loss, identity and belonging."}'),
  ('contact', '{"intro_text":"Jess welcomes enquiries about art therapy, community projects, workshops, or any other aspect of her work. Please get in touch using the details below.","referral_text":"Referrals can be made by the individual themselves, by a family member or carer, or by a professional such as a GP, teacher, social worker or other health professional.\\n\\nJess works with adults and young people (12+). She offers a free 20-minute phone consultation before any commitment is made."}')
ON DUPLICATE KEY UPDATE content = VALUES(content);

-- ── Gallery images (migrated from static site) ────────────────────────────────
INSERT INTO gallery_images (title, image_url, display_order) VALUES
  ('Frequent Crossings to England',                  'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414254594-1MLJTUUY4GI8JIV34SBJ/97F96999-11C6-4F11-AF3F-D323D7BD748E+%281%29.jpg', 1),
  ('Bread Freedom and Social Justice',               'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1455539179425-CUVAN0HFW5OOHRJJFQOA/IMG_4607.JPG', 2),
  ('Shadow Play + Solace II',                        'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1568473002893-PPUAKE888FD6ET6YRYU7/IMG_5248.JPG', 3),
  ('Shadow Play + Solace I',                         'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414523807-3KUJ7KOMH0VWX5H5P3BD/6B1D60F4-0A47-407E-B3C3-99D790E34F09.jpg', 4),
  ('The Sun Has Just Come Up',                       'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1658414724755-A0ZBCHYBSYNW4GR4OQ8M/CE51624E-D7BA-4BC1-8D92-7F95A361DD13.jpg', 5),
  ("What's Mine? What's Yours?",                    'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1455538487903-0QF75I16ECO4OZWSA6X8/JessLintonartist02.jpg', 6),
  ('Rising Sun',                                     'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412777392466-UZ1TXSGPVVOUAC2I2AMR/Rising+sun+jpeg.jpg', 7),
  ('You and Me We Collide',                          'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1412777500187-5WNGOLS77IEGGJ6HBYTF/You%26MeWeCollide.jpg', 8),
  ('What Makes a Safe Space?',                       'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524093262059-BAOZCYW0HTPRDO6NCVE4/CJAT+JL+01+What+makes+a+safe+space.JPG', 9),
  ('Akademi',                                        'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524091722258-K78K0G5006D9XOB1V79C/akademi+7FINAL.jpg', 10),
  ('ARU + UNHCR Nepal',                              'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524092168842-TZZMO9YK3O001G6J59EJ/ARU+and+UNHCR+Nepal+04.JPG', 11),
  ('Castlehaven Project',                            'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524092294763-2KE1JZBHW287RE9PIKU0/Castlehaven+Project+01.JPG', 12),
  ('Akademi Lambeth',                                'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524092272903-GL4IXOVGFO0OZ1GIKPS1/Akademi+Lambeth+12.jpg', 13),
  ('A Collaboration',                                'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524093194399-1SP706R5TENKSAQMK6KZ/CJAT+JL+15+A+Collaboration.JPG', 14),
  ('Performance and Protest',                        'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1524085233846-ZEZB62GGY1PJ8WIZEJPL/performance+and+protest.jpg', 15),
  ('The Plot Stanmer',                               'https://images.squarespace-cdn.com/content/v1/53bfdc39e4b014ff51913091/1618146511818-407BTXZ6G4MEUUQNWWMP/IMG_6621.JPG', 16);

-- ── Sample blog posts ─────────────────────────────────────────────────────────
INSERT INTO blog_posts (title, slug, excerpt, content, status, published_at) VALUES
  ('What is Art Therapy and Who is it For?',
   'what-is-art-therapy-and-who-is-it-for',
   'Art therapy is often misunderstood. Here I explain what it actually involves and who might benefit from it.',
   '<p>Art therapy is a form of psychotherapy that uses art-making as its primary mode of communication rather than talking. It is offered to people of all ages as a means of addressing emotional, developmental and mental health needs.</p><p>It is often misunderstood as being a recreational activity, or as something only suitable for people who are "good at art". Neither is true. No previous experience or ability in art is needed. The focus is on the creative process rather than the product.</p><p>Art therapy can help people express feelings that are difficult to put into words, explore and process difficult or painful experiences, develop insight and self-awareness, manage anxiety, depression and emotional distress, and build resilience and coping strategies.</p>',
   'published', '2024-03-15 10:00:00'),
  ('The Healing Power of Making: Reflections on 15 Years',
   'healing-power-of-making-reflections',
   'After fifteen years working as an art therapist, I find myself returning again and again to the same central question: what is it about making that heals?',
   '<p>After fifteen years working as an art therapist, I find myself returning again and again to the same central question: what is it about making that heals?</p><p>It is not a simple question. The making itself is sometimes painful — bringing to the surface things we would rather not see. The product can disappoint or surprise. The process can feel chaotic, stuck, or overwhelming.</p><p>And yet, again and again, I witness something shift through the act of making. A new relationship to experience. A little more space around something that felt unbearably tight.</p>',
   'published', '2024-01-20 10:00:00')
ON DUPLICATE KEY UPDATE title = title;
