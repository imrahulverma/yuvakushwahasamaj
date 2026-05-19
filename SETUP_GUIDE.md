# Yuvakushwahasamaj Community Website - Implementation Guide

## Overview
This guide will help you complete the setup of the Yuvakushwahasamaj Community Website. The child theme and custom post types have been created and are ready for configuration.

## What's Been Completed ✓

1. **Child Theme Created**: `yuvakushwahasamaj-child`
   - Based on TwentyTwentyFive block theme
   - Custom styling for community sections
   - Fully responsive design

2. **Custom Post Types Registered**:
   - Home Sections (for home page content)
   - Events (with categories)
   - Team Members (for leadership)
   - Gallery Items (with categories)

3. **SCF (Secure Custom Fields) Compatible** (for custom fields):
   - Custom post meta fields ready to use
   - Home Section fields (hero, stats, about, etc.)
   - Event details (date, time, venue, registration)
   - Team member information (designation, photo, bio)
   - Gallery item details (image, caption, year)

4. **Page Templates Created**:
   - Home (home.html) - Displays home section posts
   - About Us (page-about.php)
   - Events (page-events.php)
   - Membership (page-membership.php)
   - Gallery (page-gallery.php)
   - Contact (page-contact.php)

5. **Custom CSS Styling**:
   - Hero banners with images
   - Event cards with hover effects
   - Statistics counters
   - Gallery mosaic layouts
   - Responsive mobile design
   - CTA buttons in community colors (saffron #ff9933, green #138808)

## Step-by-Step Setup Instructions

### Step 1: Install Secure Custom Fields (SCF) Plugin

1. Go to WordPress Admin Dashboard
2. Navigate to **Plugins → Add New**
3. Search for "Secure Custom Fields"
4. Install the **"Secure Custom Fields"** plugin
5. Activate the plugin
6. You'll see a new **"Custom Fields"** menu item in the admin sidebar for managing custom fields

### Step 2: Activate the Child Theme

1. Go to **Appearance → Themes**
2. You'll see "Yuvakushwahasamaj Community" in the available themes
3. Click **Activate** on that theme
4. The child theme is now active! (Parent theme will still provide the base functionality)

### Step 3: Create Static Pages

Create the following pages in WordPress (**Pages → Add New**):

1. **Home Page**
   - Title: Home
   - Template: Default
   - Leave content empty (it will be populated by Home Section posts)
   - Set this as the front page (see Step 4)

2. **About Us**
   - Title: About Us
   - Template: About Us
   - Add content in the editor
   - Slug: `about`

3. **Events**
   - Title: Events
   - Template: Events
   - Slug: `events`

4. **Membership**
   - Title: Membership
   - Template: Membership
   - Slug: `membership`

5. **Gallery**
   - Title: Gallery
   - Template: Gallery
   - Slug: `gallery`

6. **News & Blog**
   - Title: News & Blog
   - Template: Default
   - Add content describing the blog section
   - Slug: `news`

7. **Contact Us**
   - Title: Contact Us
   - Template: Contact Us
   - Slug: `contact`

### Step 4: Set Up Static Front Page

1. Go to **Settings → Reading**
2. Under "Your homepage displays", select **"A static page"**
3. Set **Homepage** to "Home"
4. Set **Posts page** to "News & Blog"
5. Click **Save Changes**

### Step 5: Create Home Section Posts

Home sections are custom posts that appear on the home page. Create them in **Home Sections** menu:

#### Home Section 1: Hero Banner
- Title: Hero Section
- Section Type: Hero Banner
- Hero Image: Upload a high-quality banner image
- Hero Tagline: एकता | युवा | प्रगति (or translate to your preference)
- CTA Button Text: हमसे जुड़ें
- CTA Button Link: /membership/
- Published: Yes

#### Home Section 2: About Brief
- Title: About Our Community
- Section Type: About Brief
- Content: Add 3-line mission statement
- About Excerpt: "We are dedicated to youth empowerment..."
- Read More Link: /about/
- Published: Yes

#### Home Section 3: Key Stats
- Title: Our Impact
- Section Type: Key Stats
- Add Stats Items using SCF:
  - 10,000+ Members
  - 150+ Events Held
  - 15+ Years Active
- Published: Yes

#### Home Section 4: Latest Events
- Title: Upcoming Events
- Section Type: Latest Events
- (This will auto-pull from Events post type)
- Published: Yes

#### Home Section 5: Gallery Preview
- Title: Community Moments
- Section Type: Gallery Preview
- (This will auto-pull from Gallery post type)
- Published: Yes

#### Home Section 6: Testimonials
- Title: Testimonials
- Section Type: Testimonials
- Add testimonials in the editor
- Published: Yes

#### Home Section 7: News Ticker
- Title: Latest Announcements
- Section Type: News Ticker
- Add news content
- Published: Yes

#### Home Section 8: CTA Banner
- Title: Join Us CTA
- Section Type: Join Us CTA
- (This will display the membership CTA)
- Published: Yes

### Step 6: Create Sample Events

1. Go to **Events** in the admin menu
2. Click **Add New Event**
3. Title: (e.g., "Annual Youth Sammelan 2026")
4. Set Custom Fields (using SCF):
   - Event Date: (Select a date)
   - Event Time: (Select a time)
   - Venue: (Enter venue name and location)
   - Event Image: (Upload event image)
   - Event Description: (Write about the event)
   - Registration Link: (Add registration URL if applicable)
   - Status: "Upcoming" or "Completed"
5. Publish

Create at least 3-5 sample events so they display on the Events page.

### Step 7: Add Team Members

1. Go to **Team Members** in the admin menu
2. Click **Add New Team Member**
3. Title: (Person's name)
4. Set Custom Fields (using SCF):
   - Designation: (Position/role)
   - Photo: (Upload team member photo)
   - Bio: (Brief biography)
   - Contact Email: (Optional)
5. Publish

Create entries for key leadership team members.

### Step 8: Add Gallery Items

1. Go to **Gallery** in the admin menu
2. Click **Add New Gallery Item**
3. Title: (Brief description of the photo)
4. Set Custom Fields (using SCF):
   - Image: (Upload photo)
   - Caption: (Photo caption)
   - Year: (Year the photo was taken)
5. Add a Gallery Category (e.g., "Events 2025", "Cultural Programs")
6. Publish

Create multiple gallery items (at least 6) to populate the gallery preview.

### Step 9: Create Blog Posts

1. Go to **Posts → Add New**
2. Title: (News article title)
3. Content: (Write the news article)
4. Featured Image: (Add image)
5. Category: Assign a category (News, Youth Achievements, etc.)
6. Publish

These will appear on the "News & Blog" page automatically.

### Step 10: Update Site Settings

1. Go to **Settings → General**
   - Site Title: Yuvakushwahasamaj Community
   - Tagline: Unity | Youth | Progress
   - Site Language: (Select appropriate language if available)

2. Go to **Settings → Discussion**
   - Configure comment settings as needed

## Testing the Website

After completing the setup:

1. **Visit the Home Page**
   - Check that all home sections are displaying
   - Verify images are loading correctly
   - Test all CTA buttons

2. **Test Navigation**
   - Visit each page (About, Events, Membership, Gallery, Contact)
   - Ensure templates are being used correctly

3. **Check Responsive Design**
   - View on mobile, tablet, and desktop
   - Test menu responsiveness

4. **Test Forms**
   - Try the membership registration form
   - Try the contact form

## Customization Guide

### Changing Colors
Edit [wp-content/themes/yuvakushwahasamaj-child/style.css](wp-content/themes/yuvakushwahasamaj-child/style.css):
- Primary Color (Saffron): `--color-primary: #ff9933;`
- Secondary Color (Green): `--color-secondary: #138808;`

### Adding More Custom Fields
1. Use the **Custom Fields** menu in WordPress admin (provided by SCF plugin)
2. Add fields to your custom post types
3. Use `get_scf_field()` helper function in templates to retrieve values
4. Example: `echo get_scf_field( 'event_date' );`

### Modifying Page Templates
Edit the template files in `wp-content/themes/yuvakushwahasamaj-child/templates/`:
- `page-about.php` - About Us page
- `page-events.php` - Events page
- `page-membership.php` - Membership page
- `page-gallery.php` - Gallery page
- `page-contact.php` - Contact page

### Creating Additional Pages
1. Create a new template file: `page-custom.php`
2. Add the template header comment:
   ```
   <?php
   /**
    * Template Name: Custom Template
    * Description: Your template description
    */
   ```
3. Use it when creating new pages

## Features Overview

### Home Page Features
- ✓ Hero banner with CTA
- ✓ About section with read more link
- ✓ Key statistics counter
- ✓ Latest events grid
- ✓ Gallery preview (6 photos)
- ✓ Member testimonials
- ✓ News ticker
- ✓ Join us CTA banner

### Events Management
- ✓ Upcoming events with registration
- ✓ Past events archive
- ✓ Event categories
- ✓ Event filtering by status
- ✓ Annual Sammelan section

### Membership System
- ✓ Member benefits showcase
- ✓ Three membership tiers
- ✓ Online registration form
- ✓ Digital membership card preview
- ✓ Fee structure display

### Gallery & Media
- ✓ Photo gallery with categories
- ✓ Video gallery (YouTube integration ready)
- ✓ Gallery filtering
- ✓ Press coverage section
- ✓ Lightbox-ready

### Community Features
- ✓ Leadership team showcase
- ✓ Reach and statistics
- ✓ Affiliations section
- ✓ Community impact stats
- ✓ Contact form
- ✓ Social media integration
- ✓ News & blog section

## Next Steps (Optional Enhancements)

1. **Install Additional Plugins**
   - WP Forms or Contact Form 7 (for form submissions)
   - Yoast SEO (for search optimization)
   - WP Super Cache (for performance)
   - Imagify (for image optimization)

2. **SEO Optimization**
   - Add meta descriptions to pages
   - Optimize images alt text
   - Create an XML sitemap

3. **Multilingual Support**
   - Install WPML or Polylang for Hindi translations
   - Translate all page content

4. **Email Integration**
   - Set up SMTP for email notifications
   - Configure membership confirmation emails

5. **Analytics**
   - Install Google Analytics
   - Monitor user behavior and conversions

## Troubleshooting

### Pages not using templates
- Check that the page template is selected in the page editor
- Ensure the template file is in the correct directory

### Custom fields not showing
- Verify SCF plugin is installed and activated
- Go to Custom Fields menu to add fields to your post types
- Use the `get_scf_field()` helper function to retrieve field values in templates

### Custom post types not visible
- Flush permalinks: Settings → Permalinks → Save Changes
- Verify post type is set to public in functions.php

### Styling not applying
- Clear browser cache (Ctrl+Shift+Del)
- Check that child theme is activated
- Verify style.css is properly enqueued

## File Structure

```
wp-content/themes/yuvakushwahasamaj-child/
├── style.css                 (Main stylesheet)
├── theme.json               (Theme configuration)
├── functions.php            (CPT & ACF registration)
├── css/                     (Additional CSS files)
├── templates/
│   ├── home.html           (Home page template)
│   ├── page-about.php      (About Us page)
│   ├── page-events.php     (Events page)
│   ├── page-membership.php (Membership page)
│   ├── page-gallery.php    (Gallery page)
│   └── page-contact.php    (Contact page)
└── parts/                  (Template parts - header, footer, etc.)
```

## Support & Documentation

- **WordPress Codex**: https://developer.wordpress.org/
- **SCF Documentation**: https://www.secureCustomFields.com/
- **Block Theme Documentation**: https://developer.wordpress.org/block-editor/
- **WordPress Post Meta**: https://developer.wordpress.org/plugins/metadata/

---

**Last Updated**: May 7, 2026
**Theme Version**: 1.0.0
