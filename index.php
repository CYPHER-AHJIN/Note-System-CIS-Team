<?php
$error = "";
$success = "";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if (empty($title) || empty($content)) {
        $error = "All fields are required.";
    } else {

        $timestamp = date("Y-m-d H:i:s");

        $note = $timestamp . " | " . $title . " | " . $content . PHP_EOL;

        file_put_contents("notes.txt", $note, FILE_APPEND);
        $_SESSION["success"] = "Note saved successfully!";
        header("Location: " . $_SERVER['PHP_SELF'] );
        exit();
    }
    
}
 if (isset($_SESSION["error"])) : ?>
    <div class="error">
        <?php 
            echo htmlspecialchars($_SESSION["error"]);
            unset($_SESSION["error"]);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION["success"])) : ?>
    <div class="success">
        <?php 
            echo htmlspecialchars($_SESSION["success"]);
            unset($_SESSION["success"]);
        ?>
    </div>
<?php endif; ?>
<?php 
$notes = [];
if (file_exists("notes.txt")) {
    $notes = file("notes.txt", FILE_IGNORE_NEW_LINES);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Glass Notes System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="dynamic.js" defer></script>
</head>
<body>

    <h1>Glass Notes System</h1>

    <div class="container">

        <form method="POST">

            <input type="text" name="title" placeholder="Note Title">

            <textarea name="content" placeholder="Write your note..."></textarea>

            <button type="submit">Add Note</button>

        </form>

        <?php if (!empty($error)) : ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <button class="toggle-btn" onclick="toggleNotes()">Show Saved Notes</button>

    </div>
<div class="notes-wrapper" id="notesSection">

<?php foreach ($notes as $note):

$parts = explode("|", $note);
if (count($parts) >= 3):
?>

<div class="note-box">
<div class="note-time"><?php echo htmlspecialchars(trim($parts[0])); ?></div>
<div class="note-title"><?php echo htmlspecialchars(trim($parts[1])); ?></div>
<div><?php echo htmlspecialchars(trim($parts[2])); ?></div>
</div>

<?php endif; endforeach; ?>

</div>

</body>
</html>