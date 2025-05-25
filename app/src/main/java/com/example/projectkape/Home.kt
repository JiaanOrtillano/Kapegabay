package com.example.projectkape

import CardAdapter
import android.os.Bundle
import android.widget.ImageView
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.core.view.GravityCompat
import androidx.drawerlayout.widget.DrawerLayout

private lateinit var menuButton: ImageView
private lateinit var drawerLayout: DrawerLayout


class Home : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_home)
        val recyclerView: RecyclerView = findViewById(R.id.recyclerView)
        val menuButton: ImageView = findViewById(R.id.menu_button)
        val drawerLayout = findViewById<DrawerLayout>(R.id.drawer_layout)
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

    }
}