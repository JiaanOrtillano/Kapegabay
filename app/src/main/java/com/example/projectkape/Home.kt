package com.example.projectkape

import com.example.projectkape.CardAdapter
import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.EditText
import android.widget.ImageView
import android.widget.TextView
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.GravityCompat
import androidx.drawerlayout.widget.DrawerLayout
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class Home : AppCompatActivity() {

    private lateinit var drawerLayout: DrawerLayout
    private lateinit var adapter: CardAdapter
    private lateinit var recyclerView: RecyclerView
    private lateinit var searchBar: EditText

    private var currentCategory: String = "All"

    private val items = listOf(
        CardItem(
            "Coffee Grounds for Insect Repellent...",
            "The benefit of using coffee grounds...",
            R.drawable.image_30,
            "All"
        ),
        CardItem(
            "Organic Fertilizer Tips",
            "Using coffee grounds as fertilizer...",
            R.drawable.image_31,
            "Videos"
        ),
        CardItem(
            "Composting 101",
            "Turn waste into gold!",
            R.drawable.image_31,
            "Vlog"
        )
    )

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_home)

        drawerLayout = findViewById(R.id.drawer_layout)
        recyclerView = findViewById(R.id.recyclerView)
        searchBar = findViewById(R.id.search_bar)

        recyclerView.layoutManager = LinearLayoutManager(this)
        adapter = CardAdapter(items)
        recyclerView.adapter = adapter

        // Menu button
        findViewById<ImageView>(R.id.menu_button).setOnClickListener {
            drawerLayout.openDrawer(GravityCompat.START)
        }

        // Profile button
        findViewById<ImageView>(R.id.menuProfile).setOnClickListener {
            startActivity(Intent(this, Profile::class.java))
        }

        // Navigation drawer
        findViewById<TextView>(R.id.nav_home).setOnClickListener {
            drawerLayout.closeDrawer(GravityCompat.START)
        }
        findViewById<TextView>(R.id.nav_knowledge_hub).setOnClickListener {
            startActivity(Intent(this, KnowledgeHub::class.java))
        }
        findViewById<TextView>(R.id.nav_forms).setOnClickListener {
            startActivity(Intent(this, FormsActivity::class.java))
        }
        findViewById<TextView>(R.id.nav_farm_calendar).setOnClickListener {
            startActivity(Intent(this, FarmCalendar::class.java))
        }
        findViewById<TextView>(R.id.nav_notifications).setOnClickListener {
            startActivity(Intent(this, NotificationsActivity::class.java))
        }
        findViewById<TextView>(R.id.nav_support).setOnClickListener {
            startActivity(Intent(this, SupportActivity::class.java))
        }
        findViewById<TextView>(R.id.nav_about).setOnClickListener {
            startActivity(Intent(this, AboutActivity::class.java))
        }

        // Filter tabs
        findViewById<TextView>(R.id.tab_all).setOnClickListener {
            currentCategory = "All"
            filterItems()
        }
        findViewById<TextView>(R.id.tab_videos).setOnClickListener {
            currentCategory = "Videos"
            filterItems()
        }
        findViewById<TextView>(R.id.tab_vlog).setOnClickListener {
            currentCategory = "Vlog"
            filterItems()
        }

        // Search listener
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

        val filtered = items.filter {
            val matchesCategory = currentCategory == "All" || it.tagLabel == currentCategory
            val matchesSearch = query.isEmpty() || it.title.contains(query, true) || it.description.contains(query, true)
            matchesCategory && matchesSearch
        }

        adapter.updateList(filtered)
    }
}
