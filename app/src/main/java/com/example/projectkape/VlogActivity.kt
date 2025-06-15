package com.example.projectkape

import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.EditText
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class VlogActivity : AppCompatActivity() {

    private lateinit var recyclerView: RecyclerView
    private lateinit var searchBar: EditText
    private lateinit var adapter: CardAdapter

    private val vlogItems = listOf(
        CardItem(
            "Composting 101",
            "Turn waste into gold!",
            R.drawable.image_31,
            "Vlog",
            "https://www.youtube.com/embed/dQw4w9WgXcQ"
        ),
        CardItem(
            "Coffee Vlog Ep. 2",
            "Another guide on composting with coffee waste.",
            R.drawable.image_31,
            "Vlog",
            "https://www.youtube.com/embed/aBc123Xyz"
        )
    )

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.item_vlog)

        recyclerView = findViewById(R.id.recyclerViewVlog)

        recyclerView.layoutManager = LinearLayoutManager(this)
        adapter = CardAdapter(vlogItems)
        recyclerView.adapter = adapter

        searchBar.addTextChangedListener(object : TextWatcher {
            override fun afterTextChanged(s: Editable?) {
                filterItems()
            }

            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
        })
    }

    private fun filterItems() {
        val query = searchBar.text.toString().trim()
        val filtered = vlogItems.filter {
            it.title.contains(query, ignoreCase = true) || it.description.contains(query, ignoreCase = true)
        }
        adapter.updateList(filtered)
    }
}
