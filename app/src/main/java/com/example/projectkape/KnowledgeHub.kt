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
    private lateinit var searchBar: AutoCompleteTextView
    private lateinit var backButton: ImageButton

    private val db = FirebaseFirestore.getInstance()
    private val allKnowledgeItems = mutableListOf<Map<String, String>>()

    private val suggestions = listOf(
        "Anong uri ng kape ang bagay sa malamig na lugar?",
        "Ano ang tamang distansya sa pagitan ng mga punong kape kapag nagtatanim?",
        "Kailan ang tamang panahon para magtanim ng kape?",
        "Paano ang tamang pag-aabono sa punong kape?",
        "Paano maiwasan ang peste gaya ng coffee berry borer?",
        "Ano ang magandang paraan ng pag-ani ng hinog na bunga ng kape?",
        "Ano ang ibig sabihin ng rejuvenation sa kape?",
        "Anong sakit ang nagdudulot ng pulbos na kulay kalawang sa ilalim ng dahon?",
        "Bakit mahalaga ang shade trees bago magtanim ng kape?",
        "Ano ang kaibahan ng Robusta, Arabica, Liberica, at Excelsa?",
        "Anong uri ng abono ang dapat gamitin sa organikong taniman?",
        "Ano ang mga palatandaan na ang bunga ng kape ay inatake ng insekto?",
        "Paano gawin ang side pruning sa kape?",
        "Bakit hindi dapat gamitin ang ihi o dumi ng tao bilang pataba?",
        "Gaano katagal bago mamunga ang punong kape?",
        "Anong uri ng lupa ang mas bagay sa kape?",
        "Kailangan bang diligan ang punong kape araw-araw?",
        "Pwede bang magtanim ng kape kahit tag-init?",
        "Ano ang ibig sabihin ng intercropping sa kape?",
        "Anong halamang pwede isabay sa taniman ng kape?",
        "Bakit kailangan putulan ang sanga ng punong kape?",
        "Gaano kahalaga ang pag-compost para sa taniman ng kape?",
        "Paano alagaan ang seedling ng kape sa unang buwan?",
        "Paano malalaman kung may root rot ang punong kape?",
        "Anong pestisidyo ang ligtas gamitin sa kape?",
        "Ilang kilo ng bunga ang inaabot ng isang punong kape kada taon?"
    )
    val questionToTopicMap = mapOf(
        "Anong uri ng kape ang bagay sa malamig na lugar?" to "Pagtatanim",
        "Ano ang tamang distansya sa pagitan ng mga punong kape kapag nagtatanim?" to "Pagtatanim",
        "Kailan ang tamang panahon para magtanim ng kape?" to "Paglilipat-tanim",
        "Paano ang tamang pag-aabono sa punong kape?" to "Pag-aabono (Fertilizing)",
        "Paano maiwasan ang peste gaya ng coffee berry borer?" to "Pagkokontrol ng Peste at Sakit",
        "Ano ang magandang paraan ng pag-ani ng hinog na bunga ng kape?" to "Pag-ani (Harvesting)",
        "Ano ang ibig sabihin ng rejuvenation sa kape?" to "Rejuvenation",
        "Anong sakit ang nagdudulot ng pulbos na kulay kalawang sa ilalim ng dahon?" to "Pagkokontrol ng Peste at Sakit",
        "Bakit mahalaga ang shade trees bago magtanim ng kape?" to "Pagtatanim",
        "Ano ang kaibahan ng Robusta, Arabica, Liberica, at Excelsa?" to "Mga Uri ng Kape",
        "Anong uri ng abono ang dapat gamitin sa organikong taniman?" to "Pag-aabono (Fertilizing)",
        "Ano ang mga palatandaan na ang bunga ng kape ay inatake ng insekto?" to "Pagkokontrol ng Peste at Sakit",
        "Paano gawin ang side pruning sa kape?" to "Pagpupungos o Pruning ng Kape",
        "Bakit hindi dapat gamitin ang ihi o dumi ng tao bilang pataba?" to "Pag-aabono (Fertilizing)",
        "Gaano katagal bago mamunga ang punong kape?" to "Mga Uri ng Kape",
        "Anong uri ng lupa ang mas bagay sa kape?" to "Mga Uri ng Kape",
        "Kailangan bang diligan ang punong kape araw-araw?" to "Mga Uri ng Kape",
        "Pwede bang magtanim ng kape kahit tag-init?" to "Paglilipat-tanim",
        "Ano ang ibig sabihin ng intercropping sa kape?" to "Pagtatanim",
        "Anong halamang pwede isabay sa taniman ng kape?" to "Pagtatanim",
        "Bakit kailangan putulan ang sanga ng punong kape?" to "Pagpupungos o Pruning ng Kape",
        "Gaano kahalaga ang pag-compost para sa taniman ng kape?" to "Pag-aabono (Fertilizing)",
        "Paano alagaan ang seedling ng kape sa unang buwan?" to "Pagtatanim",
        "Paano malalaman kung may root rot ang punong kape?" to "Pagkokontrol ng Peste at Sakit",
        "Anong pestisidyo ang ligtas gamitin sa kape?" to "Pagkokontrol ng Peste at Sakit",
        "Ilang kilo ng bunga ang inaabot ng isang punong kape kada taon?" to "Mga Uri ng Kape"
    )

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_hub)

        knowledgeContainer = findViewById(R.id.knowledgeContainer)
        searchBar = findViewById(R.id.searchBar)
        backButton = findViewById(R.id.menuBack)

        val adapter = ArrayAdapter(this, android.R.layout.simple_dropdown_item_1line, suggestions)
        searchBar.setAdapter(adapter)
        searchBar.threshold = 1
        searchBar.setOnItemClickListener { _, _, _, _ ->
            redirectToTopic(searchBar.text.toString())
        }

        searchBar.addTextChangedListener(object : TextWatcher {
            override fun afterTextChanged(s: Editable?) {
                filterKnowledgeItems(s.toString())
            }
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
        })

        backButton.setOnClickListener {
            finish()
        }

        loadKnowledgeData()
    }

    private fun redirectToTopic(question: String) {
        val topic = questionToTopicMap[question] ?: return
        val intent = Intent(this, KnowledgeDetailActivity::class.java)
        intent.putExtra("title", topic)
        startActivity(intent)
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
