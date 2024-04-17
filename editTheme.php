<?php
$selected_theme = [];
if(isset($_POST['theme'])) {
    $selected_theme = unserialize($_POST['theme']);
}

if (isset($_POST['update_theme'])) {
    if (
        isset($_POST['theme_name']) &&
        isset($_POST['page_background_color']) &&
        isset($_POST['heading_color']) &&
        isset($_POST['heading_alignment']) &&
        isset($_POST['paragraph_color']) &&
        isset($_POST['paragraph_font_size'])
    ) {
        $updated_theme = [
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
            foreach ($themes as &$theme) {
                if ($theme['name'] === $selected_theme['name']) {
                    $theme = array_merge($theme, $updated_theme);
                }
            }
        }
        setcookie('themes', serialize($themes), time() + (86400 * 30), "/"); 
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
        setcookie('selected_theme', serialize($default_theme), time() + (86400 * 30), "/");
        header("Location: index.php");
        exit();
    } else {
        echo "Please provide all required inputs.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Theme</title>
</head>
<body>
    <h2>Edit Theme</h2>
    
    <form action="editTheme.php" method="post">
        <p>Name of Your Theme: 
        <input type="text" name="theme_name" id="theme_name" value="<?php echo isset($selected_theme['name'])? $selected_theme['name']: ''?>" ><br><br>

        <label for="page_background_color">Color of Page Background:</label>
        <input type="color" name="page_background_color" id="page_background_color" value="<?php echo isset($selected_theme['page_background_color']) ? $selected_theme['page_background_color'] : ''; ?>"><br><br>
        
        <label for="heading_color">Color of Heading 1:</label>
        <input type="color" name="heading_color" id="heading_color" value="<?php echo isset($selected_theme['heading_color']) ? $selected_theme['heading_color'] : ''; ?>"><br><br>
        
        <label for="heading_alignment">Alignment of Heading 1:</label>
        <select name="heading_alignment" id="heading_alignment">
            <option value="">--Choose The Alignment--</option>
            <option value="left" <?php echo (isset($selected_theme['heading_alignment']) && $selected_theme['heading_alignment'] == 'left') ? 'selected' : ''; ?>>Left</option>
            <option value="center" <?php echo (isset($selected_theme['heading_alignment']) && $selected_theme['heading_alignment'] == 'center') ? 'selected' : ''; ?>>Center</option>
            <option value="right" <?php echo (isset($selected_theme['heading_alignment']) && $selected_theme['heading_alignment'] == 'right') ? 'selected' : ''; ?>>Right</option>
        </select><br><br>
        
        <label for="paragraph_color">Color of Paragraph:</label>
        <input type="color" name="paragraph_color" id="paragraph_color" value="<?php echo isset($selected_theme['paragraph_color']) ? $selected_theme['paragraph_color'] : ''; ?>"><br><br>
        
        <label for="paragraph_font_size">Font Size of Paragraph (px):</label>
        <input type="number" name="paragraph_font_size" id="paragraph_font_size" min="1" value="<?php echo isset($selected_theme['paragraph_font_size']) ? $selected_theme['paragraph_font_size'] : ''; ?>"><br><br>

        <input type="hidden" name="theme" value="<?php echo htmlspecialchars(serialize($selected_theme)); ?>">

        <input type="submit" name="update_theme" value="Save">
    </form>


</body>
</html>
