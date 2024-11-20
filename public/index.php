<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Template</title>

    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and basic layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container that holds both left and right sections */
        .container {
            display: flex;
            width: 80%;
            height: 80%;
            max-width: 1200px;  /* Max width for large screens */
            border-radius: 10px;
            overflow: hidden;
        }

        /* Left Section: 70% width for image and text */
        .left {
            width: 70%;
            background-color: #fff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .left .image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .left .text h1 {
            font-size: 2rem;
            margin-top: 20px;
            color: #333;
        }

        .left .text p {
            font-size: 1rem;
            color: #666;
            margin-top: 10px;
        }

        /* Right Section: 30% width for the form */
        .right {
            width: 30%;
            background-color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .right h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        .right label {
            font-size: 1rem;
            margin-top: 10px;
        }

        .right input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .right button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .right button:hover {
            background-color: #45a049;
        }

        /* Responsive Design for Tablets and Mobile */
        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 100%;
                height: auto;
            }

            .left, .right {
                width: 100%;
                padding: 15px;
            }

            .left .text h1 {
                font-size: 1.5rem;
            }

            .right h2 {
                font-size: 1.25rem;
            }

            .right input, .right button {
                padding: 8px;
            }
        }

        @media screen and (max-width: 480px) {
            .left .text h1 {
                font-size: 1.2rem;
            }

            .left .text p {
                font-size: 0.9rem;
            }

            .right h2 {
                font-size: 1.1rem;
            }

            .right input, .right button {
                padding: 6px;
            }
        }

        /* Styles for the success message */
        .success-message {
            display: none;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <!-- تغییر منبع تصویر به Image.jpg که داخل پوشه public قرار دارد -->
        <img src="image.jpg" alt="Image" class="image">
        <div class="text">
            <h1>Welcome to Our Website</h1>
            <p>This is a sample text to describe the page content. It can be anything you want to share with your visitors.</p>
        </div>
    </div>

    <div class="right">
        <h2>Contact Us</h2>
        <form id="contact-form">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required><br>

            <button type="submit">Submit</button>
        </form>

        <!-- Success message that will be shown after form submission -->
        <div class="success-message" id="success-message">
            اطلاعات شما با موفقیت ثبت شد! با شما تماس خواهیم گرفت.
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Submit form via AJAX
        $('#contact-form').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize(); // Serialize form data

            // Send AJAX request
            $.ajax({
                url: 'process.php', // The PHP file that handles the form submission
                type: 'POST',
                data: formData,
                success: function(response) {
                    // On success, show the success message
                    $('#success-message').fadeIn();

                    // Optionally, hide the form after submission
                    $('#contact-form').hide();

                    // Optionally, reset the form (uncomment the next line if needed)
                    // $('#contact-form')[0].reset();
                }
            });
        });
    });
</script>

</body>
</html>
