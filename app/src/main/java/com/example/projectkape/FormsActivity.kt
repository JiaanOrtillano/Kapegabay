package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.widget.ImageButton
import android.widget.LinearLayout
import androidx.appcompat.app.AppCompatActivity

class FormsActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_forms) // Make sure your layout is named activity_forms.xml

        // Back button
        val backButton = findViewById<ImageButton>(R.id.menuBack)
        backButton.setOnClickListener {
            onBackPressed()
        }

        // RSBA Form container
        val rsbContainer = findViewById<LinearLayout>(R.id.rsbContainer)
        rsbContainer.setOnClickListener {
            val intent = Intent(this, RsbaFormActivity::class.java)
            startActivity(intent)
        }

        // Insurance Form container
        val insuranceContainer = findViewById<LinearLayout>(R.id.insuranceContainer)
        insuranceContainer.setOnClickListener {
            val intent = Intent(this, InsuranceFormActivity::class.java)
            startActivity(intent)
        }
    }
}
