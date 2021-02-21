<?php
namespace NeutronStars\FlashSession;

class FlashSession
{
    /**
     * @var FlashMessage[][]
     */
    private array $messages = [];
    private string $sessionKey;

    public function __construct(string $sessionKey)
    {
        $this->sessionKey = $sessionKey;
        $this->loadMessages();
    }

    private function loadMessages(): void
    {
        if(!empty($_SESSION[$this->sessionKey]))
        {
            foreach ($_SESSION[$this->sessionKey] as $key => $value)
            {
                $this->messages[$key] = new FlashMessage($value['type'], $value['message']);
            }
        }
    }

    public function add(string $key, FlashMessage $flashMessage): void
    {
        if (empty($this->messages[$key])) {
            $this->messages[$key] = [];
        }
        $this->messages[$key][] = $flashMessage;
    }

    /**
     * @param string ...$keys
     * @return FlashMessage[]
     */
    public function flashes(string ...$keys): array
    {
        $messages = [];
        if (empty($keys)) {
            foreach ($this->messages as $flashes) {
                foreach ($flashes as $message) {
                    $messages[] = $message;
                }
            }
            $this->messages = [];
            return $messages;
        }
        foreach ($keys as $key) {
            if (!empty($this->messages[$key])) {
                foreach($this->messages[$key] as $message) {
                    $messages[] = $message;
                }
                unset($this->messages[$key]);
            }
        }
        return $messages;
    }

    public function saveMessages(): void
    {
        $flashMessages = [];
        foreach ($this->messages as $key => $messages) {
            if (empty($flashMessages[$key])) {
                $flashMessages[$key] = [];
            }
            foreach ($messages as $message) {
                $flashMessages[$key][] = $message->toArray();
            }
        }
        $_SESSION[$this->sessionKey] = $flashMessages;
    }
}
