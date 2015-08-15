# apple-juice
PHP Video website for Apple TV airplay

## What is it?

It is a super lightweight php website that intends for streaming video/audio to Apple TV through your iOS devices.

* It supports local MP4 video file streaming to Apple TV.
* It scans all available MP4 video in your server.

## Why do I build it?

I bought a Sony DV, which produces a gazillion number of MP4 video clips. I want to watch them on my TV with a few clicks from my iPad. So I spent a night to learn php and build this website.

## What is requirement?
* an Apple TV connected to your TV
* an iOS device, such as iPhone and iPad
* a decent wifi network
* an ARM board/ a PC that hosts php website and your video/audio library.
* Video file must be in mp4 container and use h.264 codec for video and mpa codec for audio. 

## How to install?
* Assuming you have php enabled web server (if you don't, please google any article that guid you install apache2 and php5)
* In deploy-script/deploy.sh, change WWW_ROOT to your web root.
* In conf/apple-juice.conf, change mediar_dir to your Video library folder. It assume its root folder is the same as web root. Please use symbolic link if it is not as the same as your web root.
* Run sh deploy.sh to copy over files.

## How to use?
* Assuming your php web server is up and running at this point (if you don't, please google it)
* Open safari web browser your iOS device and go to the php website, eg http://your_php_website. If there is nothing shows up, it may be you haven't enabled web server pre-process html file. As a new php programmer, I made this mistake. Apache2 needs to explictly enable processing php in html file.
* Click on video file. If you are patient enough, you may see the Apple TV airplay icon available in the video player. Sometimes you may have to refresh the browser for a couple times before airplay icon shows up. Trust me. It just works.

## What is new?
* [Aug 14, 2015] After spending 3 hours to learn php and 2 hours coding, it provides basic functions which includes: scan video library and video airplay streaming from web browser

## What is Next?
* Deploy this php in docker container.
