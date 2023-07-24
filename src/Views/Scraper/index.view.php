<form action="/scraper/user.php" method="GET">
    <label>Steam-ID</label>
    <input type="text" placeholder="Steam-ID" name="userid">
    <input type="submit">
</form>

<?php if(!empty($users)): ?>
    <table>
        <thead>
            <th>Username</th>
            <th>Games</th>
            <th>Achievements</th>
            <th colspan="3">Actions</th>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user->name ?></td>
                    <td><?php echo $user->games_count ?></td>
                    <td><?php echo $user->total_achievements ?></td>
                    <td><a class="text-orange-300" href="/scraper/user.php?<?php echo http_build_query(['userid' => $user->id]); ?>">user</a></td>
                    <td><a class="text-green-300" href="/scraper/games.php?<?php echo http_build_query(['userid' => $user->id]); ?>">user-games</a></td>
                    <td><a class="text-red-300" href="/scraper/achievements.php?<?php echo http_build_query(['userid' => $user->id]); ?>">user-achievements</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if(isset($result) && isset($operation)): ?>
    <p>Operation: <?php echo $operation ?></p>
    <p>Success: <?php echo ($result ? '✔️' : '❌') ?></p>
    <p># of API-Calls: <?php echo $api_calls ?></p>
<?php endif; ?>
