# Steam Achievements Viewer

## Backlog
- Fix Timezone-Offset Calculation @users/activity (currently it is fixed at +02:00h)

## Coding TODOs

### general
- [ ] general | import tailwind & vue, instead of using external links
- [ ] general | option to manually add games (also tag these games as being `manually added`)
  - info: games that are not in the steam-store anymore will not be returned from GetOwnedGames (e.g. https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=403570&key=34726D7C756F3C392EAD2DABB301462C&steamid=76561197999852541)
- [ ] general | add pagination [LOW-PRIO]
### scraper
- [ ] scraper | add img_icon_url = http://media.steampowered.com/steamcommunity/public/images/apps/{appid}/{img_icon_url}.jpg
- [ ] scraper | add option to resolve vanity-urls
- [ ] scraper | more visual feedback (maybe with vue and ajax/axios)

## Styling TODOs

### general
- [ ] styling | which sites are needed?
  - List all Games of a User with Progress(-bar)
  - List all Achievements of a User for a Game
    - With Categories (Achieved / Unachieved / All)
    - With Multiple Sort Options (Original, Name, UnlockedAt, ...)
- [ ] styling | develop uniform style for the whole website
- [ ] styling | use twig for templating

## Database TODOs

### general
- [ ] db | use less insert-queries (webhoster has limit of 5000 update queries) => rewrite import function of DatabaseConnection
- [ ] db | write migrations, to recreate the db
- [ ] db | save total counts
- [ ] db | save total number of games / number of games with achievements
- [ ] db | don't save any game without achievements
- [ ] db | mark completed (user)-games (+ when it was completed -> when was the last achievement unlocked)
- [ ] db | add columns `created_at` & `updated_at` to every table
- [ ] db | log number of api calls to db (because of 100,000 per day limitation)

## CI/CD

### general
- [ ] ci/cd | remove passwords from repository

---

## Finished
- [x] ci/cd | use ftp-deploy as github action
- [x] users/show | add overview of games with percentages
- [x] games/user | show (unlocked) achievements of a specific user
- [x] scraper | split process in reproducable parts -> more error-prone
- [x] scraper | visual feedback (e.g. log, progressbar, etc.)
- [x] scraper | IPlayerService/GetOwnedGames https://steamwebapi.azurewebsites.net/ - evtl. weitere Parameter verwenden
- [x] db | add game_id to user_achievements (don't join with `system_name` since it's not unique)
- [x] users/show | error handling, when calling site without parameter
- [x] users/index | list all users
- [x] users/show | github like calendar
- [x] users/show | activity feed | per day
- [x] users/show | activity feed | group by game
- [x] games/index | list all games
- [x] games/show | list all achievements for a game
- [x] games/show | remove completed achievements here
- [x] games/show | add achievement percentages
- [x] scraper/index | alle games von usern holen
- [x] db | save achievement global percentages
