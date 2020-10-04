<?php

namespace AvpLab\ViberApi\Framework;

use AvpLab\ViberApi\Callback\Request;
use AvpLab\ViberApi\Client;
use AvpLab\ViberApi\Message\Message;

class Bot
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $senderName;
    /**
     * @var null|string
     */
    private $senderAvatar;

    /**
     * @var array
     */
    private $routes = [];
    /**
     * @var array
     */
    private $routesRegex = [];

    /**
     * @var array
     */
    private $callbackControllers = [];

    /**
     * @param string $token
     * @param string $senderName
     * @param string|null $senderAvatar
     */
    public function __construct(string $token, string $senderName, string $senderAvatar = null)
    {
        $this->token = $token;
        $this->senderName = $senderName;
        $this->senderAvatar = $senderAvatar;
    }

    /**
     * @param string $route
     * @param array $controller
     * @return $this
     */
    public function onMessage(string $route, array $controller)
    {
        $pattern = preg_replace('~:(\w+)~', '(?<$1>[^/]+)', $route);
        if ($pattern !== $route) {
            $this->routesRegex['~^' . $pattern . '$~'] = $controller;
        } else {
            $this->routes[$route] = $controller;
        }
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onWebhook(array $controller)
    {
        $this->callbackControllers[Request::WEBHOOK] = $controller;
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onConversationStarted(array $controller)
    {
        $this->callbackControllers[Request::CONVERSATION_STARTED] = $controller;
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onSubscribed(array $controller)
    {
        $this->callbackControllers[Request::SUBSCRIBED] = $controller;
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onUnsubscribed(array $controller)
    {
        $this->callbackControllers[Request::UNSUBSCRIBED] = $controller;
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onDelivered(array $controller)
    {
        $this->callbackControllers[Request::DELIVERED] = $controller;
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onSeen(array $controller)
    {
        $this->callbackControllers[Request::SEEN] = $controller;
        return $this;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function onFailed(array $controller)
    {
        $this->callbackControllers[Request::FAILED] = $controller;
        return $this;
    }

    /**
     * @param $path
     * @return array|bool
     */
    private function match($path)
    {
        if (isset($this->routes[$path])) {
            return [$this->routes[$path][0], $this->routes[$path][1], []];
        }

        foreach ($this->routesRegex as $pattern => $controller) {
            if (preg_match($pattern, $path, $match)) {
                return [$controller[0], $controller[1], $match];
            }
        }
        return false;
    }

    /**
     * @param Client $client
     * @param ControllerRequest $request
     * @param $route
     * @return mixed
     */
    private function callController(Client $client, ControllerRequest $request, $route)
    {
        $class = array_shift($route);
        $action = array_shift($route);
        $params = array_shift($route);
        /** @var Controller $controller */
        $controller = new $class();
        $controller->setRequest($request);
        $controller->setClient($client);
        return call_user_func([$controller, $action . 'Action'], $params ?: []);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $request = new ControllerRequest($this->token);
        $client = new Client($this->token, $this->senderName, $this->senderAvatar);

        if ($request->isConversationStarted() && isset($this->callbackControllers[Request::CONVERSATION_STARTED])) {
            $message = $this->callController($client, $request, $this->callbackControllers[Request::CONVERSATION_STARTED]);
            if ($message instanceof Message) {
                $client->responseWelcomeMessage($message);
            }
            return;
        }

        $callbacks = [
            Request::WEBHOOK => 'isWebhook',
            Request::SUBSCRIBED => 'isSubscribed',
            Request::UNSUBSCRIBED => 'isUnsubscribed',
            Request::DELIVERED => 'isDelivered',
            Request::SEEN => 'isSeen',
            Request::FAILED => 'isFailed'
        ];
        foreach ($callbacks as $callback => $requestMethod) {
            if ($request->$requestMethod() && isset($this->callbackControllers[$callback])) {
                return $this->callController($client, $request, $this->callbackControllers[$callback]);
            }
        }

        if ($request->isMessage()) {
            if ($request->isMessageText()) {
                $route = $this->match($request->getMessageText());
            }
            if (empty($route)) {
                $route = $this->match($request->getPath());
            }
            if (isset($route)) {
                $this->callController($client, $request, $route);
            }
        }
    }
}