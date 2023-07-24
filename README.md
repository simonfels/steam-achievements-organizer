# Steam Achievements Viewer

## Coding TODOs

### general
- [ ] general | add pagination
### scraper
- [ ] scraper | visual feedback (e.g. log, progressbar, etc.)
- [ ] scraper | split process in reproducable parts -> more error-prone
- [ ] scraper | use less sql-queries (webhoster has limit of 5000 update queries)
- [x] scraper | IPlayerService/GetOwnedGames https://steamwebapi.azurewebsites.net/ - evtl. weitere Parameter verwenden
- [ ] scraper | add img_icon_url = http://media.steampowered.com/steamcommunity/public/images/apps/{appid}/{img_icon_url}.jpg

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
- [ ] db | write migrations, to recreate the db
- [ ] db | add game_id to user_achievements (don't join with `system_name` since it's not unique)
- [ ] db | save total counts
- [ ] db | save total number of games / number of games with achievements
- [ ] db | don't save any game without achievements
- [ ] db | mark completed (user)-games (+ when it was completed -> when was the last achievement unlocked)
- [ ] db | add columns `created_at` & `updated_at` to every table
- [ ] db | log number of api calls (because of 100,000 per day limitation)

## CI/CD

### general
- [ ] ci/cd | use ftp-deploy as github action
- [ ] ci/cd | remove passwords from repository

---

## Finished
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
