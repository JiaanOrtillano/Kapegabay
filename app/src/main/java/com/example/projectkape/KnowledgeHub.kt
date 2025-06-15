package com.example.projectkape

import android.content.Intent
import android.graphics.Color
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.view.ViewGroup
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import com.google.firebase.firestore.FirebaseFirestore

class KnowledgeHub : AppCompatActivity() {

    private lateinit var knowledgeContainer: LinearLayout
    private lateinit var searchBar: EditText
    private lateinit var backButton: ImageButton

    private val db = FirebaseFirestore.getInstance()

    // Store full document data (you can create a model class if preferred)
    private val allKnowledgeItems = mutableListOf<Map<String, String>>()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_hub)

        knowledgeContainer = findViewById(R.id.knowledgeContainer)
        searchBar = findViewById(R.id.searchBar)
        backButton = findViewById(R.id.menuBack)

        backButton.setOnClickListener {
            finish()
        }

        loadKnowledgeData()

        searchBar.addTextChangedListener(object : TextWatcher {
            override fun afterTextChanged(s: Editable?) {
                filterKnowledgeItems(s.toString())
            }

            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
        })
    }

    private fun loadKnowledgeData() {
        db.collection("knowledgecollections")
            .get()
            .addOnSuccessListener { result ->
                allKnowledgeItems.clear()
                for (document in result) {
                    val coffeeType = document.getString("coffee_type") ?: ""
                    val title = document.getString("title") ?: ""
                    val description = document.getString("description") ?: ""

                    allKnowledgeItems.add(
                        mapOf(
                            "coffee_type" to coffeeType,
                            "title" to title,
                            "description" to description
                        )
                    )
                }
                displayKnowledgeItems(allKnowledgeItems)
            }
            .addOnFailureListener {
                Toast.makeText(this, "Failed to load data", Toast.LENGTH_SHORT).show()
            }
    }

    private fun displayKnowledgeItems(list: List<Map<String, String>>) {
        knowledgeContainer.removeAllViews()

        for (item in list) {
            val displayText = item["coffee_type"] ?: item["title"] ?: "Untitled"

            val cardView = CardView(this).apply {
                layoutParams = LinearLayout.LayoutParams(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
                ).apply {
                    bottomMargin = 16
                }
                radius = 16f
                cardElevation = 6f
            }

            val button = Button(this@KnowledgeHub).apply {
                text = displayText
                setTextColor(Color.BLACK)
                textSize = 16f
                setPadding(24, 24, 24, 24)
                setBackgroundResource(R.drawable.hub_btn)
                setOnClickListener {
                    val intent = Intent(this@KnowledgeHub, KnowledgeDetailActivity::class.java)
                    intent.putExtra("title", displayText)
                    startActivity(intent)
                }
            }

            cardView.addView(button)
            knowledgeContainer.addView(cardView)
        }
    }

    private fun filterKnowledgeItems(query: String) {
        if (query.isBlank()) {
            displayKnowledgeItems(allKnowledgeItems)
            return
        }

        val filtered = allKnowledgeItems.filter {
            val coffeeType = it["coffee_type"] ?: ""
            val title = it["title"] ?: ""
            val description = it["description"] ?: ""

            coffeeType.contains(query, ignoreCase = true) ||
                    title.contains(query, ignoreCase = true) ||
                    description.contains(query, ignoreCase = true)
        }

        displayKnowledgeItems(filtered)
    }
}
