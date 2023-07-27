# Steam Achievements Viewer

## CODING TODOs

### general
- [ ] general | import tailwind & vue, instead of using external links
- [ ] general | option to manually add games (also tag these games as being `manually added`)
  - info: games that are not in the steam-store anymore will not be returned from GetOwnedGames (e.g. https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=403570&key=34726D7C756F3C392EAD2DABB301462C&steamid=76561197999852541)

### scraper
- [ ] scraper | more visual feedback (maybe with vue and ajax/axios)


## STYLING TODOs

### general
- [META] Which sites are needed?
  - List all Games of a User with Progress(-bar)
  - List all Achievements of a User for a Game
    - With Categories (Achieved / Unachieved / All)
    - With Multiple Sort Options (Original, Name, UnlockedAt, ...)
- [ ] styling | develop uniform style for the whole website


## DATABASE TODOs

### general
- [ ] db | [HIGH-PRIO] use the same db-system for dev and prod
- [ ] db | use less insert-queries (webhoster has limit of 5000 update queries) => rewrite import function of DatabaseConnection
- [ ] db | write migrations, to recreate the db
- [ ] db | save total counts
- [ ] db | save total number of games / number of games with achievements
- [ ] db | don't save any game without achievements
- [ ] db | mark completed (user)-games (+ when it was completed -> when was the last achievement unlocked)
- [ ] db | add columns `created_at` & `updated_at` to every table
- [ ] db | log number of api calls to db (because of 100,000 per day limitation)


## BACKLOG
- Fix Timezone-Offset Calculation @users/activity (currently it is fixed at +02:00h)
- scraper | add img_icon_url = http://media.steampowered.com/steamcommunity/public/images/apps/{appid}/{img_icon_url}.jpg
- scraper | add option to resolve vanity-urls
- general | add pagination [LOW-PRIO]

- Warnings: When fetching A9ts for arutomas |
  ```
  Warning: Undefined array key "NEW_ACHIEVEMENT_245_15" in /var/www/src/Models/Scraper.php on line 66
  Warning: Undefined array key "NEW_ACHIEVEMENT_245_16" in /var/www/src/Models/Scraper.php on line 66
  Warning: Undefined array key "NEW_ACHIEVEMENT_245_17" in /var/www/src/Models/Scraper.php on line 66
  ```
