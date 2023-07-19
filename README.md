# Steam Achievements Viewer
## Coding TODOs
### users/index
- [x] list all users
- [ ] add pagination
### users/show
- [x] github like calendar
- activity feed
    - [x] per day
    - [x] group by game
- [ ] error handling, when calling site without parameter
### games/index
- [x] list all games
### games/show
- [x] list all achievements for a game
- [x] remove completed achievements here
- [x] add achievement percentages
### scraper/index
- [x] alle games von usern holen
- [ ] visual feedback (e.g. log, progressbar, etc.)
- [ ] split process in reproducable parts -> more error-prone
- [ ] use less sql-queries (hoster has update limit of 5000)
- [ ] IPlayerService/GetOwnedGames https://steamwebapi.azurewebsites.net/ - evtl. weitere Parameter verwenden
      - img_icon_url = http://media.steampowered.com/steamcommunity/public/images/apps/{appid}/{img_icon_url}.jpg
      - https://stackoverflow.com/questions/53963328/how-do-i-get-a-hash-for-a-picture-form-a-steam-game

## Styling TODOs
### general
- [ ] which sites are needed?
  - List all Achievements for a Game + User
    - With Categories (Achieved / Unachieved / Marked)
- [ ] develop uniform style for the whole website
- [ ] use twig for templating

## Database/Security/CICD TODOs
- [ ] write migrations, to recreate the db
- [ ] add game_id to user_achievements
- [ ] remove passwords from repository
- [ ] use ftp-deploy as github action
- [ ] save percentages in db
- [ ] save total counts in db
- [ ] don't save any game without achievements
- [ ] mark completed (user)-games (+ when it was completed -> when was the last achievement unlocked)
