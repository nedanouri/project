<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drehendes Bildkarussell mit Formular</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General Layout */
        body {
            font-family: Arial, sans-serif;
            background-color: transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .info-container {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            color: #ff6600;
        }

        .info-text {
            font-size: 1.2rem;
            margin-right: 20px;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            height: 70vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel-image {
            position: absolute;
            width: 40%;
            height: auto;
            transition: transform 1s ease-in-out, opacity 1s ease-in-out;
            z-index: 1;
        }

        .middle {
            transform: scale(1.1);
            z-index: 3;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.4);
        }

        .left {
            transform: translateX(-80%);
            opacity: 0.9;
        }

        .right {
            transform: translateX(80%);
            opacity: 0.9;
        }

        .carousel-text {
            margin-top: 10px;
            text-align: center;
            font-size: 1.5rem;
            color: #ff6600;
            width: 80%;
        }

        .form-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-top: 10px;
            font-size: 1rem;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        /* Select2 styling */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 2px 10px;
            margin: 2px 5px 2px 0;
            font-size: 0.9rem;
        }

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
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf6b4gqAAAAALyWv5xNUr9LecPzZNLX9WIjWL-r"></script>
</head>
<body>

<!-- Top Info Section -->
<div class="info-container">
    <div class="info-text" id="registration-count">
        Anzahl der vormerken: 0
    </div>
</div>

<!-- Carousel Section -->
<div class="carousel-container">
    <img src="image1.jpg" alt="Bild 1" class="carousel-image left">
    <img src="image2.jpg" alt="Bild 2" class="carousel-image middle">
    <img src="image3.jpg" alt="Bild 3" class="carousel-image right">
</div>

<!-- Carousel Text -->
<div class="carousel-text">
    JETZT VORMERKEN - WOHNEN BEIM KUTSCHKERMARKT
</div>

<!-- Form Section -->
<div class="form-container" id="form-container">
    <h2>vormerken</h2>
    <form id="contact-form" method="post">
        <label for="first_name">Vorname:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Nachname:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Telefonnummer:</label>
        <input type="tel" id="phone" name="phone">

        <label for="request">Anfragetyp:</label>
        <select id="request" name="request[]" multiple="multiple">
            <option value="Option 1">Option 1</option>
            <option value="Option 2">Option 2</option>
            <option value="Option 3">Option 3</option>
            <option value="Option 4">Option 4</option>
        </select>

        <button type="submit">Absenden</button>
    </form>
</div>

<div class="success-message" id="success-message">
    Ihre Daten wurden erfolgreich gespeichert! Wir werden uns bei Ihnen melden.
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2
        $('#request').select2({
            placeholder: "Wählen Sie Ihre Anfrage",
            width: 'resolve'
        });

        // Form submission
        $('#contact-form').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(e.target);

            fetch('process.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    $('#form-container').hide();
                    $('#success-message').show();

                    setTimeout(() => {
                        $('#success-message').hide();
                    }, 60000);
                })
                .catch(error => console.error('Fehler beim Senden des Formulars:', error));
        });

        // Fetch registration count
        fetch('process.php')
            .then(response => response.json())
            .then(data => {
                $('#registration-count').text(`Anzahl der vormerken: ${data.form_submissions}`);
            })
            .catch(error => console.error('Fehler beim Abrufen der Statistik:', error));
    });
    function onClick(e) {
        e.preventDefault();
        grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute('6Lf6b4gqAAAAALyWv5xNUr9LecPzZNLX9WIjWL-r', {action: 'LOGIN'});
        });
    }
</script>

</body>
</html>
