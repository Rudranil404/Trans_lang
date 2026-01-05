<?php
// 1. Load mPDF
require_once __DIR__ . '/vendor/autoload.php';

// 2. Get Data from Form
$textInput  = isset($_POST['prescription_text']) ? $_POST['prescription_text'] : '';
$targetLang = isset($_POST['print_language']) ? $_POST['print_language'] : 'en';

// 3. TRANSLATION LOGIC
// If the target is NOT English, we translate the input.
if ($targetLang != 'en' && !empty($textInput)) {
   // 1. Get the translated text from Google
$translatedString = translateText($textInput, $targetLang);

// 2. FORCE convert the numbers to the local script
$finalText = convertNumbersToIndian($translatedString, $targetLang);
} else {
    $finalText = $textInput;
}
// Translation function using Google Translate API
function translateText($text, $targetLang) {
    // This uses the free public endpoint (client=gtx).
    // WARNING: Google may block this if you use it for thousands of requests.
    // Use this for TESTING ONLY.
    
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=" . $targetLang . "&dt=t&q=" . urlencode($text);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Pretend to be a browser so Google doesn't block us immediately
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36');
    
    $response = curl_exec($ch);
    curl_close($ch);

    // Google returns a weird array structure like [[[ "Hindi", "English" ]]]
    $data = json_decode($response, true);

    if (isset($data[0][0][0])) {
        // We combine all parts of the translation (in case of long text)
        $translatedText = "";
        foreach ($data[0] as $sentence) {
            $translatedText .= $sentence[0];
        }
        return $translatedText;
    } else {
        return $text . " (Translation Failed)";
    }
}

function convertNumbersToIndian($text, $lang) {
    // Standard English Numbers
    $western_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    
    // Define arrays for each language's numerals
    $local_digits = [];

    switch ($lang) {
        case 'bn': // Bengali (বাংলা)
            $local_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
            break;
            
        case 'hi': // Hindi (हिंदी)
        case 'mr': // Marathi (मराठी)
            $local_digits = array('०', '१', '२', '३', '४', '५', '६', '७', '८', '९');
            break;
            
        case 'gu': // Gujarati (ગુજરાતી)
            $local_digits = array('૦', '૧', '૨', '૩', '૪', '૫', '૬', '૭', '૮', '૯');
            break;
            
        case 'te': // Telugu (తెలుగు)
            $local_digits = array('౦', '౧', '౨', '౩', '౪', '౫', '౬', '౭', '౮', '౯');
            break;
            
        case 'ta': // Tamil (தமிழ்) - *Note: Tamil numerals are distinct, but often 0-9 are used. 
                   // This uses the traditional Tamil set if you really want it.
            $local_digits = array('௦', '௧', '௨', '௩', '௪', '௫', '௬', '௭', '௮', '௯');
            break;

        case 'kn': // Kannada (ಕನ್ನಡ)
            $local_digits = array('೦', '೧', '೨', '೩', '೪', '೫', '೬', '೭', '೮', '೯');
            break;
            
        case 'pa': // Punjabi (Gurmukhi)
            $local_digits = array('੦', '੧', '੨', '੩', '੪', '੫', '੬', '੭', '੮', '੯');
            break;

        default:
            return $text; // Return original if language not found
    }

    // Replace English numbers with Local numbers
    return str_replace($western_digits, $local_digits, $text);
}


// 4. mPDF Setup
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

// 2. Register ALL Indian Fonts
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        // Hindi & Marathi
        'lohit_devanagari' => [
            'R' => 'Lohit-Devanagari.ttf', 
            'useOTL' => 0xFF, 'useKashida' => 75,
        ],
        // Bengali
        'lohit_bengali' => [
            'R' => 'Lohit-Bengali.ttf',
            'useOTL' => 0xFF, 'useKashida' => 75,
        ],
        // Tamil
        'lohit_tamil' => [
            'R' => 'Lohit-Tamil.ttf',
            'useOTL' => 0xFF, 'useKashida' => 75,
        ],
        // Telugu
        'lohit_telugu' => [
            'R' => 'Lohit-Telugu.ttf',
            'useOTL' => 0xFF, 'useKashida' => 75,
        ],
        // Gujarati
        'lohit_gujarati' => [
            'R' => 'Lohit-Gujarati.ttf',
            'useOTL' => 0xFF, 'useKashida' => 75,
        ],
        // Punjabi
        'lohit_gurmukhi' => [
            'R' => 'Lohit-Gurmukhi.ttf',
            'useOTL' => 0xFF, 'useKashida' => 75,
        ],
        // Kannada
        'lohit_kannada' => [
            'R' => 'Lohit-Kannada.ttf',
            'useOTL' => 0xFF, 'useKashida' => 75,
        ]
    ],
    // DO NOT set a 'default_font'. Let mPDF pick based on the language.
]);

// 3. Enable Auto-Language Detection
// This is the magic setting. It sees Bengali text and automatically uses 'lohit_bengali'.
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;

// 6. Output HTML
$html = '
    <h1>Translation</h1>
    <hr>
    <b>Original (English):</b><br>
    ' . $textInput . '
    <br><br>
    <b>Translated (' . strtoupper($targetLang) . '):</b><br>
    <div style="font-size: 14pt;">' . $finalText . '</div>
';

$mpdf->WriteHTML($html);
$mpdf->Output('prescription.pdf', 'I');
?>