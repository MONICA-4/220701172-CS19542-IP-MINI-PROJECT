<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="home.css" />
    <title>Blog Page</title>
    <style>
        /* Initially hide the form */
        .blog-form {
            display: none;
        }
    </style>
</head>
<body>
    <header id="home">
        <nav>
            <div class="nav__bar">
                <div class="nav__logo"><a href="#">WanderHive</a></div>
                <ul class="nav__links">
                    <li class="link"><a href="home.html">Home</a></li>
                    <li class="link"><a href="#about">Blog</a></li>
                    <li class="link"><a href="bookmark.html">Discover</a></li>
                    <li class="link"><a href="#blog">Hot topics</a></li>
                    <li> 
                        <button class="discover__btn">
                            <a href="logout.php">Logout</a> 
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="section__container hero__container">
            <p> BLOG'S</p>
            <h1> "Explore and inspire! Scroll down to share your travel stories and showcase your memories."</h1>
        </div>
    </section>

    <div class="center-content">
        <h3>Click here to add your blog</h3>
        <button type="button" id="show-blog-form" class="submit-btn">Add Blog</button>
    </div>

    <!-- Hidden blog form initially -->
    <form id="blog-form" class="blog-form" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" name="image" id="image" required>
        </div>
        <div class="form-group">
            <label for="title">Blog Title</label>
            <input type="text" name="title" id="title" placeholder="Enter Blog Title" required>
        </div>
        <div class="form-group">
            <label for="description">Blog Description</label>
            <textarea name="description" id="description" placeholder="Write your blog description here..." required></textarea>
        </div>
        <button type="button" id="add-blog-button" class="submit-btn">Add Blog</button>
    </form>

    <!-- Featured blog posts -->
    <div class="featured-posts" id="blog-posts">
        <!-- Existing blog posts will be loaded here -->
    </div>

    <script>
        // Function to load initial existing blogs
        function loadExistingBlogs() {
            const existingBlogs = [
                {
                    id: 1,
                    image_path: "https://img.freepik.com/free-photo/3d-render-tree-landscape-against-northern-lights-sky_1048-12999.jpg?ga=GA1.1.902961075.1727608681&semt=ais_hybrid",
                    title: "Northern lights",
                    description: "Witnessing the Northern Lights is a magical experience that should be on every traveler’s bucket list. To increase your chances of catching this breathtaking natural phenomenon, plan your trip during the winter months, typically between late September and March, when the skies are darkest."
                },
                {
                    id: 2,
                    image_path: "https://img.freepik.com/free-photo/woman-walking-kelingking-beach-nusa-penida-island-bali-indonesia_335224-337.jpg?ga=GA1.1.902961075.1727608681&semt=ais_hybrid",
                    title: "Travel Tips",
                    description: "Traveling can be an enriching experience, but a little preparation can go a long way. Research your destination, pack light, and carry a refillable water bottle to stay hydrated."
                },
                {
                    id: 3,
                    image_path: "https://img.freepik.com/free-photo/set-colored-balloons-flying-ground-cappadocia-turkey_181624-20938.jpg?ga=GA1.1.902961075.1727608681&semt=ais_hybrid",
                    title: "Cappadocia Travel Guide For Turkey",
                    description: "Cappadocia Turkey is the most popular hot air ballooning location in the world. Affordable prices and unique landscapes make it a must-see."
                }
            ];

            // Render the existing blogs
            const blogPostsDiv = document.getElementById('blog-posts');
            existingBlogs.forEach(blog => {
                let post = document.createElement('div');
                post.className = 'post';
                post.innerHTML = `
                    <img src="${blog.image_path}" alt="Post Image" class="postImg">
                    <div class="postInfo">
                        <h2 class="postTitle">${blog.title}</h2>
                        <p class="postDesc">${blog.description}</p>
                        <form action="delete_blog.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                            <input type="hidden" name="blog_id" value="${blog.id}">
                            <button type="submit" class="remove-post-btn">Remove Post</button>
                        </form>
                    </div>
                `;
                blogPostsDiv.appendChild(post);
            });
        }

        // Function to handle blog submission
        document.getElementById('add-blog-button').addEventListener('click', function () {
            const addBlogButton = document.getElementById('add-blog-button');
            addBlogButton.disabled = true; // Disable button to prevent multiple clicks

            let formData = new FormData(document.getElementById('blog-form'));
            const blogPostsDiv = document.getElementById('blog-posts');

            // Simulate adding new blog (you should replace this with an actual fetch request to the server)
            const newBlog = {
                image_path: URL.createObjectURL(document.getElementById('image').files[0]),
                title: document.getElementById('title').value,
                description: document.getElementById('description').value
            };

            // Add the new blog to the DOM
            let post = document.createElement('div');
            post.className = 'post';
            post.innerHTML = `
                <img src="${newBlog.image_path}" alt="Post Image" class="postImg">
                <div class="postInfo">
                    <h2 class="postTitle">${newBlog.title}</h2>
                    <p class="postDesc">${newBlog.description}</p>
                    <button type="button" class="remove-post-btn">Remove  </button>
                </div>
            `;
            blogPostsDiv.appendChild(post);

            // Reset the form after submission
            document.getElementById('blog-form').reset();
            // Hide the blog form
            document.getElementById('blog-form').style.display = 'none';

            // Re-enable the button after the request is completed
            addBlogButton.disabled = false;
        });

        // Function to show/hide the blog form when 'Add Blog' button is clicked
        document.getElementById('show-blog-form').addEventListener('click', function () {
            const blogForm = document.getElementById('blog-form');
            blogForm.style.display = (blogForm.style.display === 'none' || blogForm.style.display === '') ? 'block' : 'none';
        });

        // Load existing blogs on page load
        document.addEventListener('DOMContentLoaded', loadExistingBlogs);
    </script>
</body>
</html>
