# Reddit video downloader
Super simple PHP class that downloads videos hosted on **v.redd.it** as well as get post details such as thumbnail, video dimensions, duration, posted date, title, user and subreddit.

The Reddit post URL is used as the input (see example below).

#### Note you will need [FFmpeg](https://www.ffmpeg.org/) installed on your web server.

## Features and usage

Make sure the class is included with:
```php
require_once('rdt-video.php');
```
Call the RDTvideo class with the Reddit post url that you want to download the video from:
```php
$call = new RDTvideo();
$call->getVideoLink('https://www.reddit.com/r/funny/comments/d8qo81/baby_crocodiles_sound_like_theyre_shooting_laser/');
```

##### Download video
```php
echo $call->download('thevideo');//Saves as thevideo.mp4
```
If FFmpeg is on system it will save the video as thevideo.mp4

You can also define the preset and crf if you want to compress the video:

```php
echo $call->download('thevideo', 'faster', 23);
```

The default is fast and 20.



##### Get Post title 
```php
echo $call->videoTitle();
```

##### Get sub
```php
echo $call->videoPostedSub();
```

##### Get date when posted
```php
echo $call->videoPostedDate();
```

##### Get user who posted
```php
echo $call->videoPostedby();
```

#####  Get video thumbnail
```php
echo $call->videoThumb();
```

##### Get video dimensions and duration
```php
$video_details = $call->videoDetails();

$height = $video_details['height'];
$width = $video_details['width'];
$duration = $video_details['duration'];
```

