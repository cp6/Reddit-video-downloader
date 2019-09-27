# Reddit video downloader
Super simple PHP class that download videos hosted on **v.redd.it** as well as get post details such as thumbnail, dimensions, duration, posted date, title, user and subreddit.

#### Note you will need [FFmpeg](https://www.ffmpeg.org/) installed on your web server.

## Features and usage

Make sure the class is included
```php
require_once('rdt-video.php');
```
Call a new instance with the Reddit post url
```php
$call = new get_video();
$call->getVideoLink('https://www.reddit.com/r/funny/comments/d8qo81/baby_crocodiles_sound_like_theyre_shooting_laser/');
```

##### Download video
```php
echo $call->download('thevideo');
```
If FFmpeg is on system will save video as thevideo.mp4

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
echo $call->videoPostedDate()
```

##### Get user who posted
```php
echo $call->videoPostedby();
```

#####  Get video thumbnail
```php
echo $call->videoThumb()
```

##### Get video dimensions and duration
```php
$video_details = $call->videoDetails();

$height = $video_details['height'];
$width = $video_details['width'];
$duration = $video_details['duration'];
```

