<?php

class get_video
{
    private $post_url;
    private $video_link;
    private $data;

    /**
     * Sets post url
     * @param string $post_url
     * @return string
     * @throws Exception
     */
    public function getVideoLink($post_url)
    {
        if (!isset($post_url) or trim($post_url) == '' or strpos($post_url, 'reddit.com') === false) {
            throw new Exception("You must provide a Reddit post url");
        }
        $this->post_url = $post_url;
        $data = json_decode(file_get_contents("" . $post_url . ".json"), true);
        $this->data = $data;
        if ($data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['is_gif'] == true) {
            throw new Exception("Video is actually a gif");
        }
        $video_link = $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['dash_url'];
        $this->video_link = $video_link;
        return $video_link;
    }

    /**
     * Downloads source video
     * @param string $save_as
     * @return boolean
     * @throws Exception
     */
    public function download($save_as)
    {
        $try_ffmpeg = trim(shell_exec('type -P ffmpeg'));
        if (empty($try_ffmpeg)) {
            throw new Exception("FFmpeg not found on your system");
        }
        $video_link = $this->video_link;
        $command = "ffmpeg -i $video_link -c copy $save_as.mp4";
        echo shell_exec($command);
        return true;
    }

    /**
     * Gets video dimensions and duration as array
     * @param array $data
     * @return array
     */
    public function videoDetails()
    {
        $data = $this->data;
        $height = $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['height'];
        $width = $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['width'];
        $duration = $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['duration'];
        return array('width' => $width, 'height' => $height, 'duration' => $duration);
    }

    /**
     * Gets video thumbnail
     * @return string
     */
    public function videoThumb()
    {
        $data = $this->data;
        return $data[0]['data']['children'][0]['data']['thumbnail'];
    }

    /**
     * Gets video sub
     * @return string
     */
    public function videoPostedSub()
    {
        $data = $this->data;
        return $data[0]['data']['children'][0]['data']['subreddit'];
    }

    /**
     * Gets user who posted video
     * @return string
     */
    public function videoPostedBy()
    {
        $data = $this->data;
        return $data[0]['data']['children'][0]['data']['author'];
    }

    /**
     * Gets post title for video
     * @return string
     */
    public function videoTitle()
    {
        $data = $this->data;
        return $data[0]['data']['children'][0]['data']['title'];
    }

    /**
     * Gets date and time for post
     * @return string
     */
    public function videoPostedDate($format = 'Y-m-d H:i:s')
    {
        $data = $this->data;
        return gmdate($format, $data[0]['data']['children'][0]['data']['created_utc']);
    }
}