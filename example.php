<?php
require_once('rdt-video.php');

$call = new get_video();
$call->getVideoLink('https://www.reddit.com/r/funny/comments/d8qo81/baby_crocodiles_sound_like_theyre_shooting_laser/');//Reddit post url

echo $call->videoTitle();//Baby crocodiles sound like they’re shooting laser guns and it’s the best thing ever
echo $call->videoPostedSub();//funny
echo $call->videoPostedby();//Dynna13337
echo $call->videoPostedDate();//2019-09-24 17:46:23

echo $call->download('thevideo');//IF FFmpeg is on system will save video as thevideo.mp4

$video_details = $call->videoDetails();
echo $video_details['width'].'x'.$video_details['height'].' '.$video_details['duration'].' seconds long';//404x720 25 seconds long