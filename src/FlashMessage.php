<?php
namespace NeutronStars\FlashSession;

class FlashMessage
{
    private string $type;
    private string $message;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'type'    => $this->getType(),
            'message' => $this->getMessage()
        ];
    }
}
