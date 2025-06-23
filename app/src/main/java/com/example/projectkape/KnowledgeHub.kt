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
private lateinit var BtUringKape: Button
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_knowledge_hub)

        BtUringKape = findViewById(R.id.btnUriNgKape)

        BtUringKape.setOnClickListener {
            val intent = Intent(this, UriNgKapeActivity::class.java)
            startActivity(intent)
        }



    }



}
