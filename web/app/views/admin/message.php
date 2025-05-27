<?php require_once __DIR__ . '/layouts/header.php'; ?>

<!-- Add Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto p-4">
    <div class="flex h-[calc(100vh-100px)] bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Users List -->
        <div class="w-1/3 border-r border-gray-200">
            <div class="p-4">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">Farmers</h4>
                <div class="space-y-2">
                    <?php if (empty($conversations)): ?>
                        <p class="text-gray-500 text-center py-4">No users found</p>
                    <?php else: ?>
                        <?php foreach ($conversations as $conversation): ?>
                            <a href="#" class="block p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 user-item" 
                               data-user-id="<?php echo $conversation['other_user_id']; ?>">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h6 class="font-medium text-gray-900"><?php echo htmlspecialchars($conversation['other_username']); ?></h6>
                                        <p class="text-sm text-gray-500 truncate">
                                            <?php echo $conversation['last_message'] ? htmlspecialchars($conversation['last_message']) : 'No messages yet'; ?>
                                        </p>
                                    </div>
                                    <?php if ($conversation['unread_count'] > 0): ?>
                                        <span class="bg-blue-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                            <?php echo $conversation['unread_count']; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="w-2/3 flex flex-col">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200">
                <h5 class="text-lg font-medium text-gray-800" id="chat-with">Select a user to start chatting</h5>
            </div>

            <!-- Messages Area -->
            <div class="flex-1 p-4 overflow-y-auto bg-gray-50" id="messages-container">
                <!-- Messages will be loaded here -->
            </div>

            <!-- Message Input -->
            <div class="p-4 border-t border-gray-200">
                <form id="message-form" class="flex gap-2">
                    <input type="hidden" id="receiver-id" name="receiver_id">
                    <input type="text" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           id="message-input" 
                           placeholder="Type your message..." 
                           required>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.message {
    max-width: 70%;
    margin-bottom: 1rem;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
}

.message.sent {
    background: #3b82f6;
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 0.25rem;
}

.message.received {
    background: #e5e7eb;
    color: #1f2937;
    margin-right: auto;
    border-bottom-left-radius: 0.25rem;
}

.user-item.active {
    background-color: #f3f4f6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const messagesContainer = document.getElementById('messages-container');
    const receiverIdInput = document.getElementById('receiver-id');
    const chatWithHeader = document.getElementById('chat-with');
    let currentUserId = null;
    let messagePollingInterval = null;

    // Handle user selection
    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.dataset.userId;
            const username = this.querySelector('h6').textContent;
            
            // Update active state
            document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            // Update chat header and receiver ID
            chatWithHeader.textContent = `Chat with ${username}`;
            receiverIdInput.value = userId;
            currentUserId = userId;
            
            // Load messages
            loadMessages(userId);
            
            // Start polling for new messages
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
            }
            messagePollingInterval = setInterval(() => loadMessages(userId), 5000);
        });
    });

    // Handle message sending
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!currentUserId) {
            alert('Please select a user to chat with');
            return;
        }

        const message = messageInput.value.trim();
        if (!message) return;

        fetch('/message/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                receiver_id: currentUserId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                loadMessages(currentUserId);
            } else {
                alert('Failed to send message');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message');
        });
    });

    // Load messages
    function loadMessages(userId) {
        fetch(`/message/get?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.messages) {
                    displayMessages(data.messages);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Display messages
    function displayMessages(messages) {
        messagesContainer.innerHTML = '';
        if (messages.length === 0) {
            messagesContainer.innerHTML = '<p class="text-center text-gray-500 py-4">No messages yet. Start the conversation!</p>';
            return;
        }
        messages.forEach(message => {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${message.sender_id == <?php echo $_SESSION['user_id']; ?> ? 'sent' : 'received'}`;
            messageDiv.textContent = message.message;
            messagesContainer.appendChild(messageDiv);
        });
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>


