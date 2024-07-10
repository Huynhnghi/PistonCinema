<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Footer styles */
        footer {
            background-color: #111;
            color: #fff;
            padding: 50px 0;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
            margin-bottom: 20px;
        }

        .footer-section.about {
            margin-right: 20px;
        }

        .footer-section h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .logo-text {
            color: #fc7511;
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .contact span {
            display: block;
            margin-bottom: 10px;
        }

        .socials a {
            color: #fff;
            font-size: 24px;
            margin-right: 10px;
        }

        .links ul {
            list-style: none;
            padding: 0;
        }

        .links li {
            margin-bottom: 10px;
        }

        .contact-form form {
            display: flex;
            flex-wrap: wrap;
        }

        .contact-form input,
        .contact-form textarea {
            flex: 1;
            padding: 10px;
            margin-bottom: 15px;
        }

        .contact-form input[type="email"] {
            margin-right: 15px;
        }

        .contact-btn {
            background-color: #fc7511;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-btn:hover {
            background-color: #f56a00;
        }

        .footer-bottom {
            margin-top: 20px;
            text-align: center;
        
    }
    .form-control {
            width: auto !important;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <div id="wrapper">
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section about">
                        <h1 class="logo-text">Piston Cinema</h1>
                        <div class="contact">
                            <span><i class="fas fa-phone"></i> 0385006809</span>
                            <span><i class="fas fa-envelope"></i> motminhtui@cinema.com</span>
                        </div>
                        <div class="socials">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="footer-section links">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Portfolio</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-section contact-form">
                        <h2>Phản hồi với chúng tôi</h2>
                        <form action="email.php" method="post">
                            <div class="form-group">
                                <input type="email" name="email" class="text-input contact-input form-control" placeholder="Your email address..." required>
                            </div>
                            <div class="form-group">
                                <textarea rows="4" name="message" class="text-input contact-input form-control" placeholder="Your message..." required></textarea>
                            </div>
                            <br />
                                <button type="submit" class="btn btn-big contact-btn">
                                    <i class="fas fa-envelope"></i>
                                    Phản hồi
                                </button>
                            </div>
                        </form>
                    </div>


                </div>
                <div class="footer-bottom">
                    &copy; motminhtui copany | Designed by Tui
                </div>
            </div>
        </footer>
    </div>
</body>
</html>