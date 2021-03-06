# Mourne

An old village builder / hero manager web rpg that I originally wrote using Code Igniter 3 ported to [rcpp_framework](https://github.com/Relintai/rcpp_framework).

The original code is under the `Mourne-CI` folder. I wrote this about 9 years ago. I only have the application code in the folder.
I decided not to commit the framework code itself to minimize the chance of committing passwords, or stray temp files and such.
This was my first bigger app, so even though when I wrote this I did pay attention to make it secure (it's probably not that bad), however it's still
probably not a good idea to use it as it is.

This is highly experimental stuff. It probably shouldn't be used by anyone who's sane.

Note: this readme has been taken from an another project of mine, it will be updated later.

## Compilation

Will only work on linux! Works on the rasberry pi.

### Dependencies

Arch/Manjaro:

``` 
pacman -S --needed scons pkgconf gcc yasm 
```

Debian/Raspian:

```
sudo apt-get install build-essential scons pkg-config libudev-dev yasm 
```

Optionally if you install MariaDB/MySQL and/or PostgreSQL the compile system should pick it up. Make sure to get a version
whoch contains the development headers (A bunch of .h files).

### Initial setup

clone this repo, then call `scons`, it will clone rcpp cms into a new engine directory. Run this every time you update the project.
You don't have to run it before / between builds.

```
# git clone https://github.com/Relintai/mourne.git mourne
# cd crystal_cms
# scons
```

Now you can build the project like: `scons bl`.  ([b]uild [l]inux)

Adding -jX to the build command will run the build on that many threads. Like: `scons bl -j4`.

```
# scons bl -j4
- or -
# ./build.sh
```
Now you can run it.

First run migrations, this will create the necessary database tables:

```
# ./engine/bin/server m
- or -
# ./migrate.sh
```

Now you can start the server:

```
# ./engine/bin/server
- or -
# ./run.sh
```

Make sure to run it from the project's directory, as it needs data files.

Now just open http://127.0.0.1:8080

You can push floats to the "a/b" MQTT topics, and the new values will be save in the `database.sqlite` file, and will appear
in your browser.

## Structure

The main Application implementation is `app/ic_application.h`.

The `main.cpp` contains the initialization code for the framework.

The `content/www` folder is the wwwroot.
