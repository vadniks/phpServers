<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administration</title>
    </head>
    <body>
        <button onclick="onBtClick(0)">Ls</button><br>
        <button onclick="onBtClick(1)">Ps</button><br>
        <button onclick="onBtClick(2)">Whoami</button><br>
        <button onclick="onBtClick(3)">Id</button><br>
        <button onclick="onBtClick(4)">Pwd</button><br>
        <button onclick="onBtClick(5)">Uname -a</button><br>
        <span></span>
        <script>
            const commands = ['ls', 'ps', 'whoami', 'id', 'pwd', 'uname -a']

            function onBtClick(which) {
                const request = new XMLHttpRequest()
                request.open('GET', `/admin/adminRequestHandler.php?command=${encodeURIComponent(commands[which])}`, false)
                request.send(null)
                document.querySelector('span').textContent = request.responseText
            }
        </script>
    </body>
</html>
