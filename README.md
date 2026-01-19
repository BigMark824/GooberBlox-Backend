# GooberBlox Backend

A fast laravel library for usage on Roblox Private Servers.

## Holds core infrastructure pertaining to:
- Server infrastrucutre
- Core API backends (Accounts, Game joining, Assets)
- More information about the overall Platform structure can be found in 2019 Roblox Web Assemblies

# Usage

Simply run
```
composer require mathmark825/gooberblox-backend
```
We already have database migrations set up for you to use, just run
```
php artisan migrate
```

# Available Commands
## Importing FFlags
```
php artisan import:fflags <YourFilePath> <FlagGroup (e.g ClientAppSettings)
```

Documentation coming soon.

Made with ❤️ by MathMark825 
