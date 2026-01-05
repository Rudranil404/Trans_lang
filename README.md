Here is a professional and detailed `README.md` file for your project. You can copy-paste this code directly into a file named `README.md` in your GitHub repository.

---

```markdown
# Multilingual Medical Prescription Printer (PHP & mPDF)

A PHP-based web application that generates PDF prescriptions and medical forms in multiple Indian languages. It translates English input into languages like Hindi, Bengali, Tamil, and Telugu using the Google Translation API and renders them correctly in PDF format using **mPDF** and **Lohit fonts**.

## 🚀 Features

* **Automatic Translation:** Converts English medical notes to 8+ Indian languages (Hindi, Bengali, Marathi, Gujarati, Tamil, Telugu, Kannada, Punjabi).
* **PDF Generation:** Uses [mPDF](https://mpdf.github.io/) to create professional-grade PDF documents.
* **Indic Script Support:** Solves the common "square box" (tofu) issue in PDFs by integrating **Lohit TrueType Fonts**.
* **Numeral Conversion:** Automatically converts English numbers (0-9) to native script numerals (e.g., `123` → `১২৩`).
* **Inline Preview:** Opens the generated PDF directly in the browser instead of forcing a download.
* **Smart Font Selection:** Automatically detects the target language and switches to the correct font file.

## 🛠️ Tech Stack

* **Backend:** PHP (7.4 or 8.x recommended)
* **PDF Engine:** mPDF (via Composer)
* **Translation:** Google Cloud Translation API (v2)
* **Fonts:** Lohit Devanagari, Lohit Bengali, etc.
* **Frontend:** HTML5, CSS3

## 📋 Prerequisites

Before running this project, ensure you have:
1.  **PHP** installed (XAMPP/WAMP/LAMP).
2.  **Composer** installed globally.
3.  A **Google Cloud API Key** with "Cloud Translation API" enabled.

## ⚙️ Installation

### 1. Clone the Repository
```bash
git clone [https://github.com/yourusername/multilingual-pdf-printer.git](https://github.com/yourusername/multilingual-pdf-printer.git)
cd multilingual-pdf-printer

```

### 2. Install Dependencies

Run this command in your project folder to install mPDF:

```bash
composer require mpdf/mpdf

```

### 3. Setup Fonts

The project requires **Lohit** fonts to render Indian languages correctly.

1. Create a folder named `fonts/` in the root directory.
2. Download the following `.ttf` files from Google Fonts and place them in the `fonts/` folder:
* `Lohit-Devanagari.ttf` (Hindi, Marathi)
* `Lohit-Bengali.ttf`
* `Lohit-Tamil.ttf`
* `Lohit-Telugu.ttf`
* `Lohit-Gujarati.ttf`
* `Lohit-Kannada.ttf`
* `Lohit-Gurmukhi.ttf` (Punjabi)



> **Note:** Ensure filenames match exactly as listed above, or update the config in `generate_pdf.php`.

### 4. Configure API Key

Open `generate_pdf.php` and replace the placeholder with your actual API key:

```php
$apiKey = 'YOUR_GOOGLE_CLOUD_API_KEY';

```

---

## 📂 Project Structure

```text
/project-root
│
├── vendor/                # Composer dependencies (mPDF)
├── fonts/                 # Directory for .ttf font files
│   ├── Lohit-Devanagari.ttf
│   ├── Lohit-Bengali.ttf
│   └── ...
│
├── prescription_form.php  # User input form (HTML)
├── generate_pdf.php       # Logic for translation & PDF creation
├── composer.json          # Dependency definition
└── README.md              # Documentation

```

## 🖥️ Usage

1. Start your local server (e.g., via XAMPP).
2. Navigate to `http://localhost/your-folder/prescription_form.php`.
3. Enter the medical notes in English.
4. Select the **Print Language** (e.g., Bengali).
5. Click **Generate PDF**.
6. The translated PDF will open in a new tab with the correct script and numerals.

## 🐛 Troubleshooting

| Issue | Solution |
| --- | --- |
| **Square Boxes `[ ]` in PDF** | Missing font file. Check the `fonts/` folder and ensure filenames match the PHP config exactly. |
| **"Composer not found"** | Install Composer from [getcomposer.org](https://getcomposer.org/) and restart your terminal. |
| **Text stays in English** | Your API Key might be invalid or missing. Check `generate_pdf.php` line 22. |
| **Numbers are still English** | Ensure the `convertNumbersToIndian()` function is being called on the translated text string. |
| **PDF Downloads instead of opening** | Check your browser settings, or ensure `$mpdf->Output('name.pdf', 'I');` is used (Mode 'I'). |

## 📜 License

This project is open-source.

* **mPDF** is licensed under [GPL v2](https://www.google.com/search?q=https://github.com/mpdf/mpdf/blob/development/LICENSE.txt).
* **Lohit Fonts** are licensed under the [OFL (Open Font License)](https://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL).

## 👨‍💻 Author

Developed by **Rudranil Paul** *For support or queries, please open an issue in this repository.*

