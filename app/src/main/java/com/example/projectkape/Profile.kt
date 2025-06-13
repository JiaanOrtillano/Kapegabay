package com.example.projectkape

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.bumptech.glide.Glide

class Profile : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_profile)

        val spinner = findViewById<Spinner>(R.id.mySpinner)
        val adapter = ArrayAdapter.createFromResource(
            this,
            R.array.language_options,
            android.R.layout.simple_spinner_dropdown_item
        )
        spinner.adapter = adapter

        val sharedPreferences = getSharedPreferences("ProfileData", MODE_PRIVATE)
        val name = sharedPreferences.getString("name", "Florian Laika")
        val address = sharedPreferences.getString("address", "Brgy. Bagong Bukid, Santa Maria, Laguna")
        val imageUri = sharedPreferences.getString("imageUri", null)

        findViewById<TextView>(R.id.textViewName).text = name
        findViewById<TextView>(R.id.textViewAddress).text = address

        val profilePic = findViewById<ImageView>(R.id.profilePic)
        if (imageUri != null) {
            Glide.with(this).load(Uri.parse(imageUri)).into(profilePic)
        }

        val backButton = findViewById<ImageButton>(R.id.menuBack)
        backButton.setOnClickListener {
            startActivity(Intent(this, Home::class.java))
            finish()
        }

        val editButton = findViewById<Button>(R.id.editButton)
        editButton.setOnClickListener {
            startActivity(Intent(this, EditProfile::class.java))
        }

        val logoutButton = findViewById<Button>(R.id.logoutButton)
        logoutButton.setOnClickListener {
            sharedPreferences.edit().clear().apply()
            val intent = Intent(this, MainActivity::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
            startActivity(intent)
            finish()
        }
    }
}
