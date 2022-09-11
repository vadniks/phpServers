<html lang="en">
    <head>
        <title>Index page</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
    </head>
    <body>
        <label for="t1input">Task 1 encoded shape params</label>
        <input
            id="t1input"
            type="number"/>
        <button onclick="window.location.replace(
                `drawer/drawer.php?encoded=${document.getElementById('t1input').value}`
        )">Task 1</button>
        <br>
        <label for="t2input">Task 2 array for the Shell sort</label>
        <input
            id="t2input"
            type="text"/>
        <button onclick="window.location.replace(
                `sort/sort.php?array=${document.getElementById('t2input').value}`
        )">Task 2</button>
        <br>
        <button onclick="window.location.replace('admin/admin.php')">Task 3</button>
    </body>
</html>