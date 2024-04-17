<?php
if (isset($_POST['choose_theme'])) {
    if (!empty($_POST['theme'])) {
        $selected_theme = unserialize($_POST['theme']);
        echo "<style>
            body {
                background-color: " . $selected_theme['page_background_color'] . ";
            }
            h1 {
                color: " . $selected_theme['heading_color'] . ";
                text-align: " . $selected_theme['heading_alignment'] . ";
            }
            p {
                color: " . $selected_theme['paragraph_color'] . ";
                font-size: " . $selected_theme['paragraph_font_size'] . "px;
            }
        </style>";

        setcookie('selected_theme', $_POST['theme'], time() + (86400 * 30), "/"); // Cookie valid for 30 days

        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Please select a theme before choosing.')</script>";
    }
} elseif (isset($_POST['add_theme']) || isset($_POST['edit_theme'])) {
    
    header("Location: index.php");
    exit();
} else {
    if (!isset($_COOKIE['selected_theme'])) {
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
    } else {
        $selected_theme = unserialize($_COOKIE['selected_theme']);
        echo "<style>
            body {
                background-color: " . $selected_theme['page_background_color'] . ";
            }
            h1 {
                color: " . $selected_theme['heading_color'] . ";
                text-align: " . $selected_theme['heading_alignment'] . ";
            }
            p {
                color: " . $selected_theme['paragraph_color'] . ";
                font-size: " . $selected_theme['paragraph_font_size'] . "px;
            }
        </style>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Selection</title>
</head>
<body>
    <h2>Theme Selection</h2>
    
    <form action="index.php" method="post">
        <label for="theme">Choose a theme:</label>
        <select name="theme" id="theme">
            <option value="">--Choose Theme--</option>
            <?php
            if (isset($_COOKIE['themes'])) {
                $themes = unserialize($_COOKIE['themes']);
                foreach ($themes as $theme) {
                    $selected = '';
                    if (isset($_COOKIE['selected_theme'])) {
                        $selected_theme = unserialize($_COOKIE['selected_theme']);
                        if ($selected_theme['name'] == $theme['name']) {
                            $selected = 'selected'; 
                        }
                    }
                    echo "<option value=\"" . htmlspecialchars(serialize($theme)) . "\" $selected>" . $theme['name'] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" name="choose_theme" value="Choose the Theme">
        <!-- Modified the formaction attribute to pass the selected theme -->
        <input type="submit" name="edit_theme" value="Edit the Theme" formaction="editTheme.php">
    </form>

    <a href="addNewTheme.php">Add New Theme</a>
    
    <hr>
    
    <h1>Heading 1</h1>
    <p>Lorem Ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor im reprehenderit in voluptate velit esse cillum dolore cu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum </p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
</body>
</html>
