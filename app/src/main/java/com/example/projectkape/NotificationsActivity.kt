package com.example.projectkape

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity

class NotificationsActivity : AppCompatActivity() {

    private lateinit var notificationContainer: LinearLayout

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_notification) // ⬅️ Use your container layout file here

        notificationContainer = findViewById(R.id.cardContent)

        // Load static sample notifications
        loadSampleNotifications()
    }

    // Represents a single notification item
    class NotificationItem(
        private var title: String,
        private var description: String,
        private var date: String,
        private var imageResId: Int
    ) {
        fun getTitle() = title
        fun getDescription() = description
        fun getDate() = date
        fun getImageResId() = imageResId
    }

    private fun addNotification(item: NotificationItem) {
        val inflater = LayoutInflater.from(this)
        val cardView: View = inflater.inflate(R.layout.activity_notification, notificationContainer, false)

        val image: ImageView = cardView.findViewById(R.id.cardImage)
        val title: TextView = cardView.findViewById(R.id.cardTitle)
        val description: TextView = cardView.findViewById(R.id.cardDescription)
        val date: TextView = cardView.findViewById(R.id.cardDate)
        val delete: TextView = cardView.findViewById(R.id.cardBurahin)

        image.setImageResource(item.getImageResId())
        title.text = item.getTitle()
        description.text = item.getDescription()
        date.text = item.getDate()

        delete.setOnClickListener {
            notificationContainer.removeView(cardView)
        }

        notificationContainer.addView(cardView)
    }

    private fun loadSampleNotifications() {
        val sampleList = listOf(
            NotificationItem(
                "Welcome to ProjectKape!",
                "Your profile was successfully created.",
                "June 13, 2025",
                R.drawable.profile
            ),
            NotificationItem(
                "New Message",
                "You have received a message from Admin.",
                "June 14, 2025",
                R.drawable.profile
            ),
            NotificationItem(
                "System Maintenance",
                "The system will be down at 10:00 PM tonight.",
                "June 14, 2025",
                R.drawable.profile
            )
        )

        sampleList.forEach {
            addNotification(it)
        }
    }
}
