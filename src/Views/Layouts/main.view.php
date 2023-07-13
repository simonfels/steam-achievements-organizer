<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body class="bg-zinc-950" style="padding: 0; margin: 0; font-family: sans-serif">
    <nav>
        <ul class="flex">
            <li><a href="/games" class="text-neutral-300 inline-block p-2"><strong>Games</strong></a></li>
            <li><a href="/users" class="text-neutral-300 inline-block p-2"><strong>Users</strong></a></li>
            <li><a href="/" class="text-neutral-300 inline-block p-2"><strong>Fetch Data</strong></a></li>
        </ul>
    </nav>
    <div class="m-2">
        <?php echo $content; ?>
    </div>
</body>
</html>
