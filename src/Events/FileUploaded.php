<?php

namespace GooberBlox\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileUploaded
{
    use Dispatchable, SerializesModels;

    public string $hash;
    public string $file_name;
    public int $file_size;
    public string $destination;
    public ?string $content_type;

    public function __construct(array $data)
    {
        $this->hash = $data['hash'];
        $this->file_name = $data['file_name'];
        $this->file_size = $data['file_size'];
        $this->destination = $data['destination'];
        $this->content_type = $data['content_type'] ?? null;
    }
}
