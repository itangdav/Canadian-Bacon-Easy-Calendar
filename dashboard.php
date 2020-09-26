<!DOCTYPE html>
<html lang="en">
    <head>
        <title> My Calendar </title>
        <link rel="stylesheet" href="search.css">
        <?php include("includes/templates/header.php") ?>
        <?php include("includes/js/makeics.php") ?>
        <div style="background-image: url('includes/images/background.jpg');">
        <div class="search">
            <input id="search-bar" type="text" placeholder="Search Course" class="searchCourse"/>
        </div>
                
        <button onclick="resetCal()">Reset Calendar</button>
        <button onclick="createICS()">Add to Calendar</button>
        <button onclick="downloadCal()">Download Calendar</button>
        </div>
    </body>
</html>
