package com.example.projectkape

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.ImageButton
import androidx.appcompat.app.AppCompatActivity

class KnowledgeUriNgKapeActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_uri_ng_kape)

        val backButton = findViewById<ImageButton>(R.id.menuBack)

        findViewById<Button>(R.id.btnRobusta).setOnClickListener {
            openDetail("Robusta")
        }

        findViewById<Button>(R.id.btnExcelsa).setOnClickListener {
            openDetail("Excelsa")
        }

        findViewById<Button>(R.id.btnArabica).setOnClickListener {
            openDetail("Arabica")
        }

        findViewById<Button>(R.id.btnLiberica).setOnClickListener {
            openDetail("Liberica")
        }

        backButton.setOnClickListener {
            finish()
        }
    }

    private fun openDetail(coffeeType: String) {
        val intent = Intent(this, KnowledgeDetailActivity::class.java)
        intent.putExtra("title", coffeeType)
        startActivity(intent)
    }
}
