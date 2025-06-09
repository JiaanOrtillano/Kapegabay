package com.example.projectkape

import CardAdapter
import android.content.Intent
import android.os.Bundle
import android.widget.ImageView
import android.widget.TextView
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.GravityCompat
import androidx.drawerlayout.widget.DrawerLayout
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class Home : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_home)

        val recyclerView: RecyclerView = findViewById(R.id.recyclerView)
        val menuButton: ImageView = findViewById(R.id.menu_button)
        val drawerLayout: DrawerLayout = findViewById(R.id.drawer_layout)
        val menuProfile: ImageView = findViewById(R.id.menuProfile)
        val calendarButton: TextView = findViewById(R.id.nav_farm_calendar) // ✅ New
        val knowledgeHub: TextView = findViewById(R.id.nav_knowledge_hub)

        recyclerView.layoutManager = LinearLayoutManager(this)

        val items = listOf(
            CardItem("Coffee Grounds for Insect Repellent...", "The benefit of using coffee grounds...", R.drawable.image_30, "Pananim"),
            CardItem("Organic Fertilizer Tips", "Using coffee grounds as fertilizer...", R.drawable.image_31, "Pananim"),
            CardItem("Organic Fertilizer Tips", "Using coffee grounds as fertilizer...", R.drawable.image_31, "Pananim"),
            CardItem("Organic Fertilizer Tips", "Using coffee grounds as fertilizer...", R.drawable.image_31, "Pananim")
        )

        val adapter = CardAdapter(items)
        recyclerView.adapter = adapter

        menuButton.setOnClickListener {
            drawerLayout.openDrawer(GravityCompat.START)
        }

        menuProfile.setOnClickListener {
            val intent = Intent(this, Profile::class.java)
            startActivity(intent)
        }

        // ✅ Open Farm Calendar
        calendarButton.setOnClickListener {
            val intent = Intent(this, FarmCalendar::class.java)
            startActivity(intent)
        }

        knowledgeHub.setOnClickListener {
            val intent = Intent(this, KnowledgeHub::class.java)
            startActivity(intent)
        }

    }
}
