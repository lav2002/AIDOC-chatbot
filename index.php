<!DOCTYPE html>
<html>
<head>
  <title>AIDOC - Medical Chat</title>
  <style>
   body {
    background-color: #f1f1f1;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }


#submit-button {
  align-items: center;
  appearance: none;
  background-color: #3EB2FD;
  background-image: linear-gradient(1deg, #4F58FD, #149BF3 99%);
  background-size: calc(100% + 20px) calc(100% + 20px);
  border-radius: 100px;
  border-width: 0;
  box-shadow: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-flex;
  font-family: CircularStd,sans-serif;
  font-size: 1rem;
  height: auto;
  justify-content: center;
  line-height: 1.5;
  padding: 6px 20px;
  margin-top: 10px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: background-color .2s,background-position .2s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: top;
  white-space: nowrap;
}

#submit-button:active,
#submit-button:focus {
  outline: none;
}

#submit-button:hover {
  background-position: -20px -20px;
}

#submit-button:focus:not(:active) {
  box-shadow: rgba(40, 170, 255, 0.25) 0 0 0 .125em;
}

  .chat-container {
    max-width: 500px;
    margin: 20px auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    overflow: hidden;
  }

  .chat-header {
    background-color: #428bca;
    color: #fff;
    padding: 10px;
    text-align: center;
  }

  .chat-body {
    padding: 10px;
    max-height: 300px;
    overflow-y: scroll;
  }

  .chat-message {
    background-color: #f1f1f1;
    border-radius: 5px;
    margin-bottom: 10px;
    padding: 5px 10px;
  }

  .user-message {
    background-color: #e2eafb;
  }

  .bot-message {
    background-color: #faf7f7;
    text-align: right;
  }

  .chat-input {
    padding: 10px;
    border-top: 1px solid #ccc;
  }

  .chat-input input[type="text"] {
    width: 100%;
    padding: 5px;
    border: none;
    border-radius: 3px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="chat-header">
      <h2>AIDOC - MADE BY DISEMPIRE</h2>
    </div>
    <div class="chat-body" id="chat-body">
      <div class="chat-message bot-message">
        <p>Welcome to AIDOC! I can help you with medical advice and suggest potential treatments. How can I assist you today?</p>
      </div>
    </div>
    <div class="chat-input">
      <input type="text" id="user-input" placeholder="Type your message here..." autofocus>
      <button id="submit-button" onclick="sendMessage()">Submit</button>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    const chatBody = document.getElementById('chat-body');
    const userInput = document.getElementById('user-input');
    const submitButton = document.getElementById('submit-button');
    const model_name = 'gpt-3.5-turbo';
    const api_key = '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';
    const chatGptEndpoint = 'https://api.openai.com/v1/chat/completions';

    userInput.addEventListener('keyup', function(event) {
      if (event.keyCode === 13) {
        event.preventDefault();
        sendMessage();
      }
    });

    function sendMessage() {
      const message = userInput.value.trim();
      if (message !== '') {
        appendMessage('user', message);
        userInput.value = '';
        scrollToBottom();
        sendRequest(message);
      }
    }

    function sendRequest(message) {
      const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${api_key}`
      };

      const data = {
        'model': model_name,
        'messages': [
          {'role': 'system', 'content': 'I am AIDOC - MADE BY TEAM-DISEMPIRE, an AI medical assistant.'},
          {'role': 'user', 'content': message}
        ]
      };

      fetch(chatGptEndpoint, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then(data => {
          const aiResponse = data.choices[0].message.content;
          appendMessage('bot', aiResponse);
          scrollToBottom();
          if (message === 'bye') {
            // Clear the input field and disable it after sending 'bye'
            userInput.value = '';
            userInput.disabled = true;
            submitButton.disabled = true;
          }
        })
        .catch(error => console.error('Error:', error));
    }

    function appendMessage(sender, message) {
      const messageContainer = document.createElement('div');
      messageContainer.classList.add('chat-message');

      if (sender === 'user') {
        messageContainer.classList.add('user-message');
        messageContainer.innerHTML = `<p>${message}</p>`;
      } else {
        messageContainer.classList.add('bot-message');
        messageContainer.innerHTML = `<p>${message}</p>`;
      }

      chatBody.appendChild(messageContainer);
    }

    function scrollToBottom() {
      chatBody.scrollTop = chatBody.scrollHeight;
    }
  </script>
</body>
</html>
