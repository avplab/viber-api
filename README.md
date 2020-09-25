# ViberApi

[![Build Status](https://travis-ci.org/avplab/viber-api.svg?branch=master)](https://travis-ci.org/avplab/viber-api)

The ViberApi gives an ability to create fully functional php bots for Viber, based on Viber REST API.

## Installation
Install the component by using [Composer](https://getcomposer.org). Update your project's `composer.json` file to include dependency.

    "require": {
        "avplab/viber-api": "^1.0.0"
    }

## Usage

To create any bot, the package provides two base classes `Callback\Request` and `Client`.

```
namespace EchoBot;

use AvpLab\ViberApi\Client;
use AvpLab\ViberApi\Callback\Request;
use AvpLab\ViberApi\Message\TextMessage;

/**
 * The Echo bot will reply with the same message it received
 */

$request = new Request();
$client = new Client('<token>', 'Echo Bot');

// when user starts the conversation or was subscribed (by deep link)
if ($request->isConversationStarted()) {
    if ($request->getData()->subscribed) {
        // user is already subsribed on the bot
        $message = new TextMessage('Welcome back !');
    } else {
        // new user
        $message = new TextMessage('Welcome ! I will respond with the same message');
    }
    // response with welcome message
    $client->responseWelcomeMessage($message);
}

// User sent the text message to the bot
if ($request->isMessageText()) {
    // response to the user(sender) with the same message as received
    $client->sendMessage($request->getMessageSenderId(), new TextMessage($request->getMessageText()));
}


```

### Get request from API
The `Request` provides all the information about callback-request from the Viber API to your server.
You can trust the request data, as it is verified for authenticity (see [X-Viber-Content-Signature](https://developers.viber.com/docs/api/rest-bot-api/#callbacks)).
If for some reason the request cannot be processed, a `BadRequestException` will be thrown.

### Send request to API
To send requests to the API, the `Client` object is used(the request is sent based on cURL).
If for some reason the request does not reach the API, a `ServerErrorResponseException` exception will be thrown.
If the API received the request, but for some reason responded with an error (see API errors), an `ApiException` exception will be thrown.

#### Messages
The API is using term "message" as request body. Message is a JSON which has predefined structure(see the API docs).
Viber describes several types of messages: `text`, `picture`, `video`, `contact`, `rich-media`, `file`, `sticker`, `location` and `url`.
To prepare the specific message for sending to the API, you have to create an object of one of the predefined classes:

- TextMessage
- PictureMessage
- VideoMessage
- ContactMessage
- RichMediaMessage
- FileMessage
- StickerMessage
- UrlMessage

### Keyboards
Each message may contain a keyboard. To add the keyboard use the `Keyboard` objects(see Keyboard methods for details).

### API

_AvpLab/Callback/Request_

The request object which contains all the info sent by Viber API

- _isWebhook()_ - the callback was sent on `webhook` event
- _isSubscribed()_ - the callback was sent on `subscribed` event
- _isUnsubsribed()_ - the callback was sent on `unsubscribed` event
- _isConversationStarted()_ - the callback was sent on `conversation_started` event
- _isDelivered()_ - the callback was sent on `delivered` event
- _isSeen()_ the - callback was sent on `seen` event
- _isFailed()_ - the callback was sent on `failed` event
- _isMessage()_ - the callback was sent on `message` event. User sent a message to Public Account(aka PA)
- _isMessageText()_ - the `text` message was sent to PA
- _isMessagePicture()_ - the `picture` message was sent to PA
- _isMessageVideo()_ - the `video` message was sent to PA
- _isMessageFile()_ - the `file` message was sent to PA
- _isMessageSticker()_ - the `sticker` message was sent to PA
- _isMessageUrl()_ - the `url` message was sent to PA
- _isMessageLocation()_ - the `location` message was sent to PA
- _isMessageContact()_ - the `contact` message was sent to PA
- _getEvent()_ - returns the callback event name, which triggered the callback
- _getTimestamp()_ - returns the time of event
- _getMessageToken()_ - returns Unique ID of the message
- _getMessage()_ - returns the message data
- _getMessageText()_ - returns the message.text string
- _getMessageTrackingData()_ - returns the message.tracking_data string
- _getMessageSender()_ - returns the sender data of the message
- _getMessageSenderId()_ - returns the sender.id
- _getConversationContext()_ - returns the context string of the callback triggered by `convestation_started` event. Any additional parameters added to the [deep link](https://developers.viber.com/docs/tools/deep-links) used to access the conversation passed as a string.
- _getConversationUser()_ - returns the user's data, who triggered the conversation.
- _getData()_ - returns the callback request data

_AvpLab/Client_

The http client which communicates with Viber API.

- __construct(string $token, string $senderName, string $senderAvatar = null)
    * $token - the authentication token which was provided during the creation of account
    * $senderName - the bot's name
    * $senderAvatar - the bot's avatar url

- setWebhook(string $url, array $eventTypes = [], bool $sendName = true, bool $sendPhoto = true) - register the webhook(used once when configuring the bot)
    * $url - the URI of the bot
- removeWebhook() - unregister the webhook
- getToken() - returns the configured token
- getSenderName() - returns the bot's name
- getSenderAvatar() - returns the bot's avatar url
- sendMessage(string $receiver, Message $message, bool $withSender = true) - sends the message to the Viber API
    * $receiver - Id of receiver( Usually gets from request->getMessageSenderId() )
    * $message - Message object(see [Messages](#Messages) section for details)
    * $withSender - Include the bot's name and avatar configured for the client into the message
- broadcastMessage(array $broadcastList, Message $message, bool $withSender = true) - broadcast the message to several receivers
    * $broadcastList - array of receivers Id
    * $message - Message object(see [Messages](#Messages) section for details)
    * $withSender - Include the bot's name and avatar configured for the client into the message
- getAccountInfo() - returns the info of the account that bot communicated with
- getUserDetails(string $userId) - returns the info about the user
    * userId - Id of the user
- getOnline($ids) - returns the list with online statuses of selected users
    * ids - array of users Id
- responseWelcomeMessage(Message $message, bool $withSender = true) - send a response to the Viber API with the message. Is used when `conversation_started` event's callback is handled.
    * $message - Message object(see [Messages](#Messages) section for details)
    * $withSender - Include the bot's name and avatar configured for the client into the message

### Framework

To simplify the bot's creation and make the code cleaner there is also a framework provided.

#### Usage

```
#index.php

namespace EchoBot;

use AvpLab\ViberApi\Framework\Bot;
use EchoBot\Controller\IndexController;

$bot = new Bot('<TOKEN>', 'Echo Bot');

$bot->onConversationStarted([IndexController::class, 'conversationStarted'])
    ->onMessage('/', [IndexController::class, 'index'])
    ->run();
```

```
#Controller/IndexController.php

<?php

namespace EchoBot\Controller;

use AvpLab\ViberApi\Framework\Controller;
use AvpLab\ViberApi\Message\TextMessage;

class IndexController extends Controller
{
    public function conversationStartedAction()
    {
        if ($this->getRequest()->getData()->subscribed) {
            return new TextMessage('Welcome back !');
        } else {
            return new TextMessage('Welcome ! I will respond with the same message');
        }
    }

    public function indexAction()
    {
        $message = new TextMessage($this->getRequest()->getMessageText());
        $this->reply($message);
    }
}

```

#### Routing

The framework supports the routing system. It allows to configure the specific paths for an appropriate controller action.
- `/posts/view`
- `/posts/add`

There are also parameters available. It should be started with colon:

- `/posts/:postId/view`


#### Framework API

All functionality is located under the `AvpLab/ViberApi/Framework` namespace

##### Bot Class

The `Bot` class is the main class which should be used to configure the bot. To configure the paths and appropriate handlers the `onMessage()` method should be used.

There are also several methods available:
- _onConversationStarted()_ - configure the handler for `conversation_started` event. The handler must return the Message object.
- _onWebhook()_ - configure the handler on `webhook` event.
- _onSubscribed()_ - configure the handler on `subscribed` event. It will not be triggered since Viber API sends the `message` event instead.
- _onUnsubscribed()_ - configure the handler on `unsubscribed` event.
- _onSeen()_ - configure the handler on `seen` event.
- _onDelivered()_ - configure the handler on `delivered` event.
- _onFailed()_ - configure the handler on `failed` event.

Once the bot is configured the `run()` must be called.

##### Controller Class

The `Controller` is the base class which is used to create handlers.
You are free to provide own function as the handler but then you have to create the ControllerRequest object manually.
To become an action the controller's method must be ended with "Action" suffix.
There are several methods avaiable:

- _getRequest()_ - returns the `ControllerRequest` object.
- _reply(Message $message, $path = null)_ - sends a Message object to the current user(sender).
    * $message - Message object(see [Messages](#Messages) section for details)
    * $path - redirects to the specific path. Once the user will reply on message to the bot, it will come into $path handler
- _send($receiver, Message $message, $path = null)_ - sends a Message object to the specific user(sender).
    * $receiver - userId(sender id)
    * $message - Message object(see [Messages](#Messages) section for details)
    * $path - redirects to the specific path. Once the user will reply on message to the bot, it will come into $path handler
- _broadcast(Message $message, array $broadcastList, $path = null)_ - broadcast a Message object to the specific set of users.
    * $message - Message object(see [Messages](#Messages) section for details)
    * $broadcastList - array of users Id
    * $path - redirects to the specific path. Once the user will reply on message to the bot, it will come into $path handler

##### ControllerRequest Class

Represents the `Request` object with few extra methods regarding the controller's context
    * getPath() - returns the matched path
    * getTrackingData() - use this method to get the tracking data instead of getMessageTrackingData().
    Internally the framework is using the trackingData property to track the route paths, but it doesn't block you to use your own data as well.

## Links

1) [Viber REST API](https://developers.viber.com/docs/api/rest-bot-api/)


# License

ViberApi is licensed under the MIT License - see the `LICENSE` file for details
