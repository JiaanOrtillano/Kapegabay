package com.example.projectkape

import android.os.Bundle
import android.view.Gravity
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.firestore.FirebaseFirestore
import com.google.firebase.firestore.ListenerRegistration
import com.google.firebase.firestore.Query
import java.util.*

class SupportActivity : AppCompatActivity() {

    private lateinit var messageContainer: LinearLayout
    private lateinit var editTextMessage: EditText
    private lateinit var buttonSend: ImageButton
    private lateinit var scrollView: ScrollView
    private lateinit var backButton: ImageButton

    private val db = FirebaseFirestore.getInstance()
    private val auth = FirebaseAuth.getInstance()
    private var userId: String = ""
    private var chatListener: ListenerRegistration? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.support_activity)

        // UI Bindings
        messageContainer = findViewById(R.id.messageContainer)
        editTextMessage = findViewById(R.id.editTextMessage)
        buttonSend = findViewById(R.id.buttonSend)
        scrollView = findViewById(R.id.messageScrollView)
        backButton = findViewById(R.id.menuBack)

        // Setup Firebase Auth
        if (auth.currentUser == null) {
            auth.signInAnonymously().addOnSuccessListener {
                userId = it.user?.uid ?: ""
                setupChatListener()
            }
        } else {
            userId = auth.currentUser?.uid ?: ""
            setupChatListener()
        }

        // Send Button Click
        buttonSend.setOnClickListener {
            val messageText = editTextMessage.text.toString().trim()
            if (messageText.isNotEmpty()) {
                sendMessage(messageText)
                editTextMessage.text.clear()
            }
        }

        // Back Button
        backButton.setOnClickListener {
            finish()
        }
    }

    private fun sendMessage(message: String) {
        val messageData = hashMapOf(
            "text" to message,
            "timestamp" to Date(),
            "sender" to "user" // could also use "admin" for web
        )
        db.collection("chat_rooms")
            .document(userId)
            .collection("messages")
            .add(messageData)
    }

    private fun setupChatListener() {
        chatListener = db.collection("chat_rooms")
            .document(userId)
            .collection("messages")
            .orderBy("timestamp", Query.Direction.ASCENDING)
            .addSnapshotListener { snapshots, _ ->
                if (snapshots != null) {
                    messageContainer.removeAllViews()
                    for (doc in snapshots.documents) {
                        val message = doc.getString("text") ?: ""
                        val sender = doc.getString("sender") ?: "user"
                        addMessageToContainer(message, sender == "user")
                    }
                }
            }
    }

    private fun addMessageToContainer(message: String, isUser: Boolean) {
        val messageTextView = TextView(this).apply {
            text = message
            textSize = 16f
            setPadding(16, 12, 16, 12)
            background = getDrawable(if (isUser) R.drawable.user_message_bg else R.drawable.bot_message_bg)
            setTextColor(resources.getColor(android.R.color.black))
            val params = LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.WRAP_CONTENT,
                LinearLayout.LayoutParams.WRAP_CONTENT
            ).apply {
                setMargins(8, 8, 8, 8)
                gravity = if (isUser) Gravity.END else Gravity.START
            }
            layoutParams = params
        }

        messageContainer.addView(messageTextView)
        scrollView.post {
            scrollView.fullScroll(View.FOCUS_DOWN)
        }
    }

    override fun onDestroy() {
        super.onDestroy()
        chatListener?.remove()
    }
}
