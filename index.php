<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-100" style="padding: 0; margin: 0; font-family: sans-serif">
<div class="flex">
    <div class="w-1/6 flex-none flex flex-col py-2 pl-2">
        <span class="rounded-full border border-black px-1 py-0.5 text-xs text-center">SURVIVOR</span>
        <span class="rounded-full border border-black px-1 py-0.5 text-xs mt-2 text-center bg-black text-yellow-100">KILLER</span>
    </div>
    <div id="achievementsContainer" class="flex flex-wrap p-1">
      <?php
        $achievements = json_decode(file_get_contents(__DIR__ . '/data.json'), true)["game"]["availableGameStats"]["achievements"];
        foreach($achievements as $achievement): ?>
        <div class="flex xl:w-1/4 md:w-2/4 w-full">
            <div class="w-full border-black border m-1">
                <!--<div style="background-image: url({$achievement["icon"]});width:70px;height:70px" class="bg-cover flex-none"></div>-->
                <div class="mx-2 my-1">
                    <p class="text-lg font-bold line-clamp-1"><?php echo $achievement["displayName"] ?></p>
                    <p class="text-sm line-clamp-2"><?php echo $achievement["description"] ?></p>
                    <div class="flex mt-2 mb-2">
                        <span class="rounded-full border border-black px-2 py-0.5 text-xs">SURVIVOR</span>
                        <span class="rounded-full border border-black bg-black text-yellow-100 px-2 py-0.5 text-xs ml-1">KILLER</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
