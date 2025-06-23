package com.example.projectkape


import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.example.projectkape.R


class UriNgKapeActivity : AppCompatActivity() {

    private lateinit var BtRobusta: Button
    private lateinit var BtExcelsa: Button
    private lateinit var BtArabica: Button
    private lateinit var BtLiberica: Button



    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_uri_ng_kape)

        BtRobusta = findViewById(R.id.btnRobusta)
        BtExcelsa = findViewById(R.id.btnExcelsa)
        BtArabica = findViewById(R.id.btnArabica)
        BtLiberica = findViewById(R.id.btnLiberica)

        BtRobusta.setOnClickListener {
            val intent = Intent(this, Robusta::class.java)
            startActivity(intent)
        }
        BtExcelsa.setOnClickListener {
            val intent = Intent(this, Excelsa::class.java)
            startActivity(intent)
        }

        BtArabica.setOnClickListener {
            val intent = Intent(this, Arabica::class.java)
            startActivity(intent)
        }
        BtLiberica.setOnClickListener {
            val intent = Intent(this, Liberica::class.java)
            startActivity(intent)
        }



    }
}
