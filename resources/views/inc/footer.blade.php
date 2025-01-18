<!-- Footer Section -->
<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="{{asset('css/app.css')}}">
   <script src="index.js"></script>
   <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
 </head>
 <body>
 <footer id="contact" class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h4>About Us</h4>
                <p>We are your trusted store for all things beauty and skincare. Explore our wide range of cosmetic products, curated with care and quality in mind.</p>
                <p>Version: <strong>2.0</strong></p>
        
            </div>

            <!-- Contact Form Section -->
            <div class="col-md-4 mb-4">
                <h4>Contact Us</h4>
                <form id="contact-form" action="/pageController/submit" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" >
                        <div class="invalid-feedback" id="nameError">Please enter your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" >
                        <div class="invalid-feedback" id="emailError">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" ></textarea>
                        <div class="invalid-feedback" id="messageError">Please enter a message.</div>
                    </div>
                    <button type="submit" class="btn btn-light">Send Message</button>
                </form>
                <div id="successMessage" class="mt-3 alert alert-success" style="display: none;">
                    Thank you for contacting us! We'll get back to you soon.
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="col-md-4 mb-4">
                <h4>Follow Us</h4>
                <ul class="list-unstyled">
                    <li><i class="icon fa-brands fa-facebook"></i><a href="https://www.facebook.com/" class="text">Facebook</a></li>
                    <li><i class="icon fa-brands fa-square-instagram"></i><a href="https://www.instagram.com/" class="text">Instagram</a></li>
                    <li><i class="icon fa-brands fa-square-twitter"></i><a href="https://x.com/?lang=en" class="text">Twitter</a></li>
                    <li><i class="icon fa-brands fa-linkedin"></i><a href="https://in.linkedin.com/" class="text">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <p>&copy; 2024 <a class="redirecthome text" href="#">Cosmetic Store</a>. All rights reserved.</p>
    </div>
</footer>



<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>