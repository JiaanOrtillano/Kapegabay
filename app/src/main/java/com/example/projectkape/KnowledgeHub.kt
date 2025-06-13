package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.*
import androidx.appcompat.app.AppCompatActivity

class KnowledgeHub : AppCompatActivity() {

    private lateinit var searchBar: EditText
    private lateinit var buttonsMap: Map<Button, String>

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_hub)

        val backButton = findViewById<ImageButton>(R.id.menuBack)
        searchBar = findViewById(R.id.searchBar)

        val knowledgeMap = mapOf(
            R.id.btnUriNgKape to "Mga uri ng kape",
            R.id.btnPaglipatTanim to "Paglilipat-tanim",
            R.id.btnAbono to "Pag-aabono (Fertilizing)",
            R.id.btnPruning to "Pruning ng Kape (Maintenance Pruning)",
            R.id.btnRejuvenation to "Rejuvenation",
            R.id.btnPagsusuri to "Pagsusuri or Pagsasala (Sorting)",
            R.id.btnPagUuri to "Pag-uuri ayon sa kalidad (Grading)",
            R.id.btnPagsasangag to "Pagsasangag (Roasting)",
            R.id.btnDefects to "Mga Depekto sa Kape (Coffee defects)",
            R.id.btnPeste to "Pagkontrol sa mga Peste at Sakit"
        )

        buttonsMap = knowledgeMap.mapKeys { findViewById<Button>(it.key) }

        // Set listeners for each button
        for ((button, title) in buttonsMap) {
            button.setOnClickListener {
                val intent = if (title == "Mga uri ng kape") {
                    Intent(this, KnowledgeUriNgKapeActivity::class.java)
                } else {
                    Intent(this, KnowledgeDetailActivity::class.java).apply {
                        putExtra("title", title)
                    }
                }
                startActivity(intent)
            }
        }

        backButton.setOnClickListener {
            finish()
        }

        setupSearchFilter()
    }

    private fun setupSearchFilter() {
        searchBar.addTextChangedListener(object : TextWatcher {
            override fun afterTextChanged(s: Editable?) {
                val query = s.toString().lowercase()
                for ((button, title) in buttonsMap) {
                    if (title.lowercase().contains(query)) {
                        button.visibility = Button.VISIBLE
                    } else {
                        button.visibility = Button.GONE
                    }
                }
            }

            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
        })
    }
}
