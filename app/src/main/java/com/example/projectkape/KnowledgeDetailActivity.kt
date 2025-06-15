package com.example.projectkape

import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.ImageButton
import android.widget.ImageView
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.bumptech.glide.Glide
import com.google.firebase.firestore.FirebaseFirestore

class KnowledgeDetailActivity : AppCompatActivity() {

    private lateinit var titleTextView: TextView
    private lateinit var subtitleTextView: TextView
    private lateinit var descriptionTextView: TextView
    private lateinit var imageView: ImageView
    private lateinit var backButton: ImageButton
    private lateinit var progressBar: ProgressBar

    private val db = FirebaseFirestore.getInstance()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_detail)

        // Initialize views
        backButton = findViewById(R.id.menuBack)
        titleTextView = findViewById(R.id.detailTitle)
        subtitleTextView = findViewById(R.id.detailSubtitle)
        descriptionTextView = findViewById(R.id.detailContent)
        imageView = findViewById(R.id.detailImage)
        progressBar = findViewById(R.id.progressBar)

        // Get title from intent
        val title = intent.getStringExtra("title").orEmpty()

        if (title.isNotBlank()) {
            titleTextView.text = title
            subtitleTextView.text = "Nilalaman"
            fetchKnowledgeFromFirestore(title)
        } else {
            subtitleTextView.text = "Walang Pamagat"
            descriptionTextView.text = "Walang impormasyon."
            progressBar.visibility = View.GONE
        }

        backButton.setOnClickListener {
            finish()
        }
    }

    private fun fetchKnowledgeFromFirestore(title: String) {
        progressBar.visibility = View.VISIBLE
        descriptionTextView.text = ""

        db.collection("knowledgecollections")
            .whereEqualTo("title", title)
            .limit(1)
            .get()
            .addOnSuccessListener { documents ->
                progressBar.visibility = View.GONE
                if (!documents.isEmpty) {
                    val doc = documents.first()
                    val description = doc.getString("description").orEmpty()
                    val imagePath = doc.getString("image").orEmpty()

                    descriptionTextView.text = if (description.isNotBlank()) description else "Walang nilalaman."

                    if (imagePath.isNotBlank()) {
                        val imageUrl = "https://yourdomain.com$imagePath" // Replace with your full domain
                        Glide.with(this)
                            .load(imageUrl)
                            .into(imageView)
                    } else {
                        imageView.visibility = View.GONE
                    }

                } else {
                    descriptionTextView.text = "Hindi natagpuan ang kaalaman."
                }
            }
            .addOnFailureListener { e ->
                progressBar.visibility = View.GONE
                Log.e(TAG, "Error fetching document", e)
                descriptionTextView.text = "Nagkaroon ng error habang kinukuha ang datos."
                Toast.makeText(this, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
            }
    }

    companion object {
        private const val TAG = "KnowledgeDetailActivity"
    }
}
