# Steam Achievements Viewer

[<img alt="Deployed with FTP Deploy Action" src="https://img.shields.io/badge/Deployed With-FTP DEPLOY ACTION-%3CCOLOR%3E?style=for-the-badge&color=0077b6">](https://github.com/SamKirkland/FTP-Deploy-Action)

[![🚀 Deploy website on push](https://github.com/simonfels/playground/actions/workflows/main.yml/badge.svg?branch=main&event=push)](https://github.com/simonfels/playground/actions/workflows/main.yml)

## CODING TODOs

### general
- [ ] general list-like activity-site, grouped per day, for all users (like the steam "Activity"-tab)
- [ ] option to manually add games (also tag these games as being `manually added`)
  - info: games that are not in the steam-store anymore will not be returned from GetOwnedGames (e.g. https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=403570&key=${steamapikey}&steamid=76561197999852541)

### scraper
- [ ] add error-handling for api-calls (there are sometimes games/achievements missing, when scraping)
- [ ] call steam-api with parallel calls using curl_multi_exec / guzzle_http
  - try to benchmark with https://github.com/scottchiefbaker/php-benchmark to measure actual benefit
- [ ] adjust order of api-calls/db-inserts (for parallel processing):
  - get games list, each game:
    - calc total number of games
    - check if game already in db (if yes, multiple steps can be skipped)
    - get game-achievements (calc total) (if not already present)
    - get game-achievement percentages (if not already present)
    - get user-achievements (calc percentage completed, mark game completed if 100%)
    - maybe mark games/etc. when they were fetched, for automation (fetch all games that haven't been fetched since 2 days, etc..)

## STYLING TODOs

### general
- [ ] try to modularize repetetive elements

## DATABASE TODOs

### general
- [ ] log number of api calls to db (because of 100,000 per day limitation)

### TESTING TODOs
- [ ] add code-quality checks using: php-cs, php-cs-fixer, psalm
- [ ] add tests
- [ ] add tests and quality-checks to github-actions
- [ ] maybe add prettier for tailwind/vue/html

## BACKLOG
- display graphs for users/activity maybe
- Fix Timezone-Offset Calculation @ users/activity (currently it is fixed at +02:00h)
- scraper | add img_icon_url = http://media.steampowered.com/steamcommunity/public/images/apps/{appid}/{img_icon_url}.jpg
- scraper | add option to resolve vanity-urls
- general | add pagination [LOW-PRIO] (/games, /users)
- Visual Bug in users/activity calendar when month only has one column
- Use https://store.steampowered.com/api/appdetails?appids=240 for Game-Details (maybe if needed)
