<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription Printer</title>

    <!-- Pixel Font -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: transparent; /* BG removed */
            font-family: 'Press Start 2P', cursive;
        }

        /* Cobblestone effect */
        .mc-card {
            width: 850px;
            padding: 28px;
            background:
                linear-gradient(135deg, #9e9e9e 25%, transparent 25%) -20px 0,
                linear-gradient(225deg, #9e9e9e 25%, transparent 25%) -20px 0,
                linear-gradient(315deg, #9e9e9e 25%, transparent 25%),
                linear-gradient(45deg, #9e9e9e 25%, transparent 25%);
            background-size: 40px 40px;
            background-color: #bdbdbd;
            border: 6px solid #4e4e4e;
            box-shadow: 0 10px 0 #2f2f2f;
        }

        h2 {
            text-align: center;
            font-size: 16px;
            color: #2b2b2b;
            margin-bottom: 24px;
        }

        label {
            font-size: 11px;
            color: #1f1f1f;
            display: block;
            margin-bottom: 6px; 
        }

        textarea, select {
            width: 100%;
            padding: 10px;
            font-family: 'Press Start 2P', cursive;
            font-size: 10px;
            background: #eeeeee;
            border: 4px solid #5a5a5a;
            color: #1a1a1a;
            height: 50px;
        }

        textarea {
            resize: none;
            height: 120px;
        }

        .btn {
            margin-top: 22px;
            width: 100%;
            padding: 14px;
            font-size: 12px;
            font-family: 'Press Start 2P', cursive;
            background: #4caf50;
            color: #fff;
            border: 4px solid #2e7d32;
            cursor: pointer;
            box-shadow: 0 6px 0 #1b5e20;
        }

        .btn:hover {
            background: #66bb6a;
        }

        .btn:active {
            box-shadow: 0 2px 0 #1b5e20;
            transform: translateY(4px);
        }
    </style>
</head>

<body>

    <form class="mc-card" action="generate_pdf.php" method="POST" target="_blank">

        <h2>📜 Language Translators</h2>

        <label>Write (English)</label>
        <textarea name="prescription_text" required></textarea>

        <br><br>

        <label>Language translator</label>
        <select name="print_language">
            <option value="en">English (Original)</option>
            <option value="hi">Hindi (हिंदी)</option>
            <option value="bn">Bengali (বাংলা)</option>
            <option value="mr">Marathi (मराठी)</option>
            <option value="gu">Gujarati (ગુજરાતી)</option>
            <option value="ta">Tamil (தமிழ்)</option>
            <option value="te">Telugu (తెలుగు)</option>
            <option value="kn">Kannada (ಕನ್ನಡ)</option>
            <option value="pa">Punjabi (ਪੰਜਾਬੀ)</option>
        </select>

        <button type="submit" class="btn">Generate PDF</button>

    </form>

</body>
</html>
