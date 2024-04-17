<?php
if (isset($_POST['add_theme'])) {
    if (!empty($_POST['theme_name']) && !empty($_POST['page_background_color']) && !empty($_POST['heading_color']) && !empty($_POST['heading_alignment']) && !empty($_POST['paragraph_color']) && !empty($_POST['paragraph_font_size'])) {
        $new_theme = [
            'name' => $_POST['theme_name'],
            'page_background_color' => $_POST['page_background_color'],
            'heading_color' => $_POST['heading_color'],
            'heading_alignment' => $_POST['heading_alignment'],
            'paragraph_color' => $_POST['paragraph_color'],
            'paragraph_font_size' => $_POST['paragraph_font_size']
        ];        
        $themes = [];
        if (isset($_COOKIE['themes'])) {
            $themes = unserialize($_COOKIE['themes']);
        }        
        $themeExists = false;
        foreach ($themes as &$theme) {
            if ($theme['name'] === $new_theme['name']) {
                // Jika tema sudah ada, perbarui nilainya
                $theme = $new_theme;
                $themeExists = true;
                break;
            }
        }
        if (!$themeExists) {
            $themes[] = $new_theme;
        }        
        setcookie('themes', serialize($themes), time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
        $default_theme = [
            'page_background_color' => '#ffffff', 
            'heading_color' => '#000000', 
            'heading_alignment' => 'left', 
            'paragraph_color' => '#000000', 
            'paragraph_font_size' => 16 
        ];

        echo "<style>
            body {
                background-color: " . $default_theme['page_background_color'] . ";
            }
            h1 {
                color: " . $default_theme['heading_color'] . ";
                text-align: " . $default_theme['heading_alignment'] . ";
            }
            p {
                color: " . $default_theme['paragraph_color'] . ";
                font-size: " . $default_theme['paragraph_font_size'] . "px;
            }
        </style>";

        // Save default theme in a cookie
        setcookie('selected_theme', serialize($default_theme), time() + (86400 * 30), "/");
        
        // Redirect ke halaman index.php
        header("Location: index.php");
        exit();
    } else {
        // Jika tema tidak diisi dengan lengkap, tampilkan pesan kesalahan
        echo "Please fill all the theme details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Theme</title>
</head>
<body>
    <h2>Add New Theme</h2>
    
    <!-- Form untuk menambah tema -->
    <form action="addNewTheme.php" method="post">
        <label for="theme_name">Name of Your Theme:</label>
        <input type="text" name="theme_name" id="theme_name"><br><br>
        
        <label for="page_background_color">Color of Page Background:</label>
        <input type="color" name="page_background_color" id="page_background_color"><br><br>
        
        <label for="heading_color">Color of Heading 1:</label>
        <input type="color" name="heading_color" id="heading_color"><br><br>
        
        <label for="heading_alignment">Alignment of Heading 1:</label>
        <select name="heading_alignment" id="heading_alignment">
            <option value=>--Choose The Alignment--</option>
            <option value="left">Left</option>
            <option value="center">Center</option>
            <option value="right">Right</option>
        </select><br><br>
        
        <label for="paragraph_color">Color of Paragraph:</label>
        <input type="color" name="paragraph_color" id="paragraph_color"><br><br>
        
        <label for="paragraph_font_size">Font Size of Paragraph (px):</label>
        <input type="number" name="paragraph_font_size" id="paragraph_font_size" min="1"><br><br>
        
        <input type="submit" name="add_theme" value="Save">
    </form>

</body>
</html>
