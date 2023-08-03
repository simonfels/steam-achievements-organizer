# Steam Achievements Viewer

## CODING TODOs

### general
- [ ] option to manually add games (also tag these games as being `manually added`)
  - info: games that are not in the steam-store anymore will not be returned from GetOwnedGames (e.g. https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=403570&key=34726D7C756F3C392EAD2DABB301462C&steamid=76561197999852541)

### scraper
- [ ] call steam-api with parallel calls using curl_multi_exec
  - try to benchmark with https://github.com/scottchiefbaker/php-benchmark to measure actual benefit
- [ ] more visual feedback (maybe with vue and ajax/axios)
- [ ] adjust order of api-calls/db-inserts (for curl_multi_exec):
  - get games list, each game:
    - calc total number of games
    - check if game already in db (if yes, multiple steps can be skipped)
    - get game-achievements (calc total) (if not already present)
    - get game-achievement percentages (if not already present)
    - get user-achievements (calc percentage completed, mark game completed if 100%)

## STYLING TODOs

### general
- [ ] develop uniform style for the whole website

## DATABASE TODOs

### general
- [ ] add columns `created_at` & `updated_at` to every table
- [ ] log number of api calls to db (because of 100,000 per day limitation)

## CI/CD TODOs

### general
- [ ] remove steam-api key from repository

### workflow
- [ ] add composer install as github action & remove /vendor from vcs

## BACKLOG
- add option to add descriptions to hidden achievements (if not already present)
- import tailwind & vue, instead of using external links
- display graphs for users/activity maybe
- Fix Timezone-Offset Calculation @ users/activity (currently it is fixed at +02:00h)
- scraper | add img_icon_url = http://media.steampowered.com/steamcommunity/public/images/apps/{appid}/{img_icon_url}.jpg
- scraper | add option to resolve vanity-urls
- general | add pagination [LOW-PRIO]
- temp solution for .git folders in /vendor: rm -rf `find . -type d -name .git`
