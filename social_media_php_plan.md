Here’s your **prompt divided into clear, actionable steps** for implementation, in the right sequence:

---

## **Step 1: Project Setup and Folder Structure**

1. Create the root project directory.
2. Inside it, create the following folders and files:

```
project-root/
│   index.php
│   about.php
│   login.php
│   register.php
│   profile.php
│   create_post.php
│   categories.php
│   all_posts.php
│   logout.php
│
├── admin/
│   index.php
│   manage_users.php
│   manage_posts.php
│   ban_user.php
│
├── includes/
│   header.php
│   footer.php
│   navbar.php
│   db.php
│   functions.php
│
├── assets/
│   css/
│       styles.css
│   js/
│       main.js
│
|---database.sql
|
└── documentation/
    documentation.md
```

---

## **Step 2: Database Setup**

1. Create a new MySQL database (e.g., `college_media`).
2. Add tables:

**Users Table**

* id (PK), username, email, password, country, avatar, is\_banned (default 0).
* Note: avatar images for databse will be come from getRandomAvatar() function which i mentioned in last of the file.

**Posts Table**

* id (PK), user\_id (FK), title, description, image, category, likes (0), dislikes (0).
* Note: the image the user will upload in post that will be a link with length of 500 characters.

3. Insert a default admin and user and some post data in every category manually.

---

## **Step 3: Base Configuration**

1. In `includes/db.php`, create a **MySQLi database connection**.
2. In `includes/functions.php`, add reusable functions (e.g., fetch posts, handle forms).
3. Add `includes/header.php`, `navbar.php`, `footer.php` for modular page design.

---

## **Step 4: Design and Styling**

1. Use **TailwindCSS via CDN**:

   ```html
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
   ```
2. Add DaisyUI for prebuilt components and themes:

   ```html
   <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
   <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
   ```
3. Add Lucide icons:

   ```html
   <script src="https://unpkg.com/lucide@latest"></script>
   ```
4. Define four themes in navbar (Night, Sunset, Bumblebee, Garden).

---

## **Step 5: Authentication System**

1. Build `register.php`:

   * Form: username, email, password, country.
   * Avatar assigned randomly from a static array.
   * Store user info in DB.
2. Build `login.php`:

   * Validate credentials using sessions.
   * Redirect to home page if successful.
3. Create `logout.php` to destroy sessions.

---

## **Step 6: Core Pages**

1. **Landing Page** (index.php):

   * Parallax storytelling design.
   * Call-to-action buttons.
2. **Home Page**:

   * Show latest posts.
   * Filter/search option.
3. **Categories Page**:

   * Predefined categories: Games, Cars, Movie, Anime.
   * Show posts under each category.
4. **All Posts Page**:

   * Searchable, filterable list of all posts.
5. **Profile Page**:

   * Display and allow editing of user details.
   * Check if user is banned; if yes, redirect to landing page with modal.

---

## **Step 7: Post Management**

1. Create `create_post.php`:

   * Form: title, description, category, image upload (optional).
   * Validate and insert into DB.
2. Display posts dynamically on home, categories, and all posts pages.
3. Add like/dislike functionality with single reaction per user.

---

## **Step 8: Admin Panel**

1. **Admin Login** (session-protected).
2. **Admin Dashboard (`admin/index.php`)**:

   * Overview of users, posts, and actions.
3. **Manage Users (`admin/manage_users.php`)**:

   * List all users.
   * Ban/unban users.
4. **Manage Posts (`admin/manage_posts.php`)**:

   * Edit/delete posts.
   * Option to feature posts.
5. Protect all admin routes using session checks.

---

## **Step 9: Animations & Enhancements**

1. Add **GSAP and Lenis** for:

   * Scroll-triggered animations.
   * Smooth scrolling.
   * Parallax effects on landing.
2. Add micro-interactions (hover effects, modals, ripple effects).
3. Implement text underline animations and loading overlays.

---

## **Step 10: Documentation**

1. Create `documentation/documentation.md`:

   * Explain setup, folder structure, DB schema.
   * Instructions for adding new features.
   * Admin credentials and usage guide.

---

## 🎨 Avatar System
```php
// Array of random avatar URLs to be used in avatar.php
$avatar_urls = [
    'https://i.pinimg.com/1200x/68/e4/24/68e42428134581259d464896ac826b2b.jpg',
    'https://i.pinimg.com/736x/67/e0/f4/67e0f43a5795f412139477c0e85e7dd7.jpg',
    'https://i.pinimg.com/736x/5e/44/db/5e44db92fea8441b4c0377ec77664ed0.jpg',
    'https://i.pinimg.com/1200x/d2/81/41/d28141ea9b14869db9dc4cdbb27a5132.jpg',
    'https://i.pinimg.com/736x/90/68/7f/90687fdb3e09f2518e6c4799eb3a0668.jpg',
    'https://i.pinimg.com/736x/6a/0d/91/6a0d91751d01d300da30e85d418493b0.jpg'
];

// Function to assign random avatar
function getRandomAvatar() {
    global $avatar_urls;
    return $avatar_urls[array_rand($avatar_urls)];
}
```