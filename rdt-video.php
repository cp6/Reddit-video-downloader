<?php


class RDTvideo
{
    private string $post_url;
    private string $video_link;
    private array $data;

    public function getVideoLink(string $post_url): string
    {
        if (!isset($post_url) || trim($post_url) === '' || !str_contains($post_url, 'reddit.com')) {
            throw new Exception("You must provide a Reddit post url");
        }
        $this->post_url = $post_url;
        $this->data = $data = json_decode(file_get_contents($post_url . ".json"), true);
        if ($data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['is_gif']) {
            throw new Exception("Video is actually a gif");
        }
        return $this->video_link = $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['dash_url'];
    }

    public function download(string $save_as, string $preset = 'fast', int $crf = 20): bool
    {
        $try_ffmpeg = trim(shell_exec('type -P ffmpeg'));
        if (empty($try_ffmpeg)) {
            throw new Exception("FFmpeg not found on your system");
        }
        $command = "ffmpeg -i {$this->video_link} -c:v libx264 -preset {$preset} -crf {$crf} {$save_as}.mp4";
        echo shell_exec($command);
        return true;
    }

    public function videoDetails(): array
    {
        $data = $this->data;
        return [
            'width' => $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['height'],
            'height' => $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['width'],
            'duration' => $data[0]['data']['children'][0]['data']['secure_media']['reddit_video']['duration']
            ];
    }

    public function videoThumb(): string
    {
        return $this->data[0]['data']['children'][0]['data']['thumbnail'];
    }

    public function videoPostedSub(): string
    {
        return $this->data[0]['data']['children'][0]['data']['subreddit'];
    }

    public function videoPostedBy(): string
    {
        return $this->data[0]['data']['children'][0]['data']['author'];
    }

    public function videoTitle(): string
    {
        return $this->data[0]['data']['children'][0]['data']['title'];
    }

    public function videoPostedDate(string $format = 'Y-m-d H:i:s'): string
    {
        return gmdate($format, $this->data[0]['data']['children'][0]['data']['created_utc']);
    }
}
